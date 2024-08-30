<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use ConnectCredo;
use DB;
use Log;
use App\Models\User;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_CusTagParts;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusResources;
use App\Models\TB_Constants\TB_Frontend\TB_StatusTagParts;
use App\Models\TB_Constants\TB_Frontend\TB_typeCancelCus;

use App\Models\TB_PactContracts\Pact_Contracts;

// log
use App\Events\frontend\LogDataCusTag;
use App\Models\TB_Logs\Data_CredoFragments;

// trait
use App\Traits\TagOwners;
use App\Traits\NumberingRequests;


class TagsController extends Controller
{
    use TagOwners, NumberingRequests;

    public function index(Request $request)
    {
        if ($request->funs == 'view-tagparts') { //view tagPart
            $id = $request->id;
            $tags = Data_CusTags::where('id', $id)->first();

            $filter_tagPart = NULL;
            if (isset($tags)) {
                if ($tags->Status_Tag == 'active') {
                    $filter_tagPart = NULL;
                } else {
                    $filter_tagPart = 'disabled';
                }
            }

            return response()->view('frontend.content-tag.section-tagPart.data-tagParts', compact('tags', 'id', 'filter_tagPart'));
        }
    }

    public function create(Request $request)
    {
        if ($request->funs == 'create-tag') {
            $typeCus = TB_StatusCustomers::generateQuery();
            $typeCusRs = TB_TypeCusResources::generateQuery();
            $Branchs = TB_Branchs::generateQuery();
            $CodeJob = $this->runBillTags(date('Y-m-d'), 'TAG', auth()->user()->zone);

            $data = Data_CusTags::where('DataCus_id', $request->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $filter_tag = $this->checkfilterTag($data);
            if (!empty($filter_tag)) {
                $errorMessage = 'กรุณาตรวจสอบรายการดังกล่าว ก่อนกดปุ่มอีกครั้ง.';
                return response()->json(['title' => 'รายการติดตามหรือสัญญาเปิดใช้งานแล้ว', 'message' => $errorMessage], 403, [], JSON_UNESCAPED_UNICODE);
            }

            $id = $request->id;
            return view('frontend.content-tag.section-tag.create-tag', compact('typeCus', 'typeCusRs', 'CodeJob', 'id', 'Branchs'));
        } elseif ($request->funs == 'create-tagpart') {
            $data = Data_CusTags::where('id', $request->id)->first();
            $checktag = $this->ChecktagUserOwner($data->successor_status, $data->successor);
            if ($checktag == false) {
                return response('สิทธิ์การจัดการเป็นของ ' . $data->successorID->name, 401);
            }

            $StateTagPart = TB_StatusTagParts::generateQuery();
            $CancelTag = TB_typeCancelCus::generateQuery();
            return view('frontend.content-tag.section-tagpart.create-tagPart', compact('data', 'StateTagPart', 'CancelTag'));
        } elseif ($request->funs == 'sent-GM') {
            $roleNames = ['manager', 'supervisor'];
            try {
                $tag = Data_CusTags::where('id', $request->id)->first();
                $users = User::where('zone', auth()->user()->zone)
                    ->whereHas('roles', function ($query) use ($roleNames) {
                        $query->whereIn('name', $roleNames);
                    })->get();

                $usersWithRoles = $users->map(function ($user) {
                    return [
                        'user' => $user,
                        'roles' => $user->getRoleNames()->toArray(),
                    ];
                });

                return response()->json(['tag' => $tag, 'users' => $usersWithRoles, 'code' => 200], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    function edit($id, Request $request)
    {
        if ($request->funs == 'edit-tag') {
            $tag = Data_CusTags::find($id);

            $typeCus = TB_StatusCustomers::generateQuery();
            $typeCusRs = TB_TypeCusResources::generateQuery();
            $Branchs = TB_Branchs::generateQuery();

            return view('frontend.content-tag.section-tag.edit-tag', compact('tag', 'typeCus', 'typeCusRs', 'Branchs'));
        }
    }

    public function store(Request $request)
    {
        if ($request->funs == 'create-tag') {
            DB::beginTransaction();
            try {
                $dataTag = Data_CusTags::where('DataCus_id', $request->data['id'])->where('Status_Tag', 'active')->first();
                if (!$dataTag) {
                    $CodeJob = $this->runBillTags(date('Y-m-d'), 'TAG', auth()->user()->zone);
                    $tags = new Data_CusTags;
                    $tags->DataCus_id = $request->data['id'];
                    $tags->date_Tag = date('Y-m-d');
                    $tags->Code_Tag = @$CodeJob;
                    $tags->Status_Tag = 'active';
                    $tags->BranchCont = $request->data['BranchCont'];
                    $tags->Type_Customer = $request->data['Type_Customer'];
                    $tags->Resource_Customer = $request->data['Resource_Customer'];

                    $tags->UserZone = auth()->user()->zone;
                    $tags->UserBranch = auth()->user()->branch;
                    $tags->UserInsert = auth()->user()->id;
                    $tags->save();
                } else {
                    // ถ้าพบ $dataTag ไม่ว่าง ให้ทำการ catch error และคืนค่าออกไป
                    throw new \Exception('มีรายการที่กำลังใช้งานอยู่แล้ว', 302);
                }

                DB::commit();

                $id = $request->data['id'];
                $data = Data_CusTags::where('DataCus_id', $request->data['id'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $viewData = view('frontend.content-tag.section-tag.data-tags', compact('data', 'id'))->render();
                return response()->json(['html' => $viewData, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'create-tagPart') {
            DB::beginTransaction();
            try {
                $UserApp_relevant = $request->UserApp_relevant != NULL ? implode(',', @$request->UserApp_relevant) . ',' . $request->data['UserApp_Con'] : NULL;
                $countTag = Data_CusTagParts::where('DataTag_id', $request->idTag)->count();
                $tagPart = new Data_CusTagParts;
                $tagPart->DataCus_id = $request->idCus;
                $tagPart->DataTag_id = $request->idTag;
                $tagPart->date_TrackPart = date('Y-m-d');
                $tagPart->Ordinal_TrackPart = (@$countTag != NULL ? (@$countTag + 1) : 1);
                $tagPart->Status_TrackPart = $request->tagpart;

                if ($request->tagpart == "TAG-0001") { //ติดตาม
                    $isSent_cont = NULL;
                    $StatusTag = 'active';
                    $tagPart->Duedate_TrackPart = @$request->data['Duedate_TrackPart'];
                    $tagPart->Userfollow_TrackPart = @$request->data['Userfollow_TrackPart'];
                    $tagPart->Detail_TrackPart = @$request->data['tracking_details'];
                } elseif ($request->tagpart == "TAG-0002") { //ยกเลิกติดตาม
                    $isSent_cont = NULL;
                    $StatusTag = 'inactive';
                    $tagPart->StatusCancel_TrackPart = @$request->data['cancel_status'];
                    $tagPart->Detail_TrackPart = @$request->data['cancel_deatails'];
                } elseif ($request->tagpart == "TAG-0003") { //จัดไฟแนนซ์
                    $isSent_cont = true;
                    $StatusTag = 'complete';
                    $tagPart->Detail_TrackPart = @$request->data['finance_details'];
                }

                $tagPart->UserZone = auth()->user()->zone;
                $tagPart->UserBranch = auth()->user()->branch;
                $tagPart->UserInsert = auth()->user()->id;
                $tagPart->save();

                $tags = Data_CusTags::updateOrCreate(['id' => $request->idTag], ['Status_Tag' => $StatusTag]);
                $message = 'บันทึกรายละเอียด เรียบร้อย';

                $id_cont = NULL;
                $Br_cont = NULL;
                $contract = NULL;
                // sent finances
                if ($isSent_cont) {
                    if ($request->tagpart == "TAG-0003") {
                        $message = 'บันทึกสร้างสัญญา เรียบร้อย';

                        $datesent_con = convertDateHumanToPHP($request->data['DateSent_Con']);

                        $gencode = DB::select("SELECT dbo.uft_runContract(?,?,?,?)", [$datesent_con, $tags->TagBranchCont->Zone_Branch, $tags->TagToCulculate->CodeLoans, $tags->TagBranchCont->id_Contract]);
                        $result = reset($gencode);
                        $contract = reset($result);

                        $pactCont = new Pact_Contracts;
                        $pactCont->DataCus_id = $request->idCus;
                        $pactCont->DataTag_id = $request->idTag;

                        $pactCont->CodeLoan_Con = $tags->TagToCulculate->CodeLoans;
                        $pactCont->Contract_Con = $contract;
                        $pactCont->Status_Con = 'active';
                        $pactCont->UserSent_Con = auth()->user()->id;
                        $pactCont->BranchSent_Con = $tags->TagBranchCont->id;
                        $pactCont->Date_con = $datesent_con;
                        $pactCont->Beneficiary_PA = 'ทายาทโดยธรรม';
                        $pactCont->Relations_PA = 'ทายาทโดยธรรม';

                        $pactCont->UserApp_Con = $request->data['UserApp_Con'];
                        $pactCont->UserApp_relevant = @$UserApp_relevant; // แท็คผู้อนุมัติเพิ่มเติมในสัญญา

                        $pactCont->StatusApp_Con = 'สร้างสัญญา';
                        $pactCont->Id_Com = @$tags->TagToCulculate->ContractToTypeLoanLast->Id_Com;

                        // if ($tags->DataCusTagToDataCulcu->DataCalcuToTypeLoan->Loan_Com == 1) {
                        //     $pactCont->Data_TypeLoan = "018022";
                        // } else {
                        //     $pactCont->Data_TypeLoan = "018017";
                        // }

                        $pactCont->Data_Factors = "0760900002";
                        $pactCont->UserZone = auth()->user()->zone;
                        $pactCont->UserBranch = auth()->user()->branch;
                        $pactCont->UserInsert = auth()->user()->id;
                        $pactCont->save();

                        $id_cont = $pactCont->id;
                        $Br_cont = @$tags->TagToCulculate->ContractToTypeLoanLast->Loan_Name . ' (' . @$tags->TagToCulculate->ContractToTypeLoanLast->Loan_Code . ')';
                    }

                    // $Score = ConnectCredo::postScore($tags->Credo_Code);
                    // if ($Score['statusCode'] == 200) {
                    //     $chk_inLog = Data_CredoFragments::where('referenceNumber', $tags->credo_code)->first();
                    //     if (empty($chk_inLog)) {
                    //         $fragments = $Score['data']['fragments'];

                    //         $data_Fragment = new Data_CredoFragments;
                    //         $data_Fragment->referenceNumber = @$Score['data']['datasetInfo']['referenceNumber'];
                    //         $data_Fragment->uploadDate = @$Score['data']['datasetInfo']['uploadDate'];
                    //         $data_Fragment->device_id = @$Score['deviceId'];
                    //         $data_Fragment->scores = ($Score['GetScore'] != 0) ? json_encode($Score['data']['scores']) : 0;
                    //         for ($i = 0; $i < 10; $i++) {
                    //             $data_Fragment->{'fragments' . ($i + 1)} = (isset($fragments[$i])) ? json_encode($fragments[$i]) : null;
                    //         }

                    //         $data_Fragment->save();
                    //     }
                    // }

                    // $dataTag = Data_CusTags::where('id', $request->idTag)->first();
                    // $dataTag->Credo_Score = @$Score['data']['scores'][1]['value'];
                    // $dataTag->Credo_Score2 = @$Score['data']['scores'][0]['value'];
                    // if ($Score['GetScore'] != 0) {
                    //     $dataTag->Credo_Status = 'CD-0005';
                    //     $dataTag->Credo_Date = date('Y-m-d H:i:s');
                    // }
                    // $dataTag->update();
                }

                $filter_tagPart = NULL;
                if (isset($tags)) {
                    if ($tags->Status_Tag == 'active') {
                        $filter_tagPart = NULL;
                    } else {
                        $filter_tagPart = 'disabled';
                    }
                }

                DB::commit();

                event(new LogDataCusTag($tagPart->DataTag_id, 'insert', 'LogDataCusTag', 'create-tagPart', 'สร้างบันทึกติดตาม สถานะ ' . $StatusTag, auth()->user()->id));
                Log::channel('daily')->info($tagPart);
                //เหลือของTop insert contract
                $id = $request->idTag;
                $ct_tagPart = $tagPart->Ordinal_TrackPart;
                $nameSent = auth()->user()->name . ' (' . auth()->user()->position . ')';
                $viewData = view('frontend.content-tag.section-tagPart.data-tagParts', compact('tags', 'id', 'filter_tagPart'))->render();
                $data = Data_Customers::find($request->idCus);
                $viewPoss = view('frontend.content-possession.view', compact('data'))->render();

                return response()->json(['html' => $viewData, 'tagpart' => $ct_tagPart, 'id_cont' => $id_cont, 'contract' => $contract, 'Br_cont' => $Br_cont, 'nameSent' => $nameSent, 'message' => $message, 'viewPoss' => $viewPoss]);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->funs == 'update-tag') {
            DB::beginTransaction();
            try {
                $tags = Data_CusTags::where('id', $id)->first();
                $tags->BranchCont = $request->data['BranchCont'];
                $tags->Type_Customer = $request->data['Type_Customer'];
                $tags->Resource_Customer = $request->data['Resource_Customer'];
                $tags->update();

                DB::commit();

                event(new LogDataCusTag($tags->id, 'update', 'LogDataCusTag', 'update-tag', 'แก้ไขประเภทลูกค้า, ' . $tags->BranchCont . ', ' . $tags->Type_Customer, auth()->user()->id));
                Log::channel('daily')->info($tags);

                $data = Data_CusTags::where('DataCus_id', $tags->DataCus_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $message = 'อัพเดตรายการ ' . $tags->Code_Tag . ' เรียบร้อย';
                $viewData = view('frontend.content-tag.section-tag.data-tags', compact('data', 'id'))->render();
                return response()->json(['html' => $viewData, 'message' => $message, 'code' => 200]);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'update-tagPart') {

        } elseif ($request->funs == 'update-sentGM') {
            DB::beginTransaction();
            try {
                $tags = Data_CusTags::where('id', $id)->first();
                $tags->successor = $request->user_select;
                $tags->successor_date = Carbon::now();
                $tags->successor_status = 'active';
                $tags->update();

                $countTag = Data_CusTagParts::where('DataTag_id', $tags->id)->count();
                $tagPart = new Data_CusTagParts;
                $tagPart->DataCus_id = $tags->DataCus_id;
                $tagPart->DataTag_id = $tags->id;
                $tagPart->date_TrackPart = date('Y-m-d');
                $tagPart->Ordinal_TrackPart = (@$countTag != NULL ? (@$countTag + 1) : 1);
                $tagPart->Status_TrackPart = 'TAG-0004';
                $tagPart->Detail_TrackPart = 'ส่งมอบแท็กให้ ' . $tags->successorID->name . ' เรียบร้อย';

                $tagPart->UserZone = auth()->user()->zone;
                $tagPart->UserBranch = auth()->user()->branch;
                $tagPart->UserInsert = auth()->user()->id;
                $tagPart->save();
                DB::commit();

                event(new LogDataCusTag($tags->id, 'update', 'LogDataCusTag', 'update-sentGM', 'ส่งงานให้ ' . $request->user_select, auth()->user()->id));
                Log::channel('daily')->info($tags);

                $filter_tagPart = NULL;
                if (isset($tags)) {
                    if ($tags->Status_Tag == 'active') {
                        $filter_tagPart = NULL;
                    } else {
                        $filter_tagPart = 'disabled';
                    }
                }

                $viewData = view('frontend.content-tag.section-tagPart.data-tagParts', compact('tags', 'id', 'filter_tagPart'))->render();
                return response()->json(['tag_id' => $id, 'html' => $viewData, 'tagpart' => $tagPart->Ordinal_TrackPart, 'message' => 'ส่งมอบแท็ก เรียบร้อย', 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'update-sentBranch') {
            DB::beginTransaction();
            try {
                $tags = Data_CusTags::where('id', $id)->first();
                $tags->successor_status = 'completed';
                $tags->update();

                $countTag = Data_CusTagParts::where('DataTag_id', $tags->id)->count();
                $tagPart = new Data_CusTagParts;
                $tagPart->DataCus_id = $tags->DataCus_id;
                $tagPart->DataTag_id = $tags->id;
                $tagPart->date_TrackPart = date('Y-m-d');
                $tagPart->Ordinal_TrackPart = (@$countTag != NULL ? (@$countTag + 1) : 1);
                $tagPart->Status_TrackPart = 'TAG-0005';
                $tagPart->Detail_TrackPart = 'ส่งคืนแท็กให้สาขา เรียบร้อย';

                $tagPart->UserZone = auth()->user()->zone;
                $tagPart->UserBranch = auth()->user()->branch;
                $tagPart->UserInsert = auth()->user()->id;
                $tagPart->save();

                DB::commit();

                event(new LogDataCusTag($tags->id, 'update', 'LogDataCusTag', 'update-sentBranch', 'ส่งงานให้สาขา ' . $tags->BranchCont, auth()->user()->id));
                Log::channel('daily')->info($tags);

                $data = Data_CusTags::where('DataCus_id', $tags->DataCus_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $viewData = view('frontend.content-tag.section-tag.data-tags', compact('data', 'id'))->render();
                return response()->json(['html' => $viewData, 'tagpart' => $tagPart->Ordinal_TrackPart, 'message' => 'ส่งมอบรายการ เรียบร้อย', 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->funs == 'update-MI') {
            DB::beginTransaction();
            try {

                $dataMiView = DB::table('View_MIDATA')->where('id', $id)->first();
                $countNull = 0;
                if ($dataMiView != NULL) {
                    $dataArray = json_decode(json_encode($dataMiView), true);
                    $filteredData = array_filter($dataArray, 'is_null');
                    $countNull = count($filteredData);

                    if (@$dataMiView->id_rateType == 'car' || @$dataMiView->id_rateType == 'moto') {
                        if ($countNull < 3) {
                            $dataMI = array(
                                'applied_date' => @$dataMiView->applied_date,
                                'zone' => @$dataMiView->zone,
                                'customer_type' => @$dataMiView->customer_type,
                                'loan_type' => @$dataMiView->loan_type,
                                'contract_no' => @$dataMiView->contract_no,
                                'credo_score' => floatval(@$dataMiView->Credo_Score), //int
                                'gender' => @$dataMiView->gender,
                                'birth_date' => @$dataMiView->birth_date,
                                'age' => floatval(@$dataMiView->age),//int
                                'occupation' => @$dataMiView->occupation,
                                'occupation2' => NULL,
                                'status' => @$dataMiView->status,
                                'vehicle_brand' => @$dataMiView->vehicle_brand,
                                'vehicle_model' => @$dataMiView->vehicle_model,
                                'vehicle_launched_year' => floatval(@$dataMiView->vehicle_launched_year),//int
                                'vehicle_acquired_date' => @$dataMiView->vehicle_acquired_date,
                                'vehicle_acquired_num_days' => floatval(@$dataMiView->vehicle_acquired_num_days),//int
                                'vehicle_acquired_order' => @$dataMiView->vehicle_acquired_order,
                                'vehicle_book_p16' => @$dataMiView->vehicle_book_p16,
                                'vehicle_book_p18' => @$dataMiView->vehicle_book_p18,
                                'vehicle_estimated_price' => floatval(@$dataMiView->vehicle_estimated_price),//int
                                'loan_amount' => floatval(@$dataMiView->loan_amount),//int
                                'ltv' => @$dataMiView->ltv != 0 ? floatval(@$dataMiView->ltv) : NULL,//int
                                'interest_rate' => floatval(@$dataMiView->interest_rate),//int
                                'num_installment' => floatval(@$dataMiView->num_installment),//int
                                'installment_amount' => floatval(@$dataMiView->installment_amount)
                            );//int
                            $dataArr = json_encode($dataMI);

                            $getDataMI = ConnectCredo::getMI($dataArr);
                            $deCodeMi = json_decode(@$getDataMI);

                            $tags = Data_CusTags::where('id', $id)->first();
                            $tags->MI_label = @$deCodeMi->label;
                            $tags->MI_probability = @$deCodeMi->probability;
                            $tags->update();


                            DB::commit();

                            event(new LogDataCusTag($tags->id, 'update', 'LogDataCusTag', 'update-MI', 'ประเมิณเคสพิเศษ ' . $tags->BranchCont, auth()->user()->id));
                            Log::channel('daily')->info($tags);

                            $data = Data_CusTags::where('DataCus_id', $tags->DataCus_id)
                                ->orderBy('created_at', 'desc')
                                ->get();

                            $viewData = view('frontend.content-tag.section-tag.data-tags', compact('data', 'id'))->render();
                            return response()->json(['html' => $viewData, 'tagpart' => '', 'message' => 'ประเมิณเคสพิเศษ เรียบร้อย', 'code' => 200], 200);
                        } else {
                            return response()->json(['message' => 'กรอกข้อมูลไม่ครบ', 'code' => 500], 500);
                        }
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }

        }
    }
}
