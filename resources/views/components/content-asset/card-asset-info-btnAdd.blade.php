<style>
    .cardAdd-asset{
        /*height: 240px;*/
        transition : 0.3s;
    }
    .cardAdd-asset:hover{
        opacity:0.7;
        transition : 0.3s;
    }

</style>

<div class="d-flex">
    <a id="add-large-btn-asset" class="create-dataAssetBtn" data-bs-toggle="modal" data-bs-target="#modal_xl" data-link="{{ route('asset.create') }}?type=new&cusid={{@$dataCus_id}}">
        <div class="card rounded-4 bg-secondary p-2 cardAdd-asset" style="min-height: 18rem;">
            <div class="bg-light m-auto" style="border-radius:50px">
                <img src="assets/images/plus.png" alt="เพิ่ม" style="width: 100px;" class="btnAdd">
            </div>
        </div>
    </a>
</div>
