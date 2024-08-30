9<style>
	.icon-add {
		border-radius: 50px;
		position: relative;
		top: 50px;
	}

	.cardAdd {
		/* height: 250px; */
		transition: 0.3s;
	}

	.cardAdd:hover {
		opacity: 0.7;
		transition: 0.3s;
	}
</style>

    <div class="d-flex mb-2" style="overflow: auto;">
        <div class="cardAdd">
            <a id="add-large-btn">
                <div class="card bg-secondary p-2" style="height : 223px;">
                    <div class="bg-light icon-add">
                        <img src="{{URL::asset('assets/images/plus.png')}}" alt="เพิ่ม" style="width: 100px;" class="btnAdd">
                    </div>
                </div>
            </a>
        </div>
        <div class="card task-box border border-primary border-2 border-opacity-50 placeholder-glow ms-1" id="cmptask-1" style="min-width:350px;">
            <div class="card-header bg-info bg-soft">
                <div class="row">
                    <div class="col-10">
                        <h6 class="text-primary fw-semibold"> <i class="bx bx-purchase-tag"></i> <span class="placeholder col-7"></span></h6>
                    </div>
                    <div class="col-2 text-end">
                        <div class="dropdown float-end me-2">
                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="javascript: void(0);" class="text-warning fs-6 fw-semibold" id="task-name" title="ที่อยู่ปัจจุบัน"><span class="placeholder col-7"></span> <i class="bx bxs-check-circle text-primary d-none"></i> </a>
                            <p class="fw-semibold text-truncate">
                                <i class="bx bx-detail m-0 text-success h5"></i> : <span class="placeholder col-7"></span><br>
                                <i class="bx bx-bookmark m-0 text-success h5"></i> : <span class="placeholder col-7"></span><br>
                                <i class="bx bx-spreadsheet m-0 text-success h5"></i> : <span class="placeholder col-7"></span>
                            </p>
                        </div>
                        <div class="col-3 text-end me-2 m-auto">
                            {{-- <img src="assets/images/home-address.png" alt="" width="70px;"> --}}
                            <div class="spinner-grow spinner-grow-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            <div class="col-12 text-end mt-1">
                                <span class="badge rounded-pill badge-soft-success  font-size-12" id="task-status">
                                    Loading...
                                </span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <small class="text-muted fs-6">
                    <div class="row">
                        <div class="col-6" title="">
                            <span class="placeholder col-7"></span>
                        </div>
                        <div class="col-6 text-end" title="">
                           <p class="text-muted mb-0 text-truncate"><i class="bx bxs-user-circle"></i> <span class="placeholder col-7"></span></p>
                        </div>
                    </div>
        
                </small>
            </div>
        </div>
    </div>
