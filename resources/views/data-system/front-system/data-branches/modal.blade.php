<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}
</style>

@if(@$mode == 'create')
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มสาขา</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="CODE" name="CODE" class="form-control" placeholder="รหัสสาขา" required>
                                                    <label for="Contract">รหัสสาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="PhoneNumber" name="PhoneNumber" class="form-control" placeholder="รหัสสาขา2">
                                                    <label for="Contract">เบอร์โทรศัพท์สาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="Position_branch" name="Position_branch" class="form-control" placeholder="พิกัดสาขา">
                                                    <label for="Contract">พิกัดสาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea name="Branch_Address" id="Branch_Address" rows="4" class="form-control" placeholder="ชื่อสาขา EN" required></textarea>
                                                    <label for="Contract">ที่อยู่สาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LineId" name="LineId" class="form-control" placeholder="พิกัดสาขา" required>
                                                    <label for="Contract">Line ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="visually-hidden" id="Provice_Seca">test</button>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="NAME_TH" name="NAME_TH" class="form-control" placeholder="ชื่อสาขา TH" required>
                                                    <label for="Contract">ชื่อสาขา TH</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="NAME_EN" name="NAME_EN" class="form-control" placeholder="ชื่อสาขา EN" required>
                                                    <label for="Contract">ชื่อสาขา EN</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="Province" name="Province" class="form-control" placeholder="จังหวัด" required>
                                                    <label for="Contract">จังหวัด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="OpenDate" name="OpenDate" class="form-control" placeholder="จังหวัด" required>
                                                    <label for="Contract">วันเปิด-ปิด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mt-4 mt-lg-0">
                                                    <h5 class="font-size-12 mb-1">เปิดปิดสาขา</h5>
                                                    <div class="d-flex">
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes" id="BranchActive" checked>
                                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div>
                                <div id="map" style="height: 300px; border-radius: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-edit"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@elseif(@$mode == 'edit')
    <form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
        @csrf
        @method('put')
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขสาขา</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="id" name="ID" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="CODE" name="CODE" value="{{@$data->id_Contract}}" class="form-control" placeholder="รหัสสาขา" required>
                                                    <label for="Contract">รหัสสาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="PhoneNumber" name="PhoneNumber" value="{{@$data->phoneNo}}" class="form-control" placeholder="รหัสสาขา2">
                                                    <label for="Contract">เบอร์โทรศัพท์สาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="Position_branch" name="Position_branch" value="{{@$data->lat}},{{@$data->lon}}" class="form-control" placeholder="พิกัดสาขา">
                                                    <label for="Contract">พิกัดสาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea name="Branch_Address" id="Branch_Address" rows="4" class="form-control" placeholder="ชื่อสาขา EN" required>{{@$data->address}}</textarea>
                                                    <label for="Contract">ที่อยู่สาขา</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LineId" name="LineId" class="form-control" value="{{@$data->line_id}}" placeholder="พิกัดสาขา" required>
                                                    <label for="Contract">Line ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="visually-hidden" id="Provice_Seca">test</button>
                                        </div>
                                        <br>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="NAME_TH" name="NAME_TH" value="{{@$data->Name_Branch}}" class="form-control" placeholder="ชื่อสาขา TH" required>
                                                    <label for="Contract">ชื่อสาขา TH</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="NAME_EN" name="NAME_EN" value="{{@$data->NickName_Branch}}" class="form-control" placeholder="ชื่อสาขา  EN" required>
                                                    <label for="Contract">จังหวัด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="Province" name="Province" class="form-control" value="{{ @$data->province_Branch }}" placeholder="จังหวัด" required>
                                                    <label for="Contract">จังหวัด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="OpenDate" name="OpenDate" class="form-control" value="{{ @$data->open_time }}"  placeholder="จังหวัด" required>
                                                    <label for="Contract">วันเปิด-ปิด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mt-4 mt-lg-0">
                                                    <h5 class="font-size-12 mb-1">เปิดปิดสาขา</h5>
                                                    <div class="d-flex">
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes" {{(@$data->Branch_Active == 'yes')?'checked':''}}>
                                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div>
                                <div id="map" style="height: 300px; border-radius: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" id="UpdateData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-move"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>
@endif
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{-- Create Data --}}
<script>

$("#SaveData").click(function(){
    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});  
    if ($("#formAdd").valid() == true) {
        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('dataStatic.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              store: 'branches',
              data: data,
            },
            success: function(result) {
              $('#Modal-xl').modal('hide');
              $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
              swal.fire({
                icon : 'success',
                text : 'บันทึกข้อมูลสำเร็จ',
                timer: 3500,
                dangerMode: true,
              })
              $('#dataBranches').html(result).show('slow');
            }
        });
    } else {
        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        swal.fire({
            icon : 'warning',
            title : 'ข้อมูลไม่ครบ !',
            text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
            timer: 3000,
            showConfirmButton: true,
        })
    }      
  });
</script>

{{-- Update Data --}}
<script>
    $("#UpdateData").click(function(){
        var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
        if ($("#formUpdate").valid() == true) {
            $.ajax({
                url: "{{ route('dataStatic.update',0) }}",
                method: 'PUT',
                // data:data,
                data:{
                    _token:'{{ csrf_token() }}',
                    update: 'branches',
                    data:data,
                },

                success: function(result) {
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#dataBranches").html(result).show('slow');
                }
            });
        }    
    });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd,#formUp').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

<script>
    function appendGoogleMapApis() {
        if (typeof google === 'object' && typeof google.maps === 'object') {
            initMap();
        } else {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCyqGqjIB7DvtpbSmZ14qyhKbA7XQdHw2Y&callback=initMap&language=th";
            document.body.appendChild(script);
        }
    }
    appendGoogleMapApis();
</script>
<script>
    function initMap() {
        //console.log( "initMap" );
        let _latLon = $("#Position_branch").val();
        const latLons = _latLon.split(",");
        console.log(latLons[0]);
        let _HQpositon = { lat: _latLon !== '' ? Number(latLons[0]) : {{ @$lat }}, lng:  _latLon !== '' ? Number(latLons[1]) : {{ @$lon }} };
        const zoom = 15;
        const imageMarker = "{{ asset('assets/images/CK-location.png') }}";
        let TimeOutEvent;

        let image = new google.maps.MarkerImage(
            imageMarker,
            new google.maps.Size(120, 120),
            new google.maps.Point(0, 0),
            new google.maps.Point(21, 21),
            new google.maps.Size(71, 71)
        );

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: zoom,
            center: _HQpositon,
        });

        const marker = new google.maps.Marker({
            position: _HQpositon,
            map,
            animation: google.maps.Animation.DROP,
            icon: image,
            draggable: true,
            title: "new branche position",
        });

        const infoWindow = new google.maps.InfoWindow({});

        function dragEvent(event) {
            const position = event.latLng;
            infoWindow.setContent(`พิกัด : ${position.lat()},${position.lng()}`);
            $("#Position_branch").val(`${position.lat()},${position.lng()}`);
            console.log(`${position.lat()},${position.lng()}`);
            TimeOutEvent = setTimeout(() => {
                $("#Provice_Seca").click();
            }, 2000);
        }

        function reSetTimeOut () {
            clearTimeout(TimeOutEvent);
        }

        marker.addListener('drag', dragEvent, reSetTimeOut);
        marker.addListener('dragend', dragEvent, reSetTimeOut);
    }
</script>
<script>
    $(document).ready(function() {
        let province = '';

        $("#Position_branch").change(function() {
            appendGoogleMapApis();
        });

        $("#Provice_Seca").click(async () => {
           const LogLat = $("#Position_branch").val().split(",");
           const response = await axios.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${LogLat[0]},${LogLat[1]}&language=th&key=AIzaSyCyqGqjIB7DvtpbSmZ14qyhKbA7XQdHw2Y`);
           console.log(response);
           const dataLatLons = response.data;
           const datacount = dataLatLons.results.length - 2;
           const dataLatLon = response.data.results[datacount].address_components[0].short_name;
           console.log(datacount);
           const Locat = response.data.results[2].formatted_address;
           const splitProvince = dataLatLon.split(".");
           province = splitProvince[1];
           $("#Branch_Address").val(Locat === undefined ? "ไม่มีข้อมูลจังหวัด" : Locat);
           $("#Province").val(province === undefined ? "ไม่มีข้อมูลจังหวัด" : province);
        //    console.log(province);
        //    console.log(response);

        //    if (dataLatLons.results[1]) {
        //         let indice = 0;
        //         for (let i = 0; i < dataLatLons.results.length; index++) {
        //             if (dataLatLons.results[i].types[0]=='locality') {
        //                 indice=i;
        //                 break;
        //             }
        //             // alert('The good number is: '+i);
        //             console.log(dataLatLons.results[i]);

        //             for (let j=0; j < dataLatLons.results[i].address_components.length; i++) {
        //                 if (dataLatLons.results[i].address_components[j].types[0] == "locality") {
        //                         //this is the obiect you are looking for City
        //                         city = dataLatLons.results[i].address_components[j];
        //                     }
        //                 if (dataLatLons.results[i].address_components[j].types[0] == "administrative_area_level_1") {
        //                         //this is the obiect you are looking for State
        //                         region = dataLatLons.results[i].address_components[j];
        //                     }
        //                 if (dataLatLons.results[i].address_components[j].types[0] == "country") {
        //                         //this is the obiect you are looking for
        //                         country = dataLatLons.results[i].address_components[j];
        //                     }
        //             }

        //             console.log(city.long_name + " || " + region.long_name + " || " + country.short_name);
        //         } 
        //    }
        });
    });
</script>
