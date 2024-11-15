<?php
    $fac = \App\Facility::where('id','<>',$user->facility_id)
                ->where('status',1)
                ->select('facility.id','facility.name')
                ->orderBy('name','asc')
                ->get();
    $dept = \App\Department::get();
?>
<style>
    /* The container */
    .container1 {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 12px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container1 input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container1:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container1 input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container1 input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container1 .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>

<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">
            Filter Results
            <span class="pull-right badge" style="cursor: pointer" onclick="exportReferredExcel()">Result: {{ $data->total() }}</span>
        </h3>
    </div>
    <div class="panel-body">
        <form method="GET" action="{{ url('doctor/referred') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="search" id="keyword" value="{{ $search }}" class="form-control" placeholder="Code, Firstname, Lastname" />
            </div>
            <div class="form-group">
                <input type="text" id="daterange" value="{{ $start.' - '.$end }}" max="{{ date('Y-m-d') }}" name="date_range" class="form-control" />
            </div>
            <div class="form-group">
                <select class="select2" name="facility_filter" id="facility">
                    <option value="">All Facility</option>
                    @foreach($fac as $f)
                        <option {{ ($facility_filter==$f->id) ? 'selected':'' }} value="{{ $f->id }}">{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="department_filter" id="department">
                    <option value="">All Department</option>
                    @foreach($dept as $d)
                        <option {{ ($department_filter==$d->id) ? 'selected': '' }} value="{{ $d->id }}">{{ $d->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="option_filter" class="form-control" id="option">
                    <option value="">All Transaction</option>
                    <option @if($option_filter=='referred') selected @endif value="referred">Referred</option>
                    <option @if($option_filter=='seen_only') selected @endif value="seen_only">Seen Only</option>
                    <option @if($option_filter=='accepted') selected @endif value="accepted">Accepted</option>
                    {{--<option @if($option_filter=='arrived') selected @endif value="arrived">Arrived</option>
                    <option @if($option_filter=='admitted') selected @endif value="admitted">Admitted</option>
                    <option @if($option_filter=='discharged') selected @endif value="discharged">Discharged</option>
                    <option @if($option_filter=='cancelled') selected @endif value="cancelled">Cancelled</option>--}}
                </select>
            </div>
            <div class="form-group">
                <label class="container1">2nd position
                    <input type="radio" value="1" name="more_position" @if($more_position == 1) checked @endif>
                    <span class="checkmark"></span>
                </label>
                <label class="container1">3rd position
                    <input type="radio" value="2" name="more_position" @if($more_position == 2) checked @endif>
                    <span class="checkmark"></span>
                </label>
                <label class="container1">4th position
                    <input type="radio" value="3" name="more_position" @if($more_position == 3) checked @endif>
                    <span class="checkmark"></span>
                </label>
                <label class="container1">5th position
                    <input type="radio" value="4" name="more_position" @if($more_position == 4) checked @endif>
                    <span class="checkmark"></span>
                </label>
                <label class="container1">More than 5th position
                    <input type="radio" value="5" name="more_position" @if($more_position == 5) checked @endif>
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-flat btn-warning" onclick="clearFieldsSidebar()">
                    <i class="fa fa-eye"></i> View All
                </button>
                <button type="submit" class="btn btn-flat btn-success">
                    <i class="fa fa-filter"></i> Filter Result
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function exportReferredExcel() {
        window.open("<?php echo asset('excel/export/referred'); ?>", '_blank');
    }
</script>