<div>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                <div class="form-floating mb-0">
                    <select class="form-control UserApp_Con" id="select2test" multiple="multiple" >
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>

                    </select>
                    <label for="select2test" class="fw-bold text-danger">ผู้เกี่ยวข้อง</label>
                </div>
                <button class="btn btn-light border-secondary border-opacity-50 rounded-end d-flex align-items-center openDatepickerBtn_formfloating" type="button">
                    <img src="{{ asset('assets/images/icon/microsoft-teams.svg') }}" alt="">
                </button>
            </div>



        </div>
        <div class="col-6">
            <div class="card p-2 h-100">
                <input class="form-control mb-1" wire:model.live.debounce.300ms="searchTableA" type="text">
                @if(true)
                <div class="table-responsive" style="max-height: 390px;">
                    <table class="table align-middle table-nowrap table-hover">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Occupation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (@$dataAll as $item )
                            <tr>
                                <td>
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $item->FORCODE }}</td>
                                <td>{{ $item->FORDESC }}</td>
                                <td class="text-center"> <button type="button" wire:click="update({{ $item->id }} ,'add')"  class="btn btn-primary rounded-pill btn-sm"> <i class="bx bx-plus"></i> </button> </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="card p-2 h-100" >
                <input class="form-control mb-1" wire:model.live.debounce.300ms="searchTableB" type="text">
                @if(true)
                <div class="table-responsive" style="max-height: 390px;">
                    <table  class="table align-middle table-nowrap table-hover">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Occupation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody wire:sortable="updatedItems">
                            @foreach (@$data as $item )
                            <tr draggable="true" ondragstart="dragit(event)" ondragover="dragover(event)" wire:sortable.item="{{ $item->id }}" wire:key="item-{{ $item->id }}">
                                <td>
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                            {{ $item->REGFL }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $item->FORCODE }}</td>
                                <td>{{ $item->FORDESC }}</td>
                                <td class="text-center"> <button type="button" wire:click="update({{ $item->id }} ,'delete')" class="btn btn-danger rounded-pill btn-sm"> <i class="bx bx-minus"></i> </button> </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    let shadow
    function dragit(event){
        shadow=event.target;
    }
    function dragover(e){
    let children=Array.from(e.target.parentNode.parentNode.children);
    if(children.indexOf(e.target.parentNode)>children.indexOf(shadow))
        e.target.parentNode.after(shadow);
    else e.target.parentNode.before(shadow);
    }

</script>

<script>
    // select2test
    $(document).ready(function() {
        $( '#select2test' ).select2( {
            theme: "bootstrap-5",
            // language: "th",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            // placeholder: $( this ).data( 'placeholder' ),
            // allowClear: true,
            // dropdownParent: $('#modal_lg .modal-content'),
            //data: dataArray_user,
        } );
    });
</script>












