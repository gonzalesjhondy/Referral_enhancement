<?php
$count = count($data);
?>
@if(count($data) > 0)
    <div class="table-responsive">
        <table id="table" class="table table-hover table-bordered" style="font-size: 9pt;">
            <tr class="bg-success">
                <th></th>
                <th class='text-green'>Patient Code</th>
                <th class='text-green'>Patient Name</th>
                <th class='text-green'>Address</th>
                <th class='text-green'>Age</th>
                <th class='text-green'>Referral Type</th>
                <th class='text-green'>Diagnosis</th>
                @if($type === 'incoming')
                    <th class="text-green">Referred From</th>
                @elseif($type === 'outgoing')
                    <th class="text-green">Referred To</th>
                @endif
                {{--<th class='text-green'>Status</th>--}}
                <th class='text-green'>Date Referred</th>
            </tr>
            @foreach($data as $row)
                <tr>
                    <td>
                        <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-stethoscope"></i> Track</a>
                    </td>
                    <td>{{ $row->code }}</td>
                    <td>{{ $row->patient_name }}</td>
                    <td>{{ $row->barangay }}, {{ $row->muncity }}, {{ $row->province }}</td>
                    <td>{{ $row->age }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->diagnosis }}</td>
                    <td>{{ $row->facility_referred }}</td>
                    {{--<td>{{ $row->status }}</td>--}}
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
    var count = '{{ count(Session::get("agebracket_data")) }}';
    $(".age_bracket_title").html('{{ $description }}' + " <span class = 'badge bg-yellow'>" + count + "</span>");

    $(document).ready( function () {
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            changePage(page);
        });
    });

    function changePage(page) {
        var url = "<?php echo asset('admin/report/agebracket/filter'); ?>";
        url = url + "?page=" + page;
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "desc" : "{{ $desc }}",
            "date_start" : "{{ $date_start }}",
            "date_end" : "{{ $date_end }}",
            "sex" : "{{ $sex }}",
            "type" : "{{ $type }}",
            "getInfo" : true
        };
        $.post(url,json,function(result){
            $('.age_bracket_body').html(result);
        });
    }
</script>