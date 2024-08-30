<?php

namespace App\Http\Livewire;

use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use Livewire\Component;

class OrderPayfor extends Component
{
    public $count = 5,
        $data  ,$dataAll,
        $dataA = false,
        $dataB = false;

    public $searchTableA = ""  , $searchTableB = "";
    public $drag = true;
    public $key;



    public function mount()
    {

    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        $this->Requery();
        return view('livewire.backend.invoice.order-payfor');
    }

    public function update($id,$param)
    {
        if($param == 'add'){
            $lastRow = intVal(TB_PAYFOR::where('STATUSREG','Y')->orderBy('REGFL','DESC')->first()->REGFL ?? 0)  + 1;

            $this->data =  TB_PAYFOR::find($id)->update([
                "STATUSREG" => "Y",
                "REGFL" => $lastRow
            ]);
        }else{
            $this->dataAll =  TB_PAYFOR::find($id)->update([
                "STATUSREG" => NULL,
                "REGFL" => NULL
            ]);
        }
        session()->flash('success','Post Updated Successfully!!');
        $this->Requery();

    }

    public function Requery(){

        $this->dataAll = TB_PAYFOR::
        when($this->searchTableA,function($query){
            return $query->where('FORCODE','like',"%{$this->searchTableA}%")->Orwhere('FORDESC','like',"%{$this->searchTableA}%");
        })
        ->where('STATUS','Y')
        ->whereNull('STATUSREG')
        ->orderBy('FORCODE','ASC')
        ->get();

        $this->data = TB_PAYFOR::
        when($this->searchTableB,function($query){
            return $query->where('FORCODE','like',"%{$this->searchTableB}%")->Orwhere('FORDESC','like',"%{$this->searchTableB}%");
        })
        ->where('STATUSREG','Y')
        ->orderBy('REGFL','ASC')
        ->get();

    }




}
