<?php

namespace App\Http\Livewire\Components\ContentSearch;

use Livewire\Component;

class Search extends Component
{
    public $values;
    public $typeSr,$placeholder;

    public function render()
    {
        return view('livewire.components.content-search.search');
    }

    public function typeResearch($type)
    {
        if ($type == 'namecus') {
            $this->placeholder = 'ชื่อ-นามสกุล';
        }elseif ($type == 'idcardcus') {
            $this->placeholder = 'เลขบัตรประชาชน';
        }elseif ($type == 'codecus') {
            $this->placeholder = 'รหัสลูกค้า';
        }
    }
}
