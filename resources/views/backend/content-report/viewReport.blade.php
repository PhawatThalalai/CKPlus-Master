@component('components.content-report.view-report')
    @slot('data', [
        'reportTitle' => $reportTitle,
        'form' => $form,
        'report' => $report,
        'dataBranchs' => @$dataBranchs,
        'dataZone' => @$dataZone,
        'dataEmpy'=>@$dataEmpy
    ])
@endcomponent
