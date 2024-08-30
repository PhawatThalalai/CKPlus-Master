<style>

    .custom-tooltip {
    --bs-tooltip-bg: var(--bs-primary);
    }

	.ribbon-2 {
		--f: 10px;
		/* control the folded part*/
		--r: 15px;
		/* control the ribbon shape */
		--t: 10px;
		/* the top offset */
		position: absolute;
		inset: var(--t) calc(-1*var(--f)) auto auto;
		padding: 0 10px var(--f) calc(10px + var(--r));
		clip-path:
			polygon(0 0, 100% 0, 100% calc(100% - var(--f)), calc(100% - var(--f)) 100%,
				calc(100% - var(--f)) calc(100% - var(--f)), 0 calc(100% - var(--f)),
				var(--r) calc(50% - var(--f)/2));
		background: #f54462;
		box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
	}
</style>
<div class="d-flex cardCus-{{@$data['id']}}">
    <div class="div d-none d-sm-block">
        <div class="card rounded-4 me-2 border-2 border mb-1 {{ @$data['data-right'] == 0 && @$data['type-broker'] == true ? 'border-danger' : 'border-primary border-opacity-50' }} " style = "min-width:30rem; max-width:30rem;">
            <div class="card-header bg-transparent border-bottom">
                <div class="box">
                    <div class="ribbon-2 text-light fs-6"> {{ @$data['name-index'] }} ( {{ @$data['index'] }} ) &nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-8 d-flex">
                        <span class="badge rounded-circle bg-success bg-soft">
                           <span class="text-success">
                                 <i class="bx bxs-id-card fs-5"></i>
                            </span>
                        </span>
                        <span class="fw-semibold ms-2">{{ @$data['Name_Cus'] }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-5 m-auto border-end">
                        <div class="col-12 text-center mb-2">
                            <img src="{{ @$data['img'] != NULL ? @$data['img'] : URL::asset('\assets\images\OIP.png') }}" class="rounded-circle border border-3 {{ @$data['img'] != NULL ? 'border-primary border-opacity-50' : 'border-danger' }}  p-1" alt="เพิ่ม" style="width: 100px; height: 100px;">
                        </div>
                        <div class="row">
                            <div class="col m-auto text-center border-end">
                                <p class="fw-semibold fs-6 mb-0">{{ @$data['title-left'] }}</p>
                                <p class="{{ @$data['data-left'] == NULL ? 'fw-semibold text-danger' : '' }}">{{ @$data['data-left'] != NULL ? @$data['data-left'] : 'ไม่มีข้อมูล !' }}</p>
                            </div>
                            <div class="col m-auto text-center">
                                <p class="fw-semibold fs-6 mb-0">{{ @$data['title-right'] }}</p>
                                <p class="{{ @$data['data-right'] == NULL ? 'fw-semibold text-danger' : '' }}"> <span class="d-inline-block text-truncate" style="max-width: 90px;">{{ @$data['data-right'] != NULL ? @$data['data-right'] : 'ไม่มีข้อมูล !' }} </span> </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-7">
                        <h6 class="fw-semibold my-3">{{ @$data['content-head'] }}  </h6>
                        <table class="table table-nowrap table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-1'] }} :</th>
                                    <td class="text-end" title="{{ @$data['data-1'] }}">{{ Str::limit(@$data['data-1'], 15) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-2'] }} :</th>
                                    <td class="text-end" title="{{@$data['data-2']}}">{{ Str::limit(@$data['data-2'], 12) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-3'] }} :</th>
                                    <td class="text-end" title="{{@$data['data-3']}}"> {{ Str::limit(@$data['data-3'], 15) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-4'] }} :</th>
                                    <td class="text-end" title="{{@$data['data-4']}}">{{ Str::limit(@$data['data-4'], 15) }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-5'] }} :</th>
                                    <td class="text-end" title="{{@$data['data-5']}}">{{ Str::limit(@$data['data-5'], 15) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="display: block;">
                <div class="row">
                    <div class="col-5 d-flex justify-content-evenly">
                        <div class="row">
                            @if(@$data['btn-edit'] == true)
                                <div class="col d-grid">
                                    <div class="btn-group dropend">
                                        <a class="rounded-pill btn-sm btn btn-outline-primary px-4" data-bs-toggle="dropdown" aria-expanded="false" type="button" title="">ดูข้อมูล</a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <span tabindex="0" role="menuitem" class="text-primary text-center dropdown-item" disabled>รายการ</span>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a id="edit-about-cus" class="dropdown-item edittask-details data-modal-xl-2" data-link = "{{ @$data['data-linkedit'] }}">1. แก้ไข (Edit)</a>
                                            <a id="edit-about-cus" class="dropdown-item edittask-details data-modal-xl-2" data-link = "{{ @$data['data-linkview'] }}">2. ดูข้อมูล (View)</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col d-grid">
                                    <a type="button" class="rounded-pill btn-sm btn btn-outline-primary data-modal-xl-2" data-link = "{{ @$data['data-linkview'] }}">ดูข้อมูล</a>
                                </div>
                            @endif

                            @if(@$data['type-broker'] == true)
                            <div class="col-3">
                                <button class="rounded-circle btn-sm btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#com{{ @$data['id'] }}">
                                    <i class="bx bxl-bitcoin bx-tada"></i>
                                </button>
                            </div>
                            @endif

                            <div class="col-3">
                                <button class="rounded-circle btn-sm btn btn-danger {{@$data['classRemove']}}" data-id="{{@$data['id']}}" type="button">
                                    <i class="bx bxs-trash bx-tada"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-7 d-flex justify-content-evenly">
                        <small class="fw-semibold text-secondary"><i class="bx bxs-user-circle fs-5 m-auto"></i> {{ $data['UserInsert'] }}</small><br>
                        <small class="fw-semibold text-secondary d-none d-sm-inline" data-bs-toggle="tooltip" title="{{ $data['LastUpdate'] }}"><i class="bx bxs-time-five fs-5"></i> {{ \Carbon\Carbon::parse($data['LastUpdate'])->locale('th_TH')->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p class="text-danger fw-semibold fs-6">
                    @if(@$data['textAlert'])
                     <i class="bx bx-error"></i> {{ @$data['textAlert'] }}
                    @endif
                </p>
            </div>
        </div>
    </div>

 {{-- On Mobile --}}
    <div class="div d-md-none">
        <div class="card rounded-4 me-2 border-2 border mb-1 {{ @$data['data-right'] == 0 && @$data['type-broker'] == true ? 'border-danger' : 'border-primary border-opacity-50' }} " style = "min-width:12rem; max-width:12rem;">
            <div class="card-header bg-transparent border-bottom">
                <div class="row">
                    <div class="col text-center">
                        <span class="badge rounded-pill bg-danger bg-soft text-danger fs-6 fw-semibold">
                            {{ @$data['name-index'] }} ( {{ @$data['index'] }} )
                        </span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-12 m-auto">
                        <div class="col-12 text-center my-2">
                            <img src="{{ @$data['img'] != NULL ? @$data['img'] : URL::asset('\assets\images\OIP.png') }}" class="rounded-circle border border-3 {{ @$data['img'] != NULL ? 'border-primary border-opacity-50' : 'border-danger' }}  p-1" alt="เพิ่ม" style="width: 100px; height: 100px;">
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <span class="fw-semibold ms-2">{{ @$data['Name_Cus'] }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m-auto text-center border-end">
                                <p class="fw-semibold fs-6 mb-0">{{ @$data['title-left'] }}</p>
                                <p class="{{ @$data['data-left'] == NULL ? 'fw-semibold text-danger' : '' }}">{{ @$data['data-left'] != NULL ? @$data['data-left'] : 'ไม่มีข้อมูล !' }}</p>
                            </div>
                            <div class="col m-auto text-center">
                                <p class="fw-semibold fs-6 mb-0">{{ @$data['title-right'] }}</p>
                                <p class="{{ @$data['data-right'] == NULL ? 'fw-semibold text-danger' : '' }}"> <span class="d-inline-block text-truncate" style="max-width: 90px;">{{ @$data['data-right'] != NULL ? @$data['data-right'] : 'ไม่มีข้อมูล !' }} </span> </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ @$data['id'] }}" aria-expanded="false" aria-controls="flush-{{ @$data['id'] }}">
                        แก้ไขข้อมูล
                    </button>
                  </h2>
                  <div id="flush-{{ @$data['id'] }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row gap-1">
                                        @if(@$data['btn-edit'] == true)
                                            <div class="col-12 d-grid">
                                                <div class="btn-group dropend">
                                                    <a class="rounded-pill btn-sm btn btn-outline-primary px-4" data-bs-toggle="dropdown" aria-expanded="false" type="button" title="">ดูข้อมูล</a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <span tabindex="0" role="menuitem" class="text-primary text-center dropdown-item" disabled>รายการ</span>
                                                        <div tabindex="-1" class="dropdown-divider"></div>
                                                        <a id="edit-about-cus" class="dropdown-item edittask-details data-modal-xl-2" data-link = "{{ @$data['data-linkedit'] }}">1. แก้ไข (Edit)</a>
                                                        <a id="edit-about-cus" class="dropdown-item edittask-details data-modal-xl-2" data-link = "{{ @$data['data-linkview'] }}">2. ดูข้อมูล (View)</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12 d-grid">
                                                <a type="button" class="rounded-pill btn-sm btn btn-outline-primary data-modal-xl-2" data-link = "{{ @$data['data-linkview'] }}">ดูข้อมูล</a>
                                            </div>
                                        @endif

                                        @if(@$data['type-broker'] == true)
                                        <div class="col-12 d-grid">
                                            <button class="rounded-pill btn-sm btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#com{{ @$data['id'] }}">
                                                <i class="bx bxl-bitcoin bx-tada"></i>
                                            </button>
                                        </div>
                                        @endif

                                        <div class="col-12 d-grid">
                                            <button class="rounded-pill btn-sm btn btn-danger {{@$data['classRemove']}}" data-id="{{@$data['id']}}" type="button">
                                                <i class="bx bxs-trash bx-tada"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p class="text-danger fw-semibold fs-6">
                    @if(@$data['textAlert'])
                     <i class="bx bx-error"></i> {{ @$data['textAlert'] }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if(@$data['type-broker'] == true)
        <div class="collapse collapse-horizontal me-2" id="com{{ @$data['id'] }}">
            <div class="card border-2 border border-2 border {{ @$data['data-right'] == 0 && @$data['type-broker'] == true ? 'border-danger' : 'border-primary border-opacity-50' }} rounded-4 card-body" style="width: 200px; min-height:18rem; max-height:18rem;">
                <h5 class="fw-semibold"><i class="bx bx-dollar-circle text-warning"></i> เพิ่มค่าคอมมิชชั่น </h5>
                <form id = "formComm-{{@$data['id']}}">
                    <div class="mb-2">
                        <label class="fw-semibold">ค่าคอมมิชชั่น</label>
                        <input type="text" class="form-control form-control-sm border border-2 border-warning commission-{{@$data['id']}}" value="{{ number_format(@$data['Commission_Broker'],2) }}" name="commission" id="commission-{{ @$data['id'] }}" >
                    </div>
                    <div class="mb-2">
                        <label class="fw-semibold">ประเภทค่าคอมมิชชั่น</label>
                        <select class="form-select form-select-sm border border-2 border-warning typeCom-{{@$data['id']}} typeCom" index = "{{@$data['id']}}" name="typeCom" id="typeCom-{{ @$data['id'] }}">
                            <option value="" dataVal="100">--- ประเภทค่าคอมมิชชั่น ---</option>
                            @foreach(@$data['datacom'] as $val)
                                <option value="{{@$val->CodeCom}}" dataVal="{{$val->value}}" {{@$val->CodeCom == @$data['TypeCom'] ? 'selected' : ''}}>{{@$data['index']}}. {{@$val->NameCom}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="fw-semibold">รวมค่าคอมมิชชั่น</label>
                        <input type="text" class="form-control form-control-sm border border-2 border-success totalCom-{{@$data['id']}}" value="{{ @$data['SumCom_Broker'] }}" name="totalCom"  id="totalCom-{{ @$data['id'] }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col d-grid">
                            <button class="btn btn-primary btn-sm btn-saveCom-{{@$data['id']}} btn-saveCom rounded-pill" onclick="saveCom('{{ @$data['id'] }}',{{ @$data['id'] }},{{ @$data['PactCon_id'] }} )" type="button">บันทึก <span class="addSpin"></span></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @endif

</div>







