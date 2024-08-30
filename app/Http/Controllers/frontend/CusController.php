<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Events\frontend\LogDataCus;
use DB;

use App\Models\TB_Constants\TB_Frontend\TB_BankThai;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusAddress;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusAssets;
use App\Models\TB_Constants\TB_Frontend\TB_CareerCus;
use App\Models\TB_Constants\TB_Frontend\TB_UniqueID_Type;
use App\Models\TB_Constants\TB_Frontend\TB_TypeBroker;
use App\Models\TB_Constants\TB_Frontend\TB_Prefix;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusCareers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_Broker;

// trait
use App\Traits\TagOwners;

class CusController extends Controller
{
    use TagOwners;
    function __construct()
    {
        //$this->middleware('role_or_permission:profile-cus', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        if ($request->page == 'profile-cus') {
            $page_type = 'frontend';
            $page = $request->page;
            $pageUrl = 'customer';
            $typeSreach = 'namecus';
            $dataSreach = [
                'namecus' => true,
                'idcardcus' => true,
                'license' => true,
                'contract' => true,
                'phone' => true,
            ];

            $id = $request->id;
            $data = Data_Customers::where('id', $id)
                ->with([
                    'DataCusToDataCusTag' => function ($query) {
                        return $query->orderBy('id', 'DESC');
                    }
                ])
                ->first();

            return view('frontend.content-cus.view-cus', compact('data', 'page_type', 'page', 'pageUrl', 'typeSreach', 'dataSreach'));
        }
    }

    public function create(Request $request)
    {
        if ($request->funs == 'manage-adds') { //modal create address
            $data = Data_Customers::where('id', $request->id)
                ->select('id')
                ->first();

            $dataAdds = $data->DataCusToDataCusAddsMany;
            $dataTBAdds = TB_TypeCusAddress::generateQuery();

            $funs = 'adds';
            $CodeJob = $this->runBill(date('Y-m-d'), 'ADR', $funs);
            return view('frontend.content-cus.section-address.create-address', compact('data', 'dataAdds', 'CodeJob', 'dataTBAdds'));
        } elseif ($request->funs == 'manage-carreer') { //modal create carreer
            $data = Data_Customers::where('id', $request->id)
                ->select('id')
                ->first();

            $funs = 'carreer';
            $CodeJob = $this->runBill(date('Y-m-d'), 'CRS', $funs);
            $typeCareer = TB_CareerCus::generateQuery();
            return view('frontend.content-cus.section-carreer.create-carreer', compact('data', 'CodeJob', 'typeCareer'));
        } elseif ($request->funs == 'manage-asset') { //modal create asset
            $data = Data_Customers::where('id', $request->id)
                ->select('id')
                ->first();

            $funs = 'asset';
            $CodeJob = $this->runBill(date('Y-m-d'), 'CST', $funs);

            $typeAsset = TB_TypeCusAssets::generateQuery();
            return view('frontend.content-cus.section-asset.create-asset', compact('data', 'CodeJob', 'typeAsset'));
        }
    }
    public function store(Request $request)
    {
        if ($request->funs == 'new-cus') { // สร้างลูกค้าใหม่
            DB::beginTransaction();
            try {
                $dataCus = new Data_Customers;
                $dataCus->date_Cus = date('Y-m-d');
                $dataCus->Code_Cus = null;
                $dataCus->Status_Cus = 'active';

                $dataCus->Prefix = $request->data['Prefix'];
                if ($dataCus->Prefix == 'อื่น ๆ') {
                    $dataCus->PrefixOther = $request->data['PrefixOther'];
                    $dataCus->Name_Cus = $request->data['PrefixOther'] . " " . $request->data['Firstname_Cus'] . " " . $request->data['Surname_Cus'];
                } else {
                    $dataCus->PrefixOther = null;
                    $dataCus->Name_Cus = $request->data['Prefix'] . " " . $request->data['Firstname_Cus'] . " " . $request->data['Surname_Cus'];
                }

                $dataCus->Firstname_Cus = $request->data['Firstname_Cus'];
                $dataCus->Surname_Cus = $request->data['Surname_Cus'];
                $dataCus->Nickname_cus = $request->data['Nickname_cus'];
                $dataCus->NameEng_cus = $request->data['NameEng_cus'];

                $phoneCus = explode(',', @$request->data['Phone_cus']);

                //$dataCus->Phone_cus = ($request->data['Phone_cus'] != NULL ? str_replace(array('-', '_'), "", @$request->data['Phone_cus']) : NULL);
                $dataCus->Phone_cus = ($request->data['Phone_cus'] != NULL ? str_replace(array('-', '_'), "", @$request->data['Phone_cus']) : NULL);
                $dataCus->Phone_cus2 = ($request->data['Phone_cus2'] != NULL ? str_replace(array('-', '_'), "", @$request->data['Phone_cus2']) : NULL);

                $dataCus->Type_Card = $request->data['Type_Card'];
                $dataCus->IDCard_cus = ($request->data['IDCard_cus'] != NULL ? str_replace(array('-', '_'), "", @$request->data['IDCard_cus']) : NULL);
                $dataCus->Branch_id = @$request->data['Branch_id'];
                $dataCus->Status_Com = @$request->data['Status_Com'];

                if (!empty($request->data['IdcardExpire_cus'])) {
                    $dataCus->IdcardExpire_cus = convertDateHumanToPHP($request->data['IdcardExpire_cus']);
                }
                if (!empty($request->data['Birthday_cus'])) {
                    $dataCus->Birthday_cus = convertDateHumanToPHP($request->data['Birthday_cus']);
                }
                /*
                $dataCus->IdcardExpire_cus = ($request->data['IdcardExpire_cus']);
                $dataCus->Birthday_cus = ($request->data['Birthday_cus']);
                */

                $dataCus->Gender_cus = $request->data['Gender_cus'];
                $dataCus->Nationality_cus = $request->data['Nationality_cus'];
                $dataCus->Religion_cus = $request->data['Religion_cus'];
                $dataCus->Driver_cus = $request->data['Driver_cus'];
                $dataCus->Namechange_cus = $request->data['Namechange_cus'];
                $dataCus->Social_Line = $request->data['Social_Line'];
                $dataCus->Social_facebook = $request->data['Social_facebook'];

                $dataCus->Marital_cus = $request->data['Marital_cus'];
                if ($request->data['Mate_cus'] != null) {
                    $dataCus->Mate_cus = $request->data['Mate_cus'];
                    $dataCus->Mate_Phone = $request->data['Mate_Phone'];
                }

                $dataCus->Name_Account = $request->data['Name_Account'];
                $dataCus->Branch_Account = $request->data['Branch_Account'];
                $dataCus->Number_Account = $request->data['Number_Account'];

                $dataCus->Note_cus = $request->data['Note_cus'];

                $dataCus->UserZone = $request->data['zone_cus'] ?? auth()->user()->zone;
                $dataCus->UserBranch = $request->data['branch_cus'] ?? auth()->user()->branch;
                $dataCus->UserInsert = auth()->user()->id;
                $dataCus->save();

                DB::commit();
                Log::channel('daily')->info($dataCus);

                event(new LogDataCus($dataCus->id, 'insert', 'LogDataCus', 'new-cus', 'สร้างข้อมูลลูกค้าใหม่', auth()->user()->id));

                $href_newCus = route('cus.index') . "?page=profile-cus&id=" . $dataCus->id;
                return response()->json(['href_newCus' => $href_newCus, 'message' => 'สร้างลูกค้าสำเร็จแล้ว กำลังพาไปยังหน้าลูกค้า'], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        } elseif ($request->funs == 'manage-adds') { //insert-adds
            $funs = 'adds';
            $CodeJob = $this->runBill(date('Y-m-d'), 'ADR', $funs);
            DB::beginTransaction();
            try {
                $data = new Data_CusAddress;
                $data->DataCus_id = $request->data['DataCus_id'];
                $data->date_Adds = date('Y-m-d');
                $data->Code_Adds = $CodeJob;
                $data->Status_Adds = 'active';

                $data->Type_Adds = $request->data['Type_Adds'];
                $data->houseNumber_Adds = $request->data['houseNumber_Adds'];
                $data->houseGroup_Adds = $request->data['houseGroup_Adds'];
                $data->building_Adds = $request->data['building_Adds'];
                $data->village_Adds = $request->data['village_Adds'];
                $data->roomNumber_Adds = $request->data['roomNumber_Adds'];
                $data->Floor_Adds = $request->data['Floor_Adds'];
                $data->alley_Adds = $request->data['alley_Adds'];
                $data->road_Adds = $request->data['road_Adds'];
                $data->houseZone_Adds = $request->data['houseZone_Adds'];

                $data->houseProvince_Adds = $request->data['houseProvince_Adds'];
                $data->houseDistrict_Adds = $request->data['houseDistrict_Adds'];
                $data->houseTambon_Adds = $request->data['houseTambon_Adds'];
                $data->Postal_Adds = $request->data['Postal_Adds'];
                $data->Detail_Adds = $request->data['Detail_Adds'];
                $data->Coordinates_Adds = $request->data['Coordinates_Adds'];
                $data->Registration_number = @$request->data['Registration_number'];

                //
                $data->UserZone = auth()->user()->zone;
                $data->UserBranch = auth()->user()->branch;
                $data->UserInsert = auth()->user()->name;
                $data->save();

                DB::commit();
                $data = Data_Customers::find($request->data['DataCus_id']);

                // $view = view('components.content-user-about.section-address.insert-adds', compact('data'))->render();
                // return response()->json(array('html' => $view, 'message' => 'success'));
                return response()->view('components.content-user-about.section-address.data-address', compact('data'));
            } catch (\Exception $e) {
                DB::rollback();

                $message = 'error';
                return response()->json(['message' => $e->getMessage()], $e->getCode());
            }
            // $dataLog = new Log_DataCustomers;
            //     $dataLog->Data_id = $request->data['id'];
            //     $dataLog->date = (new DateTime)->format('Y-m-d');
            //     $dataLog->status = "insert";
            //     $dataLog->model = "Customer Details";
            //     $dataLog->tagInput = "AddressTags";
            //     $dataLog->details = $data->Code_Adds;
            //     $dataLog->UserInsert = auth()->user()->id;
            //     $dataLog->save();

            // $data = Data_Customers::where('id', $request->data['id'])->first();

        } elseif ($request->funs == 'manage-carreer') { //New Career
            if ($request->data['main_Career'] == 'yes') {
                $dataCarreer = Data_CusCareers::where('DataCus_id', $request->data['DataCus_id'])
                    ->where('main_Career', 'yes')
                    ->update(['main_Career' => 'no']);
            }

            $funs = 'carreer';
            $CodeJob = $this->runBill(date('Y-m-d'), 'CRS', $funs);

            DB::beginTransaction();
            try {
                $data = new Data_CusCareers;
                $data->DataCus_id = $request->data['DataCus_id'];
                $data->date_Cus = date('Y-m-d');
                $data->Code_Cus = $CodeJob;
                $data->Status_Cus = 'active';
                $data->Main_Career = $request->data['main_Career'];
                $data->Career_Cus = $request->data['Career_Cus'];
                $data->DetailCareer_Cus = @$request->data['DetailCareer_Cus'];
                $data->Workplace_Cus = $request->data['Workplace_Cus'];
                $data->Income_Cus = $request->data['Income_Cus'];
                $data->BeforeIncome_Cus = $request->data['BeforeIncome_Cus'];
                $data->AfterIncome_Cus = $request->data['AfterIncome_Cus'];
                $data->IncomeNote_Cus = $request->data['IncomeNote_Cus'];
                $data->Coordinates = $request->data['Coordinates'];


                $data->UserZone = auth()->user()->zone;
                $data->UserBranch = auth()->user()->branch;
                $data->UserInsert = auth()->user()->name;
                $data->save();

                DB::commit();

                // $data = Data_CusCareers::where('DataCus_id', $request->data['DataCus_id'])->get();
                $data = Data_Customers::find($request->data['DataCus_id']);
                return response()->view('components.content-user-about.section-carreer.data-carreer', compact('data'));
            } catch (\Exception $e) {
                DB::rollback();

                $message = 'error';
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } elseif ($request->funs == 'manage-asset') { //New Asset
            // $CheckMain_Asset = Data_CusAssets::where('DataCus_id', $request->data['DataCus_id'])->get();
            // if ($CheckMain_Asset != NULL && $request->data['Main_Asset'] == 'yes') {
            //     Data_CusAssets::where('DataCus_id', $request->data['DataCus_id'])
            //         ->update([
            //             'Main_Asset' => 'no'
            //         ]);
            // }
            $funs = 'assetCus';
            $CodeJob = $this->runBill(date('Y-m-d'), 'CST', $funs);
            DB::beginTransaction();
            try {

                $data = new Data_CusAssets;
                $data->DataCus_id = $request->data['DataCus_id'];
                $data->date_Asset = date('Y-m-d');
                $data->Code_Asset = @$CodeJob;
                $data->Status_Asset = 'active';
                $data->Type_Asset = @$request->data['Type_Asset'];
                $data->Deednumber_Asset = @$request->data['Deednumber_Asset'];
                $data->Area_Asset = @$request->data['Area_Asset'];

                $data->houseZone_Asset = @$request->data['houseZone_Asset'];
                $data->houseProvince_Asset = @$request->data['houseProvince_Asset'];
                $data->houseDistrict_Asset = @$request->data['houseDistrict_Asset'];
                $data->houseTambon_Asset = @$request->data['houseTambon_Asset'];
                $data->Postal_Asset = @$request->data['Postal_Asset'];

                $data->Coordinates_Asset = @$request->data['Coordinates_Asset'];
                $data->Note_Asset = @$request->data['Note_Asset'];

                $data->UserZone = auth()->user()->zone;
                $data->UserBranch = auth()->user()->branch;
                $data->UserInsert = auth()->user()->name;
                $data->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }


            $data = Data_Customers::where('id', $request->data['DataCus_id'])->first();
            return response()->view('components.content-user-about.section-asset.data-asset', compact('data'));

        } elseif ($request->funs == 'create-broker') {
            DB::beginTransaction();
            try {
                $broker = new Data_Broker;
                $broker->DataCus_id = $request->data['cus_id'];
                $broker->status_Broker = $request->data['status_Broker'];
                $broker->date_Broker = date('Y-m-d');

                $broker->type_Broker = $request->data['type_Broker'];
                $broker->nickname_Broker = $request->data['nickname_Broker'];
                $broker->location_Broker = $request->data['location_Broker'];
                $broker->note_Broker = $request->data['note_Broker'];
                $broker->Link_Broker = $request->data['Link_Broker'];

                $broker->UserZone = auth()->user()->zone;
                $broker->UserBranch = auth()->user()->branch;
                $broker->UserInsert = auth()->user()->id;
                $broker->save();

                DB::commit();
                $eventLog = event(new LogDataCus(@$request->data['DataCus_id'], 'insert', 'LogDataCus', 'create-broker', 'ลงทะเบียนผู้แนะนำ , ' . $broker->status_Broker . ', ' . $broker->type_Broker, auth()->user()->id));

                $message = 'บันทึกผู้แนะนำ เรียบร้อย';
                $data = Data_Customers::find($request->data['cus_id']);
                $viewData = view('frontend.content-cus.section-broker.data-broker', compact('data'))->render();
                return response()->json(['html' => $viewData, 'broker_id' => $broker->id, 'status_Broker' => $broker->status_Broker, 'message' => $message, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }
    public function show($id, Request $request)
    {
        if ($request->funs == 'insert-adds') {
            $data = Data_Customers::find($request->DataCus_id);
            $html = view('components.content-user-about.section-address.data-address', compact('data'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'insert-Career') {
            $data = Data_Customers::find($request->DataCus_id);
            $html = view('components.content-user-about.section-carreer.data-carreer', compact('data'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'insert-Asset') {
            $data = Data_Customers::find($request->DataCus_id);
            $html = view('components.content-user-about.section-asset.data-asset', compact('data'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'card-user') {
            $data = Data_Customers::find($request->DataCus_id);
            $page = 'profile-cus';
            $html = view('components.content-user.card-user', compact('data', 'page'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'card-tag') {
            $data = Data_CusTags::where('DataCus_id', $request->DataCus_id)
                ->orderBy('created_at', 'desc')
                ->get();

            $filter_tag = $this->checkfilterTag($data);
            $id = $request->DataCus_id;
            $html = view('frontend.content-tag.view-tag', compact('data', 'filter_tag', 'id'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'manage-adds') { //viewDetal address
            $typeAdds = TB_TypeCusAddress::generateQuery();
            $data = Data_CusAddress::find($id);
            $funs = $request->funs;
            return view('frontend.content-cus.section-address.viewDetail-address', compact('data', 'funs', 'typeAdds'))->render();
        } elseif ($request->funs == 'manage-carreer') { //viewDetal career
            $data = Data_CusCareers::find($id);
            $typeCareer = TB_CareerCus::generateQuery();

            $type = $request->type;
            return view('frontend.content-cus.section-carreer.viewDetail-carreer', compact('type', 'data', 'typeCareer'));
        } elseif ($request->funs == 'manage-asset') { //viewDetal asset
            $data = Data_CusAssets::find($id);
            $typeAsset = TB_TypeCusAssets::generateQuery();

            $type = $request->type;
            return view('frontend.content-cus.section-asset.viewDetail-asset', compact('type', 'data', 'typeAsset'));
        } elseif ($request->funs == 'add-broker') {
            $data = Data_Customers::find($id);
            $typeBroker = TB_TypeBroker::generateQuery();

            return view('frontend.content-cus.section-broker.view-broker', compact('data', 'typeBroker'));
        } elseif ($request->funs == 'view-tagparts') { //view tagPart
            $tags = Data_CusTags::where('DataCus_id', $id)->orderBY('id', 'DESC')->first();
            $id = $tags->id;
            $DataCus_id = $tags->DataCus_id;
            $filter_tagPart = NULL;
            $flag = 'show';
            if (isset($tags)) {
                if ($tags->Status_Tag == 'active') {
                    $filter_tagPart = NULL;
                } else {
                    $filter_tagPart = 'disabled';
                }
            }
            return view('frontend.content-tag.section-tagpart.show-tagParts', compact('tags', 'filter_tagPart', 'id', 'flag', 'DataCus_id'));
            // return view('frontend.content-tag.section-tagPart.data-tagParts', compact('tags', 'id', 'filter_tagPart'));
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->funs == 'edit-dataCus') {
            $funs = $request->funs;
            $title = 'ข้อมูลลูกค้า ( Customer Details )';
            $sub_topic = 'Edit Customer Information';

            $TBPrefix = TB_Prefix::queryPrefix();
            $TypeCard = TB_UniqueID_Type::GetTypeCard();
            $NameAccount = TB_BankThai::get();

            $data = Data_Customers::where('id', $id)->first();

            $userArr = ['administrator', 'audit', 'manager', 'supervisor'];
            $userRole = auth()->user()->getRoleNames();
            $chkUser = $userRole->filter(function ($item) use ($userArr) {
                return in_array($item, $userArr);
            });

            return view('frontend.content-cus.edit-cus', compact('data', 'funs', 'title', 'sub_topic', 'TBPrefix', 'TypeCard', 'NameAccount', 'chkUser'));
        } elseif ($request->funs == 'manage-adds') { //edit address
            $typeAdds = TB_TypeCusAddress::generateQuery();
            $data = Data_CusAddress::find($id);
            $funs = $request->funs;
            $dataAdds = $data->DataCusAddsToDataCus->DataCusToDataCusAddsMany;
            return view('frontend.content-cus.section-address.edit-address', compact('data', 'funs', 'typeAdds', 'dataAdds'))->render();
        } elseif ($request->funs == 'manage-carreer') { //edit career
            $data = Data_CusCareers::find($id);
            $typeCareer = TB_CareerCus::generateQuery();

            $type = $request->type;
            return view('frontend.content-cus.section-carreer.edit-carreer', compact('type', 'data', 'typeCareer'));
        } elseif ($request->funs == 'manage-asset') { //edit asset
            $data = Data_CusAssets::find($id);
            $typeAsset = TB_TypeCusAssets::generateQuery();

            $type = $request->type;
            return view('frontend.content-cus.section-asset.edit-asset', compact('type', 'data', 'typeAsset'));
        } elseif ($request->funs == 'edit-Status') {
            $data = Data_Customers::find($id);
            return view('frontend.content-cus.view-status', compact('data'));
        }
    }
    public function update(Request $request, $id)
    {
        if ($request->funs == 'edit-dataCus') { //update type call function edit
            DB::beginTransaction();
            try {
                $data = Data_Customers::where('id', $request->data['id'])->first();
                $data->Prefix = @$request->data['Prefix'];
                if ($data->Prefix == 'อื่น ๆ') {
                    $data->PrefixOther = $request->data['PrefixOther'];
                    $data->Name_Cus = $request->data['PrefixOther'] . " " . $request->data['Firstname_Cus'] . " " . $request->data['Surname_Cus'];
                } else {
                    $data->PrefixOther = null;
                    $data->Name_Cus = $request->data['Prefix'] . " " . $request->data['Firstname_Cus'] . " " . $request->data['Surname_Cus'];
                }

                $data->FirstName_Cus = @$request->data['Firstname_Cus'];
                $data->Surname_Cus = @$request->data['Surname_Cus'];
                $data->Nickname_cus = @$request->data['Nickname_cus'];
                $data->NameEng_cus = @$request->data['NameEng_cus'];

                $data->Type_Card = @$request->data['Type_Card'];
                $data->Branch_id = @$request->data['Branch_id'];
                $data->Phone_cus = ($request->data['Phone_cus'] != NULL ? str_replace(array('-', '_'), "", @$request->data['Phone_cus']) : NULL);
                $data->Phone_cus2 = ($request->data['Phone_cus2'] != NULL ? str_replace(array('-', '_'), "", @$request->data['Phone_cus2']) : NULL);
                $data->IDCard_cus = ($request->data['IDCard_cus'] != NULL ? str_replace(array('-', '_'), "", @$request->data['IDCard_cus']) : NULL);
                $data->Status_Com = @$request->data['Status_Com'];

                if (!empty($request->data['IdcardExpire_cus'])) {
                    $data->IdcardExpire_cus = convertDateHumanToPHP($request->data['IdcardExpire_cus']);
                }
                if (!empty($request->data['Birthday_cus'])) {
                    $data->Birthday_cus = convertDateHumanToPHP($request->data['Birthday_cus']);
                }

                $data->Gender_cus = @$request->data['Gender_cus'];
                $data->Nationality_cus = @$request->data['Nationality_cus'];
                $data->Religion_cus = @$request->data['Religion_cus'];
                $data->Driver_cus = @$request->data['Driver_cus'];
                $data->Namechange_cus = @$request->data['Namechange_cus'];
                $data->Social_facebook = @$request->data['Social_facebook'];
                $data->Social_Line = @$request->data['Social_Line'];

                $data->Marital_cus = $request->data['Marital_cus'];
                $data->Mate_cus = @$request->data['Mate_cus'];
                $data->Mate_Phone = @$request->data['Mate_Phone'];

                $data->Name_Account = @$request->data['Name_Account'];
                $data->Branch_Account = @$request->data['Branch_Account'];
                $data->Number_Account = @$request->data['Number_Account'];

                $data->Note_cus = @$request->data['Note_cus'];

                if (!empty($request->data['Status_Cus'])) {
                    $data->Status_Cus = @$request->data['Status_Cus'];
                }
                $data->image_cus = @$request->data['LinkUpload_Con'];

                $data->update();

                DB::commit();
                // session()->push('dataAdds-'.$data->DataCus_id, $data);
                $eventLog = event(new LogDataCus($data->id, 'update', 'LogDataCus', 'edit-dataCus', 'แก้ไขข้อมูลลูกค้า ', auth()->user()->id));

                $type = $request->type;
                $page = @$request->data['page'];
                $title = @$request->data['title'];
                $html_card_user = view('components.content-user.card-user', compact('type', 'page', 'title', 'data'))->render();

                $html_view_profile = view('components.content-user.view-card-profile', compact('data'))->render();

                return response()->json([
                    'html_card_user' => $html_card_user,
                    'html_view_profile' => $html_view_profile,
                    'message' => 'อัพเดตข้อมูลลูกค้าสำเร็จแล้ว!',
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                throw $e;
            }
        } elseif ($request->funs == 'manage-adds') { //Update CusAddress
            $dataAdds = Data_CusAddress::where('id', $request->data['id'])->first();
            $dataAdds->Status_Adds = @$request->data['Status_Adds'];
            $dataAdds->Type_Adds = @$request->data['Type_Adds'];
            $dataAdds->houseNumber_Adds = @$request->data['houseNumber_Adds'];
            $dataAdds->houseGroup_Adds = @$request->data['houseGroup_Adds'];
            $dataAdds->building_Adds = @$request->data['building_Adds'];
            $dataAdds->village_Adds = @$request->data['village_Adds'];
            $dataAdds->roomNumber_Adds = @$request->data['roomNumber_Adds'];
            $dataAdds->Floor_Adds = @$request->data['Floor_Adds'];
            $dataAdds->alley_Adds = @$request->data['alley_Adds'];
            $dataAdds->road_Adds = @$request->data['road_Adds'];
            $dataAdds->houseZone_Adds = @$request->data['houseZone_Adds'];
            $dataAdds->houseProvince_Adds = @$request->data['houseProvince_Adds'];
            $dataAdds->houseDistrict_Adds = @$request->data['houseDistrict_Adds'];
            $dataAdds->houseTambon_Adds = @$request->data['houseTambon_Adds'];
            $dataAdds->Postal_Adds = @$request->data['Postal_Adds'];
            $dataAdds->Detail_Adds = @$request->data['Detail_Adds'];
            $dataAdds->Coordinates_Adds = @$request->data['Coordinates_Adds'];
            $dataAdds->Registration_number = @$request->data['Registration_number'];

            $dataAdds->update();

            $eventLog = event(new LogDataCus(@$request->data['DataCus_id'], 'update', 'LogDataCus', 'manage-adds', 'แก้ไขที่อยู่ลูกค้า :' . $request->data['id'], auth()->user()->id));

            $data = Data_Customers::where('id', @$request->data['DataCus_id'])->first();
            return response()->view('components.content-user-about.section-address.data-address', compact('data'));
        } elseif ($request->funs == 'manage-carreer') { //Update Career
            $CheckMain_Career = Data_CusCareers::where('DataCus_id', $request->data['DataCus_id'])->get();
            if ($CheckMain_Career != NULL && $request->data['Main_Career'] == 'yes') {
                Data_CusCareers::where('DataCus_id', $request->data['DataCus_id'])
                    ->update([
                        'Main_Career' => 'no'
                    ]);
            }
            $data = Data_CusCareers::where('id', $request->data['id'])->first();
            $data->Main_Career = $request->data['Main_Career'];
            $data->Status_Cus = @$request->data['Status_Cus'];
            $data->Career_Cus = $request->data['Career_Cus'];
            $data->DetailCareer_Cus = @$request->data['DetailCareer_Cus'];
            $data->Workplace_Cus = $request->data['Workplace_Cus'];
            $data->Income_Cus = $request->data['Income_Cus'];
            $data->BeforeIncome_Cus = $request->data['BeforeIncome_Cus'];
            $data->AfterIncome_Cus = $request->data['AfterIncome_Cus'];
            $data->IncomeNote_Cus = $request->data['IncomeNote_Cus'];
            $data->Coordinates = $request->data['Coordinates'];

            $data->update();

            $eventLog = event(new LogDataCus(@$request->data['DataCus_id'], 'update', 'LogDataCus', 'manage-carreer', 'แก้ไขอาชีพลูกค้า :' . $request->data['id'], auth()->user()->id));

            $data = Data_Customers::where('id', @$request->data['DataCus_id'])->first();
            return response()->view('components.content-user-about.section-carreer.data-carreer', compact('data'));

        } elseif ($request->funs == 'manage-asset') { //Update CusAsset
            DB::beginTransaction();
            try {
                $dataasst = Data_CusAssets::find($request->data['id']);
                $dataasst->Status_Asset = $request->data['Status_Asset'];
                $dataasst->Type_Asset = @$request->data['Type_Asset'];
                $dataasst->Deednumber_Asset = @$request->data['Deednumber_Asset'];
                $dataasst->Area_Asset = @$request->data['Area_Asset'];
                $dataasst->houseZone_Asset = @$request->data['houseZone_Asset'];
                $dataasst->houseProvince_Asset = @$request->data['houseProvince_Asset'];
                $dataasst->houseDistrict_Asset = @$request->data['houseDistrict_Asset'];
                $dataasst->houseTambon_Asset = @$request->data['houseTambon_Asset'];
                $dataasst->Postal_Asset = @$request->data['Postal_Asset'];
                $dataasst->Coordinates_Asset = @$request->data['Coordinates_Asset'];
                $dataasst->Note_Asset = @$request->data['Note_Asset'];
                $dataasst->update();

                DB::commit();
                $eventLog = event(new LogDataCus(@$request->data['DataCus_id'], 'update', 'LogDataCus', 'manage-asset', 'แก้ไขทรัพย์ค้ำลูกค้า :' . $request->data['id'], auth()->user()->id));

                $data = Data_Customers::where('id', @$request->data['DataCus_id'])->first();
                return response()->view('components.content-user-about.section-asset.data-asset', compact('data'));
            } catch (\Exception $e) {
                DB::rollback();
                return response(['error' => true], 500);

            }

        } elseif ($request->funs == 'update-broker') {
            DB::beginTransaction();
            try {
                $broker = Data_Broker::where('id', $id)->first();
                $broker->status_Broker = $request->data['status_Broker'];
                $broker->type_Broker = $request->data['type_Broker'];
                $broker->nickname_Broker = $request->data['nickname_Broker'];
                $broker->location_Broker = $request->data['location_Broker'];
                $broker->note_Broker = $request->data['note_Broker'];
                $broker->Link_Broker = $request->data['Link_Broker'];
                $broker->update();

                DB::commit();
                event(new LogDataCus(@$request->data['DataCus_id'], 'update', 'LogDataCus', 'update-broker', 'แก้ไขข้อมูลลูกค้าBroker : สถานะ ' . $broker->status_Broker . ' ประเภทนายหน้า ' . $broker->type_Broker, auth()->user()->id));
                Log::channel('daily')->info($broker);

                $message = 'อัพเดตผู้แนะนำ เรียบร้อย';
                $data = Data_Customers::find($request->data['cus_id']);
                $viewData = view('frontend.content-cus.section-broker.data-broker', compact('data'))->render();
                return response()->json(['html' => $viewData, 'broker_id' => $broker->id, 'status_Broker' => $broker->status_Broker, 'message' => $message, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'update-statusCus') {
            DB::beginTransaction();
            try {
                $data = Data_Customers::find($id);
                $data->Status_Cus = $request->statusCus;
                $data->update();
                DB::commit();
                $html_view_profile = view('components.content-user.view-card-profile', compact('data'))->render();
                return response()->json(['html_view_profile' => $html_view_profile]);
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
    }
    public function SearchData(Request $request)
    {
        if ($request->type == 'searchAdds') {
            $data = $request->data;
            $data = Data_CusAddress::where('DataCus_id', $request->idCus)->where('Type_Adds', $request->typeAddress)->first();
            $html = view('frontend.content-cus.section-address.viewCreate-address', compact('data'))->render();
            return response()->json(['html' => $html, 'data' => $data]);

        } elseif ($request->type == 'searchIdCard') { //เช้คเลขบัตร ประชาชน
            //$IdCard = str_replace (["_","-"],"",$request->IdCard);
            //----------------------------------------------------------------
            $Type_Card = @$request->Type_Card;
            $Branch_id = @$request->Branch_id;
            if ($request->IdCard_old != '') { // เช็คว่าเป็นการกดแก้ไขรึเปล่า
                # ถ้ากดแก้ไข ให้เช็คเลขบัตร ปชช. ที่ไม่ใช่ไอดีตัวเอง
                $dataCus = Data_Customers::where('IDCard_cus', '!=', $request->IdCard_old)
                    ->when($Type_Card == '324003', function ($q) use ($Branch_id) {
                        return $q->where('Branch_id', $Branch_id);
                    })
                    ->where('Status_Cus', 'active')
                    ->where('IDCard_cus', '=', $request->IdCard)
                    ->get();
            } else {
                # ถ้าไม่ใช่ ให้เช็คเลขถังกับลูกค้าทั้งหมดตามปกติ
                $dataCus = Data_Customers::where('Status_Cus', 'active')
                    ->when($Type_Card == '324003', function ($q) use ($Branch_id) {
                        return $q->where('Branch_id', $Branch_id);
                    })
                    ->where('IDCard_cus', '=', $request->IdCard)
                    ->get();
            }
            //----------------------------------------------------------------


            $duplicate = false;
            if (count($dataCus) > 0) { // แสดงว่าซ้ำ
                $duplicate = true;
                /*
                if ($dataAsset->first()->DataCus_Id != $request->cusId) {
                    // dataAsset ที่เจอ DataCus_Id ไม่ตรงกับคนนี้
                    // เป็นทรัพย์ของคนละคน สามารถให้ไปย้ายได้
                    $canTranfer = true;
                    $cusData = Data_customers::where('id', $dataAsset->first()->DataCus_Id)->first();
                    $href_tranfer = route('asset.edit', $dataAsset->first()->id)."?type=1&mode=viewTransfer&new_cusId=".$request->cusId;
                }
                */
            }
            //----------------------------------------------------------------
            return response()->json([
                'duplicate' => $duplicate,
            ]);
        } elseif ($request->type == 'searchPhone') { //เช็คเบอร์โทรศัพท์


            $edit_flag = false;
            $phone_cus = '';
            if ($request->phone_old != '') {
                $edit_flag = true;
                $phone_cus = $request->phone_old;
            }

            // แปลงเบอร์โทรที่รับเข้ามาให้เป็นตัวเลขอย่างเดียว
            $phone = preg_replace('/\D/', '', $request->phone);

            // ใช้ whereRaw เพื่อค้นหาเบอร์โทรที่มีรูปแบบหลากหลาย
            // ลบเครื่องหมาย `_`, `-` และ `,` ออกจากเบอร์โทรในฟิลด์ Phone_cus
            $dataCus = Data_Customers::where('Status_Cus', '!=', 'cancel')
                ->when($edit_flag == true, function ($q) use ($phone_cus) {
                    return $q->whereRaw(replacePhone(getFirstPhone('Phone_cus')) . ' != ?', [$phone_cus]);
                })
                ->whereRaw(replacePhone(getFirstPhone('Phone_cus')) . ' = ?', [$phone])
                ->get();

            $duplicate = $dataCus->isNotEmpty(); // ตรวจสอบว่ามีข้อมูลซ้ำหรือไม่
            //----------------------------------------------------------------
            return response()->json([
                'duplicate' => $duplicate,
                'dataCus' => $dataCus,
            ]);
        }
    }

    private function dataCustomer($id)
    {
        $dataCus = Data_Customers::find($id);
        return $dataCus;
    }

    private function runBill($tx_date, $tx_header, $funs)
    {
        if ($funs == 'adds') {
            $runBill = DB::select("SELECT dbo.uft_runbillAdd(?,?)", [$tx_date, $tx_header]);
        } else if ($funs == 'carreer') {
            $runBill = DB::select("SELECT dbo.uft_runbillJob(?,?)", [$tx_date, $tx_header]);
        } else if ($funs == 'asset') {
            $runBill = DB::select("SELECT dbo.uft_runbillAst(?,?)", [$tx_date, $tx_header]);
        } else if ($funs == 'assetCus') {
            $runBill = DB::select("SELECT dbo.uft_runbillAstCus(?,?)", [$tx_date, $tx_header]);
        }

        $flattened = reset($runBill);
        $CodeJob = reset($flattened);

        return $CodeJob;
    }
}
