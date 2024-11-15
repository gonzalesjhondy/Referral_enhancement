<style>
    @media
    only screen and (min-device-width: 280px)
    and (max-device-width: 568px) {
        #icd_table_group, tr td:nth-child(3) { display: none; visibility: hidden; }
        #icd_table_cr, tr td:nth-child(4) { display: none; visibility: hidden; }
        #icd_table_pf, tr td:nth-child(5) { display: none; visibility: hidden; }
        #icd_table_hcf, tr td:nth-child(6) { display: none; visibility: hidden; }
        #icd_table_source, tr td:nth-child(7) { display: none; visibility: hidden; }
    }
</style>

@if(!empty($icd) && count($icd) > 0)
    <input type="hidden" id="icd_keyword" value="{{ $icd_keyword }}">
    <table class="table table-bordered table-hover icd-table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th id="icd_table_group">Group</th>
            <th id="icd_table_cr">CR</th> <!--Case Rate -->
            <th id="icd_table_pf">PF</th> <!-- Professional Fee -->
            <th id="icd_table_hcf">HCF</th> <!-- Health Care Fee -->
            <th id="icd_table_source">Source</th>
            <th>Option</th>
        </tr>
        </thead>
        @foreach($icd as $row)
            <tr>
                <td>{{ $row->code }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->group }}</td>
                <td>{{ $row->case_rate }}</td>
                <td>{{ $row->professional_fee }}</td>
                <td>{{ $row->health_care_fee }}</td>
                <td>{{ strtoupper($row->source) }}</td>
                <td>
                    <div class="custom-control custom-checkbox checkbox-xl">
                        <input type="checkbox" class="custom-control-input" value="{{ $row->id }}" name="icd_checkbox[]" style="height: 30px;width: 30px;cursor: pointer;">
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {{ $icd->links() }}
    </div>
@else
    <div class="alert alert-warning">
        <div class="text-warning">
            <i class="fa fa-warning"></i> NO DATA!
        </div>
    </div>
@endif

<script>
    $(document).ready( function () {
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            changePage(page);
        });
    });

    function changePage(page) {
        var url = "<?php echo asset('icd/search');?>";
        url = url + "?page=" + page;

        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "pagination_table" : "true",
            "icd_keyword" : $('#icd_keyword').val()
        };
        $.post(url,json,function(result){
            $('.icd_body').html(result);
        });
    }
</script>
