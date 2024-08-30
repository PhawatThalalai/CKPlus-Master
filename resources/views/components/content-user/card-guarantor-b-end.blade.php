<div class="card mb-2">
	<div class="card-body ">
		<div class="row">
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center border-end">
				<div class="bg-light mini-stat-icon rounded-3 py-3">
					<img src="{{ URL::asset('\assets\images\users\avatar-1.jpg') }}" alt="" class="rounded-circle bg-white border border-2 border-warning mb-1" style="max-width: 45%;">
						<br><span class="badge text-bg-warning fs-5 mb-1">ผู้ค้ำคนที่ {{ @$data['numGuaran'] }}</span>
					<div class="accordion-flush" id="accor-{{ @$data['numGuaran'] }}">
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading-{{ @$data['numGuaran'] }}">
								<button class="btn btn-soft-warning rounded-circle" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ @$data['numGuaran'] }}" aria-expanded="false" aria-controls="flush-{{ @$data['numGuaran'] }}">
									<i class="bx bx-down-arrow-alt"></i>
								</button>
							</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl col-lg col-md col-sm-12">
				<div class="row">
					<div class="col">
						<h5 class="text-primary p-2"><i class="bx bx-user"></i> รายละเอียดผู้ค้ำ (Guarantor Details)</h5>
						<div class="table-responsive">
							<table class="table table-sm table-nowrap mb-0 table-striped">
								<tbody class="fs-6">
									<tr>
										<th scope="row">ชื่อ :</th>
										<td class="text-end">
											{{ @$data['nameGuaran'] != null ? @$data['nameGuaran'] : '-' }}

										</td>
									</tr>
									<tr>
										<th scope="row">นามสกุล :</th>
										<td class="text-end">
											{{ @$data['relationship'] != null ? @$data['relationship'] : '-' }}

										</td>
									</tr>
									<tr>
										<th scope="row">ชื่อเล่น :</th>
										<td class="text-end">
											{{ @$data['nickname'] != null ? @$data['nickname'] : '-' }}
										</td>
									</tr>
									<tr>
										<th scope="row">เลขที่บัตร :</th>
										<td class="text-end">
											{{ @$data['cardIdGuar'] != null ? @$data['cardIdGuar'] : '-' }}
										</td>
									</tr>
									<tr class="bg-warning p-2 bg-soft">
										<th scope="row">เบอร์โทร :</th>
										<td class="text-end">
											{{ @$data['phoneGuar'] != null ? @$data['phoneGuar'] : '-' }}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col border border-light rounded-2">
						<h5 class="text-primary p-2"><i class="bx bxs-note"></i> หมายเหตุ (Guarantor Details)</h5>
						Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally.

						{{--
                        <h5 class="text-primary p-2"><i class="bx bxs-flag"></i> ข้อมูลอาชีพ (Carreer Details)</h5>
                        <div class="table-responsive">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                @php
                                    $i = 0;
                                @endphp
                                    @foreach (@$data['CareerMany'] as $value)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $i == 0 ? 'active show' : '' }}" data-bs-toggle="tab" href="#tab{{$value->id}}" role="tab" aria-selected="false" tabindex="-1">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">อาชีพที่ {{$i+1}}</span> 
                                        </a>
                                    </li>
                                    @php
                                        $i = $i+1;
                                    @endphp
                                @endforeach
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                @php
                                    $j = 0;
                                @endphp
                                @foreach (@$data['CareerMany'] as $value)
                                <div class="tab-pane {{ $j == 0 ? 'active show' : '' }}" id="tab{{$value->id}}" role="tabpanel">
                                    <table class="table table-sm table-nowrap mb-0 table-striped">
                                        <tbody class="fs-6">
                                            <tr>
                                                <th scope="row">รายได้ :</th>
                                                <td class="text-end">
                                                    {{  $value->Income_Cus }}
                                                        
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">อาชีพ :</th>
                                                <td class="text-end">
                                                {{  $value->Career_Cus }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">หักค่าใช้จ่าย :</th>
                                                <td class="text-end">
                                                {{  $value->BeforeIncome_Cus }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">คงเหลือ :</th>
                                                <td class="text-end">
                                                {{  $value->AfterIncome_Cus }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">สถานที่ทำงาน :</th>
                                                <td class="text-end">
                                                {{  $value->Workplace_Cus }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                    @php
                                        $j = $j+1;
                                    @endphp
                                @endforeach
                            </div>

                        </div>
                        --}}
					</div>
				</div>
			</div>
				<div id="flush-{{ @$data['numGuaran'] }}" class="accordion-collapse collapse mt-2 mb-2" aria-labelledby="heading-{{ @$data['numGuaran'] }}" data-bs-parent="#accor-{{ @$data['numGuaran'] }}" style="">
					<div class="row">
						<div class="col-xl-3 col-sm-12 border-end">		
							<div id="flush-{{ @$data['numGuaran'] }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ @$data['numGuaran'] }}" data-bs-parent="#accor-{{ @$data['numGuaran'] }}" style="">
								<div class="col">
									<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
										<a class="nav-link mx-4 text-center mb-2 active" id="v-pills-adds-{{@$data['numGuaran']}}-tab" data-bs-toggle="pill" href="#v-pills-adds-{{@$data['numGuaran']}}" role="tab" aria-controls="v-pills-adds-{{@$data['numGuaran']}}" aria-selected="false" tabindex="-1">ข้อมูลที่อยู่ผู้ค้ำ</a>
										<a class="nav-link mx-4 text-center mb-2" id="v-pills-carr-{{@$data['numGuaran']}}-tab" data-bs-toggle="pill" href="#v-pills-carr-{{@$data['numGuaran']}}" role="tab" aria-controls="v-pills-carr-{{@$data['numGuaran']}}" aria-selected="true">ข้อมูลอาชีพ</a>
										<a class="nav-link mx-4 text-center mb-2" id="v-pills-asst-{{@$data['numGuaran']}}-tab" data-bs-toggle="pill" href="#v-pills-asst-{{@$data['numGuaran']}}" role="tab" aria-controls="v-pills-asst-{{@$data['numGuaran']}}" aria-selected="false" tabindex="-1"> ทรัพย์ค้ำประกัน</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl col-sm-12">
							<div class="row">
								<div class="col">
									<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

										<div class="tab-pane fade active show" id="v-pills-adds-{{@$data['numGuaran']}}" role="tabpanel" aria-labelledby="v-pills-adds-{{@$data['numGuaran']}}-tab">
											@if (@count(@$data['AddsMany']) !== 0 )
												<ul class="nav nav-pills px-3" role="tablist">
													@foreach (@$data['AddsMany'] as $value)
													<li class="" role="presentation">
														<a class="nav-link {{ $loop->index == 0 ? 'active show' : '' }}" data-bs-toggle="tab" href="#tab{{$value->id}}" role="tab" aria-selected="false" tabindex="-1">
															<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
															<span class="d-none d-sm-block">{{$value->DataCusAddsToTypeAdds->Name_Address}}</span> 
														</a>
													</li>
													@endforeach
												</ul>
												<div class="table-responsive">
													<div class="tab-content p-3 text-muted">
														@foreach (@$data['AddsMany'] as $value)
															<div class="tab-pane {{ $loop->index == 0 ? 'active show' : '' }}" id="tab{{$value->id}}" role="tabpanel">
																<table class="table table-sm table-nowrap mb-0 table-striped">
																	<tbody class="fs-6">
																		<tr>
																			<th scope="row">ที่อยู่ :</th>
																			<td class="text-end">
																				{{ @$value->houseNumber_Adds.' หมู่ '.@$value->houseGroup_Adds.' หมู่บ้าน '.@$value->village_Adds }}
																					
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">ตำบล :</th>
																			<td class="text-end">
																				{{ @$value->houseTambon_Adds }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">อำเภอ :</th>
																			<td class="text-end">
																				{{ @$value->houseDistrict_Adds }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">จังหวัด :</th>
																			<td class="text-end">
																			{{ @$value->houseProvince_Adds }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">รหัสไปรษณีย์ :</th>
																			<td class="text-end">
																			{{ @$value->Postal_Adds }}
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														@endforeach
													</div>
												</div>
											@else
												<div class="tab-pane" id="" role="tabpanel">
													<div class="row">
														<div class="col text-center">
															<img src="{{ URL::asset('\assets\images\out-of-stock.png') }}" style="width:10%;">
															<h5 class="text-danger fw-semibold mt-2">ยังไม่มีข้อมูลอาชีพในผู้ค้ำรายนี้</h5>
														</div>
													</div>	
												</div>
											@endif
										</div>
										<div class="tab-pane fade" id="v-pills-carr-{{@$data['numGuaran']}}" role="tabpanel" aria-labelledby="v-pills-carr-{{@$data['numGuaran']}}-tab">
											@if (@count(@$data['CareerMany']) !== 0 )
												<ul class="nav nav-pills px-3" role="tablist">
														@foreach (@$data['CareerMany'] as $value)
														<li class="" role="presentation">
															<a class="nav-link {{ $loop->index == 0 ? 'active show' : '' }}" data-bs-toggle="tab" href="#tab{{$value->id}}" role="tab" aria-selected="false" tabindex="-1">
																<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
																<span class="d-none d-sm-block">อาชีพที่ {{$loop->iteration}}</span> 
															</a>
														</li>
													@endforeach
												</ul>
												<div class="table-responsive">
													<div class="tab-content p-3 text-muted">
														@foreach (@$data['CareerMany'] as $value)
														<div class="tab-pane {{ $loop->index == 0 ? 'active show' : '' }}" id="tab{{$value->id}}" role="tabpanel">
															<table class="table table-sm table-nowrap mb-0 table-striped">
																<tbody class="fs-6">
																	<tr>
																		<th scope="row">อาชีพ :</th>
																		<td class="text-end">
																		{{  ( $value->CusCareerToTBCareerCus->Code_Career == 'CR-0018' ) ? $value->DetailCareer_Cus : $value->CusCareerToTBCareerCus->Name_Career }}
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">รายได้ :</th>
																		<td class="text-end">
																			{{  $value->Income_Cus }}
																				
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">หักค่าใช้จ่าย :</th>
																		<td class="text-end">
																		{{  $value->BeforeIncome_Cus }}
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">คงเหลือ :</th>
																		<td class="text-end">
																		{{  $value->AfterIncome_Cus }}
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">สถานที่ทำงาน :</th>
																		<td class="text-end">
																		{{  $value->Workplace_Cus }}
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
														@endforeach
													</div>
												</div>
											@else
												<div class="tab-pane" id="tab{{@$value->id}}" role="tabpanel">
													<div class="row">
														<div class="col text-center">
															<img src="{{ URL::asset('\assets\images\out-of-stock.png') }}" style="width:10%;">
															<h5 class="text-danger fw-semibold mt-2">ยังไม่มีข้อมูลอาชีพในผู้ค้ำรายนี้</h5>
														</div>
													</div>	
												</div>
											@endif
										</div>
										<div class="tab-pane fade" id="v-pills-asst-{{@$data['numGuaran']}}" role="tabpanel" aria-labelledby="v-pills-asst-{{@$data['numGuaran']}}-tab">
											@if (@$data['asstMany'] != NULL && count(@$data['asstMany']) !== 0)
												<ul class="nav nav-pills px-3" role="tablist">
														@foreach (@$data['asstMany'] as $value)
														<li class="" role="presentation">
															<a class="nav-link {{ @$loop->index == 0 ? 'active show' : '' }}" data-bs-toggle="tab" href="#tab{{$value->id}}" role="tab" aria-selected="false" tabindex="-1">
																<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
																<span class="d-none d-sm-block">ทรัพย์ที่ {{@$loop->iteration}}</span> 
															</a>
														</li>
													@endforeach
												</ul>
												<div class="table-responsive">
													<div class="tab-content p-3 text-muted">
														
															@foreach (@$data['asstMany'] as $value)
															<div class="tab-pane {{ $loop->index== 0 ? 'active show' : '' }}" id="tab{{$value->id}}" role="tabpanel">
																<table class="table table-sm table-nowrap mb-0 table-striped">
																	<tbody class="fs-6">
																		<tr>
																			<th scope="row">ประเภททรัพย์ :</th>
																			<td class="text-end">
																			{{  $value->DataCusAssetToTypeAsset->Name_Assets }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">ภูมิภาค :</th>
																			<td class="text-end">
																				{{  $value->houseZone_Asset }}
																					
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">จังหวัด :</th>
																			<td class="text-end">
																			{{  $value->houseProvince_Asset }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">อำเภอ :</th>
																			<td class="text-end">
																			{{  $value->houseDistrict_Asset }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">ตำบล :</th>
																			<td class="text-end">
																			{{  $value->houseTambon_Asset }}
																			</td>
																		</tr>
																		<tr>
																			<th scope="row">เลขไปรษณีย์ :</th>
																			<td class="text-end">
																			{{  $value->Postal_Asset }}
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															@endforeach
													</div>

												</div>
											@else
												<div class="tab-pane" id="tab{{@$value->id}}" role="tabpanel">
													<div class="row">
														<div class="col text-center">
															<img src="{{ URL::asset('\assets\images\out-of-stock.png') }}" style="width:10%;">
															<h5 class="text-danger fw-semibold mt-2">ยังไม่มีทรัพย์ค้ำประกันในผู้ค้ำรายนี้</h5>
														</div>
													</div>	
												</div>
											@endif
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
