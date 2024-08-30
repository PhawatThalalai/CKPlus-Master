@component('components.content-contract.section-contract.view')
    {{-- @php
        dd(@$data,@$data->ContractToDataCusTags);
    @endphp --}}
    @slot('data', [
        'DateDocApp_Con' => @$data->DateDocApp_Con,
        'Status_Con'=>@$data->Status_Con,
        'UserApp_Con'=>@$data->ContractToUserApprove->name,
        'UserApp_ConPosition'=> Str::upper(@$Approve[0]) , // ตำแหน่ง
        'Memo_Con'=>@$data->Memo_Con,
        'idCon'=>@$data->id,
        'UserSent_Con' => @$data->ContractToUserBranch->name,
        'DateDue_Con' => @$data->DateDue_Con,
        'DateCheck_Bookcar' => @$data->DateCheck_Bookcar,
        'LinkBookcar' => @$data->LinkBookcar, //link เช็คเล่ม
        'DateSpecial_Bookcar' => @$data->DateSpecial_Bookcar,
        'Special_Name' => @$data->ContractToBookSpecial->Special_Name,
        'ConfirmDocApp_Con' => @$data->ConfirmDocApp_Con,
        'Date_BookSpecial' => @$data->Date_BookSpecial,
        'LinkBookSpecial' => @$data->LinkBookSpecial, // link ได้รับเล่ม
        'Checkers_Con' => @$data->Checkers_Con,
        'Date_Checkers' => @$data->Date_Checkers,
        'linkChecker' => @$data->linkChecker,
        'BookSpecial_Trans' => @$data->BookSpecial_Trans,
        'ConfirmApp_Con'=>@$data->ConfirmApp_Con,
        'DocApp_Con'=>@$data->ContractToUserApp->name, // ผู้ขออนุมัติ
        'DocApp_ConPosition'=>@$data->DocApp_Con!=NULL?Str::upper(@$data->ContractToUserApp->getRoleNames()) :'', // ตำแหน่งผู้ขออนุมัติ
        'DocApp_ConBranch'=>@$data->ContractToUserApp->UserToBranch->Name_Branch, // สาขาผู้ขออนุมัติ
        'ConfirmApp_Con'=>@$data->ConfirmApp_Con,
        'DateConfirmApp_Con' => @$data->DateConfirmApp_Con, // สัญญาสมบูรณ์ วันที่
        'Adds_Con' => @$data->ContractToAddress->DataCusAddsToTypeAdds->Name_Address,
        'Cus_Ref' => @$data->Cus_Ref,
        'PhoneCus_Ref' => @$data->PhoneCus_Ref,
        'statusDoc' => @$data->ContractToAudittor->statusDoc, // สถานะการตรวจเอกสาร
        'StatusApprove' => @$data->ContractToAudittor->StatusApprove, // สถานะการขออนุมัติ
        'TypeLoan' => @$data->ContractToTypeLoanLast->id_rateType, // สถานะการขออนุมัติ
        'TypeLoans' => @$data->ContractToDataCusTags->TagToCulculate->TypeLoans, // ประเภททรัพย์
        'SpApp' => @$SpApp,
        'Beneficiary_PA' => @$data->Beneficiary_PA,
        'buyPA' => @$data->ContractToCal->Buy_PA
    ]);
@endcomponent
