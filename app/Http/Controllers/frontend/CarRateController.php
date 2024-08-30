<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TB_Assessments\Stat_rateType;
use App\Models\TB_Assessments\Stat_CarBrand;
use App\Models\TB_Assessments\Stat_CarGroup;
use App\Models\TB_Assessments\Stat_CarModel;
use App\Models\TB_Assessments\Stat_CarYear;
use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_DataCus\Data_CusTagCalculate;
use App\User;

class CarRateController extends Controller
{
  public function index(Request $request){
    // dd($request);
    if($request->type == 1){
      $brand_id = $request->brand_id;
      $brand_name = $request->brand_name;
      $data = Stat_CarGroup::where('Brand_id', $brand_id)->get();
  
      $returnHTML = view('data-system.rate-system.data-car.car-group', compact('data','brand_id','brand_name'))->render();
      return response()->json(['html' => $returnHTML]);
    }
    elseif($request->type == 2){
      $brand_id = $request->brand_id;
      $group_id = $request->group_id;
      $group_name = $request->group_name;
      $data = Stat_CarModel::where('Group_id',$group_id)->get();
  
      $returnHTML = view('data-system.rate-system.data-car.car-model', compact('data','brand_id','group_id','group_name'))->render();
      return response()->json(['html' => $returnHTML]);
    }
    elseif($request->type == 3){
      $brand_id = $request->brand_id;
      $group_id = $request->group_id;
      $rate_id = $request->rate_id;
      $model_id = $request->model_id;
      $model_name = $request->model_name;
      $data = Stat_CarYear::where('Brand_id',$brand_id)
              ->where('Group_id', $group_id)
              ->where('Model_id', $model_id)
              ->orderBy('Year_car','ASC')
              ->get();
      
      $returnHTML = view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'))->render();
      return response()->json(['html' => $returnHTML]);
    } 
  }

  public function create(Request $request){
    // dd($request);
    if($request->create == 'brand'){
      $title = 'ยี่ห้อรถ';
      $create = $request->create;
      return view('data-system.rate-system.data-car.create', compact('create','title'));
    }
    elseif($request->create == 'group'){
      $title = 'กลุ่มรถ';
      $create = $request->create;
      $brand_id = $request->brand_id;
      $brand_name = $request->brand_name;
      $carType = Stat_rateType::where('type_car','car')->get();
      return view('data-system.rate-system.data-car.create', compact('create','title','brand_id','brand_name','carType'));
    }
    elseif($request->create == 'model'){
      $title = 'รุ่นรถ';
      $create = $request->create;
      $brand_id = $request->BrandID;
      $group_id = $request->GroupID;
      $model_id = $request->ModelID;
      $data = Stat_CarGroup::where('id',$group_id)->first();
      $carType = Stat_rateType::where('type_car','car')->get();
      // dd($data);
      return view('data-system.rate-system.data-car.create', compact('create','title','data','carType','brand_id','group_id'));
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
      
      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->first();
            // dd($data);
      // $carType = Stat_rateType::where('type_car','car')->get();
      return view('data-system.rate-system.data-car.create', compact('create','title','data','brand_id','group_id','rate_id','model_id','modelname'));
    }
  }

  public function store(Request $request){
    // dd($request);
    if($request->store == 'brand'){
      $dataBrand = new Stat_CarBrand;
         $dataBrand->Brand_car = $request->data['BRANDCAR'];
         $dataBrand->UserZone = auth()->user()->zone;
         $dataBrand->UserBranch = auth()->user()->branch;
         $dataBrand->UserInsert = auth()->user()->username;
      $dataBrand->save();

      $scale = 'large';
      $data = Stat_CarBrand::get();
      return response()->view('data-system.rate-system.data-car.car-brand', compact('data','scale'));
    }
    else if($request->store == 'group'){
      // dd(count($request->data));
      $dataGroup = new Stat_CarGroup;
           $dataGroup->Status_group = $request->data['STATUS'];
           $dataGroup->Brand_id = $request->data['BRAND_ID'];
           $dataGroup->Ratetype_id = $request->data['TYPECAR']; 
           $dataGroup->Group_car = $request->data['GROUPCAR'];
           $dataGroup->UserZone = auth()->user()->zone;
           $dataGroup->UserBranch = auth()->user()->branch;
           $dataGroup->UserInsert = auth()->user()->username;
      $dataGroup->save();

      // $data = Stat_CarBrand::get();
      $data = Stat_CarGroup::where('brand_id',$request->data['BRAND_ID'])->get();
      return response()->view('data-system.rate-system.data-car.car-group', compact('data'));
    }
    else if($request->store == 'model'){
      // dd($request,$request->data);
      $dataModel = new Stat_CarModel;
          $dataModel->Status_model = $request->data['STATUS'];
          $dataModel->Brand_id = $request->data['BRAND_ID'];
          $dataModel->Group_id = $request->data['GROUP_ID'];
          $dataModel->Ratetype_id = $request->data['TYPECAR']; 
          $dataModel->Model_car = $request->data['MODELCAR']; 
          $dataModel->Tank_No = $request->data['TANKCAR']; 
          $dataModel->Topcar = $request->data['TOPCAR']; 
          $dataModel->UserZone = auth()->user()->zone;
          $dataModel->UserBranch = auth()->user()->branch;
          $dataModel->UserInsert = auth()->user()->username;  
      $dataModel->save();

      $group_name = $request->data['GROUPCAR'];
      $data = Stat_CarModel::where('Group_id',$request->data['GROUP_ID'])->get();
      return response()->view('data-system.rate-system.data-car.car-model', compact('data','group_name'));
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
          $dataYear = new Stat_CarYear;
            $dataYear->Brand_id = $brand_id;
            $dataYear->Group_id = $group_id;
            $dataYear->Ratetype_id = $rate_id;
            $dataYear->Model_id = $model_id;  
            
            $dataYear->Year_car = $yearcar[$i];
            $dataYear->PriceAT_car = ($request->PRICE_AT[$i] != 0 ? str_replace (array(','),"",$request->PRICE_AT[$i]) : NULL);
            $dataYear->PriceMT_car = ($request->PRICE_MT[$i] != 0 ? str_replace (array(','),"",$request->PRICE_MT[$i]) : NULL); 
            
            $dataYear->UserZone = auth()->user()->zone;
            $dataYear->UserBranch = auth()->user()->branch;
            $dataYear->UserInsert = auth()->user()->username;  

          $dataYear->save();
        }
      }

      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      return response()->view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
    }
  }

  public function show(Request $request, $id){
      $type = $request->type;
      $type_car = $request->type_car;
      $Brand_id = $request->Brand_id;
      $Group_id = $request->Group_id;
      $Model_id = $request->Model_id;
      $Val_year = $request->Val_year;
      if($request->type == 1){
        $data =  Stat_CarGroup::where('brand_id',$Brand_id)          
            ->get();    
          $li ="";
            foreach($data as $key => $value){   
              if($value->Status_group=="no"){
                $text_hide = "line_through" ;
              }else{
                $text_hide = "";
              }       
              $li .= '<li class="nav-link item-1 hover-up " >
              <span class="float-right"> 
              <button class="btn btn-warning btn-sm hover-up"  data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataCarRate.show",$value->id).'?type=2&flag=2&rate_type=car&idGroup='.$value->id.'" title="แก้ไขรายการ">
                  <i class="far fa-edit"></i>
                </button>     
              <button  onclick="deleteDataCar('.$value->id.',1)" class="delete-modal btn btn-danger btn-sm AlertForm " title="ลบรายการ">
                  <i class="far fa-eye-slash"></i>
                </button>              
                </span>
                 <a class="nav-link " onclick="ShowModel('."'".$value->id."'".',)">
                  <i class="fa-solid fa-car"></i><span title="'.$value->Group_car.'" class="'.$text_hide.'"  > '.$value->Group_car.'</span>
                  </a>
              </li> ';
            }
            $countModel = count($data);
            $arr_data = array($countModel,$li);
      
            echo json_encode($arr_data);

      }elseif($request->type == 2){
        $type_car = $request->code_car;
        $data =  Stat_CarModel::where('Group_id',$Group_id)
                ->when(!empty($type_car) , function ($q) use ($type_car) {
                  return $q->where('Ratetype_id',$type_car); }) 
                  ->get();

        $dataGroup =  Stat_CarGroup::where('id',$Group_id)->first();

        $carType = Stat_rateType::where('type_car','car')->get();
        $selectType ="";
        $arr_code = ['C01','C05','C06'];
        if($dataGroup->Ratetype_id=="C02"){ 
          $selectType = '<div class="row">
                        <select class="form-control form-control-sm SizeText-1" id="type_car" onchange="ShowModel('."'".$Group_id."'".',this.value)">
                            <option value="">--เลือกประเภทรถ--</option>';
          foreach( $carType as $value){
          if($value->code_car==$request->code_car){
            $selected = "selected";
          }else{
            $selected = "";
          }            
          
            if(in_array($value->code_car, $arr_code)){
              continue;
            }else{
              $selectType .= '<option value="'.$value->code_car.'" '.$selected.'>'.$value->nametype_car.'</option>';
            }
            
          }

          $selectType .='</select></div><hr>'; 
        }
        $li ='<table class="table table-hover" id="table1">
        <thead>
          <tr>
            <th class="text-center">รุ่นรถ</th>
            <th class="text-center">เลขถัง</th>
            <th class="text-center"></th>         
          </tr>
        </thead>
        <tbody>';
        foreach($data as $key => $value){  
          if($value->Status_model=="no"){
            $text_hide = "line_through" ;
          }else{
            $text_hide = "";
          } 
          // $li .= '<li class="nav-link item-1 hover-up " >
          //   <span class="float-right">              
          //   <button  type="button" class="btn btn-warning btn-sm hover-up  " data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataCarRate.show",$value->id).'?type=3&flag=2&rate_type=car&idGroup='.$value->id.'" title="แก้ไขรายการ"> 
          //     <i class="far fa-edit"></i>
          //   </button>
          //   <button  type="button" onclick="deleteDataCar('.$value->id.',2)" class="btn btn-danger btn-sm  " title="ลบรายการ">
          //     <i class="far fa-eye-slash"></i>
          //   </button>
          //   </span>
          //   <a class="nav-link " onclick="ShowModelYear('."'".$value->id."'".','."'".$value->Model_car."'".')">
          //   <i class="fa-solid fa-car"></i><span class="'.$text_hide.'" title="'.$value->Tank_No.'" > '.substr(@$value->Model_car,0,30).'</span>
          //   </a>
          // </li> ';
          $HighlightRow ="";
          if($value->Topcar!=NULL){
            $HighlightRow ="bg-success";
          }
          $li .='
                <tr class="'.$text_hide.' '.$HighlightRow.'" onclick="ShowModelYear('."'".$value->id."'".','."'".$value->Model_car."'".')" style="cursor: pointer;" >
                  <td>'.@$value->Model_car.'</td>
                  <td>'.@$value->Tank_No.'</td>
                  <td class="text-right"> <button  type="button" class="btn btn-warning btn-sm hover-up  " data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataCarRate.show",$value->id).'?type=3&flag=2&rate_type=car&idGroup='.$value->id.'" title="แก้ไขรายการ"> 
                    <i class="far fa-edit"></i>
                    </button>
                    <button  type="button" onclick="deleteDataCar('.$value->id.',2)" class="btn btn-danger btn-sm  " title="ลบรายการ">
                      <i class="far fa-eye-slash"></i>
                    </button> </td>
                </tr> ';
        }
        $li .="</tbody> </table>";
        $countModel = count($data);
        $arr_data = array($countModel,$li,$selectType);

        echo json_encode($arr_data);

      }elseif($request->type == 3){
        $data =  Stat_CarYear::where('Model_id',$Model_id)          
            ->get();
          $body="";
            foreach($data as $key => $value){
              if($value->Status_year=="no"){
                $text_hide = "line_through" ;
              }else{
                $text_hide = "";
              }    
            $body .= '<tr class="'.$text_hide.'">
                <td class="text-center">'. ($key+1).'</td>
                <td class="text-center">'. $value->yearCartype->nametype_car.' </td>
                <td class="text-center">'.  $value->Year_car.' </td>
                <td class="text-right">'.  number_format(@$value->PriceAT_car,2) .'</td>
                <td class="text-right">'.  number_format(@$value->PriceMT_car,2) .' </td>
                <td class="text-center">'.  @$value->updated_at  .'</td>
                <td class="text-right">
                    <button class="btn btn-warning btn-sm hover-up" data-toggle="modal" data-target="#modal-Popup" data-link="'.route("MasterDataCarRate.show",$value->id).'?type=4&flag=2&rate_type=car" title="แก้ไขรายการ">
                        <i class="far fa-edit"></i>
                    </button>
                    <button type="button" onclick="deleteDataCar('.$value->id.',3)" class="delete-modal btn btn-danger btn-sm AlertForm" title="ลบรายการ">
                      <i class="far fa-eye-slash"></i>
                    </button>
                  
                </td>
            </tr>';
          }
          echo $body;
            
      }elseif($request->type == 4){ //brand
        $value = $request->value;
        $brand_car = $request->brand_car;
        $dataGroup =  Stat_CarModel::where('Ratetype_id',$value)->get();
        $optionBrand = "";

        // foreach($dataGroup as $groupCar){
        //   $optionGroup .= "<option value=".$groupCar->id.">".$groupCar->Group_car."</option>";
        // }
        foreach($dataGroup->unique('Brand_id') as $brandCar){
          if($brandCar->Brand_id==$brand_car){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionBrand .= "<option value=".$brandCar->modelToBrandCar->id." ".$selected.">".$brandCar->modelToBrandCar->Brand_car."</option>";
        }
        
        echo $optionBrand;

      }elseif($request->type == 5){ //Group
        $value = $request->value;
        $group_car = $request->group_car;
        $dataGroup =  Stat_CarModel::where('Ratetype_id',$type_car)
                      ->where('Brand_id',$value)
                      ->whereNull('Status_model')->get();
        $optionGroup = "";
        foreach($dataGroup->unique('Group_id') as $groupCar){
          if($groupCar->id==$group_car){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionGroup .= "<option value=".$groupCar->modelToGroupCar->id." ".$selected.">".$groupCar->modelToGroupCar->Group_car."</option>";
        }        
        echo $optionGroup;

      }elseif($request->type == 6){ //model
        $value = $request->value;
        $model_car = $request->model_car;

        $dataYear =  Stat_CarYear::select('Model_id')->where('Ratetype_id',$type_car)
                      ->where('Brand_id',$Brand_id)
                      ->where('Group_id', $Group_id)
                      ->where('Year_car',$value)
                      ->whereNull('Status_year')->get();       

        $dataModel =  Stat_CarModel::whereIn('id',$dataYear)
                      ->whereNull('Status_model')->get();

        $optionModel = "";
        foreach($dataModel as $modelCar){
          $bg ="";
          if($modelCar->id==$model_car){
            $selected = "selected";
          }else{
            $selected = "";
          }
          if($modelCar->Topcar=='yes'){
            $bg = "class=bg-warning";
          }
          $optionModel .= "<option ".$bg." value=".$modelCar->id." ".$selected.">".$modelCar->Model_car."</option>";
        }

        echo $optionModel;
      }elseif($request->type == 7){ //year
        $value = $request->value;
        $year_car = $request->year_car;
        $dataYear =  Stat_CarYear::select("Year_car")->where('Ratetype_id',$type_car)
                      ->where('Brand_id',$Brand_id)
                      ->where('Group_id', $value)
                      //->where('Model_id',$value)                    
                     
                      ->whereNull('Status_year')
                      ->groupby('Year_car')->get();
        $optionYear = "";
        foreach($dataYear as $yearCar){
          if($yearCar->Year_car==$year_car){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionYear .= "<option value=".$yearCar->Year_car." ".$selected.">".$yearCar->Year_car."</option>";
        }
        
        echo $optionYear;
      }elseif($request->type == 8){ //gear
        $value = $request->value;
        $gear_car = $request->gear_car;
       
        $dataGear =  Stat_CarYear::where("Year_car",$Val_year)
                      ->where('Ratetype_id',$type_car)
                      ->where('Brand_id',$Brand_id)
                      ->where('Group_id', $Group_id)
                       ->where('Model_id',$value)->first();
        
        if (!empty($dataGear->PriceAT_car) and !empty($dataGear->PriceMT_car)) {
          $setStatus = 'show-all';
        }elseif (!empty($dataGear->PriceAT_car) or empty($dataGear->PriceMT_car)) {
          $setStatus = 'show-A';
        }elseif (!empty($dataGear->PriceMT_car) or empty($dataGear->PriceAT_car)) {
          $setStatus = 'show-B';
        }

        if( $gear_car == "Auto"){
            $auto_select = "selected";
            $manual_select = "";
        }elseif( $gear_car == "Manual"){
            $auto_select = "";
            $manual_select = "selected";
        }else{
          $auto_select = "";
            $manual_select = "";
        }

        $optionGears = "";
        if ($setStatus == 'show-all') {
          $optionGears .= "<option value="."Auto"." ".$auto_select." >"."Auto"."</option>
                           <option value="."Manual"." ".$manual_select.">"."Manual"."</option>";
        }elseif ($setStatus == 'show-A') {
          $optionGears .= "<option value="."Auto"." ".$auto_select.">"."Auto"."</option>";
        }elseif ($setStatus == 'show-B') {
          $optionGears .= "<option value="."Manual"." ".$manual_select." >"."Manual"."</option>";
        }

        echo $optionGears;
      }elseif($request->type == 9){ //ratePrice
        $value = $request->value;
        $Year_id = $request->Year_id;
        $dataYear =  Stat_CarYear::where("Year_car",$Val_year)
                    ->where('Ratetype_id',$type_car)
                    ->where('Brand_id',$Brand_id)
                    ->where('Group_id', $Group_id)
                    ->where('Model_id',$Model_id)->first();
        
        if($value == "Auto"){
          $ratePrice = $dataYear->PriceAT_car; 
        }else{
          $ratePrice = $dataYear->PriceMT_car;
        }  
        return array($ratePrice, $dataYear->id );
       
      }elseif ($request->type == 10) {  //TypeLoans
        $value = $request->value;
        $v_select = $request->u_RateCartypes;
        $datatypeCar =  Stat_rateType::where('type_car',$value)->get();

        $optiontypeCar = "";

        foreach($datatypeCar as $typeCar){
          if($typeCar->code_car==$v_select){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optiontypeCar .= "<option value=".$typeCar->code_car." ".$selected.">".$typeCar->nametype_car."</option>";
        }
        
        echo $optiontypeCar;
      }elseif ($request->type == 11) {  //getall
        $value = $request->value;
        $Cal_id = $request->Cal_id;
        $Asst_id = $request->Asst_id;   //view Asset
        $dataAssetSelected = "";
        $dataCal = "";
        
        if($Asst_id!=NULL){
          $dataAssetSelected = Data_Assets::where('id','=',$Asst_id)->first();
          $yearCar =  Stat_CarYear::where('id',$dataAssetSelected->Vehicle_Year)->first();
        }
        if($Cal_id!=NULL){
            $dataCal = Data_CusTagCalculate::where('id',$Cal_id)->first();
            $yearCar =  Stat_CarYear::where('id',$dataCal->RateYears)->first();    
        }
          
        //type
        $datatypeCar =  Stat_rateType::where('type_car',$value)->get();

        $optiontypeCar = "";

        foreach($datatypeCar as $typeCar){
          if($typeCar->code_car==@$dataCal->RateCartypes || $typeCar->code_car == @$dataAssetSelected->Vehicle_Type ){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optiontypeCar .= "<option value=".$typeCar->code_car." ".$selected.">".$typeCar->nametype_car."</option>";
        }

        //brand
        $dataBrand =  Stat_CarBrand::get();
        $optionBrand = "";

        foreach($dataBrand as $brandCar){
          if($brandCar->id==@$dataCal->RateBrands || $brandCar->id==@$dataAssetSelected->Vehicle_Brand){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionBrand .= "<option value=".$brandCar->id." ".$selected.">".$brandCar->Brand_car."</option>";
        }

        //group
        if($Cal_id!=NULL){
          $dataGroup =  Stat_CarModel::where('Ratetype_id',$dataCal->RateCartypes)
                  ->where('Brand_id',$dataCal->RateBrands)
                  ->whereNull('Status_model')->get(); 
         }else{
            $dataGroup =  Stat_CarModel::where('Ratetype_id',$dataAssetSelected->Vehicle_Type)
                  ->where('Brand_id',$dataAssetSelected->Vehicle_Brand)
                  ->whereNull('Status_model')->get(); 
          }
          $optionGroup = "";
         
          foreach($dataGroup->unique('Group_id') as $groupCar){
          
              if($groupCar->Group_id==@$dataCal->RateGroups || $groupCar->Group_id==@$dataAssetSelected->Vehicle_Group){
                $selected = "selected";
              }else{
                $selected = "";
              }
              $optionGroup .= "<option value=".$groupCar->Group_id." ".$selected.">".$groupCar->modelToGroupCar->Group_car."</option>";
            
          }
        //model
        if($Cal_id!=NULL){
          $dataYear =  Stat_CarYear::select('Model_id')->where('Ratetype_id',$dataCal->RateCartypes)
                      ->where('Brand_id',$dataCal->RateBrands)
                      ->where('Group_id', $dataCal->RateGroups)
                      ->where('Year_car',$yearCar->Year_car)
                      ->whereNull('Status_year')->get();    
          // $dataYear =  Stat_CarYear::select('Model_id')->where('id',$dataCal->RateYears)
          //               ->first(); 
                        
        }else{
          $dataYear =  Stat_CarYear::select('Model_id')->where('Ratetype_id',$dataAssetSelected->Vehicle_Type)
                      ->where('Brand_id',$dataAssetSelected->Vehicle_Brand)
                      ->where('Group_id', $dataAssetSelected->Vehicle_Group)
                      ->where('Year_car',$yearCar->Year_car)
                      ->whereNull('Status_year')->get(); 
          // $dataYear =  Stat_CarYear::select('Model_id')->where('id',$dataAssetSelected->Vehicle_Year)
          //               ->whereNull('Status_year')->get(); 
        }
           

        $dataModel =  Stat_CarModel::whereIn('id',$dataYear)
                      ->whereNull('Status_model')->get();
        
        $optionModel = "";
        foreach($dataModel as $modelCar){
          $bg = "";
          if($modelCar->id==@$dataCal->RateModals || $modelCar->id==@$dataAssetSelected->Vehicle_Model ){
            $selected = "selected";
          }else{
            $selected = "";
          }
          if($modelCar->Topcar=='yes'){
            $bg = "class=bg-warning";
          }
          $optionModel .= "<option ".$bg." value=".$modelCar->id." ".$selected.">".$modelCar->Model_car."</option>";
        }

        //year
        // $dataYear =  Stat_CarYear::where('Ratetype_id',$dataCal->RateCartypes)
        //               ->where('Brand_id',$dataCal->RateBrands)
        //               ->where('Group_id',$dataCal->RateGroups)
        //               ->where('Model_id',$dataCal->RateModals)
        //               ->whereNull('Status_year')->get();
        $optionYear = "";
       
        foreach($yearCar->yearToYearAll->unique('Year_car')  as $yearCar){
          if($yearCar->Year_car==@$dataCal->DataCalcuToCarYear->Year_car || $yearCar->Year_car==@$dataAssetSelected->AssetToCarYear->Year_car){
            $selected = "selected";
          }else{
            $selected = "";
          }
          $optionYear .= "<option value=".$yearCar->Year_car." ".$selected.">".$yearCar->Year_car."</option>";
        }
        return array($optiontypeCar, $optionBrand, $optionGroup, $optionModel, $optionYear );
      }
    
      
  }

  public function edit(Request $request,$id){
    // dd($request, $id);
    if($request->edit == 'yearcar'){
      $title = 'อัพเดทข้อมูลแบบกลุ่ม';
      $edit = $request->edit;
      $brand_id = $request->BrandID;
      $group_id = $request->GroupID;
      $model_id = $request->ModelID;
      $rate_id = $request->RateID;
      $modelname = $request->Modelname;
      
      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      $Model_name = $request->ModelName;
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','brand_id','group_id','rate_id','model_id','modelname'));
    }
    elseif($request->edit == 'pricecar'){
      $title = 'ปีและราคารถ';
      $edit = $request->edit;
      $data = Stat_CarYear::where('id',$id)->first();
      $carType = Stat_rateType::where('type_car','car')->get();
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','carType'));
    }
    elseif($request->edit == 'modelcar'){
      $title = 'รุ่นรถ';
      $edit = $request->edit;
      $data = Stat_CarModel::where('id',$id)->first();
      $carType = Stat_rateType::where('type_car','car')->get();
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','carType'));
    }
    elseif($request->edit == 'groupcar'){
      $title = 'กลุ่มรถ';
      $edit = $request->edit;
      $data = Stat_CarGroup::where('id',$id)->first();
      $carType = Stat_rateType::where('type_car','car')->get();
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','carType'));
    }
    elseif($request->edit == 'yearprice'){
      $title = 'อัพเดทเรทราคาแบบกลุ่ม';
      $edit = $request->edit;
      $brand_id = $request->BrandID;
      $group_id = $request->GroupID;
      $model_id = $request->ModelID;
      $rate_id = $request->RateID;
      $modelname = $request->Modelname;
      
      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      $Model_name = $request->ModelName;
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','brand_id','group_id','rate_id','model_id','modelname'));
    }
    elseif($request->edit == 'brandcar'){
      $title = 'ยี่ห้อรถ';
      $edit = $request->edit;
      $key = $request->key;
      $data = Stat_CarBrand::where('id',$id)->first();
      // dd($data);
      return view('data-system.rate-system.data-car.edit', compact('edit','title','data','key'));
    }
  }

  public function update(Request $request, $id){
    // dd($request);
    if($request->update == 'brandcar'){
      $updateBrand = Stat_CarBrand::where('id', $request->data['ID'])->first();
      $updateBrand->Brand_car = $request->data['BRANDCAR'];
      $updateBrand->update();
      // dd($updateBrand);
      // return 'success';
      // $data = Stat_CarBrand::get();
      // $title_small = 'ราคากลางรถยนต์';
      // return view('data-system.rate-system.data-car.view', compact('data','title_small'));
      // return response()->view('data-system.rate-system.data-car.view', compact('data','title_small'));
      $key = $request->data['KEY'];
      $brand_name = $request->data['BRANDCAR'];
      $data = Stat_CarGroup::where('brand_id',$request->data['ID'])->get();
      return response()->view('data-system.rate-system.data-car.car-group', compact('data','brand_name','key'));
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

        $updateYear = Stat_CarYear::where('id', $request->ID[$i])->first();
        $updateYear->Year_car = $yearcar[$i];
        $updateYear->PriceAT_car = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) : NULL);
        $updateYear->PriceMT_car = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) : NULL);
        $updateYear->Status_year = @$request->STATUS[$i];

        $updateYear->UserZone = auth()->user()->zone;
        $updateYear->UserBranch = auth()->user()->branch;
        $updateYear->UserInsert = auth()->user()->username;
        $updateYear->update();

      }

      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      return response()->view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
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
            $updateYear = Stat_CarYear::where('id', $request->ID[$i])->first();
            $updateYear->PriceAT_car = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) + str_replace(array(','), "", $AT_RATE) : NULL);
            $updateYear->PriceMT_car = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) + str_replace(array(','), "", $MT_RATE) : NULL);
            $updateYear->Status_year = @$request->STATUS[$i];
    
            $updateYear->PriceAT_old = str_replace(array(','), "", $request->PRICE_AT[$i]);
            $updateYear->PriceMT_old = str_replace(array(','), "", $request->PRICE_MT[$i]);
            $updateYear->UserZone = auth()->user()->zone;
            $updateYear->UserBranch = auth()->user()->branch;
            $updateYear->UserInsert = auth()->user()->username;
            $updateYear->update();
          }
        }
        elseif($TYPERATE == 'down'){
          for ($i = 0; $i < $countData; $i++) {
            $updateYear = Stat_CarYear::where('id', $request->ID[$i])->first();
            $updateYear->PriceAT_car = ($request->PRICE_AT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_AT[$i]) - str_replace(array(','), "", $AT_RATE) : NULL);
            $updateYear->PriceMT_car = ($request->PRICE_MT[$i] != 0 ? str_replace(array(','), "", $request->PRICE_MT[$i]) - str_replace(array(','), "", $MT_RATE) : NULL);
            $updateYear->Status_year = @$request->STATUS[$i];
    
            $updateYear->PriceAT_old = str_replace(array(','), "", $request->PRICE_AT[$i]);
            $updateYear->PriceMT_old = str_replace(array(','), "", $request->PRICE_MT[$i]);
            $updateYear->UserZone = auth()->user()->zone;
            $updateYear->UserBranch = auth()->user()->branch;
            $updateYear->UserInsert = auth()->user()->username;
            $updateYear->update();
          }
        }
      }


      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      return response()->view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
    }
    else if($request->update == 'pricecar'){
      // dd($request,@$request->data['STATUS']);
      $brand_id = $request->data['BRAND_ID'];
      $rate_id = $request->data['RATE_ID'];
      $group_id = $request->data['GROUP_ID'];
      $model_name = $request->data['MODEL_NAME'];
      $model_id = $request->data['MODEL_ID'];

      $updateYear = Stat_CarYear::where('id', $request->data['ID'])->first();
      $updateYear->Year_car = $request->data['YEARCAR'];
      $updateYear->PriceAT_car = ($request->data['PRICE_AT'] != 0 ? str_replace(array(','), "", $request->data['PRICE_AT']) : NULL);
      $updateYear->PriceMT_car = ($request->data['PRICE_MT'] != 0 ? str_replace(array(','), "", $request->data['PRICE_MT']) : NULL);
      $updateYear->PriceAT_old = ($request->data['PRICE_AT_OLD'] != 0 ? str_replace(array(','), "", $request->data['PRICE_AT_OLD']) : NULL);
      $updateYear->PriceMT_old = ($request->data['PRICE_MT_OLD'] != 0 ? str_replace(array(','), "", $request->data['PRICE_MT_OLD']) : NULL);
      $updateYear->Ratetype_id = $request->data['RATE_ID'];
      $updateYear->Status_year = (@$request->data['STATUS']!=null)?@$request->data['STATUS']:'N';
      $updateYear->Link_car = $request->data['LINK_CAR'];
      $updateYear->Profile_car = $request->data['PROFILE_CAR'];

      $updateYear->UserZone = auth()->user()->zone;
      $updateYear->UserBranch = auth()->user()->branch;
      $updateYear->UserInsert = auth()->user()->username;
      $updateYear->update();

      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();
      return response()->view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
    }
    else if($request->update == 'modelcar'){
      $updateModel = Stat_CarModel::where('id', $request->data['ID'])->first();
      // dd($request,$updateModel);
      $updateModel->Status_model = @$request->data['STATUS'];
      $updateModel->Ratetype_id = $request->data['TYPECAR']; 
      $updateModel->Model_car = $request->data['MODELCAR']; 
      $updateModel->Tank_No = $request->data['TANKCAR']; 
      $updateModel->Topcar = @$request->data['TOPCAR']; 
      $updateModel->UserZone = auth()->user()->zone;
      $updateModel->UserBranch = auth()->user()->branch;
      $updateModel->UserInsert = auth()->user()->username;  
      $updateModel->update();

      $group_name = $request->data['GROUPCAR'];
      $data = Stat_CarModel::where('Group_id',$request->data['GROUP_ID'])->get();
      return response()->view('data-system.rate-system.data-car.car-model', compact('data','group_name'));
    }
    else if($request->update == 'groupcar'){
      $updateGroup = Stat_CarGroup::where('id', $request->data['ID'])->first();
      // dd($request,$updateGroup);
      $updateGroup->Status_group = @$request->data['STATUS'];
      $updateGroup->Ratetype_id = $request->data['TYPECAR']; 
      $updateGroup->Group_car = $request->data['GROUPCAR']; 
      $updateGroup->UserZone = auth()->user()->zone;
      $updateGroup->UserBranch = auth()->user()->branch;
      $updateGroup->UserInsert = auth()->user()->username;  
      $updateGroup->update();

      $brand_name = $request->data['BRANDCAR'];
      $data = Stat_CarGroup::where('brand_id',$request->data['BRAND_ID'])->get();
      return response()->view('data-system.rate-system.data-car.car-group', compact('data','brand_name'));
    }

  }

  public function destroy(Request $request, $id){
    if ($request->del == 'cardetail') {
      $item = Stat_CarYear::find($id);
      $item->Delete();

      $brand_id = $request->brand_id;
      $group_id = $request->group_id;
      $model_id = $request->model_id;
      $rate_id = $request->rate_id;
      $data = Stat_CarYear::where('Brand_id',$brand_id)
            ->where('Group_id', $group_id)
            ->where('Model_id', $model_id)
            ->orderBy('Year_car','ASC')
            ->get();

      // $model_name = @$data[0]->yearToModelCar->Model_car;
      $model_name = @$request->model_name;
      return response()->view('data-system.rate-system.data-car.car-detail', compact('data','brand_id','group_id','rate_id','model_id','model_name'));
    } 
    else if ($request->del == 'model') {
      $item = Stat_CarModel::find($id);
      $item->Delete();

      $brand_id = $request->brand_id;
      $group_id = $request->group_id;
      $data = Stat_CarModel::where('Group_id',$group_id)->get();

      // $group_name = @$data[0]->modelToGroupCar->Group_car;
      $group_name = @$request->group_name;
      
      return response()->view('data-system.rate-system.data-car.car-model', compact('data','brand_id','group_id','group_name'));
    } 
    else if ($request->del == 'group'){
      $item = Stat_CarGroup::find($id);
      $item->Delete();

      $brand_id = $request->brand_id;
      $data = Stat_CarGroup::where('brand_id', $brand_id)->get();
      
      // $brand_name = @$data[0]->groupToBrandCar->Brand_car;
      $brand_name = @$request->brand_name;
      
      return response()->view('data-system.rate-system.data-car.car-group', compact('data','brand_id','brand_name'));
    }
    else if ($request->del == 'brand'){
      $item = Stat_CarBrand::find($id);
      $item->Delete();

      
      return 'Success';
    }
  }

}