<div id="card-contracts">
    @include('components.content-contract.backend.card-contracts',['contract' => @$contract, 'active_memo' => 'true'])
</div>
<!-- tab content -->
    @include('backend.content-contract.view-tab-contract', ['page' => 'contracts'])
<!-- end tab content -->


<script>
    $(document).ready(function() {
        sessionStorage.setItem('DataPact_id' , '{{ @$contract->DataPact_id }}')
        sessionStorage.setItem('DataCus_id' , '{{ @$contract->DataCus_id }}')
        getTab('data-main-contract')
    })
</script>

<script>
    getTab = (tab) => {

        let DataPact_id = sessionStorage.getItem('DataPact_id')

        $('.'+tab+'_tab').hide()
        $('.'+tab+'_loading').show()
        $('#img-empty').hide() // hidden imaage on first time

        url = "{{ route('contracts.show', ':ID') }}"
        $.ajax({
            url : url.replace(":ID",DataPact_id),
            type : "GET",
            data : {
                page : 'get-contentCon',
                tab : tab,
                _token : "{{ @CSRF_TOKEN() }}"
            },
            success : (res) =>{
                $('#img-empty').empty() // clear imaage on first time
                $('.'+tab+'_tab').show()
                $('.'+tab+'_loading').hide()
                $('#'+tab+'_tab').html(res.html)

            },
            error : (err)=>{
                $('#img-empty').show() // hidden imaage on first time
                $('.'+tab+'_tab').show()
                $('.'+tab+'_loading').hide()
            }
        })

    }

</script>

