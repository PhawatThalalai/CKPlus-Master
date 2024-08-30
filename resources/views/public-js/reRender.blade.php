<script>
    function appendDataByColumnValue(columnName, columnValue, newData ,elementTB ) {
        let dataTable = $(elementTB).DataTable()
        dataTable.rows().every(function(index, element) {
            var rowData = this.data();
            if (rowData[columnName] === columnValue) {
                $.extend(rowData, newData);
                this.invalidate('data').nodes().to$().addClass('bg-warning bg-soft');
            }
            setTimeout(() => {
                this.invalidate('data').nodes().to$().removeClass('bg-warning bg-soft');
            }, 5000);
        });

        console.log(columnName, columnValue, newData ,elementTB ) ;

    }
</script>
