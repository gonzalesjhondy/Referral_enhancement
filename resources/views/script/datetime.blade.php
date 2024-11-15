<link rel="stylesheet" href="{{ url('resources/plugin/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" />
<script src="{{ url('resources/plugin/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    var FromEndDate = new Date();
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minuteStep: 2,
        endDate: FromEndDate,
        endTime: FromEndDate
    });
</script>