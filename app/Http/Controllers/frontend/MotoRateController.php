<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TB_Assessments\Stat_rateType;
use App\Models\TB_Assessments\Stat_MotoBrand;
use App\Models\TB_Assessments\Stat_MotoGroup;
use App\Models\TB_Assessments\Stat_MotoModel;
use App\Models\TB_Assessments\Stat_MotoYear;
use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_DataCus\Data_CusTagCalculate;

class MotoRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $type = $request->type;
    //     $rate_type = "moto";
    //     $dataMoto = Stat_MotoBrand::get();
   
    //     return view('data_Rate.data_Moto.view', compact('dataMoto','type','rate_type'));
    // }
    public function index(Request $request){
      // dd($request);
      if($request->type == 1){
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;
        $data = Stat_MotoGroup::where('Brand_id', $brand_id)->get();
    
        $returnHTML = view('data-system.rate-system.data-moto.moto-group', compact('data','brand_id','brand_name'))->render();
        return response()->json(['html' => $returnHTML]);
      }
      elseif($request->type == 2){
        $brand_id = $request->brand_id;
        $group_id = $request->group_id;
        $group_name = $request->group_name;
        $data = Stat_MotoModel::where('Group_id',$group_id)->get();
    
        $returnHTML = view('data-system.rate-system.data-moto.moto-model', compact('data','brand_id','group_id','group_name'))->render();
        return response()->json(['html' => $returnHTML]);
      }
      elseif($request->type == 3){
        $brand_id = $request->brand_id;
        $group_id = $request->group_id;
        $rate_id = $request->rate_id;
        $model_id = $request->model_id;
        $model_name = $request->model_name;
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
                ->where('Group_id', $group_id)
                ->where('Model_id', $model_id)
                ->orderBy('Year_moto','ASC')
                ->get();
    
        $returnHTML = view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'))->render();
        return response()->json(['html' => $returnHTML]);
      } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
      // dd($request);
      if($request->create == 'brand'){
        $title = 'ยี่ห้อรถ';
        $create = $request->create;
        return view('data-system.rate-system.data-moto.create', compact('create','title'));
      }
      elseif($request->create == 'group'){
        $title = 'กลุ่มรถ';
        $create = $request->create;
        $brand_id = $request->brand_id;
        $brand_name = $request->brand_name;
        $carType = Stat_rateType::where('type_car','moto')->get();
        return view('data-system.rate-system.data-moto.create', compact('create','title','brand_id','brand_name','carType'));
      }
      elseif($request->create == 'model'){
        $title = 'รุ่นรถ';
        $create = $request->create;
        $brand_id = $request->BrandID;
        $group_id = $request->GroupID;
        $model_id = $request->ModelID;
        $data = Stat_MotoGroup::where('id',$group_id)->first();
        $carType = Stat_rateType::where('type_car','moto')->get();
        // dd($data);
        return view('data-system.rate-system.data-moto.create', compact('create','title','data','carType','brand_id','group_id'));
      }
      elseif($request->create == 'yearcar'){
        // dd($request);
        $title = 'รุ่นรถย่อย';
        $create = $request->create;
        $brand_id = $request->BrandID;
        $group_id = $request->GroupID;
        $model_id = $request->ModelID;
        $rate_id = $request->RateID;
        $modelname = $request->Modelname;
        
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->first();
              // dd($data,@$data->yearToModelMoto->Model_moto);
        // $carType = Stat_rateType::where('type_car','car')->get();
        return view('data-system.rate-system.data-moto.create', compact('create','title','data','brand_id','group_id','rate_id','model_id','modelname'));
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //   $type = $request->type;
   
    //   if($type==1){ //add edit Brand
    //     $status = "success";
    //     $arr_data = array($status);
    //     $Brandmoto = $request->Brandmoto;
    //     $id = $request->id;
    //     $dataBrand = Stat_MotoBrand::where('id',"=", $id)->first(); 
                   
    //     if($dataBrand==NULL){
    //       $lastid = Stat_MotoBrand::latest('id')->first();
    //       $dataBrand = new Stat_MotoBrand;
    //       $dataBrand->id = ($lastid->id)+1; 
    //     } 

    //     $dataBrand->Brand_moto=$Brandmoto;

    //     $dataBrand->save();

    //     echo json_encode($arr_data);


    //   }elseif($type == 2){ //add edit Group
    //       $arr_data = array();
    //         $brandmoto = $request->Brand_id;
    //         $motoType = $request->carType;
    //         $Group_id = $request->Group_id;
    //         $Group_moto = $request->Group_moto;

    //       $dataGroup = Stat_MotoGroup::where('id',"=", $Group_id)->first(); 
                   
    //       if($dataGroup==NULL){
    //         $lastid = Stat_MotoGroup::latest('id')->first();
    //         $dataGroup = new Stat_MotoGroup;
    //         $dataGroup->id = ($lastid->id)+1; 
    //       } 
         
    //       $dataGroup->Status_group = $request->Status;
    //       $dataGroup->Brand_id=$brandmoto;
    //       $dataGroup->Ratetype_id=$motoType; 
    //       $dataGroup->Group_moto=$Group_moto; 
        
    //       $dataGroup->save();

    //       $status = "success";

    //       $arr_data = array($status,$brandmoto,$type,$motoType);
    //       echo json_encode($arr_data);

    //   }elseif($type==3){ // add edit Model
    //     $arr_data = array();
    //       $brandmoto = $request->Brand_id;
    //       $motoType = $request->carType;
    //       $Group_id = $request->Group_id;
    //       $Model_moto = $request->Model_moto;
    //       $Model_id = $request->Model_id;
    //       $dataModel = Stat_MotoModel::where('id',"=", $Model_id)->first(); 
                   
    //       if($dataModel==NULL){
    //         $lastid = Stat_MotoModel::latest('id')->first();
    //         $dataModel = new Stat_MotoModel;
    //         $dataModel->id = ($lastid->id)+1; 
    //       } 
    //       $dataModel->Status_model = $request->Status;
    //       $dataModel->Brand_id=$brandmoto;
    //       $dataModel->Group_id=$Group_id;
    //       $dataModel->Ratetype_id=$motoType; 
    //       $dataModel->Model_moto=$Model_moto; 
          
    //       $dataModel->save();

    //       $status = "success";

    //       $arr_data = array($status,$Group_id,$type,$motoType);
    //       echo json_encode($arr_data);

    //   }elseif($type==4){// add edit year rate
    //     $arr_data = array();
    //     $Brand_id = $request->Brand_id;
    //     $Ratetype_id = $request->Ratetype_id;
    //     $Group_id = $request->Group_id;
    //     $Model_moto = $request->Model_moto;
    //     $Model_id = $request->Model_id;
    //     $yearmoto = $request->yearmoto;
    //     $Year_id = $request->Year_id;
    //     $dataYear = Stat_MotoYear::where('id',"=", $Year_id)->first(); 
    //     if($dataYear==NULL){
    //       $lastid = Stat_MotoYear::latest('id')->first();
    //       $dataYear = new Stat_MotoYear;
    //       $dataYear->id = ($lastid->id)+1;
    //       $dataYear->Brand_id = $Brand_id;
    //       $dataYear->Group_id = $Group_id;
    //       $dataYear->Ratetype_id = $Ratetype_id;
    //       $dataYear->Model_id = $Model_id;  
            
    //     } 
    //     $dataYear->Status_year = $request->Status;
    //     $dataYear->Year_moto = $yearmoto;
    //     $dataYear->PriceAT_moto = ($request->PriceAT_moto != 0 ? str_replace (array(','),"",$request->PriceAT_moto) : NULL);
    //     $dataYear->PriceMT_moto = ($request->PriceMT_moto != 0 ? str_replace (array(','),"",$request->PriceMT_moto) : 0);  
        
        
    //     $dataYear->save();

    //     $status = "success";

    //     $arr_data = array($status,$Model_id,$type,$Model_moto);
    //     echo json_encode($arr_data);
    //   }
    // }
    public function store(Request $request){
      // dd($request);
      if($request->store == 'brand'){
        $dataBrand = new Stat_MotoBrand;
           $dataBrand->Brand_moto = $request->data['BRANDCAR'];
           $dataBrand->UserZone = auth()->user()->zone;
           $dataBrand->UserBranch = auth()->user()->branch;
           $dataBrand->UserInsert = auth()->user()->username;
        $dataBrand->save();
  
        $scale = 'large';
        $data = Stat_MotoBrand::get();
        return response()->view('data-system.rate-system.data-moto.moto-brand', compact('data','scale'));
      }
      else if($request->store == 'group'){
        // dd($request->data);
        $dataGroup = new Stat_MotoGroup;
             $dataGroup->Status_group = $request->data['STATUS'];
             $dataGroup->Brand_id = $request->data['BRAND_ID'];
             $dataGroup->Ratetype_id = $request->data['TYPECAR']; 
             $dataGroup->Group_moto = $request->data['GROUPCAR'];
             $dataGroup->UserZone = auth()->user()->zone;
             $dataGroup->UserBranch = auth()->user()->branch;
             $dataGroup->UserInsert = auth()->user()->username;
        $dataGroup->save();

        $data = Stat_MotoGroup::where('Brand_id',$request->data['BRAND_ID'])->get();
        // dd($data);
        return response()->view('data-system.rate-system.data-moto.moto-group', compact('data'));
      }
      else if($request->store == 'model'){
        // dd($request,$request->data);
        $dataModel = new Stat_MotoModel;
            $dataModel->Status_model = $request->data['STATUS'];
            $dataModel->Brand_id = $request->data['BRAND_ID'];
            $dataModel->Group_id = $request->data['GROUP_ID'];
            $dataModel->Ratetype_id = $request->data['TYPECAR']; 
            $dataModel->Model_moto = $request->data['MODELCAR']; 
            $dataModel->Tank_No = $request->data['TANKCAR']; 
            $dataModel->Topcar = $request->data['TOPCAR']; 
            $dataModel->UserZone = auth()->user()->zone;
            $dataModel->UserBranch = auth()->user()->branch;
            $dataModel->UserInsert = auth()->user()->username;  
        $dataModel->save();
  
        $group_name = $request->data['GROUPCAR'];
        $data = Stat_MotoModel::where('Group_id',$request->data['GROUP_ID'])->get();
        return response()->view('data-system.rate-system.data-moto.moto-model', compact('data','group_name'));
      }
      else if($request->store == 'yearcar'){
        $brand_id = $request->BRAND_ID;
        $rate_id = $request->RATE_ID;
        $group_id = $request->GROUP_ID;
        $model_name = $request->MODEL_NAME;
        $model_id = $request->MODEL_ID;
        $yearcar = $request->YEARCAR;
        // dd($yearcar,$rate_id);
        for ($i=0; $i < count($yearcar) ; $i++) { 
          if($yearcar[$i] != ""){
            $dataYear = new Stat_MotoYear;
              $dataYear->Brand_id = $brand_id;
              $dataYear->Group_id = $group_id;
              $dataYear->Ratetype_id = $rate_id;
              $dataYear->Model_id = $model_id;  
              
              $dataYear->Year_moto = $yearcar[$i];
              $dataYear->PriceAT_moto = ($request->PRICE_AT[$i] != 0 ? str_replace (array(','),"",$request->PRICE_AT[$i]) : NULL);
              $dataYear->PriceMT_moto = ($request->PRICE_MT[$i] != 0 ? str_replace (array(','),"",$request->PRICE_MT[$i]) : NULL); 
              
              $dataYear->UserZone = auth()->user()->zone;
              $dataYear->UserBranch = auth()->user()->branch;
              $dataYear->UserInsert = auth()->user()->username;  
  
            $dataYear->save();
          }
        }
  
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
        return response()->view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request,$id)
    // {
    //     $type = $request->type;
            
    //     $token =  csrf_token();
    //     $arr_type = array('moto'=>'รถยนต์', 'moto'=>'รถมอเตอร์ไซต์');
    //     $zone = auth()->user()->zone;
    //     $motoType = Stat_rateType::where('type_car','moto')->get();
    //     $dataMoto = Stat_MotoBrand::get();

    //     if ($type == 1) {    //Add Edit Brand 
    //       $flag = $request->flag;
    //       $rate_type = $arr_type[$request->rate_type]; 
    //       $header = "เพิ่มยี่ห้อรถมอเตอร์ไซต์";
    //       if($flag==2){
    //         $moto = Stat_MotoBrand::where('id',$id)->first();
        
    //         $header = "แก้ไขยี่ห้อรถมอเตอร์ไซต์";
    //         }
        
    //       return view('data_Rate.data_Moto.viewModal', compact('type','dataMoto','moto','flag','header','rate_type','token'));
    //     }elseif ($type == 2) { //เพิ่ม แก้ไข  กลุ่มรถ  
    //         $flag = $request->flag;
    //         $idBrand = $request->idBrand;
    //         $idGroup = $request->idGroup;
    //         $nameform = "formGroup";
    //         $header = "เพิ่มกลุ่มรถมอเตอร์ไซต์";

    //         if($flag==2){
    //         $Group = Stat_MotoGroup::where('id',$id)->first();
        
    //         $header = "แก้ไขกลุ่มรถมอเตอร์ไซต์";
    //         }
                
    //       return view('data_Rate.data_Moto.viewModal', compact('type','dataMoto','motoType','idBrand','flag','Group','header','nameform','token'));
    //     }elseif ($type == 3) {    //เพิ่ม แก้ไข  รุ่นรถ  
    //     $flag = $request->flag;
    //     $idBrand = $request->idBrand;
    //     $idGroup = $request->idGroup;
    //     $rate_type = $request->rate_type; 
    //     $nameGroup ="";
    //     $nameform = "formModel";
    //     if($flag==1){ //เพิ่ม รุ่นรถ
    //       $Group = Stat_MotoModel::where('Group_id',$idGroup)->first();
         
    //       if($Group!=NULL){
    //         $Group = $Group;
    //         $addModel = 0;
    //       }else{
    //         $Group = Stat_MotoGroup::where('id',$idGroup)->first();
    //         $addModel = 1;
    //       }
      
            
            
    //         $header = "เพิ่มรุ่นรถมอเตอร์ไซต์";
    //     }elseif($flag==2){ //แก้ไข รุ่นรถ
    //         $Group = Stat_MotoModel::where('id',$idGroup)->first();
    //         $addModel = 0;
    //         $header = "แก้ไขรุ่นรถมอเตอร์ไซต์";
    //     }
                
    //     return view('data_Rate.data_Moto.viewModal', compact('type','rate_type','datamoto','motoType','addModel','flag','Group','header','nameform','token'));
    // }elseif($type == 4){
    //   $flag = $request->flag;
    //   $idBrand = $request->idBrand;
    //   $idModel = $request->idModel;
    //   $rate_type = $request->rate_type; 
      
    //   if($flag==1){ //เพิ่ม รุ่นรถ
    //       $Group = Stat_MotoModel::where('id',$idModel)->first();
          
    //       $header = "เพิ่มปีและราคากลาง";
    //   }elseif($flag==2){ //แก้ไข รุ่นรถ
    //       $Group = Stat_MotoYear::where('id',$id)->first();
          
    //       $header = "แก้ไขปีและราคากลาง";
    //   }

    //   return view('data_Rate.data_Moto.viewModal', compact('type','rate_type','flag','Group','header','token'));
    // }elseif($type == 5){
    //   $model_id = $request->idModel;
    //   $Group = Stat_MotoYear::where('Model_id',$model_id)->get();

    //   return view('data_Rate.data_Moto.viewModal', compact('type','rate_type','flag','Group','header','token'));
    // }
    // }
    public function edit(Request $request,$id){
      // dd($request);
      if($request->edit == 'yearcar'){
        $title = 'อัพเดทข้อมูลแบบกลุ่ม';
        $edit = $request->edit;
        $brand_id = $request->BrandID;
        $group_id = $request->GroupID;
        $model_id = $request->ModelID;
        $rate_id = $request->RateID;
        $modelname = $request->Modelname;
        
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
        $Model_name = $request->ModelName;
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','brand_id','group_id','rate_id','model_id','modelname'));
      }
      elseif($request->edit == 'pricecar'){
        $title = 'ปีและราคารถ';
        $edit = $request->edit;
        $data = Stat_MotoYear::where('id',$id)->first();
        $carType = Stat_rateType::where('type_car','moto')->get();
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','carType'));
      }
      elseif($request->edit == 'modelcar'){
        $title = 'รุ่นรถ';
        $edit = $request->edit;
        $data = Stat_MotoModel::where('id',$id)->first();
        //dd(@$data->modelToBrandMoto->Brand_moto);
        $carType = Stat_rateType::where('type_car','moto')->get();
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','carType'));
      }
      elseif($request->edit == 'groupcar'){
        $title = 'กลุ่มรถ';
        $edit = $request->edit;
        $data = Stat_MotoGroup::where('id',$id)->first();
        $carType = Stat_rateType::where('type_car','moto')->get();
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','carType'));
      }
      elseif($request->edit == 'yearprice'){
        $title = 'อัพเดทเรทราคาแบบกลุ่ม';
        $edit = $request->edit;
        $brand_id = $request->BrandID;
        $group_id = $request->GroupID;
        $model_id = $request->ModelID;
        $rate_id = $request->RateID;
        $modelname = $request->Modelname;
        
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
        $Model_name = $request->ModelName;
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','brand_id','group_id','rate_id','model_id','modelname'));
      }
      elseif($request->edit == 'brandmoto'){
        $title = 'ยี่ห้อรถ';
        $edit = $request->edit;
        $key = $request->key;
        $data = Stat_MotoBrand::where('id',$id)->first();
        // dd($data);
        return view('data-system.rate-system.data-moto.edit', compact('edit','title','data','key'));
      }
    }


    // public function update(Request $request, $id)
    // {
    //   if($request->type == 5){
    //     $Model_id = $request->id;
    //     $countData = count($request->PriceAT_moto);
 
    //     for($i=0;$i<$countData;$i++){
          
    //         $updateYear = Stat_MotoYear::where('id',$request->Year_id[$i])->first();
    //         $updateYear->PriceAT_moto = ($request->PriceAT_moto[$i] != 0 ? str_replace (array(','),"",$request->PriceAT_moto[$i]) : NULL);
    //         $updateYear->PriceMT_moto = ($request->PriceMT_moto[$i] != 0 ? str_replace (array(','),"",$request->PriceMT_moto[$i]) : NULL); 
    //         $updateYear->Status_year = $request->Status[$i];  
            
          
    //         $updateYear->update();
 
    //     }
    //     $status = "success";
 
    //     $arr_data = array($status,$Model_id,$request->type,$request->Model_moto);
    //     echo json_encode($arr_data);
 
    //   }
    // }

    public function update(Request $request, $id){
      // dd($request);
      if($request->update == 'brandmoto'){
        $updateBrand = Stat_MotoBrand::where('id', $request->data['ID'])->first();
        $updateBrand->Brand_moto = $request->data['BRANDCAR'];
        $updateBrand->update();

        $key = $request->data['KEY'];
        $brand_name = $request->data['BRANDCAR'];
        $data = Stat_MotoGroup::where('Brand_id',$request->data['ID'])->get();
        return response()->view('data-system.rate-system.data-moto.moto-group', compact('data','brand_name','key'));
      }
      else if($request->update == 'yearcar'){
        $brand_id = $request->BRAND_ID;
        $rate_id = $request->RATE_ID;
        $group_id = $request->GROUP_ID;
        $model_name = $request->MODEL_NAME;
        $model_id = $request->MODEL_ID;
        $yearcar = $request->YEARCAR;
        $countData = count($request->ID);
  
        for ($i = 0; $i < $countData; $i++) {
  
          $updateYear = Stat_MotoYear::where('id', $request->ID[$i])->first();
          $updateYear->Year_moto = $yearcar[$i];
          $updateYear->PriceAT_moto = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) : NULL);
          $updateYear->PriceMT_moto = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) : NULL);
          $updateYear->Status_year = @$request->STATUS[$i];
  
          $updateYear->UserZone = auth()->user()->zone;
          $updateYear->UserBranch = auth()->user()->branch;
          $updateYear->UserInsert = auth()->user()->username;
          $updateYear->update();
  
        }
  
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
        return response()->view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
      }
      else if($request->update == 'yearprice'){
        // dd($request,$request->TYPERATE);
        $brand_id = $request->BRAND_ID;
        $rate_id = $request->RATE_ID;
        $group_id = $request->GROUP_ID;
        $model_name = $request->MODEL_NAME;
        $model_id = $request->MODEL_ID;
        $yearcar = $request->YEARCAR;
        $countData = count($request->ID);
  
        $AT_RATE = $request->AT_RATE;
        $MT_RATE = $request->MT_RATE;
        $TYPERATE = $request->TYPERATE;
  
        if($TYPERATE != NULL){
          if($TYPERATE == 'up'){
            for ($i = 0; $i < $countData; $i++) {
              $updateYear = Stat_MotoYear::where('id', $request->ID[$i])->first();
              $updateYear->PriceAT_moto = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) + str_replace(array(','), "", $AT_RATE) : NULL);
              $updateYear->PriceMT_moto = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) + str_replace(array(','), "", $MT_RATE) : NULL);
              $updateYear->Status_year = @$request->STATUS[$i];
      
              $updateYear->UserZone = auth()->user()->zone;
              $updateYear->UserBranch = auth()->user()->branch;
              $updateYear->UserInsert = auth()->user()->username;
              $updateYear->update();
            }
          }
          elseif($TYPERATE == 'down'){
            for ($i = 0; $i < $countData; $i++) {
              $updateYear = Stat_MotoYear::where('id', $request->ID[$i])->first();
              $updateYear->PriceAT_moto = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) - str_replace(array(','), "", $AT_RATE) : NULL);
              $updateYear->PriceMT_moto = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) - str_replace(array(','), "", $MT_RATE) : NULL);
              $updateYear->Status_year = @$request->STATUS[$i];
      
              $updateYear->UserZone = auth()->user()->zone;
              $updateYear->UserBranch = auth()->user()->branch;
              $updateYear->UserInsert = auth()->user()->username;
              $updateYear->update();
            }
          }
        }
  
  
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
        return response()->view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
      }
      else if($request->update == 'pricecar'){
        // dd($request);
        $brand_id = $request->data['BRAND_ID'];
        $rate_id = $request->data['RATE_ID'];
        $group_id = $request->data['GROUP_ID'];
        $model_name = $request->data['MODEL_NAME'];
        $model_id = $request->data['MODEL_ID'];
  
        $updateYear = Stat_MotoYear::where('id', $request->data['ID'])->first();
        $updateYear->Year_moto = $request->data['YEARCAR'];
        $updateYear->PriceAT_moto = ($request->data['PRICE_AT'] != 0 ? str_replace(array(','), "", $request->data['PRICE_AT']) : NULL);
        $updateYear->PriceMT_moto = ($request->data['PRICE_MT'] != 0 ? str_replace(array(','), "", $request->data['PRICE_MT']) : NULL);
        $updateYear->PriceAT_old = ($request->data['PRICE_AT_OLD'] != 0 ? str_replace(array(','), "", $request->data['PRICE_AT_OLD']) : NULL);
        $updateYear->PriceMT_old = ($request->data['PRICE_MT_OLD'] != 0 ? str_replace(array(','), "", $request->data['PRICE_MT_OLD']) : NULL);
        $updateYear->Ratetype_id = $request->data['RATE_ID'];
        $updateYear->Status_year = (@$request->data['STATUS']!=null)?@$request->data['STATUS']:'N';
        $updateYear->Link_moto = $request->data['LINK_MOTO'];
        $updateYear->Profile_moto = $request->data['PROFILE_MOTO'];
  
        $updateYear->UserZone = auth()->user()->zone;
        $updateYear->UserBranch = auth()->user()->branch;
        $updateYear->UserInsert = auth()->user()->username;
        $updateYear->update();
  
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->get();
        return response()->view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
      }
      else if($request->update == 'modelcar'){
        $updateModel = Stat_MotoModel::where('id', $request->data['ID'])->first();
        // dd($request,$updateModel);
        $updateModel->Status_model = @$request->data['STATUS'];
        $updateModel->Ratetype_id = $request->data['TYPECAR']; 
        $updateModel->Model_moto = $request->data['MODELCAR']; 
        $updateModel->Tank_No = $request->data['TANKCAR']; 
        $updateModel->Topcar = @$request->data['TOPCAR']; 
        $updateModel->UserZone = auth()->user()->zone;
        $updateModel->UserBranch = auth()->user()->branch;
        $updateModel->UserInsert = auth()->user()->username;  
        $updateModel->update();
  
        $group_name = $request->data['GROUPCAR'];
        $data = Stat_MotoModel::where('Group_id',$request->data['GROUP_ID'])->get();
        return response()->view('data-system.rate-system.data-moto.moto-model', compact('data','group_name'));
      }
      else if($request->update == 'groupcar'){
        $updateGroup = Stat_MotoGroup::where('id', $request->data['ID'])->first();
        // dd($request,$updateGroup);
        $updateGroup->Status_group = @$request->data['STATUS'];
        $updateGroup->Ratetype_id = $request->data['TYPECAR']; 
        $updateGroup->Group_moto = $request->data['GROUPCAR']; 
        $updateGroup->UserZone = auth()->user()->zone;
        $updateGroup->UserBranch = auth()->user()->branch;
        $updateGroup->UserInsert = auth()->user()->username;  
        $updateGroup->update();
  
        $brand_name = $request->data['BRANDCAR'];
        $data = Stat_MotoGroup::where('brand_id',$request->data['BRAND_ID'])->get();
        return response()->view('data-system.rate-system.data-moto.moto-group', compact('data','brand_name'));
      }
  
    }

    // public function destroy(Request $request,$id)
    // {
    //   if($request->type==1){
 
    //     $group_moto = Stat_MotoGroup::where('id',$request->id)->first();
    //     if($group_moto!=NULL){
    //         $group_moto->Status_group = "no";

    //         $group_moto->update();
 
    //         $arr_data = array("success",$request->type,$group_moto->id);
    //         echo json_encode($arr_data);
    //     }
               
    //   }elseif($request->type==2){
 
    //     $model_moto = Stat_MotoModel::where('id',$request->id)->first();
    //     if($model_moto!=NULL){
    //         $model_moto->Status_model = "no";

          
    //         $model_moto->update();
 
    //         $arr_data = array("success",$request->type,$model_moto);
    //         echo json_encode($arr_data);
    //     }
               
    //   }elseif($request->type==3){
 
    //       $year_moto = Stat_MotoYear::where('id',$request->id)->first();
    //       if($year_moto!=NULL){
    //           $year_moto->Status_year = "no";

    //           $year_moto->update();
 
    //           $arr_data = array("success",$request->type,$year_moto,$year_moto->yearToModelmoto->Model_moto);
    //           echo json_encode($arr_data);
    //       }
         
          
    //     }
    // }

    public function destroy(Request $request, $id){
      if ($request->del == 'cardetail') {
        $item = Stat_MotoYear::find($id);
        $item->Delete();
  
        $brand_id = $request->brand_id;
        $group_id = $request->group_id;
        $model_id = $request->model_id;
        $rate_id = $request->rate_id;
        $data = Stat_MotoYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_moto','ASC')
              ->get();
  
        // $model_name = @$data[0]->yearToModelCar->Model_car;
        $model_name = @$request->model_name;
        return response()->view('data-system.rate-system.data-moto.moto-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
      } 
      else if ($request->del == 'model') {
        $item = Stat_MotoModel::find($id);
        $item->Delete();
  
        $brand_id = $request->brand_id;
        $group_id = $request->group_id;
        $data = Stat_MotoModel::where('Group_id',$group_id)->get();
  
        // $group_name = @$data[0]->modelToGroupCar->Group_car;
        $group_name = @$request->group_name;
        
        return response()->view('data-system.rate-system.data-moto.moto-model', compact('data','brand_id','group_id','group_name'));
      } 
      else if ($request->del == 'group'){
        $item = Stat_MotoGroup::find($id);
        $item->Delete();
  
        $brand_id = $request->brand_id;
        $data = Stat_MotoGroup::where('brand_id', $brand_id)->get();
        
        // $brand_name = @$data[0]->groupToBrandCar->Brand_car;
        $brand_name = @$request->brand_name;
        
        return response()->view('data-system.rate-system.data-moto.moto-group', compact('data','brand_id','brand_name'));
      }
      else if ($request->del == 'brand'){
        $item = Stat_MotoBrand::find($id);
        $item->Delete();
        return 'Success';
      }
    }

    public function show(Request $request,$id ){
      $type = $request->type;
      $type_moto = $request->type_moto;
      $Brand_id = $request->Brand_id;
      $Group_id = $request->Group_id;
      $Model_id = $request->Model_id;
      $Val_year = $request->Val_year;

      if($request->type==1){
        $data =  Stat_MotoGroup::where('brand_id',$Brand_id)
                  ->when(!empty($type_moto) , function ($q) use ($type_moto) {
                    return $q->where('Ratetype_id',$type_moto); }) 
                  ->get();  
        
        //$dataGroup =  Stat_MotoGroup::where('id',$Group_id)->first();

        $motoType = Stat_rateType::where('type_car','moto')->get();
        
        
          $selectType = '<div class="row"><select class="form-control form-control-sm SizeText-1" id="type_moto" onchange="showGroup('."'".$Brand_id."'".',this.value)"><option value="">--เลือกประเภทรถ--</option>';
          foreach( $motoType as $value){ 
              if($value->code_car==$request->type_moto){
                $selected = "selected";
              }else{
                $selected = "";
              }            
              $selectType .= '<option value="'.$value->code_car.'" '.$selected.'>'.$value->nametype_car.'</option>';            
            
          }

          $selectType .='</select></div><hr>'; 
          
          $li ="";
          foreach($data as $key => $value){   
            if($value->Status_group=="no"){
              $text_hide = "line_through" ;
            }else{
              $text_hide = "";
            }    
                    
              $li .= '<li class="nav-link item-1 hover-up ">'.
                  '<span class="float-right">'.
                    '<button class="btn btn-warning btn-sm hover-up" data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataMotoRate.show",$value->id).'?type=2&flag=2&rate_type=moto&idGroup='.$value->id.'" title="แก้ไขรายการ">'.
                    '<i class="far fa-edit"></i>'.
                    '</button>'.
                    '<button  onclick="deleteDataMoto('.$value->id.',1)" class="delete-modal btn btn-danger btn-sm AlertForm " title="ลบรายการ">'.
                    '<i class="far fa-eye-slash"></i>'.
                    '</button></span>'.
                    '<a class="nav-link " onclick="ShowModel('."'".$value->id."'".',)"> 
                    <i class="fa-solid fa-motorcycle"></i><span title="'.$value->Group_moto.'" class="'.$text_hide.'" > '.$value->Group_moto.'</span>
                    </a></li>';
            }
            
            $countModel = count($data);
            $arr_data = array($countModel,$li,$selectType);
      
            echo json_encode($arr_data);

      }elseif($request->type==2){
        $type_car = $request->code_moto;
        $data =  Stat_MotoModel::where('Group_id',$Group_id)
                  ->get();

        
        $li ="";
        foreach($data as $key => $value){  
          if($value->Status_model=="no"){
            $text_hide = "line_through" ;
          }else{
            $text_hide = "";
          } 
          $li .= '<li class="nav-link item-1 hover-up " >
          <span class="float-right">              
            <button  type="button" class="btn btn-warning btn-sm hover-up  " data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataMotoRate.show",$value->id).'?type=3&flag=2&rate_type=moto&idGroup='.$value->id.'" title="แก้ไขรายการ"> 
              <i class="far fa-edit"></i>
            </button>
            <button  type="button" onclick="deleteDataMoto('.$value->id.',2)" class="btn btn-danger btn-sm  " title="ลบรายการ">
              <i class="far fa-eye-slash"></i>
            </button>
            </span>
            <a class="nav-link " onclick="ShowModelYear('."'".$value->id."'".','."'".$value->Model_moto."'".')"> 
            <i class="fa-solid fa-motorcycle"></i><span class="'.$text_hide.'" title="'.$value->Model_moto.'" > '.substr(@$value->Model_moto,0,30).'</span>
            </a>
          </li> ';
        }
        $countModel = count($data);
        $arr_data = array($countModel,$li);

        echo json_encode($arr_data);

      }elseif($request->type==3){
        $data =  Stat_MotoYear::where('Model_id',$Model_id)          
            ->get();
          $body="";
            foreach($data as $key => $value){
              if($value->Status_moto=="no"){
                $text_hide = "line_through" ;
              }else{
                $text_hide = "";
              }    
              $body .= '<tr class="'.$text_hide.'">
                <td class="text-center">'. ($key+1).'</td>
                <td class="text-center">'. $value->yearMototype->nametype_car.' </td>
                <td class="text-center">'.  $value->Year_moto.' </td>
                <td class="text-right">'.  number_format(@$value->PriceAT_moto,2) .'</td>
                <td class="text-right">'.  number_format(@$value->PriceMT_moto,2) .'</td>
                <td class="text-center">'.  @$value->updated_at  .'</td>
                <td class="text-right">
                    <button class="btn btn-warning btn-sm hover-up" data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataMotoRate.show",$value->id).'?type=4&flag=2&rate_type=moto" title="แก้ไขรายการ">
                        <i class="far fa-edit"></i>
                    </button>
                    <button type="button" onclick="deleteDataMoto('.$value->id.',3)" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                      <i class="far fa-eye-slash"></i>
                    </button>
                    
                </td>
            </tr>';
          }
          echo $body;
            
      }elseif($request->type == 4){ //brand
          $value = $request->value;
          $dataGroup =  Stat_MotoGroup::where('Ratetype_id',$value)->whereNull('Status_group')->get();
          $optionBrand = "";

          // foreach($dataGroup as $groupCar){
          //   $optionGroup .= "<option value=".$groupCar->id.">".$groupCar->Group_car."</option>";
          // }
          foreach($dataGroup->unique('Brand_id') as $brandMoto){
            $optionBrand .= "<option value=".$brandMoto->Brand_id.">".$brandMoto->groupToBrandMoto->Brand_moto."</option>";
          }
        
          echo $optionBrand;
      }elseif($request->type == 5){ //Group
        $value = $request->value;
        $dataGroup =  Stat_MotoGroup::where('Ratetype_id',$request->type_car)
                      ->where('Brand_id',$value)
                      ->whereNull('Status_group')->get();
        $optionGroup = "";
        foreach($dataGroup as $groupMoto){
          $optionGroup .= "<option value=".$groupMoto->id.">".$groupMoto->Group_moto."</option>";
        }        
      
        echo $optionGroup;
      }elseif($request->type == 6){ //model
        $value = $request->value;
        //  $dataModel =  Stat_MotoModel::where('Ratetype_id',$request->type_car)
        //                ->where('Brand_id',$Brand_id)
        //                ->where('Group_id',$value)
        //                ->whereNull('Status_model')->get();
        //  $optionModel = "";
        //  foreach($dataModel as $modelMoto){
        //    $optionModel .= "<option value=".$modelMoto->id.">".$modelMoto->Model_moto."</option>";
        //  }
        $dataYear =  Stat_MotoYear::select('Model_id')->where('Ratetype_id',$request->type_car)
                    ->where('Brand_id',$Brand_id)
                    ->where('Group_id', $Group_id)
                    ->where('Year_moto',$value)
                    ->whereNull('Status_year')->get();       

        $dataModel =  Stat_MotoModel::whereIn('id',$dataYear)
                      ->whereNull('Status_model')->get();

        $optionModel = "";
        foreach($dataModel as $modelMoto){
        
          $optionModel .= "<option value=".$modelMoto->id." >".$modelMoto->Model_moto."</option>";
        }
        
        echo $optionModel;
      }elseif($request->type == 7){ //year
        $value = $request->value;
        $dataYear =  Stat_MotoYear::select("Year_moto")->where('Ratetype_id',$request->type_car)
                    ->where('Brand_id',$Brand_id)
                    ->where('Group_id', $value)
                    // ->where('Model_id',$value)
                    ->whereNull('Status_year')->groupby('Year_moto')->get();
        $optionYear = "";
        foreach($dataYear as $yearmoto){
        
          $optionYear .= "<option value=".$yearmoto->Year_moto.">".$yearmoto->Year_moto."</option>";
        }
        
        //  $dataYear =  Stat_MotoYear::where('Ratetype_id',$request->type_car)
        //                ->where('Brand_id',$Brand_id)
        //                ->where('Group_id',$Group_id)
        //                ->where('Model_id',$value)
        //                ->whereNull('Status_year')->get();

        //  $optionYear = "";
        //  foreach($dataYear as $yearMoto){
        //    $optionYear .= "<option value=".$yearMoto->id.">".$yearMoto->Year_moto."</option>";
        //  }         
        
        echo $optionYear;
      }elseif($request->type == 8){ //ratePrice
        $value = $request->value;
      
        $dataYear =  Stat_MotoYear::where("Year_moto",$Val_year)
                    ->where('Ratetype_id',$request->type_car)
                    ->where('Brand_id',$Brand_id)
                    ->where('Group_id', $Group_id)
                      ->where('Model_id',$value)->first();

        $ratePrice = $dataYear->PriceAT_moto; 
      
        return array($ratePrice,$dataYear->id) ;
      }elseif ($request->type == 10) {  //TypeLoans
        $value = $request->value;
        $v_select = $request->u_RateCartypes;
        $datatypeCar =  Stat_rateType::where('type_car',$value)->get();

        $optionypeCar = "";
        foreach($datatypeCar as $typeCar){
          if($typeCar->code_car==$v_select){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionypeCar .= "<option value=".$typeCar->code_car." ".$selected.">".$typeCar->nametype_car."</option>";
        }
        
        echo $optionypeCar;
      }elseif ($request->type == 11) {  //getall
        $value = $request->value;
        $Cal_id = $request->Cal_id;
        $Asst_id = $request->Asst_id;
        $dataAssetSelected = "";
        $dataCal = "";
      
        $dataAssetSelected = Data_Assets::where('id','=',$Asst_id)->first();

        $dataCal = Data_CusTagCalculate::where('id',$Cal_id)->first();
        if($Cal_id!=NULL){
          $yearMoto=  Stat_MotoYear::where('id',$dataCal->RateYears)->first();
        }else{
          $yearMoto=  Stat_MotoYear::where('id',$dataAssetSelected->Vehicle_Year)->first();
        }
        

        //type
        $datatypeCar =  Stat_rateType::where('type_car',$value)->get();

        $optiontypeCar = "";

        foreach($datatypeCar as $typeCar){
          if($typeCar->code_car==@$dataCal->RateCartypes||$typeCar->code_car==@$dataAssetSelected->Vehicle_Type){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optiontypeCar .= "<option value=".$typeCar->code_car." ".$selected.">".$typeCar->nametype_car."</option>";
        }

        //brand
        $dataBrand =  Stat_MotoBrand::get();
          $optionBrand = "";

          foreach($dataBrand as $brandMoto){
          if($brandMoto->id==@$dataCal->RateBrands||$brandMoto->id==@$dataAssetSelected->Vehicle_Brand){
            $selected = "selected";
          }else{
            $selected = "";
          }
            $optionBrand .= "<option value=".$brandMoto->id." ". $selected.">".$brandMoto->Brand_moto."</option>";
          }

        //group
          // $dataGroup =  Stat_MotoGroup::where('Ratetype_id',$dataCal->RateCartypes)
          //            ->where('Brand_id',$dataCal->RateBrands)
          //            ->whereNull('Status_group')->get();
          $optionGroup = "";
          foreach($yearMoto->yearToGroupAll as $groupMoto){
            if($groupMoto->Ratetype_id==@$yearMoto->Ratetype_id||$groupMoto->Ratetype_id==@$dataAssetSelected->Vehicle_Type){              
              if($groupMoto->id==@$dataCal->RateGroups||$groupMoto->id==@$dataAssetSelected->Vehicle_Group){
                $selected = "selected";
              }else{
                $selected = "";
              }
              $optionGroup .= "<option value=".$groupMoto->id." ".$selected.">".$groupMoto->Group_moto."</option>";
            }
          }        
        
        if($dataCal!=NULL){
          $dataYear =  Stat_MotoYear::select('Model_id')->where('Ratetype_id',$dataCal->RateCartypes)
                      ->where('Brand_id',$dataCal->RateBrands)
                      ->where('Group_id', $dataCal->RateGroups)
                      //->where('Year_moto',$yearMoto->Year_moto)
                      ->whereNull('Status_year')->get();  
        }else{
          $dataYear =  Stat_MotoYear::select('Model_id')->where('Ratetype_id',$dataAssetSelected->Vehicle_Type)
                        ->where('Brand_id',$dataAssetSelected->Vehicle_Brand)
                        ->where('Group_id', $dataAssetSelected->Vehicle_Group)
                        //->where('Year_moto',$dataAssetSelected->Vehicle_Year)
                        ->whereNull('Status_year')->get(); 
                        
        }   
            

        $dataModel =  Stat_MotoModel::whereIn('id',$dataYear)
                      ->whereNull('Status_model')->get();
        $optionModel = "";
        foreach($dataModel as $modelMoto){
          if($modelMoto->id==@$dataCal->RateModals||$modelMoto->id==@$dataAssetSelected->Vehicle_Model){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionModel .= "<option value=".$modelMoto->id." ".$selected .">".$modelMoto->Model_moto."</option>";
        }
        
        //year
        // $dataYear =  Stat_MotoYear::where('Ratetype_id',$dataCal->RateCartypes)
        //              ->where('Brand_id',$dataCal->RateBrands)
        //              ->where('Group_id',$dataCal->RateGroups)
        //              ->where('Model_id',$dataCal->RateModals)
        //              ->whereNull('Status_year')->get();
        $optionYear = "";
        foreach($yearMoto->yearToYearAll as $yearMoto){
        if($yearMoto->id==@$dataCal->RateYears||$yearMoto->id==@$dataAssetSelected->Vehicle_Year){
          $selected = "selected";
        }else{
          $selected = "";
        }
          $optionYear .= "<option value=".$yearMoto->Year_moto." ".$selected.">".$yearMoto->Year_moto."</option>";
        }         
        return array($optiontypeCar, $optionBrand, $optionGroup, $optionModel, $optionYear );
      }
    }
 }
 
