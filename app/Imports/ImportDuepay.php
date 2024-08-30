<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Hash;

use App\Models\TB_Constants\TB_Frontend\TB_CrossBank;

class ImportDuepay implements ToCollection, WithHeadingRow, WithCustomCsvSettings
{
    protected $customHeadingRow = 0; // กำหนด headingRow เริ่มต้นเป็น 0

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $matchedFields = null;
        $corssbank = TB_CrossBank::all()->pluck('actions')->toArray();

        // search account
        $matchingData = $collection->first(function ($row) use ($corssbank, &$matchedFields) {
            // return count(array_intersect($row->toArray(), $corssbank)) > 0;
            $matchedFields = array_intersect($row->toArray(), $corssbank);
            return count($matchedFields) > 0;
        });

        // แสดงผลข้อมูลที่ตรงกับเงื่อนไข
        if ($matchingData) {
            // dump($matchedFields);
            // dd($matchingData->toArray());

            $selectedRow = [];

            // Skip the first 2 rows (index 0 and 1) and start from row 3 (index 2)
            $collection = $collection->skip(6);
            foreach ($collection as $key => $row) {
                if (strlen(str_replace(' ', '', $row[7])) == 10) {
                    $selectedRow = [
                        'RECORD_TYPE' => $row[0],
                        'SEQ_NO' => $row[1],
                        'BANK_CODE' => $row[2],
                        'COMPANY_ACCOUNT' => $row[3],
                        'PAYMENT_DATE' => $row[4],
                        'PAYMENT_TIME' => $row[5],
                        'CUSTOMER_NAME' => rtrim($row[6]),
                        'REF1' => rtrim($row[7]),
                        'REF2' => $row[8],
                        'REF3' => $row[9],
                        'BRANCH_NO' => $row[10],
                        'TELLER_NO' => $row[11],
                        'TRANSACTION_KIND' => $row[12],
                        'TRANSACTION_CODE' => $row[13],
                        'CHEQUE_NO' => $row[14],
                        'AMOUNT' => $row[15],
                        'CHEQUE_BANK_CODE' => $row[16],
                        'CHEQUE_BANK_CODE_1' => $row[17],
                    ];

                    dd($selectedRow);
                }
                elseif (strlen(str_replace(' ', '', $row[7])) == 12) {
                    # code...
                }

            }

        } else {
            dd("ไม่พบข้อมูลที่ตรงกับเงื่อนไข");
        }

        // return $data;
    }

    public function headingRow(): int
    {
        return $this->customHeadingRow;
    }

    public function setHeadingRow(int $headingRow): self
    {
        $this->customHeadingRow = $headingRow;
        return $this;
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'Tis-620',
            'utf-8', // ระบุ encoding ที่ถูกต้องของข้อมูลใน CSV
        ];
    }

}