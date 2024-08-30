<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;
use Auth;
use DateTime;

use App\Http\Controllers\Controller;

use App\Events\frontend\LogDataAsset;

/*
use App\Models\TB_Constants\TB_Prefix;
use App\Models\TB_DataBroker\Data_Brokers;
*/
use App\Models\TB_Assessments\Stat_rateType;

use App\Models\TB_Assessments\Stat_CarBrand;
use App\Models\TB_Assessments\Stat_CarGroup;
use App\Models\TB_Assessments\Stat_CarModel;
use App\Models\TB_Assessments\Stat_CarYear;
use App\Models\TB_Assessments\Stat_MotoBrand;
use App\Models\TB_Assessments\Stat_MotoGroup;
use App\Models\TB_Assessments\Stat_MotoModel;
use App\Models\TB_Assessments\Stat_MotoYear;

use App\Models\TB_Constants\TB_Frontend\TB_TypeAssets; // ประเภททรัพย์
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsPoss;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsBldg;
use App\Models\TB_Constants\TB_Frontend\TB_TypeVehicle;
use App\Models\TB_Constants\TB_Frontend\TB_Company_Insurance;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Assets\Data_AssetsDetails;
use App\Models\TB_Assets\Data_AssetsOwnership;

use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_CusTagCalculate;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_PactContracts\Pact_Indentures_Assets;

use App\Models\TB_Logs\Log_DataAssets;

class AssetController extends Controller
{
    // ค่าคงที่ใช้แสดงใน Dropdown ต่าง ๆ
    const DATA_FORM = [
        'InsuranceState' => [
            ['Buy', 'ซื้อประกัน'],
            ['Yes', 'มีอยู่แล้ว'],
            ['No', 'ไม่มี']
        ],
        'InsuranceClass' => [
            ['1', 'ชั้น 1'],
            ['2', 'ชั้น 2'],
            ['3', 'ชั้น 3'],
            ['2+', 'ชั้น 2+'],
            ['3+', 'ชั้น 3+']
        ],
        'OccupiedTime' => [
            'น้อยกว่า 1 เดือน',
            '1 เดือน - 2 เดือน',
            '2 เดือน - 3 เดือน',
            '3 เดือนขึ้นไป'
        ],
        'PurposeType' => [
            'รถใช้ในการส่วนตัว',
            'รถใช้เพื่อการพานิชย์'
        ],
        'PossessionOrder' => [
            'ลำดับ 1',
            'ลำดับ 2',
            'ลำดับ 3',
            'ลำดับ 4',
            'ลำดับ 5',
            'ลำดับ 6 ขึ้นไป'
        ],
        'History_16' => [
            'ต่อภาษีทุกปีไม่มีค่าปรับ',
            'ต่อทุกปี มีค่าปรับ',
            'ต่อไม่ทุกปี'
        ],
        'History_18' => [
            '1มีการดัดแปลงสภาพหรือเกิดอุบัติเหตุ ที่ใช้วิศวะรับรอง',
            '2มีรายการเปลี่ยนสภาพรถ เช่น ทำสี เปลี่ยนเครื่อง เชื้อเพลิง',
            '3เล่มทะเบียนเคยโดนระงับใช้',
            '4มีรายการยกเลิกเช่าซื้อ',
            '5มีรายการออกแทนฉบับเดิม ชำรุด',
            '6เล่มทะเบียนเต็ม เปลี่ยนเล่ม',
            '7เล่มทะเบียนปกติ',
            '8อื่นๆ'
        ],
        'Land_BuildingKind' => [
            'บ้านปูน',
            'บ้านไม้',
            'บ้านครึ่งปูนครึ่งไม้',
            'อื่น ๆ'
        ],
        'Land_BuildingStorey' => [
            '1 ชั้น',
            '2 ชั้น',
            '3 ชั้น',
            'มากกว่า 3 ชั้น'
        ],
    ];


    public function index(Request $request)
    {
        if ($request->type == 'tab') {

            $dataCusId = $request->cus_id;

            if ($request->filter_asset == null) {
                $filter_asset = 'lastest';
            } else {
                $filter_asset = $request->filter_asset;
            }

            $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);

            /*
            if ( !empty($dataAsset) ) {
                session()->put('dataAsset',$dataAsset);
            }
            */

            /*
            $asset = Data_Assets::where('id',1)->first();
            dd( $asset, $asset->AssetToOwnership, $asset->AssetToDataCus );
            */

            /*
            $cus = Data_Customers::where('id',1)->first();
            dd( $cus, $cus->DataCusToAssetOwnership, $cus->DataCusToDataAsset );
            */
            //$filter_asset = "lastest"

            $html = view('frontend.content-asset.view-asset', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => '',
            ]);

        } elseif ($request->type == 'form-datails') {
            // เรียกฟอร์ม details ไปใช้แสดงข้อมูลตอนย้ายทรัพย์
            $asset = $request->asset;
            $type = 'new';

            //---------------------------------------------------------
            $dataForm = $this::DATA_FORM;
            $typeRate = Stat_rateType::get();
            $typePoss = null;
            $CompanyInsurance = null;
            $TypeVehicle = null;
            $typeBldg = null;
            if ($asset == 'car' || $asset == 'moto') {
                $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
                $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
                $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            } elseif ($asset == 'land') {
                $typeBldg = TB_TypeAssetsBldg::select('Code_TypeBldg', 'Name_TypeBldg', 'No_Building')
                    ->where('Flag_TypeBldg', 'yes')
                    ->orderBy('Code_TypeBldg')
                    ->get();
            }
            //---------------------------------------------------------
            $asset_id = $request->asset_id;
            $asset_obj = Data_Assets::find($asset_id);
            if ($asset_obj) {
                $midPrice = $asset_obj->getMidPrice();
            } else {
                $midPrice = 0;
            }
            $html = view('frontend.content-asset.section-details.create-asset-details', compact('type', 'asset', 'dataForm', 'typeRate', 'typePoss', 'typeBldg', 'CompanyInsurance', 'TypeVehicle', 'midPrice'))->render();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => '',
            ]);
        }
    }

    public function create(Request $request)
    {
        if ($request->type == 'new') {  // กดสร้างทรัพย์ใหม่
            //---------------------------------------------------------
            // รับค่าจาก Input เข้ามา
            $type = $request->type;
            $asset = $request->asset;
            $dataCusId = $request->cusid;
            $title = "สร้างทรัพย์ใหม่";
            // สร้างรหัสไอดี Asset ให้ดูล่วงหน้า
            $subtitle = "Create New Asset";
            $tagcalid = null;
            //---------------------------------------------------------
            $dataForm = $this::DATA_FORM;
            $typeRate = Stat_rateType::get();
            $typePoss = null;
            $TypeVehicle = null;
            $CompanyInsurance = null;
            $typeBldg = null;
            if ($asset == 'car' || $asset == 'moto') {
                $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
                $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
                $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            } elseif ($asset == 'land') {
                $typeBldg = TB_TypeAssetsBldg::select('Code_TypeBldg', 'Name_TypeBldg', 'No_Building')
                    ->where('Flag_TypeBldg', 'yes')
                    ->orderBy('Code_TypeBldg')
                    ->get();
            }
            //---------------------------------------------------------
            $dataCar = [];
            $dataMoto = [];
            if ($asset == 'car') {
                $dataCar = array(
                    "all" => Stat_CarYear::getAllCarData(),
                    "brand" => Stat_CarBrand::getBrandArray(),
                    "group" => Stat_CarGroup::getGroupArray(),
                    "model" => Stat_CarModel::getModelArrayWithTopcar()
                );
            } elseif ($asset == 'moto') {
                $dataMoto = array(
                    "all" => Stat_MotoYear::getAllMotoData(),
                    "brand" => Stat_MotoBrand::getBrandArray(),
                    "group" => Stat_MotoGroup::getGroupArray(),
                    "model" => Stat_MotoModel::getModelArray()
                );
            }
            //---------------------------------------------------------
            $assetFromTagCal = null;
            $assetDatailFromTagCal = null;
            if ($request->tagcalid != null) {  // เช็คว่าเป็นการสร้างทรัพย์จาก TagCal
                $tagcalid = $request->tagcalid;
                //--------------
                $dataTagCal = Data_CusTagCalculate::where('id', $tagcalid)->first();
                $assetFromTagCal = new Data_Assets;
                $assetFromTagCal->TypeAsset_Code = Stat_rateType::where('code_car', $dataTagCal->RateCartypes)->first()->type_car;
                $assetFromTagCal->Vehicle_Type = $dataTagCal->RateCartypes;
                $assetFromTagCal->Vehicle_Type_PLT = $dataTagCal->Type_PLT;
                $assetFromTagCal->Vehicle_Brand = $dataTagCal->RateBrands;
                $assetFromTagCal->Vehicle_Group = $dataTagCal->RateGroups;
                $assetFromTagCal->Vehicle_Model = $dataTagCal->RateModals;
                $assetFromTagCal->Vehicle_Year = $dataTagCal->RateYears;
                $assetFromTagCal->Vehicle_Gear = $dataTagCal->RateGears;
                $assetFromTagCal->Price_Asset = $dataTagCal->RatePrices;
                $assetDatailFromTagCal = new Data_AssetsDetails;
                $assetDatailFromTagCal->OccupiedDT = $dataTagCal->DateOccupiedcar;
                $assetDatailFromTagCal->PossessionState_Code = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')
                    ->where('Name_TypePoss', $dataTagCal->TypeAssetsPoss)->first()->Code_TypePoss;//$dataTagCal->TypeAssetsPoss;
                $assetFromTagCal->dataTagCal_id = $dataTagCal->id;
            }
            //---------------------------------------------------------
            return view('frontend.content-asset.create-asset', compact('type', 'title', 'asset', 'dataCusId', 'subtitle', 'dataForm', 'typeRate', 'typePoss', 'typeBldg', 'TypeVehicle', 'CompanyInsurance', 'assetFromTagCal', 'assetDatailFromTagCal', 'dataCar', 'dataMoto'));
        } elseif ($request->type == 'load') {
            $type = $request->type;
            $title = "สร้างทรัพย์ใหม่จากบันทึกติดตาม";
            $dataCusId = $request->cusid;

            $nameCus = Data_Customers::where('id', $dataCusId)->first()->Name_Cus;

            $dataTag = Data_CusTags::where('DataCus_id', $dataCusId)->get()->sortByDesc('created_at');

            return view('frontend.content-asset.taglist-asset', compact('type', 'title', 'nameCus', 'dataCusId', 'dataTag'));
        } elseif ($request->type == "own") {      // สร้างการโอนย้าย จากหน้าลูกค้า
            $dataCusId = $request->cusid;
            $title = "ย้ายการครอบครองทรัพย์";
            $subtitle = "Transfer Asset";

            $preload_cus = Data_Customers::where('id', $dataCusId)->first();

            $type = $request->type;
            return view('frontend.content-asset.section-transfer.transfer-asset', compact('type', 'title', 'subtitle', 'dataCusId', 'preload_cus'));
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->type == "asset") {      // กดแก้ไขข้อมูลทรัพย์
            //----------------------------------------------------------------
            // ตั้งค่าข้อมูลเริ่มต้น
            $type = 'edit';

            $assetItem = Data_Assets::where('Data_Assets.id', $id)
                ->leftJoin('Data_AssetsDetails', 'Data_Assets.id', '=', 'Data_AssetsDetails.DataAsset_Id');
            //->select('Code_Asset', 'TypeAsset_Code', 'DataCus_Id', 'Price_Asset')
            $asset = $assetItem->select('TypeAsset_Code')->first()->TypeAsset_Code;
            if ($asset == 'car' || $asset == 'moto') {
                $assetItem = $assetItem->addSelect('Vehicle_OldLicense', 'Vehicle_OldLicense_Text', 'Vehicle_OldLicense_Number', 'Vehicle_OldLicense_Province', 'Vehicle_NewLicense', 'Vehicle_NewLicense_Text', 'Vehicle_NewLicense_Number', 'Vehicle_NewLicense_Province', 'Vehicle_Chassis', 'Vehicle_Engine', 'Vehicle_Color', 'Vehicle_Miles', 'Vehicle_CC', 'Vehicle_Type', 'Vehicle_Type_PLT', 'Vehicle_Brand', 'Vehicle_Group', 'Vehicle_Model', 'Vehicle_Year', 'Vehicle_Gear', 'InsuranceType_Code', 'InsuranceState', 'InsuranceClass', 'InsuranceCompany_Id', 'PolicyNumber', 'InsuranceDT', 'InsuranceActDT', 'InsuranceRegisterDT', 'PurposeType', 'PossessionState_Code', 'PossessionOrder', 'History_16', 'History_18');
            } elseif ($asset == 'land') {
                $assetItem = $assetItem->addSelect('Land_Type', 'Land_Id', 'Land_ParcelNumber', 'Land_SheetNumber', 'Land_TambonNumber', 'Land_Book', 'Land_BookPage', 'Land_SizeRai', 'Land_SizeNgan', 'Land_SizeSquareWa', 'Land_Zone', 'Land_Province', 'Land_District', 'Land_Tambon', 'Land_PostalCode', 'Land_Coordinates', 'Land_Detail', 'Land_BuildingType', 'Land_BuildingKind', 'Land_BuildingStorey', 'Land_BuildingSize');
            }
            $assetItem = $assetItem->addSelect('Code_Asset', 'TypeAsset_Code', 'DataCus_Id', 'Price_Asset')
                ->addSelect('OccupiedDT', 'OccupiedTime')
                ->addSelect('Data_Assets.id AS id', 'Data_AssetsDetails.id AS detail_id')
                ->first();

            //$asset = $assetItem->TypeAsset_Code;
            $dataCusId = $assetItem->DataCus_Id;
            $title = "แก้ไขข้อมูลทรัพย์";
            $subtitle = "Edit Asset";//$assetItem->Code_Asset;
            //----------------------------------------------------------------
            $dataForm = $this::DATA_FORM;
            $typeRate = Stat_rateType::get();
            $typePoss = null;
            $TypeVehicle = null;
            $CompanyInsurance = null;
            $typeBldg = null;
            if ($asset == 'car' || $asset == 'moto') {
                $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
                $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
                $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            } elseif ($asset == 'land') {
                $typeBldg = TB_TypeAssetsBldg::select('Code_TypeBldg', 'Name_TypeBldg', 'No_Building')
                    ->where('Flag_TypeBldg', 'yes')
                    ->orderBy('Code_TypeBldg')
                    ->get();
            }
            //----------------------------------------------------------------
            $dataCar = [];
            $dataMoto = [];
            if ($asset == 'car') {
                $dataCar = array(
                    "all" => Stat_CarYear::getAllCarData(),
                    "brand" => Stat_CarBrand::getBrandArray(),
                    "group" => Stat_CarGroup::getGroupArray(),
                    "model" => Stat_CarModel::getModelArrayWithTopcar()
                );
            } elseif ($asset == 'moto') {
                $dataMoto = array(
                    "all" => Stat_MotoYear::getAllMotoData(),
                    "brand" => Stat_MotoBrand::getBrandArray(),
                    "group" => Stat_MotoGroup::getGroupArray(),
                    "model" => Stat_MotoModel::getModelArray()
                );
            }
            return view('frontend.content-asset.create-asset', compact('type', 'title', 'asset', 'dataCusId', 'subtitle', 'dataForm', 'typeRate', 'typePoss', 'typeBldg', 'PLTTypeCarArray', 'CompanyInsurance', 'assetItem', 'TypeVehicle', 'dataCar', 'dataMoto'));
        } elseif ($request->type == "owner-asset") {      // กดแก้ไขทรัพย์ในหน้า owner
            //----------------------------------------------------------------
            // ตั้งค่าข้อมูลเริ่มต้น
            $type = 'edit';

            //$assetItem = Data_Assets::where('Data_Assets.id', $id)
            $ownership = Data_AssetsOwnership::where('id', '=', $request->ownerid)->first();
            $assetItem = Data_Assets::where('Data_Assets.id', '=', $ownership->DataAsset_Id)
                ->leftJoin('Data_AssetsOwnerships', function ($join) use ($ownership) {
                    $join->on('Data_AssetsOwnerships.DataAsset_Id', 'Data_Assets.id');
                    $join->on('Data_AssetsOwnerships.id', DB::raw($ownership->id));
                })
                ->leftJoin('Data_AssetsDetails', function ($join) {
                    $join->on('Data_AssetsDetails.DataAssetOwn_Id', 'Data_AssetsOwnerships.id');
                });
            $asset = $assetItem->select('TypeAsset_Code')->first()->TypeAsset_Code;
            if ($asset == 'car' || $asset == 'moto') {
                $assetItem = $assetItem->addSelect('Vehicle_OldLicense', 'Vehicle_OldLicense_Text', 'Vehicle_OldLicense_Number', 'Vehicle_OldLicense_Province', 'Vehicle_NewLicense', 'Vehicle_NewLicense_Text', 'Vehicle_NewLicense_Number', 'Vehicle_NewLicense_Province', 'Vehicle_Chassis', 'Vehicle_Engine', 'Vehicle_Color', 'Vehicle_Miles', 'Vehicle_CC', 'Vehicle_Type', 'Vehicle_Type_PLT', 'Vehicle_Brand', 'Vehicle_Group', 'Vehicle_Model', 'Vehicle_Year', 'Vehicle_Gear', 'InsuranceType_Code', 'InsuranceState', 'InsuranceClass', 'InsuranceCompany_Id', 'PolicyNumber', 'InsuranceDT', 'InsuranceActDT', 'InsuranceRegisterDT', 'PurposeType', 'PossessionState_Code', 'PossessionOrder', 'History_16', 'History_18');
            } elseif ($asset == 'land') {
                $assetItem = $assetItem->addSelect('Land_Type', 'Land_Id', 'Land_ParcelNumber', 'Land_SheetNumber', 'Land_TambonNumber', 'Land_Book', 'Land_BookPage', 'Land_SizeRai', 'Land_SizeNgan', 'Land_SizeSquareWa', 'Land_Zone', 'Land_Province', 'Land_District', 'Land_Tambon', 'Land_PostalCode', 'Land_Coordinates', 'Land_Detail', 'Land_BuildingType', 'Land_BuildingKind', 'Land_BuildingStorey', 'Land_BuildingSize');
            }
            $assetItem = $assetItem->addSelect('Code_Asset', 'TypeAsset_Code', 'Data_AssetsOwnerships.DataCus_Id AS DataCus_Id', 'Price_Asset')
                ->addSelect('OccupiedDT', 'OccupiedTime')
                ->addSelect('Data_Assets.id AS id', 'Data_AssetsDetails.id AS detail_id')
                ->first();

            $dataCusId = $assetItem->DataCus_Id;
            $dataOwnId = $request->ownerid;
            $title = "แก้ไขข้อมูลทรัพย์";
            $subtitle = "Edit Asset";
            //----------------------------------------------------------------
            $dataForm = $this::DATA_FORM;
            $typeRate = Stat_rateType::get();
            $typePoss = null;
            $TypeVehicle = null;
            $CompanyInsurance = null;
            $typeBldg = null;
            if ($asset == 'car' || $asset == 'moto') {
                $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
                $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
                $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            } elseif ($asset == 'land') {
                $typeBldg = TB_TypeAssetsBldg::select('Code_TypeBldg', 'Name_TypeBldg', 'No_Building')
                    ->where('Flag_TypeBldg', 'yes')
                    ->orderBy('Code_TypeBldg')
                    ->get();
            }
            //----------------------------------------------------------------
            $dataCar = [];
            $dataMoto = [];
            if ($asset == 'car') {
                $dataCar = array(
                    "all" => Stat_CarYear::getAllCarData(),
                    "brand" => Stat_CarBrand::getBrandArray(),
                    "group" => Stat_CarGroup::getGroupArray(),
                    "model" => Stat_CarModel::getModelArrayWithTopcar()
                );
            } elseif ($asset == 'moto') {
                $dataMoto = array(
                    "all" => Stat_MotoYear::getAllMotoData(),
                    "brand" => Stat_MotoBrand::getBrandArray(),
                    "group" => Stat_MotoGroup::getGroupArray(),
                    "model" => Stat_MotoModel::getModelArray()
                );
            }
            //----------------------------------------------------------------
            return view('frontend.content-asset.create-asset', compact('type', 'title', 'asset', 'dataCusId', 'dataOwnId', 'subtitle', 'dataForm', 'typeRate', 'typePoss', 'typeBldg', 'CompanyInsurance', 'assetItem', 'TypeVehicle', 'dataCar', 'dataMoto'));
        } elseif ($request->type == "transfer") {      // กดโอนย้ายทรัพย์ จากการ์ดทรัพย์นั้น ๆ
            $assetItem = Data_Assets::where('id', $id)->first();
            $title = "โอนย้ายข้อมูลทรัพย์";
            $subtitle = "Transfer Asset";

            $asset = $assetItem->TypeAsset_Code;

            $ownership = Data_AssetsOwnership::where('id', $request->ownerid)->first();
            $page_dataCusId = $ownership->DataCus_Id;

            $type = $request->type;
            $dataForm = $this::DATA_FORM;
            $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
            $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            return view('frontend.content-asset.section-transfer.transfer-asset', compact('type', 'title', 'subtitle', 'asset', 'assetItem', 'dataForm', 'typePoss', 'CompanyInsurance', 'page_dataCusId'));
        } elseif ($request->type == "re-transfer") {      // กดโอนย้ายทรัพย์ จากการ์ดทรัพย์นั้น ๆ
            $assetItem = Data_Assets::where('id', $id)->first();
            $title = "โอนย้ายข้อมูลทรัพย์";
            $subtitle = "Transfer Asset";

            $asset = $assetItem->TypeAsset_Code;

            $dataCusId = $request->cusid;
            $preload_cus = Data_Customers::where('id', $dataCusId)->first();
            $page_dataCusId = $dataCusId;

            $type = $request->type;
            $dataForm = $this::DATA_FORM;
            $typePoss = TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
            $CompanyInsurance = TB_Company_Insurance::where('Flag_active', 'yes')->get();
            return view('frontend.content-asset.section-transfer.transfer-asset', compact('type', 'title', 'subtitle', 'dataCusId', 'preload_cus', 'asset', 'assetItem', 'dataForm', 'typePoss', 'CompanyInsurance', 'page_dataCusId'));

        }
    }

    public function show(Request $request, $id)
    {
        if ($request->type == "asset") {    // กดดูข้อมูลทรัพย์
            //----------------------------------------------------------------
            // ตั้งค่าข้อมูลเริ่มต้น
            $type = 'view';


            //dd( Data_Assets::where('Data_Assets.id', $id)->first()->CheckExpired() );

            $own_id = $request->ownerid;
            //dd($request, $id);
            $assetItem = Data_Assets::where('Data_Assets.id', $id)


                // ownerid
                //->leftJoin('Data_AssetsDetails', 'Data_Assets.id', '=', 'Data_AssetsDetails.DataAsset_Id');

                ->leftJoin('Data_AssetsOwnerships', function ($join) use ($own_id) {
                    $join->on('Data_AssetsOwnerships.DataAsset_Id', 'Data_Assets.id');
                    $join->on('Data_AssetsOwnerships.id', DB::raw($own_id));
                })
                ->leftJoin('Data_AssetsDetails', function ($join) {
                    $join->on('Data_AssetsDetails.DataAssetOwn_Id', 'Data_AssetsOwnerships.id');
                });

            //->select('Code_Asset', 'TypeAsset_Code', 'DataCus_Id', 'Price_Asset')
            $asset = $assetItem->select('TypeAsset_Code')->first()->TypeAsset_Code;
            if ($asset == 'car' || $asset == 'moto') {
                // ประเภททรัพย์
                $assetItem = $assetItem->leftJoin('Stat_rateTypes', function ($query) {
                    return $query->on('Stat_rateTypes.code_car', 'Data_Assets.Vehicle_Type')
                        ->where('Stat_rateTypes.Flag_car', 'Yes');
                })->addSelect('Stat_rateTypes.nametype_car AS Type_Name');

                $assetItem = $assetItem
                    // ประเภทรถ ธปท.
                    ->leftJoin('TB_TypeVehicle', function ($query) {
                        return $query->on('Data_Assets.Vehicle_Type_PLT', 'TB_TypeVehicle.Code_PLT')
                            ->where('TB_TypeVehicle.Flag_Vehicle', 'yes');
                    })
                    ->addSelect('TB_TypeVehicle.Name_Vehicle AS Type_PLT_Name')
                    // สถานะครอบครอง
                    ->leftJoin('TB_TypeAssetsPoss', function ($query) {
                        return $query->on('TB_TypeAssetsPoss.Code_TypePoss', 'Data_AssetsDetails.PossessionState_Code');
                    })->addSelect('TB_TypeAssetsPoss.Name_TypePoss AS TypePoss_Name')
                    // บริษัทประกัน
                    ->leftJoin('TB_Company_Insurance', function ($query) {
                        return $query->on('TB_Company_Insurance.id', 'Data_AssetsDetails.InsuranceCompany_Id');
                    })->addSelect('TB_Company_Insurance.CompanayIns_Name AS CompananyIns_Name')
                ;

                if ($asset == 'car') {
                    // join ตารางรถยนต์
                    $assetItem = $assetItem->leftJoin('Stat_CarBrand', function ($query) {
                        return $query->on('Stat_CarBrand.id', 'Data_Assets.Vehicle_Brand');
                    })->addSelect('Stat_CarBrand.Brand_car AS Brand_Name')
                        ->leftJoin('Stat_CarGroup', function ($query) {
                            return $query->on('Stat_CarGroup.id', 'Data_Assets.Vehicle_Group');
                        })->addSelect('Stat_CarGroup.Group_car AS Group_Name')
                        ->leftJoin('Stat_CarYear', function ($query) {
                            return $query->on('Stat_CarYear.id', 'Data_Assets.Vehicle_Year');
                        })->addSelect('Stat_CarYear.Year_car AS Year_Number')
                        ->leftJoin('Stat_CarModel', function ($query) {
                            return $query->on('Stat_CarModel.id', 'Data_Assets.Vehicle_Model');
                        })->addSelect('Stat_CarModel.Model_car AS Model_Name');
                } elseif ($asset == 'moto') {
                    // join ตารางรมอไซค์
                    $assetItem = $assetItem->leftJoin('Stat_MotoBrand', function ($query) {
                        return $query->on('Stat_MotoBrand.id', 'Data_Assets.Vehicle_Brand');
                    })->addSelect('Stat_MotoBrand.Brand_moto AS Brand_Name')
                        ->leftJoin('Stat_MotoGroup', function ($query) {
                            return $query->on('Stat_MotoGroup.id', 'Data_Assets.Vehicle_Group');
                        })->addSelect('Stat_MotoGroup.Group_moto AS Group_Name')
                        ->leftJoin('Stat_MotoYear', function ($query) {
                            return $query->on('Stat_MotoYear.id', 'Data_Assets.Vehicle_Year');
                        })->addSelect('Stat_MotoYear.Year_moto AS Year_Number')
                        ->leftJoin('Stat_MotoModel', function ($query) {
                            return $query->on('Stat_MotoModel.id', 'Data_Assets.Vehicle_Model');
                        })->addSelect('Stat_MotoModel.Model_moto AS Model_Name');
                }

                $assetItem = $assetItem->addSelect('Vehicle_OldLicense', 'Vehicle_NewLicense', 'Vehicle_Chassis', 'Vehicle_Engine', 'Vehicle_Color', 'Vehicle_Miles', 'Vehicle_CC', 'Vehicle_Gear', 'InsuranceType_Code', 'InsuranceState', 'InsuranceClass', 'PolicyNumber', 'InsuranceDT', 'InsuranceActDT', 'InsuranceRegisterDT', 'PurposeType', 'PossessionOrder', 'History_16', 'History_18');
            } elseif ($asset == 'land') {
                // ประเภททรัพย์
                $assetItem = $assetItem->leftJoin('Stat_rateTypes', function ($query) {
                    return $query->on('Stat_rateTypes.code_car', 'Data_Assets.Land_Type')
                        ->where('Stat_rateTypes.Flag_car', 'Yes');
                })->addSelect('Stat_rateTypes.nametype_car AS Type_Name');

                // ประเภทสิ่งปลูกสร้าง
                $assetItem = $assetItem->leftJoin('TB_TypeAssetsBldg', function ($query) {
                    return $query->on('TB_TypeAssetsBldg.Code_TypeBldg', 'Data_Assets.Land_BuildingType')
                        ->where('TB_TypeAssetsBldg.Flag_TypeBldg', 'yes');
                })->addSelect('TB_TypeAssetsBldg.Name_TypeBldg AS BuildingType_Name');

                $assetItem = $assetItem->addSelect('Land_Id', 'Land_ParcelNumber', 'Land_SheetNumber', 'Land_TambonNumber', 'Land_Book', 'Land_BookPage', 'Land_SizeRai', 'Land_SizeNgan', 'Land_SizeSquareWa', 'Land_Zone', 'Land_Province', 'Land_District', 'Land_Tambon', 'Land_PostalCode', 'Land_Coordinates', 'Land_Detail', 'Land_BuildingKind', 'Land_BuildingStorey', 'Land_BuildingSize');
            }
            $assetItem = $assetItem->addSelect('Code_Asset', 'Status_Asset', 'TypeAsset_Code', 'Data_AssetsOwnerships.DataCus_Id AS DataCus_Id', 'Price_Asset')
                ->addSelect('OccupiedDT', 'OccupiedTime')
                ->addSelect('Data_Assets.id AS id', 'Data_AssetsDetails.id AS detail_id')
                // แสดงใน Log
                ->addSelect('Data_Assets.created_at', 'Data_Assets.UserInsert AS Name_UserInsert')
                ->first();

            // UserInsert แบบเก่าจะเก็บเป็นชื่อ แบบใหม่จะเก็บไอดี
            if (is_numeric($assetItem->Name_UserInsert)) {
                $UserInsert = DB::table('users')->where('id', $assetItem->Name_UserInsert)->first();
                $Name_UserInsert = $UserInsert->name;
            } else {
                $Name_UserInsert = $assetItem->Name_UserInsert;
            }

            $dataCusId = $assetItem->DataCus_Id;
            $title = "ตรวจสอบข้อมูลทรัพย์";
            $subtitle = "Check Asset Information";
            //----------------------------------------------------------------
            //$contractRelate = null;
            //dd( $assetItem->AssetToPactIndenturesAsset );
            $contractRelate = Pact_Indentures_Assets::where('Pact_Indentures_Assets.Asset_id', $own_id)
                ->leftJoin('Pact_Contracts', function ($query) {
                    return $query->on('Pact_Indentures_Assets.PactCon_id', 'Pact_Contracts.id');
                })
                ->leftJoin('TB_Branchs', function ($query) {
                    return $query->on('TB_Branchs.id', 'Pact_Contracts.BranchSent_Con');
                })
                ->leftJoin('TB_TypeLoans', function ($query) {
                    return $query->on('TB_TypeLoans.Loan_Code', 'Pact_Contracts.CodeLoan_Con');
                })
                ->leftJoin('Users', function ($query) {
                    return $query->on('Users.id', 'Pact_Contracts.UserSent_Con');
                })
                ->leftJoin('Data_CusTagCalculates', function ($query) {
                    return $query->on('Data_CusTagCalculates.DataTag_id', 'Pact_Indentures_Assets.DataTag_id');
                })
                ->leftJoin('TB_StatusCon', function ($query) {
                    return $query->on('TB_StatusCon.Name_StatusCon', 'Pact_Contracts.Status_Con');
                })
                ->select(
                    'TB_Branchs.NickName_Branch AS NickName_B',
                    'TB_Branchs.Name_Branch AS Name_B',

                    'Pact_Contracts.Date_con',
                    'Pact_Contracts.Contract_Con',

                    'TB_TypeLoans.Loan_Name',
                    'Users.name AS Name_U',

                    'Pact_Contracts.DateCheck_Bookcar',

                    'Data_CusTagCalculates.Cash_Car',
                    'Data_CusTagCalculates.Process_Car',

                    'Pact_Contracts.Status_Con',
                    'TB_StatusCon.Memo_StatusCon',
                    'Pact_Contracts.Approve_monetary',

                    'Pact_Indentures_Assets.created_at'
                )->get();
            //dd($contractRelate);
            //----------------------------------------------------------------
            $logAsset = Log_DataAssets::where('Data_id', $assetItem->id)
                ->leftJoin('Users', function ($query) {
                    return $query->on('Users.id', 'Log_DataAssets.UserInsert');
                })
                ->select(
                    'Log_DataAssets.created_at',
                    'Log_DataAssets.status',
                    'Log_DataAssets.tagInput',
                    'Log_DataAssets.details',
                    'Users.name AS Name_U',
                )
                ->get();
            //----------------------------------------------------------------
            $dataForm = $this::DATA_FORM;
            $dataCar = [];
            $dataMoto = [];
            if ($asset == 'car') {
                $dataCar = array(
                    "all" => Stat_CarYear::getAllCarData(),
                    "brand" => Stat_CarBrand::getBrandArray(),
                    "group" => Stat_CarGroup::getGroupArray(),
                    "model" => Stat_CarModel::getModelArrayWithTopcar()
                );
            } elseif ($asset == 'moto') {
                $dataMoto = array(
                    "all" => Stat_MotoYear::getAllMotoData(),
                    "brand" => Stat_MotoBrand::getBrandArray(),
                    "group" => Stat_MotoGroup::getGroupArray(),
                    "model" => Stat_MotoModel::getModelArray()
                );
            }
            return view('components.content-asset.view-card-asset-info', compact('type', 'title', 'asset', 'dataCusId', 'subtitle', 'dataForm', 'assetItem', 'contractRelate', 'logAsset', 'Name_UserInsert', 'dataCar', 'dataMoto'));

        } elseif ($request->type == "selected-asset") {
            try {
                $asset = Data_Assets::where('id', $id)
                    ->with([
                        'AssetToManyOwner' => function ($query) {
                            $query->orderBy('id', 'asc');
                        }
                    ])
                    ->first();

                $view_content = view('frontend.content-asset.section-asset.asset-detail', compact('asset'))->render();
                return response()->json(['html' => $view_content, 'asset' => $asset, 'message' => 'selected asset success.'], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => $th->getMessage()], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->mod == "asset") {            // บันทึกข้อมูลทรัพย์

            DB::beginTransaction();
            try {
                $dataAsset = Data_Assets::where('id', $request->data['asset_id'])->first();
                $kind = $dataAsset->AssetToTypeAsset->Kind_TypeAsset;
                if ($kind == 'vehicle') {
                    $dataAsset->Price_Asset = floatval(str_replace(",", "", $request->data['Mid_Price']));

                    // ข้อมูลทั่วไปรถ

                    //$dataAsset->Vehicle_OldLicense = $request->data['Vehicle_OldLicense'];
                    $dataAsset->Vehicle_OldLicense_Text = $request->data['Vehicle_OldLicense_Text'];
                    $dataAsset->Vehicle_OldLicense_Number = $request->data['Vehicle_OldLicense_Number'];
                    $dataAsset->Vehicle_OldLicense_Province = $request->data['Vehicle_OldLicense_Province'];
                    $dataAsset->Vehicle_OldLicense = $dataAsset->Vehicle_OldLicense_Text . ' ' . $dataAsset->Vehicle_OldLicense_Number . ' ' . $dataAsset->Vehicle_OldLicense_Province;

                    //$dataAsset->Vehicle_NewLicense = $request->data['Vehicle_NewLicense'];
                    $dataAsset->Vehicle_NewLicense_Text = $request->data['Vehicle_NewLicense_Text'];
                    $dataAsset->Vehicle_NewLicense_Number = $request->data['Vehicle_NewLicense_Number'];
                    $dataAsset->Vehicle_NewLicense_Province = $request->data['Vehicle_NewLicense_Province'];
                    if (empty($request->data['Vehicle_NewLicense_Text']) && empty($request->data['Vehicle_NewLicense_Number']) && empty($request->data['Vehicle_NewLicense_Province'])) {
                        $dataAsset->Vehicle_NewLicense = null;
                    } else {
                        $dataAsset->Vehicle_NewLicense = $dataAsset->Vehicle_NewLicense_Text . ' ' . $dataAsset->Vehicle_NewLicense_Number . ' ' . $dataAsset->Vehicle_NewLicense_Province;
                    }

                    $dataAsset->Vehicle_Chassis = $request->data['Vehicle_Chassis'];
                    $dataAsset->Vehicle_NewChassis = $request->data['Vehicle_NewChassis'];
                    $dataAsset->Vehicle_Engine = $request->data['Vehicle_Engine'];
                    $dataAsset->Vehicle_Color = $request->data['Vehicle_Color'];
                    $dataAsset->Vehicle_Miles = $request->data['Vehicle_Miles'];
                    $dataAsset->Vehicle_CC = $request->data['Vehicle_CC'];
                    $dataAsset->Vehicle_Type = $request->data['Vehicle_Type'];
                    $dataAsset->Vehicle_Type_PLT = $request->data['Vehicle_Type_PLT'];
                    // ข้อมูลประเภทรถ - ยี่ห้อ/กลุ่ม/รุ่น/ปี/เกียร์
                    $dataAsset->Vehicle_Brand = $request->data['Vehicle_Brand'];
                    $dataAsset->Vehicle_Group = $request->data['Vehicle_Group'];
                    $dataAsset->Vehicle_Model = $request->data['Vehicle_Model'];
                    $dataAsset->Vehicle_Year = $request->data['Vehicle_Year'];
                    if ($dataAsset->TypeAsset_Code == 'car') {
                        $dataAsset->Vehicle_Gear = $request->data['Vehicle_Gear'];
                    }
                } elseif ($kind == 'land') {
                    $dataAsset->Price_Asset = floatval(str_replace(",", "", $request->data['Appraisal_Price']));
                    // ข้อมูลทั่วไปที่ดิน
                    $dataAsset->Land_Type = $request->data['Land_Type'];
                    $dataAsset->Land_Id = $request->data['Land_Id'];
                    $dataAsset->Land_ParcelNumber = $request->data['Land_ParcelNumber'];
                    $dataAsset->Land_SheetNumber = $request->data['Land_SheetNumber'];
                    $dataAsset->Land_TambonNumber = $request->data['Land_TambonNumber'];
                    $dataAsset->Land_Book = $request->data['Land_Book'];
                    $dataAsset->Land_BookPage = $request->data['Land_BookPage'];
                    // ข้อมูลขนาดที่ดิน
                    $dataAsset->Land_SizeRai = $request->data['Land_SizeRai'];
                    $dataAsset->Land_SizeNgan = $request->data['Land_SizeNgan'];
                    $dataAsset->Land_SizeSquareWa = $request->data['Land_SizeSquareWa'];
                    // ข้อมูลที่ตั้ง (จังหวัด/อำเถอ ฯลฯ)
                    $dataAsset->Land_Zone = $request->data['Land_Zone'];
                    $dataAsset->Land_Province = $request->data['Land_Province'];
                    $dataAsset->Land_District = $request->data['Land_District'];
                    $dataAsset->Land_Tambon = $request->data['Land_Tambon'];
                    $dataAsset->Land_PostalCode = $request->data['Land_PostalCode'];
                    $dataAsset->Land_Coordinates = $request->data['Land_Coordinates'];
                    $dataAsset->Land_Detail = $request->data['Land_Detail'];
                    // ข้อมูลสิ่งปลูกสร้าง
                    $dataAsset->Land_BuildingType = $request->data['Land_BuildingType'];
                    if ($request->data['Land_BuildingType'] != 'BLD-0001') {
                        $dataAsset->Land_BuildingKind = $request->data['Land_BuildingKind'];
                        $dataAsset->Land_BuildingStorey = $request->data['Land_BuildingStorey'];
                        $dataAsset->Land_BuildingSize = $request->data['Land_BuildingSize'];
                    } else {
                        $dataAsset->Land_BuildingKind = null;
                        $dataAsset->Land_BuildingStorey = null;
                        $dataAsset->Land_BuildingSize = null;
                    }
                }
                $dataAsset->UserUpdate = \Auth::user()->id;

                if ($dataAsset->isDirty()) {
                    $eventLog = event(new LogDataAsset($request->data['asset_id'], 'update', 'DataAsset', 'Update', 'แก้ไขข้อมูลทรัพย์', auth()->user()->id));
                    $dataAsset->save();
                }

                $assetDetail = Data_AssetsDetails::where('DataAssetOwn_Id', $request->dataOwn_Id)->first();
                if ($request->AssetType == 'car' or $request->AssetType == 'moto') {

                    $_OccupiedDT = convertDateHumanToPHP($request->data['OccupiedDT_Veh']);
                    $assetDetail->OccupiedDT = $_OccupiedDT;
                    $assetDetail->OccupiedTime = $request->data['OccupiedTime_Veh'];

                    //$newAssetDetail->InsuranceType_Code = $request->InsuranceType_Code;
                    $assetDetail->InsuranceState = $request->data['InsuranceState'];
                    $assetDetail->InsuranceClass = $request->data['InsuranceClass'];
                    $assetDetail->InsuranceCompany_Id = $request->data['InsuranceCompany_Id'];
                    $assetDetail->PolicyNumber = $request->data['PolicyNumber'];

                    $_InsuranceDT_start = $request->data['InsuranceDT_start'];
                    $_InsuranceDT_end = $request->data['InsuranceDT_end'];
                    if ($_InsuranceDT_start != null || $_InsuranceDT_end != null) {
                        $_InsuranceDT = convertDateRangeHumanToPHP($_InsuranceDT_start, $_InsuranceDT_end);
                        $assetDetail->InsuranceDT = $_InsuranceDT;
                    }

                    $_InsuranceActDT_start = $request->data['InsuranceActDT_start'];
                    $_InsuranceActDT_end = $request->data['InsuranceActDT_end'];
                    if ($_InsuranceActDT_start != null || $_InsuranceActDT_end != null) {
                        $_InsuranceActDT = convertDateRangeHumanToPHP($_InsuranceActDT_start, $_InsuranceActDT_end);
                        $assetDetail->InsuranceActDT = $_InsuranceActDT;
                    }
                    $_InsuranceRegisterDT_start = $request->data['InsuranceRegisterDT_start'];
                    $_InsuranceRegisterDT_end = $request->data['InsuranceRegisterDT_end'];
                    if ($_InsuranceRegisterDT_start != null || $_InsuranceRegisterDT_end != null) {
                        $_InsuranceRegisterDT = convertDateRangeHumanToPHP($_InsuranceRegisterDT_start, $_InsuranceRegisterDT_end);
                        $assetDetail->InsuranceRegisterDT = $_InsuranceRegisterDT;
                    }

                    $assetDetail->PurposeType = $request->data['PurposeType'];
                    $assetDetail->PossessionState_Code = $request->data['PossessionState_Code'];
                    $assetDetail->PossessionOrder = $request->data['PossessionOrder'];
                    $assetDetail->History_16 = $request->data['History_16'];
                    $assetDetail->History_18 = $request->data['History_18'];
                    $assetDetail->MilesNumber = $dataAsset->Vehicle_Miles;

                    // MidPrice, OccupiedDate
                    $assetDetail->MidPrice = floatval(str_replace(",", "", $request->data['Mid_Price']));
                    $assetDetail->OccupiedDate = $_OccupiedDT;

                } else if ($request->AssetType == 'land') {
                    $_OccupiedDT = convertDateHumanToPHP($request->data['OccupiedDT_Land']);
                    $assetDetail->OccupiedDT = $_OccupiedDT;
                    $assetDetail->OccupiedTime = $request->data['OccupiedTime_Land'];

                    // MidPrice, OccupiedDate
                    $assetDetail->MidPrice = floatval(str_replace(",", "", $request->data['Appraisal_Price']));
                    $assetDetail->OccupiedDate = $_OccupiedDT;
                }
                $assetDetail->UserUpdate = \Auth::user()->id;

                if ($assetDetail->isDirty()) {
                    $eventLog = event(new LogDataAsset($request->data['asset_id'], 'update', 'DataAssetDetails', 'Update', 'แก้ไขข้อมูลครอบครอง', auth()->user()->id));
                    $assetDetail->save();
                }
                //$assetDetail->save();
                //-------------------------------------------------------------------
                DB::commit();
                // all good

                //$eventLog = event(new LogDataAsset( $request->data['asset_id'], 'update', 'DataAsset &Details', 'Update' , 'แก้ไขข้อมูลทรัพย์', auth()->user()->id));

            } catch (\Exception $e) {
                DB::rollback();

                // something went wrong
                throw $e;

            }
            //-------------------------------------------------
            if ($request->filter_asset == null) {
                $filter_asset = 'lastest';
            } else {
                $filter_asset = $request->filter_asset;
            }

            $ownership = Data_AssetsOwnership::where('id', $request->dataOwn_Id)->first();
            $dataCusId = $ownership->DataCus_Id;
            $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
            $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();
            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'การเปลี่ยนแปลงถูกบันทึกแล้ว!',
            ]);
        } elseif ($request->mod == "state") {

            DB::beginTransaction();
            try {
                $dataAsset = Data_Assets::where('id', $id)->first();

                if ($request->Status_Asset == 'Active') {
                    if ($dataAsset->TypeAsset_Code == 'land') {
                        $check_duplicate = Data_Assets::where('id', '!=', $id)
                            ->where('Status_Asset', 'Active')
                            ->where('Land_Id', '=', $dataAsset->Land_Id)
                            ->where('Land_Province', '=', $dataAsset->Land_Province)
                            ->where('Land_District', '=', $dataAsset->Land_District)
                            ->get();
                        $excption_text = "ไม่สามารถเปิดใช้งานทรัพย์ที่มี เลขโฉนด/จังหวัด/อำเภอ เดียวกันพร้อมกันได้";
                    } else {
                        $check_duplicate = Data_Assets::where('id', '!=', $id)
                            ->where('Status_Asset', 'Active')
                            ->where('Vehicle_Chassis', '=', $dataAsset->Vehicle_Chassis)
                            ->get();
                        $excption_text = "ไม่สามารถเปิดใช้งานทรัพย์ที่มีเลขถังเดียวกันพร้อมกันได้";
                    }
                    if (count($check_duplicate) > 0) { // แสดงว่าเลขถังซ้ำ
                        $duplicateAsset = $check_duplicate->first();
                        throw new \Exception($excption_text);
                    }
                }

                if ( ($request->Status_Asset == 'Inactive' || $request->Status_Asset == 'Hide') && $dataAsset->Flag_Asset != null && ($dataAsset->Flag_Asset == 'CU' || $dataAsset->Flag_Asset == 'InUse')) {
                    throw new \Exception("ไม่สามารถปิดใช้งานหรือลบทรัพย์ที่กำลังใช้ในสัญญาได้");
                }

                $old_status = $dataAsset->Status_Asset;
                $dataAsset->Status_Asset = $request->Status_Asset;
                $dataAsset->UserUpdate = \Auth::user()->id;
                $dataAsset->save();
                //-------------------------------------------------------------------
                DB::commit();
                // all good

                $eventLog = event(new LogDataAsset($id, 'update', 'DataAsset', 'Update', 'อัพเดตสถานะทรัพย์', auth()->user()->id));

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                throw $e;
            }
            //------------------------------------------------------------

            if ($request->page == 'asset') {
                $asset = Data_Assets::where('id', $id)
                    ->with([
                        'AssetToManyOwner' => function ($query) {
                            $query->orderBy('id', 'asc');
                        }
                    ])
                    ->first();
                $html = view('frontend.content-asset.section-asset.asset-detail', compact('asset'))->render();
            } else {
                if ($request->filter_asset == null) {
                    $filter_asset = 'lastest';
                } else {
                    $filter_asset = $request->filter_asset;
                }
                $dataCusId = $request->dataCusId;
                $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
                $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();
            }

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'การอัปเดตสถานะทรัพย์เสร็จสมบูรณ์แล้ว!',
            ]);
        } elseif ($request->mod == "owner-state") {
            DB::beginTransaction();
            try {
                $ownership = Data_AssetsOwnership::where('id', $id)->first();
                if ($request->Status_Owner == 'Cancel') {
                    if ($ownership->State_Ownership == 'Active' || $ownership->State_Ownership == 'Transfer') {
                        $ownership->State_Ownership = 'Cancel';
                    } else {
                        throw new \Exception("สามารถยกเลิกการครอบครองในสถานะพร้อมใช้งาน หรือรอโอนย้ายได้เท่านั้น");
                    }
                }

                $ownership->UserUpdate = \Auth::user()->id;
                $ownership->save();
                //-------------------------------------------------------------------
                DB::commit();
                // all good
                // event Log
                //$eventLog = event(new LogDataAsset( $id, 'update', 'DataAsset', 'Update' , 'อัพเดตสถานะทรัพย์', auth()->user()->id));
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                throw $e;
            }
            //--------------------------------------------------
            if ($request->filter_asset == null) {
                $filter_asset = 'lastest';
            } else {
                $filter_asset = $request->filter_asset;
            }
            $dataCusId = $ownership->DataCus_Id;
            $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
            $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();
            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'การอัปเดตสถานะครอบครองเสร็จสมบูรณ์แล้ว!',
            ]);
        } elseif ($request->mod == "transfer") {
            DB::beginTransaction();
            try {

                //-------------------------------------------------------------------
                // เช็ค canTransfer อีกรอบตอนจะเซฟ
                $dataAsset = Data_Assets::where('id', $id)->first();
                //if ($request->type == 'transfer' && $dataAsset->canTransfer() == false) {
                if ($dataAsset->canTransfer() == false) {
                    throw new \Exception("ขออภัย! ทรัพย์นี้อยู่ในสถานะที่ไม่สามารถโอนย้ายได้แล้ว กรุณาตรวจสอบข้อมูลล่าสุด");
                }

                //-------------------------------------------------------------------
                // สถานะ OwnerShip 
                //-------------------------------------------------------------------
                // ถ้าเป็นการยิายทรัพย์ในขณะที่มีทรัพย์เดิมกำลังทำสัญญาอยู่ ให้สถานะเป็น Transfer
                $new_state = "Active";
                $owner_contract = $dataAsset->getOwnerContract();
                // เช็คว่าทรัพย์กำลังทำสัญญารีเปล่า
                if ($owner_contract->count() > 0) {
                    // เข็คว่าเจ้าของทรัพย์ที่ทำสัญญา เป็นคนเดียวกับเจ้าของทรัพย์ใหม่ไหม
                    // ถ้าโอนทรัพย์ให้คนอื่น สถานะจะเป็น Transfer
                    if ($owner_contract->where('DataCus_Id', '!=', $request->dataCus_Id)->count() > 0) {
                        $new_state = "Transfer";
                    }
                }

                //-------------------------------------------------------------------
                // สร้าง Data_AssetsOwnership ข้อมูลการครอบครอง
                //-------------------------------------------------------------------
                $newOwnership = new Data_AssetsOwnership;
                $newOwnership->State_Ownership = $new_state;
                $newOwnership->DataCus_Id = $request->dataCus_Id;
                $newOwnership->DataAsset_Id = $id;
                $newOwnership->UserZone = \Auth::user()->zone;
                $newOwnership->UserBranch = \Auth::user()->branch;
                $newOwnership->UserInsert = \Auth::user()->id;
                $newOwnership->save();

                // สร้าง Details         
                $newAssetDetail = $this->CreateAssetDetails(
                    $request->data,
                    $dataAsset->TypeAsset_Code,
                    $newOwnership->id,
                    $dataAsset->Vehicle_Miles
                );

                //-------------------------------------------------------------------
                DB::commit();
                // all good
                // event Log
                //$eventLog = event(new LogDataAsset( $id, 'update', 'DataAsset', 'Update' , 'อัพเดตสถานะทรัพย์', auth()->user()->id));
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                throw $e;
            }
            if ($request->filter_asset == null) {
                $filter_asset = 'lastest';
            } else {
                $filter_asset = $request->filter_asset;
            }
            $dataCusId = $request->page_dataCusId;
            $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
            $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();
            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'สร้างการครอบครองใหม่สำเร็จแล้ว!',
            ]);
        }

    }

    public function store(Request $request)
    {
        $new_code = '';
        DB::beginTransaction();
        try {
            $CodeJob = "";
            $new_code = $CodeJob;
            //-------------------------------------------------------------------
            $newAsset = new Data_Assets;
            $newAsset->Code_Asset = $CodeJob;
            $newAsset->DataCus_Id = $request->dataCus_Id;
            $newAsset->Status_Asset = 'Active';
            $newAsset->TypeAsset_Code = $request->AssetType;
            $newAsset->Flag_Asset = "NotUse";

            if ($request->AssetType == 'car' or $request->AssetType == 'moto') {
                $newAsset->Price_Asset = floatval(str_replace(",", "", $request->data['Mid_Price']));

                // ข้อมูลทั่วไปรถ
                //$newAsset->Vehicle_OldLicense = $request->data['Vehicle_OldLicense'];
                $newAsset->Vehicle_OldLicense_Text = $request->data['Vehicle_OldLicense_Text'];
                $newAsset->Vehicle_OldLicense_Number = $request->data['Vehicle_OldLicense_Number'];
                $newAsset->Vehicle_OldLicense_Province = $request->data['Vehicle_OldLicense_Province'];
                $newAsset->Vehicle_OldLicense = $newAsset->Vehicle_OldLicense_Text . ' ' . $newAsset->Vehicle_OldLicense_Number . ' ' . $newAsset->Vehicle_OldLicense_Province;

                //$newAsset->Vehicle_NewLicense = $request->data['Vehicle_NewLicense'];
                $newAsset->Vehicle_NewLicense_Text = $request->data['Vehicle_NewLicense_Text'];
                $newAsset->Vehicle_NewLicense_Number = $request->data['Vehicle_NewLicense_Number'];
                $newAsset->Vehicle_NewLicense_Province = $request->data['Vehicle_NewLicense_Province'];
                if (empty($request->data['Vehicle_NewLicense_Text']) && empty($request->data['Vehicle_NewLicense_Number']) && empty($request->data['Vehicle_NewLicense_Province'])) {
                    $newAsset->Vehicle_NewLicense = null;
                } else {
                    $newAsset->Vehicle_NewLicense = $newAsset->Vehicle_NewLicense_Text . ' ' . $newAsset->Vehicle_NewLicense_Number . ' ' . $newAsset->Vehicle_NewLicense_Province;
                }

                $newAsset->Vehicle_Chassis = $request->data['Vehicle_Chassis'];
                $newAsset->Vehicle_Engine = $request->data['Vehicle_Engine'];
                $newAsset->Vehicle_Color = $request->data['Vehicle_Color'];
                $newAsset->Vehicle_Miles = $request->data['Vehicle_Miles'];
                $newAsset->Vehicle_CC = $request->data['Vehicle_CC'];
                $newAsset->Vehicle_Type = $request->data['Vehicle_Type'];
                $newAsset->Vehicle_Type_PLT = $request->data['Vehicle_Type_PLT'];

                // ข้อมูลประเภทรถ - ยี่ห้อ/กลุ่ม/รุ่น/ปี/เกียร์
                $newAsset->Vehicle_Brand = $request->data['Vehicle_Brand'];
                $newAsset->Vehicle_Group = $request->data['Vehicle_Group'];
                $newAsset->Vehicle_Model = $request->data['Vehicle_Model'];
                $newAsset->Vehicle_Year = $request->data['Vehicle_Year'];

                if ($newAsset->TypeAsset_Code == 'car') {
                    $newAsset->Vehicle_Gear = $request->data['Vehicle_Gear'];
                }
            } elseif ($request->AssetType == 'land') {
                $newAsset->Price_Asset = floatval(str_replace(",", "", $request->data['Appraisal_Price']));

                // ข้อมูลทั่วไปที่ดิน
                $newAsset->Land_Type = $request->data['Land_Type'];
                $newAsset->Land_Id = $request->data['Land_Id'];
                $newAsset->Land_ParcelNumber = $request->data['Land_ParcelNumber'];
                $newAsset->Land_SheetNumber = $request->data['Land_SheetNumber'];
                $newAsset->Land_TambonNumber = $request->data['Land_TambonNumber'];
                $newAsset->Land_Book = $request->data['Land_Book'];
                $newAsset->Land_BookPage = $request->data['Land_BookPage'];

                // ข้อมูลขนาดที่ดิน
                $newAsset->Land_SizeRai = $request->data['Land_SizeRai'];
                $newAsset->Land_SizeNgan = $request->data['Land_SizeNgan'];
                $newAsset->Land_SizeSquareWa = $request->data['Land_SizeSquareWa'];

                // ข้อมูลที่ตั้ง (จังหวัด/อำเถอ ฯลฯ)
                $newAsset->Land_Zone = $request->data['Land_Zone'];
                $newAsset->Land_Province = $request->data['Land_Province'];
                $newAsset->Land_District = $request->data['Land_District'];
                $newAsset->Land_Tambon = $request->data['Land_Tambon'];
                $newAsset->Land_PostalCode = $request->data['Land_PostalCode'];
                $newAsset->Land_Coordinates = $request->data['Land_Coordinates'];
                $newAsset->Land_Detail = $request->data['Land_Detail'];

                // ข้อมูลสิ่งปลูกสร้าง
                $newAsset->Land_BuildingType = $request->data['Land_BuildingType'];
                if ($request->data['Land_BuildingType'] != 'BLD-0001') {
                    $newAsset->Land_BuildingKind = $request->data['Land_BuildingKind'];
                    $newAsset->Land_BuildingStorey = $request->data['Land_BuildingStorey'];
                    $newAsset->Land_BuildingSize = $request->data['Land_BuildingSize'];
                }

            }
            $newAsset->dataTagCal_id = $request->data['dataTagCal_id'];

            $newAsset->UserZone = \Auth::user()->zone;
            $newAsset->UserBranch = \Auth::user()->branch;
            $newAsset->UserInsert = \Auth::user()->id;
            $newAsset->save();


            //-------------------------------------------------------------------
            // สร้าง Data_AssetsOwnership ข้อมูลการครอบครอง
            //-------------------------------------------------------------------
            $newOwnership = new Data_AssetsOwnership;
            $newOwnership->State_Ownership = "Active";
            $newOwnership->DataCus_Id = $request->dataCus_Id;
            $newOwnership->DataAsset_Id = $newAsset->id;
            $newOwnership->UserZone = \Auth::user()->zone;
            $newOwnership->UserBranch = \Auth::user()->branch;
            $newOwnership->UserInsert = \Auth::user()->id;
            $newOwnership->save();
            //-------------------------------------------------------------------

            //-------------------------------------------------------------------
            // สร้าง Data_AssetDetails obj ตัวใหม่ด้วย
            //-------------------------------------------------------------------
            $newAssetDetail = new Data_AssetsDetails;
            $newAssetDetail->DataAssetOwn_Id = $newOwnership->id;
            // dd( $newAssetDetail,$newAssetDetail->DataAsset_Id);

            if ($request->AssetType == 'car' or $request->AssetType == 'moto') {

                $_OccupiedDT = convertDateHumanToPHP($request->data['OccupiedDT_Veh']);
                $newAssetDetail->OccupiedDT = $_OccupiedDT;
                $newAssetDetail->OccupiedTime = $request->data['OccupiedTime_Veh'];

                //$newAssetDetail->InsuranceType_Code = $request->InsuranceType_Code;
                $newAssetDetail->InsuranceState = $request->data['InsuranceState'];
                $newAssetDetail->InsuranceClass = $request->data['InsuranceClass'];
                $newAssetDetail->InsuranceCompany_Id = $request->data['InsuranceCompany_Id'];
                $newAssetDetail->PolicyNumber = $request->data['PolicyNumber'];

                $_InsuranceDT_start = $request->data['InsuranceDT_start'];
                $_InsuranceDT_end = $request->data['InsuranceDT_end'];
                if ($_InsuranceDT_start != null || $_InsuranceDT_end != null) {
                    $_InsuranceDT = convertDateRangeHumanToPHP($_InsuranceDT_start, $_InsuranceDT_end);
                    $newAssetDetail->InsuranceDT = $_InsuranceDT;
                }

                $_InsuranceActDT_start = $request->data['InsuranceActDT_start'];
                $_InsuranceActDT_end = $request->data['InsuranceActDT_end'];
                if ($_InsuranceActDT_start != null || $_InsuranceActDT_end != null) {
                    $_InsuranceActDT = convertDateRangeHumanToPHP($_InsuranceActDT_start, $_InsuranceActDT_end);
                    $newAssetDetail->InsuranceActDT = $_InsuranceActDT;
                }
                $_InsuranceRegisterDT_start = $request->data['InsuranceRegisterDT_start'];
                $_InsuranceRegisterDT_end = $request->data['InsuranceRegisterDT_end'];
                if ($_InsuranceRegisterDT_start != null || $_InsuranceRegisterDT_end != null) {
                    $_InsuranceRegisterDT = convertDateRangeHumanToPHP($_InsuranceRegisterDT_start, $_InsuranceRegisterDT_end);
                    $newAssetDetail->InsuranceRegisterDT = $_InsuranceRegisterDT;
                }

                $newAssetDetail->PurposeType = $request->data['PurposeType'];
                $newAssetDetail->PossessionState_Code = $request->data['PossessionState_Code'];
                $newAssetDetail->PossessionOrder = $request->data['PossessionOrder'];
                $newAssetDetail->History_16 = $request->data['History_16'];
                $newAssetDetail->History_18 = $request->data['History_18'];
                $newAssetDetail->MilesNumber = $newAsset->Vehicle_Miles;

            } else if ($request->AssetType == 'land') {

                $_OccupiedDT = convertDateHumanToPHP($request->data['OccupiedDT_Land']);
                $newAssetDetail->OccupiedDT = $_OccupiedDT;
                $newAssetDetail->OccupiedTime = $request->data['OccupiedTime_Land'];
            }

            // MidPrice, OccupiedDate
            $newAssetDetail->MidPrice = $newAsset->Price_Asset;
            $newAssetDetail->OccupiedDate = $newAssetDetail->OccupiedDT;

            $newAssetDetail->UserZone = \Auth::user()->zone;
            $newAssetDetail->UserBranch = \Auth::user()->branch;
            $newAssetDetail->UserInsert = \Auth::user()->id;
            $newAssetDetail->save();



            //dd($newAsset->id, $newOwnership->DataAsset_Id);


            DB::commit();

            $eventLog = event(new LogDataAsset($newAsset->id, 'insert', 'Data Assets', 'Assets Data', 'สร้างทรัพย์ใหม่', auth()->user()->id));

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            throw $e;
        }

        if ($request->filter_asset == null) {
            $filter_asset = 'lastest';
        } else {
            $filter_asset = $request->filter_asset;
        }

        $dataCusId = $request->dataCus_Id;
        $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
        $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();

        return response()->json([
            'status' => true,
            'message' => 'สร้างทรัพย์ใหม่เสร็จสมบูรณ์แล้ว!',
            'html' => $html,
        ]);
    }

    public function getDataAsset($cusId, $filter_asset = null)
    {

        //$dataAsset = Data_Assets::where('DataCus_Id', $cusId)
        //->where('Status_Asset', 'Active')
        /*
        ->leftJoin('TB_TypeAssets', function($join) {
            $join->on('Data_Assets.TypeAsset_Code', '=', 'TB_TypeAssets.Code_TypeAsset');
        })

        ->leftJoin()

        ->select('Data_Assets.id', 'Code_Asset', 'Status_Asset', 'TypeAsset_Code', 'TB_TypeAssets.Name_TypeAsset', '')

        */
        //->get();

        /*
        $dataAsset = Data_Assets::where('DataCus_Id', $cusId)
            ->get();
        */

        //$dataAsset = Data_Customers::where('id',$cusId)->first()->DataCusToDataAsset;
        //$filter_asset = 'lastest-asset';

        $dataAsset = Data_Customers::where('id', $cusId)->with([
            'DataCusToAssetOwnership' => function ($query) {
                $query->latest();
            }
        ])->first()->DataCusToAssetOwnership;

        // กรองทรัพย์ที่โดนลบไปแล้วออก
        // อนาคตสามารถเพิ่ม filter ดูทรัพย์ที่ลบไปได้
        $dataAsset = $dataAsset->filter(function ($ownership, $key) {
            return $ownership->OwnershipToAsset != NULL;
        })
            // แปลง index ของ array ใหม่ให้นับจาก 0
            ->values()->flatten();

        if ($filter_asset == 'lastest') {
            // กรองสถานะครอบครอง Cancel ออก
            $dataAsset = $dataAsset->filter(function ($ownership, $key) {
                return $ownership->State_Ownership != 'Cancel';
            })
                // จัดกลุ่ม DataAsset_Id ให้เหลือทรัพย์เดียว
                ->groupBy('DataAsset_Id')
                // แปลง index ของ array ใหม่ให้นับจาก 0
                ->map(function ($group) {
                    return $group->first();
                })
                ->values()->flatten();
        }

        return $dataAsset;
    }

    public function CreateAssetDetails($data, $assetType, $own_id, $milesNumber)
    {
        $newAssetDetail = new Data_AssetsDetails;
        $newAssetDetail->DataAssetOwn_Id = $own_id;
        // dd( $newAssetDetail,$newAssetDetail->DataAsset_Id);

        if ($assetType == 'car' or $assetType == 'moto') {

            $_OccupiedDT = convertDateHumanToPHP($data['OccupiedDT_Veh']);
            $newAssetDetail->OccupiedDT = $_OccupiedDT;
            $newAssetDetail->OccupiedTime = $data['OccupiedTime_Veh'];

            //$newAssetDetail->InsuranceType_Code = $request->InsuranceType_Code;
            $newAssetDetail->InsuranceState = $data['InsuranceState'];
            $newAssetDetail->InsuranceClass = $data['InsuranceClass'];
            $newAssetDetail->InsuranceCompany_Id = $data['InsuranceCompany_Id'];
            $newAssetDetail->PolicyNumber = $data['PolicyNumber'];

            $_InsuranceDT_start = $data['InsuranceDT_start'];
            $_InsuranceDT_end = $data['InsuranceDT_end'];
            if ($_InsuranceDT_start != null || $_InsuranceDT_end != null) {
                $_InsuranceDT = convertDateRangeHumanToPHP($_InsuranceDT_start, $_InsuranceDT_end);
                $newAssetDetail->InsuranceDT = $_InsuranceDT;
            }

            $_InsuranceActDT_start = $data['InsuranceActDT_start'];
            $_InsuranceActDT_end = $data['InsuranceActDT_end'];
            if ($_InsuranceActDT_start != null || $_InsuranceActDT_end != null) {
                $_InsuranceActDT = convertDateRangeHumanToPHP($_InsuranceActDT_start, $_InsuranceActDT_end);
                $newAssetDetail->InsuranceActDT = $_InsuranceActDT;
            }
            $_InsuranceRegisterDT_start = $data['InsuranceRegisterDT_start'];
            $_InsuranceRegisterDT_end = $data['InsuranceRegisterDT_end'];
            if ($_InsuranceRegisterDT_start != null || $_InsuranceRegisterDT_end != null) {
                $_InsuranceRegisterDT = convertDateRangeHumanToPHP($_InsuranceRegisterDT_start, $_InsuranceRegisterDT_end);
                $newAssetDetail->InsuranceRegisterDT = $_InsuranceRegisterDT;
            }

            $newAssetDetail->PurposeType = $data['PurposeType'];
            $newAssetDetail->PossessionState_Code = $data['PossessionState_Code'];
            $newAssetDetail->PossessionOrder = $data['PossessionOrder'];
            $newAssetDetail->History_16 = $data['History_16'];
            $newAssetDetail->History_18 = $data['History_18'];

            $newAssetDetail->MilesNumber = $milesNumber;

        } else if ($assetType == 'land') {

            $_OccupiedDT = convertDateHumanToPHP($data['OccupiedDT_Land']);
            $newAssetDetail->OccupiedDT = $_OccupiedDT;
            $newAssetDetail->OccupiedTime = $data['OccupiedTime_Land'];
        }

        $newAssetDetail->UserZone = \Auth::user()->zone;
        $newAssetDetail->UserBranch = \Auth::user()->branch;
        $newAssetDetail->UserInsert = \Auth::user()->id;
        $newAssetDetail->save();
        return $newAssetDetail;
    }


    /**
     * ค้นหาข้อมูลที่ต้องการ โดยการใช้เงื่อนไขตามประเภทต่าง ๆ.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function SearchData(Request $request)
    {
        if ($request->mode == "chassis") {      // ค้นหาเลขถังเพื่อเอาไปเช็คว่าซ้ำไหม
            $SearchValue = str_replace(["_", "-"], "", $request->SearchValue);
            //---------------------------------------------
            if ($request->assetId != '') { // เช็คว่าเป็นการกดแก้ไขรึเปล่า
                # ถ้ากดแก้ไข ให้เช็คเลขถังซ้ำที่ไม่ใช่ไอดีตัวเอง
                $dataAsset = Data_Assets::where('id', '!=', $request->assetId)
                    ->where(function ($query) {
                        $query->where('Status_Asset', 'Active')
                            ->orWhere('Status_Asset', 'Blacklist');
                    })
                    ->where('Vehicle_Chassis', '=', $SearchValue)
                    ->get();
            } else {
                # ถ้าไม่ใช่ ให้เช็คเลขถังกับทรัพย์ทั้งหมดตามปกติ
                $dataAsset = Data_Assets::where(function ($query) {
                    $query->where('Status_Asset', 'Active')
                        ->orWhere('Status_Asset', 'Blacklist');
                })
                    ->where('Vehicle_Chassis', '=', $SearchValue)
                    ->get();
            }
            //---------------------------------------------
            $isblacklist = false;
            $duplicate = false;
            $canTranfer = false;
            $cusData = null;
            $assetId = null;
            $href_tranfer = null;
            //---------------------------------------------
            if (count($dataAsset) > 0) { // แสดงว่าซ้ำ
                $duplicate = true;
                if ($dataAsset->first()->Status_Asset == 'Blacklist') {
                    $isblacklist = true;
                } else if ($dataAsset->first()->DataCus_Id != $request->cusId) {
                    // dataAsset ที่เจอ DataCus_Id ไม่ตรงกับคนนี้
                    // เป็นทรัพย์ของคนละคน สามารถให้ไปย้ายได้
                    $canTranfer = true;
                    $cusData = Data_customers::where('id', $dataAsset->first()->DataCus_Id)->first();
                    $href_tranfer = route('asset.edit', $dataAsset->first()->id) . "?type=1&mode=viewTransfer&new_cusId=" . $request->cusId;
                }
            }
            //--------------------------------------------
            // เช็คสิทธิการย้ายทรัพย์
            if ($canTranfer == true) {
                //$permissionTranfer = !empty(auth::user()->UserToAssignAsset->PerAsset_3);
            } else {
                $permissionTranfer = false;
            }

            // ADD ยังไม่ได้เช็คนะบบสิทธิ์
            $permissionTranfer = false;

            //--------------------------------------------
            return response()->json([
                'isblacklist' => $isblacklist,
                'duplicate' => $duplicate,
                'canTranfer' => $canTranfer,
                'cusData' => $cusData,
                'href_tranfer' => $href_tranfer,
                'permissionTranfer' => $permissionTranfer,
            ]);
        } elseif ($request->mode == "landid") {      // เช็คโฉนดที่ดินซ้ำ เช็ต 3 อย่าง เลขที่โฉนด + จังหวัด + อำเภอ
            $SearchValue = str_replace(["_", "-"], "", $request->search_landid);
            $district_id = $request->search_district_id;
            $province_id = $request->search_province_id;
            //---------------------------------------------
            if ($request->assetId != '') { // เช็คว่าเป็นการกดแก้ไขรึเปล่า
                # ถ้ากดแก้ไข ให้เช็คเลขถังซ้ำที่ไม่ใช่ไอดีตัวเอง
                $dataAsset = Data_Assets::where('id', '!=', $request->assetId)
                    ->where('Status_Asset', 'Active')
                    ->where('Land_Id', '=', $SearchValue)
                    ->where('Land_Province', '=', $district_id)
                    ->where('Land_District', '=', $province_id)
                    ->get();
            } else {
                # ถ้าไม่ใช่ ให้เช็คเลขถังกับทรัพย์ทั้งหมดตามปกติ
                $dataAsset = Data_Assets::where('Status_Asset', 'Active')
                    ->where('Land_Id', '=', $SearchValue)
                    ->where('Land_Province', '=', $district_id)
                    ->where('Land_District', '=', $province_id)
                    ->get();
            }
            //---------------------------------------------
            $duplicate = false;
            $canTranfer = false;
            $cusData = null;
            $assetId = null;
            $href_tranfer = null;
            //---------------------------------------------
            if (count($dataAsset) > 0) { // แสดงว่าซ้ำ
                $duplicate = true;
                if ($dataAsset->first()->DataCus_Id != $request->cusId) {
                    // dataAsset ที่เจอ DataCus_Id ไม่ตรงกับคนนี้
                    // เป็นทรัพย์ของคนละคน สามารถให้ไปย้ายได้
                    $canTranfer = true;
                    $cusData = Data_customers::where('id', $dataAsset->first()->DataCus_Id)->first();
                    $href_tranfer = route('asset.edit', $dataAsset->first()->id) . "?type=1&mode=viewTransfer&new_cusId=" . $request->cusId;
                }
            }
            //--------------------------------------------
            // เช็คสิทธิการย้ายทรัพย์
            if ($canTranfer == true) {
                // $permissionTranfer = !empty(auth::user()->UserToAssignAsset->PerAsset_3);
            } else {
                $permissionTranfer = false;
            }

            // ADD
            $permissionTranfer = false;

            //--------------------------------------------
            return response()->json([
                'duplicate' => $duplicate,
                'canTranfer' => $canTranfer,
                'cusData' => $cusData,
                'href_tranfer' => $href_tranfer,
                'permissionTranfer' => $permissionTranfer,
            ]);
        } elseif ($request->mode == "transfer") {
            $form_id = $request->form_id;
            if ($form_id == "search-old-asset") {

                $search_name = '%' . $request->SearchValue . '%';
                $search_idcard = str_replace(["_", "-"], "", $request->SearchValue);

                $data = Data_Assets::where('Status_Asset', 'Active')
                    ->where(function ($query) use ($search_name) {
                        $query->where('Vehicle_OldLicense', 'LIKE', $search_name)
                            ->orWhere('Vehicle_NewLicense', 'LIKE', $search_name)
                            ->orWhere('Vehicle_Chassis', 'LIKE', $search_name)
                            ->orWhere('Land_Id', 'LIKE', $search_name)
                            ->orWhere('Land_Id', 'LIKE', $search_name);
                    })
                    ->take(50)->get();

            } elseif ($form_id = "search-new-cus") {

                $search_name = '%' . $request->SearchValue . '%';
                $search_idcard = str_replace(["_", "-"], "", $request->SearchValue);

                $data = Data_Customers::where(function ($query) use ($search_name, $search_idcard) {
                    $query->where('Name_Cus', 'LIKE', $search_name)
                        ->orWhere('IDCard_cus', $search_idcard);
                })->take(50)->get();

            } else {
                return response()->json([
                    'feedback-search' => "- ขออภัย! ทำการค้นหาไม่สำเร็จ :'( -",
                    'feedback-data-search' => ''
                ]);
            }

            if ($data->count() > 0) {
                $feedback_search = "";
                $view_data_search = view('frontend.content-asset.section-transfer.data-search', compact('form_id', 'data'))->render();
            } else {
                $feedback_search = "- ขออภัย! ไม่พบผลการค้นหา :'( -";
                $view_data_search = "";
            }

            return response()->json([
                'feedback-search' => $feedback_search,
                'feedback-data-search' => $view_data_search
            ]);
        } elseif ($request->mode == "data-assets") {  // ฐานทรัพย์
            if ($request->type_search == 'license') {
                $assets = Data_Assets::where(function ($query) use ($request) {
                    $query->where('Vehicle_OldLicense', 'LIKE', '%' . $request->input_search . '%')
                        ->orWhere('Vehicle_NewLicense', 'LIKE', '%' . $request->input_search . '%');
                })->get();
            } elseif ($request->type_search == 'chassis') {
                $assets = Data_Assets::where(function ($query) use ($request) {
                    $query->where('Vehicle_Chassis', 'LIKE', '%' . $request->input_search . '%')
                        ->orWhere('Vehicle_NewChassis', 'LIKE', '%' . $request->input_search . '%');
                })->get();
            } elseif ($request->type_search == 'land_id') {
                $assets = Data_Assets::where('Land_Id', 'LIKE', '%' . $request->input_search . '%')->get();
            }

            $typeSreach = $request->type_search;
            $view_content = view('frontend.content-asset.section-asset.asset-list', compact('assets', 'typeSreach'))->render();
            return response()->json(['html' => $view_content], 200);
        }
    }

    // ลบข้อมูล
    public function destroy(Request $request, $id)
    {
        if ($request->mod == "asset") {    // ลบข้อมูลทรัพย์
            //dd($id, $request); dataCusId
            //------------------------------------------------------------
            DB::beginTransaction();
            try {
                //-------------------------------------------------------------------
                $ownership = Data_AssetsOwnership::where('DataAsset_Id', $id)
                    ->whereIn('State_Ownership', ['Process', 'Contract', 'Transfer', 'TransferProcess', 'Completed'])
                    ->get();
                if (count($ownership) > 0) {
                    throw new \Exception("ไม่สามารถลบทรัพย์ที่กำลังดำเนินการกับสัญญาได้");
                }
                $dataAsset = Data_Assets::where('id', $id)->first();
                $dataAsset->Status_Asset = "Hide";

                $dataAsset->UserUpdate = \Auth::user()->id;
                $dataAsset->save();

                // ลบ Data_AssetsOwnership
                $exist_ownership = Data_AssetsOwnership::where('DataAsset_Id', $id)->delete();

                //-------------------------------------------------------------------
                DB::commit();
                // all good
                // event Log
                //$eventLog = event(new LogDataAsset( $id, 'update', 'DataAsset', 'Update' , 'อัพเดตสถานะทรัพย์', auth()->user()->id));
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                throw $e;
            }
            //------------------------------------------------------------

            if ($request->page == 'asset') {
                $asset = Data_Assets::where('id', $id)
                    ->with([
                        'AssetToManyOwner' => function ($query) {
                            $query->orderBy('id', 'asc');
                        }
                    ])
                    ->first();
                $html = view('frontend.content-asset.section-asset.asset-detail', compact('asset'))->render();
            } else {
                if ($request->filter_asset == null) {
                    $filter_asset = 'lastest';
                } else {
                    $filter_asset = $request->filter_asset;
                }
                $dataCusId = $request->dataCusId;
                $dataAsset = $this->getDataAsset($dataCusId, $filter_asset);
                $html = view('frontend.content-asset.view-asset-card-container', compact('dataCusId', 'dataAsset', 'filter_asset'))->render();
            }

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'การอัปเดตสถานะทรัพย์เสร็จสมบูรณ์แล้ว!',
            ]);

        }
    }

}
