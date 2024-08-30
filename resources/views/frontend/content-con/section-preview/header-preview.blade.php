@component('components.content-contract.section-cardCon.view')
@slot('data', [
    'Con_id' => $data->id, // id สัญญา
    'typeCon' => $data->ContractToTypeLoan->Loan_Name, //ประเภทสัญญา
    'CONTNO' => $data->Contract_Con, // เลขที่สัญญา
    'Date_con' => $data->Date_con, //วันทำสัญญา
    'Name_Branch' => $data->ContractToBranch->Name_Branch, //สาขา
    'Credo_Code' => $data->ContractToDataCusTags->Credo_Code, //Credo Code
    'LinkUpload_Con' => $data->LinkUpload_Con, //Link Contract
    'StatusApp_Con' => $data->StatusApp_Con, //Main Status
    'Status_Con' => $data->Status_Con,
    'linkChecker' => $data->linkChecker,
    'Memo_Con' => $data->Memo_Con,

    'Cus_id' => $data->ContractToCus->id, //id ลูกค้า
    'typeCus' => $data->ContractToDataCusTags->TagToStatusCus->Name_Cus, //ประเภทลูกค้า
    'typeCusRe' => $data->ContractToDataCusTags->TagToTypeCusRe->Name_CusResource,
    'NameCus' => $data->ContractToCus->Name_Cus, //ชื่อลูกค้า
    'Birthday_cus' => $data->ContractToCus->Birthday_cus, //เบอร์ลูกค้า
    'Phone_cus' => $data->ContractToCus->Phone_cus, //เพศ
    'IDCard_cus' => $data->ContractToCus->IDCard_cus, //เลข ปชช
    'Reference' => $data->ContractToCus->Reference, //บุคคลอ้างอิง
    'Social_Line' => $data->ContractToCus->Social_Line, //Social_Line
    'Social_facebook' => $data->ContractToCus->Social_facebook, //Social_facebook
    'Cus_tag' => $data->DataTag_id,

    'Cus_Ref' => $data->Cus_Ref, // ผู้อ้างอิง
    'Adds_Con' => $data->Adds_Con, // ที่อยู่ใช้ทำสัญญา
    'cardProfile' => false
]);
@endcomponent
