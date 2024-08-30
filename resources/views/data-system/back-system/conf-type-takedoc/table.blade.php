<div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
    <table class="table align-middle table-nowrap table-hover">
        <thead class="table-light sticky-top">
            <tr>
                <th scope="col" style="width: 70px;">#</th>
                <th scope="col">ชื่อประเภท TH</th>
                <th scope="col">ชื่อประเภท EN</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataTypeTake as $key => $value)
                <tr>
                    <td>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                {{$key+1}}
                            </span>
                        </div>
                    </td>
                    <td>
                        <p class="text-muted mb-0">{{@$value->name_th}}</p>
                    </td>
                    <td>
                        <p class="text-muted mb-0">{{@$value->name_en}}</p>
                    </td>
                    <td>
                        <p class="text-muted mb-0">{{@$value->flag_st}}</p>
                    </td>
                    <td>
                        <div>
                            <button class="btn-edit" id="btn-edit">
                                <i class='bx bx-edit' ></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {

    });
</script>