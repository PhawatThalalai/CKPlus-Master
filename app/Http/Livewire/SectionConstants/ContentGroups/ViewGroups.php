<?php

namespace App\Http\Livewire\SectionConstants\ContentGroups;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

use App\Traits\UserApproved;
use App\Models\TB_Constants\TB_Frontend\TB_Groups;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeGroups;

class ViewGroups extends Component
{
    use UserApproved;

    public $modalFormCreate = false;

    public $dataGroup, $dataBranch, $dataTypeGroup, $userHandler;

    public $taskName, $taskDate, $taskType, $taskHandler, $taskBranch, $taskdesc, $txtCountBranch;

    public function rules()
    {
        return [
            'taskName' => 'required|max:255',
            'taskDate' => 'required',
            'taskType' => 'required',
            'taskBranch' => 'required|max:255',
        ];
    }
    public function mount()
    {
        session()->forget('dataBranch');
        session()->forget('dataTypeGroup');
        session()->forget('userHandler');
    }
    public function countSelectedBranch()
    {
        $this->txtCountBranch = count($this->taskBranch);
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
    }

    public function showModalFormCreate()
    {
        // $this->emit('resetForm');
        $this->modalFormCreate = true;
        $this->taskType = null; // reset taskType to null
        $this->resetForm();

        if (!session()->has('dataBranch')) {
            $this->dataBranch = TB_Branchs::where('Zone_Branch', Auth::user()->zone)->where('Branch_Active', 'yes')->get();
            session(['dataBranch' => $this->dataBranch]);
        } else {
            $this->dataBranch = session('dataBranch');
        }

        if (!session()->has('dataTypeGroup')) {
            $this->dataTypeGroup = TB_TypeGroups::where('TypeGroup_Status', 'Y')->get();
            session(['dataTypeGroup' => $this->dataTypeGroup]);
        } else {
            $this->dataTypeGroup = session('dataTypeGroup');
        }

        if (!session()->has('userHandler')) {
            $this->userHandler = $this->getUserHandlerGroup();
            session(['userHandler' => $this->userHandler]);
        } else {
            $this->userHandler = session('userHandler');
        }

    }

    public function storeTask()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $task = new TB_Groups();
            $task->groupStatus = 'active';
            $task->groupName = $this->taskName;
            $task->groupDate = $this->taskDate;
            $task->groupType = implode(',', $this->taskType);
            $task->groupHandler = $this->taskHandler;
            $task->groupZone = auth()->user()->zone;
            $task->groupDesc = $this->taskdesc;
            $task->save();

            foreach ($this->taskBranch as $branch) {
                $task->groupLists()->create([
                    'listStatus' => 'active',
                    'listDate' => $this->taskDate,
                    'listBranch_id' => $branch,
                ]);
            }

            DB::commit();

            $this->emit('refreshTable');
            $this->emit('Swal:alert', [
                'icon' => 'success',
                'title' => 'Data Berhasil Disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('Swal:alert', [
                'icon' => 'error',
                'title' => 'Data Gagal Disimpan',
            ]);
        }

        $this->modalFormCreate = false;
        $this->resetForm();
        $this->dispatchBrowserEvent('closeModalFormCreate', ['massages' => 'successfull']);

    }

    public function render()
    {
        $this->dataGroup = TB_Groups::all();
        return view('livewire.section-constants.content-groups.view-groups', [
            'dataGroup' => $this->dataGroup,
            'dataBranch' => $this->dataBranch,
            'dataTypeGroup' => $this->dataTypeGroup,
            'userHandler' => $this->userHandler
        ]);
    }
}
