<?php
$count = count($data);
?>
@if(count($data) > 0)
    <div class="table-responsive">
        <table id="table" class="table table-hover table-bordered" style="font-size: 9pt;">
            <tr class="bg-success">
                <th></th>
                <th class='text-green text-center'>Code</th>
                <th class='text-green text-center'>Patient Name</th>
                <th class='text-green text-center'>Address</th>
                <th class='text-green text-center'>Referral Type</th>
                <th class="text-green text-center">Referred From</th>
                <th class='text-green text-center'>Date Referred</th>
            </tr>
            @foreach($data as $row)
                <tr>
                    <td>
                        <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-stethoscope"></i> Track</a>
                    </td>
                    <td>{{ $row->code }}</td>
                    <td>{{ $row->patient_name }}</td>
                    <td>{{ $row->barangay }}, {{ $row->muncity }}, {{ $row->province }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->referring_facility }}</td>
                    <td>{{ $row->date_referred }}</td>
                </tr>
            @endforeach
        </table>

        <div class="text-center">
            {{ $data->links() }}
        </div>
    </div>
@else
    <div class="alert alert-warning">
        <div class="text-warning">
            <i class="fa fa-warning"></i> NO DATA!
        </div>
    </div>
@endif

<script>
    var count = '{{ count(Session::get("dashboard_data")) }}';
    $(".dashboard-modal-title").html('{{ $desc }}' + " <span class = 'badge bg-yellow'>" + count + "</span>");

    $(document).ready( function () {
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            changePage(page);
        });
    });

    function changePage(page) {
        var url = "<?php echo asset('doctor/dashboard/getTransactions'); ?>";
        url = url + "/" + "{{ $type }}" + "?page=" + page;
        var json = {
            "type" : "{{ $type }}",
            "date_start" : "{{ $date_start }}",
            "date_end" : "{{ $date_end }}",
        };
        $.get(url,json,function(result){
            $('.dashboard_modal_body').html(result);
        });
    }
</script>