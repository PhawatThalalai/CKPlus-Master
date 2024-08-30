<div class="card p-2 table-responsive h-100" id="appendTB" style="overflow: hidden;">
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-4 mt-2">
            <img class=" " src="assets/images/add-user.png" alt="" style="width: 50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2">ข้อมูลนายหน้า (BROKER INFO )</h5>
            <h6 class="text-secondary fw-semibold"><i class="bx bxs-map me-1"></i> สาขา {{@$dataBranch2->Name_Branch}}</h6>
            <p class="border-primary border-bottom mt-2"></p>
            <input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
        </div>
    </div>
    <table class="viewWalkin dateHide  table table-hover text-nowrap dateHide createContract border border-light" id="table1">
        <thead>
          <tr class="bg-light">
            <th class="text-center">วันที่เข้า</th>
            <th class="text-center">ประเภทนายหน้า</th>
            <th class="text-center">ชื่อ-สกุล</th>
            <th class="text-center">เบอร์โทร</th>
            <th class="text-center" style="width: 5%"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataCus as $row)
              <tr>
                <td class="text-center"> 
                  <i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
                      <p>{{ date_format(date_create(@$row->date_Broker), 'Ymd')}} </p>
                      {{date('d-m-Y', strtotime(substr($row->date_Broker,0,10)))}} 
                </td>
                <td class="text-center"> 
                  <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" fdprocessedid="kwov7p">
                    {{@$row->BrokerToType->Name_typeBroker}}
                  </div>
                </button>
                <td class="text-center"> 
                  <h5 class="font-size-12 mb-1"> {{(@$row->BrokerToDataCus->Name_Cus != Null) ? $row->BrokerToDataCus->Name_Cus : '-'}} </h5>
                  @if (@$row->BrokerToDataCus->Status_Cus == 'active')
                    <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
                  @elseif (@$row->BrokerToDataCus->Status_Cus == 'cancel')
                    <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
                  @else
                    <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
                  @endif
                  
                </td>
                <td class="text-center">
                  <i class="btn btn-soft-info btn-sm rounded-pill fas fa-phone"></i>
                   {{(@$row->BrokerToDataCus->Phone_cus)}} 

                </td>
                <td class="text-center">
                  <li class="list-inline-item px-2">
                    <a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$row->BrokerToDataCus->id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft fs-3"></i></a>
                  </li>
                
                </td>
              </tr>
          @endforeach
        </tbody>
    </table>
</div>
                  
        <script>
            $(".viewWalkin").DataTable({
                "responsive": false,
                "autoWidth": false,
                "ordering": true,
                "lengthChange": true,
                "order": [[ 0, "asc" ]],
                "pageLength": 10,
            });
        </script>

