<?php

namespace App\Http\Livewire\Backend\ContentPayment;

use Livewire\Component;
use DB;

class ViewPayment extends Component
{
    public $data;
    public $contract,$branchCon;

    public $inputPayment,$interest,$sumAmount,$payinteff,$payton;
    public $showPayment,$showinterest,$showSum;

    public $PAYTYP_CODE,$PAYTYP_NAME,$PAYFOR_CODE,$PAYFOR_NAME;

    public $Duepay;
    public $Paydue;
    public $paydueCus;

    public $flagModeAdd;
    public $isDisabled = 'disabled';
    public $btn_cal = 'disabled';
    public $btn_add = 'disabled';
    public $btn_active;

    protected $rules = [
        'PAYTYP_CODE' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->flagModeAdd = false;

        $this->inputPayment = '';
        $this->interest = '';
        $this->sumAmount = '0.00';
        $this->payinteff = '0.00';
        $this->payton = '0.00';

        if ($this->data != '') {
            $this->contract = $this->data->CONTNO;
            $this->branchCon = $this->data->LOCAT;
            $this->btn_cal = '';
        }

        $this->Duepay = date('Y-m-d');
        $this->inputPayment = '';
        $this->CalupDuePayment($this->contract,$this->branchCon,$this->Duepay);
    }

    public function render()
    {
        return view('livewire.backend.content-payment.view-payment');
    }

    public function CalupDuePayment() {
        $this->flagModeAdd = false;
        $this->btn_active = '';

        $this->showPayment = 0;
        $this->showinterest = 0;
        $this->showSum = 0;

        $this->inputPayment = '';
        $this->interest = '';
        $this->sumAmount = '0.00';
        $this->payinteff = '0.00';
        $this->payton = '0.00';

        $getPost = DB::statement("EXEC dbo.Sp_CalintHp ?,?,?",[$this->contract,$this->branchCon,$this->Duepay]);

        $Results = DB::select("SELECT * FROM dbo.utf_CalUpDuePayment(?,?,?)",[$this->contract,$this->branchCon,$this->Duepay]);
        $this->Paydue = json_decode(json_encode($Results), true);

        // set paydueCus
        if (count($Results) != 0) {
            $this->paydueCus = ($this->Paydue[0]['dueamt'] * count($Results));
        }
        $this->dispatchBrowserEvent('swal:success',[
            'text' => "successful",
            'icon' => "success",
            'timer' => 1500,
            'showConfirmButton' => false,
            'customClass' => [
                'popup' => 'bg-light',
            ],
        ]);
    }

    public function checkPayments() {
        if ($this->inputPayment == '') {
            $this->flagModeAdd = false;
            $this->dispatchBrowserEvent('swal:error',[
                'text' => "กรุณาป้อนยอดชำระค่างวด ก่อนกดคำนวณ !",
                'icon' => "error",
                'timer' => 3000,
                'customClass' => [
                    'popup' => 'bg-light',
                    'content' => 'text-dark',
                ],
            ]);
            return;
        }else {
            if ($this->inputPayment > $this->paydueCus) {
                $this->dispatchBrowserEvent('swal:error',[
                    'text' => "ยอดรับชำระ เกินค่างวดค้างดิว !",
                    'icon' => "warning",
                    'timer' => 3000,
                    'customClass' => [
                        'popup' => 'bg-light',
                        'title' => 'text-light',
                    ],
                ]);
                $this->inputPayment = '';
                return;
            }else{
                // set bunttom add
                $this->flagModeAdd = true;
                $this->dispatchBrowserEvent('focus-input', ['id' => 'interest']);

                $this->qeurydata();
                $arrParam_1 = $this->qeurydata()[0];
                $arrParam_2 = $this->qeurydata()[1];

                // set value show
                $this->interest = collect($arrParam_1)->sum('INTLATEAMT');
                $this->showPayment = $this->inputPayment;

                $this->payinteff = $arrParam_2[0]['payinteff'];
                $this->payton = $arrParam_2[0]['payton'];
                $this->sumAmount = ($this->inputPayment + ($this->interest == ''? 0 : $this->interest));
            }
        }
    }

    public function qeurydata() {
        $getPost = DB::statement("EXEC dbo.Sp_CalintHp ?,?,?",[$this->contract,$this->branchCon,$this->Duepay]);

        $Results = DB::select("SELECT * FROM dbo.utf_UpDateDuePayment(?,?,?,?)",
            [
                $this->contract,$this->branchCon,$this->Duepay,$this->inputPayment
            ]);
        $this->Paydue = json_decode(json_encode($Results), true);
        
        $getData = DB::select("SELECT * FROM dbo.utf_PrePayment(?,?,?,?)",
            [
                $this->contract,$this->branchCon,$this->Duepay,$this->inputPayment
            ]);
        $setvalue = json_decode(json_encode($getData), true);

        return array($Results, $setvalue);
    }

    public function savePayments()
    {
        $validatedData = $this->validate();
        dd($validatedData);
        // return;

    }

    public function openModal() {
        if ($this->flagModeAdd == false) {
            $this->flagtagMode = '';
            $this->dispatchBrowserEvent('close-modal');

            $this->dispatchBrowserEvent('swal:error',[
                'text' => "กรุณาคำนวณยอดรับชำระ ก่อนรับชำระจริง !",
                'icon' => "warning",
                'timer' => 3000,
                'customClass' => [
                    'popup' => 'bg-light',
                    'title' => 'text-light',
                ],
            ]);
            return;
        }else {
            $this->flagModeAdd = true;

            $this->PAYTYP_CODE = null;
            $this->PAYTYP_NAME = null;
            $this->PAYFOR_CODE = null;
            $this->PAYFOR_NAME = null;
        }
    }

    public function closeModal() {
    }

    public function addInterest() {
        if ($this->inputPayment != '') {
            if ($this->interest == '') {
                $this->interest = 0;
            }
            $this->sumAmount = ($this->inputPayment + $this->interest);
            $this->showinterest = $this->interest;
            $this->showSum = $this->sumAmount;

            $this->dispatchBrowserEvent('focus-input', ['id' => 'openModal']);
        }
    }

    public function focusInput($param) {
        if ($param == 'PAYTYP_CODE') {
            $this->dispatchBrowserEvent('focus-input', ['id' => 'PAYFOR_CODE']);
        }
        elseif ($param == 'PAYFOR_CODE') {
            $this->dispatchBrowserEvent('focus-input', ['id' => 'PAYFOR_CODE']);
        }
    }

    public function activeBtn($param) {
        if ($param == 'period') {
            $this->btn_active = 'period';
            $this->isDisabled = '';
            $this->btn_add = '';

            $this->flagModeAdd = false;

        }else{
            $this->btn_active = 'period_orther';
            $this->isDisabled = 'disabled';
            $this->btn_add = '';
            
            $this->flagModeAdd = true;
        }

        $this->interest = '';
        $this->inputPayment = '';
        $this->sumAmount = '0.00';
        $this->payinteff = '0.00';
        $this->payton = '0.00';
    }
}
