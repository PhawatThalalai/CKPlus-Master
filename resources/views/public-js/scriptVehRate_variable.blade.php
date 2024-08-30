<script id="json_dataVehRate">

    var dataCar = [];
    var brandCar_array = [];
    var groupCar_array = [];
    var modelCar_array = [];
    var TypeVehicle = [];

    @if(!empty($TypeVehicle)) 
        TypeVehicle = @json($TypeVehicle);
    @endif

    @if(!empty($dataCar))       
        dataCar = @json($dataCar["all"]);       
        brandCar_array = @json($dataCar["brand"]);      
        groupCar_array = @json($dataCar["group"]);    
        modelCar_array = @json($dataCar["model"]);      
    @endif

    @if( !empty( $dataMoto ) )
        var dataMoto = @json( $dataMoto["all"]);
        var brandMoto_array = @json( $dataMoto["brand"]);
        var groupMoto_array = @json( $dataMoto["group"]);
        var modelMoto_array = @json( $dataMoto["model"]);
    @endif

    var rateType_array = [];
    @if( !empty( $typeRate ) )
        rateType_array = @json($typeRate);
    @endif

</script>