<?php

namespace App\Http\Livewire\SectionConstants\ContentGroups;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

class CreateGroup extends Component
{
    protected $listeners = ['resetForm' => 'resetForm'];
    public $taskName, $taskDate, $taskHandler, $taskBranch, $taskdesc;

    public function rules()
    {
        return [
            'taskName' => 'required|max:255',
            'taskDate' => 'required|date',
            'taskHandler' => 'required|max:255',
            'taskBranch' => 'required|max:255',
            'taskdesc' => 'required|max:255',
        ];
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
    }

    public function storeTask()
    {
        dd($this);
        $this->validate();

    }

    public function render()
    {
        return view('livewire.section-constants.content-groups.create-group', [
            'dataBranch' => TB_Branchs::where('Zone_Branch', Auth::user()->zone)->where('Branch_Active', 'yes')->get()
        ]);
    }

}
