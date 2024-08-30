<div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll">
    <div class="d-flex justify-content-center gap-2">
      <div id="TrackListToday" onclick="shortcut(1,'{{$GroupType}}','TrackListToday')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> รายการติดตามวันนี้ <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['TrackListToday'] }}</span>
      </div>
      <div id="Past12PSL" onclick="shortcut(2,'{{$GroupType}}','Past12PSL')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> PAST 2 , PAST 3 (PSL) <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['Past12PSL'] }}</span>
      </div>
      <div id="SendManagerPSL" onclick="shortcut(3,'{{$GroupType}}','SendManagerPSL')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> ส่งรายงานหัวหน้า ,ส่งรายงาน GM (PSL) <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['SendManagerPSL'] }}</span>
      </div>
      <div id="SendManagerHP" onclick="shortcut(4,'{{$GroupType}}','SendManagerHP')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> ส่งรายงานหัวหน้า ,ส่งรายงาน GM (HP) <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['SendManagerHP'] }}</span>
      </div>
      <div id="AppointmentToday" onclick="shortcut(5,'{{$GroupType}}','AppointmentToday')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> นัดชำระวันนี้ <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['AppointmentToday'] }}</span>
      </div>
      <div id="DueToday" onclick="shortcut(6,'{{$GroupType}}','DueToday')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> ดีลวันนี้ <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['DueToday'] }}</span>
      </div>
      <div id="DueYesterday" onclick="shortcut(7,'{{$GroupType}}','DueYesterday')" class="btn btn-soft-secondary waves-effect waves-light btn btn-secondary rounded-pill text-nowrap btn-shortCut" style="max-width : 100%">
        <i class="bx bxs-rocket bx-tada"></i> ดีลเมื่อวาน <span class="badge rounded-pill text-bg-danger ms-1">{{ $count['DueYesterday'] }}</span>
      </div>
    </div>
  </div>