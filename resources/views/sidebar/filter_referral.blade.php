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
            <span class="pull-right badge">Result: {{ $data->total() }}</span>  <!-- Incoming Results -->
        </h3>
    </div>
  
    <div class="panel-body">
        <form action="{{ url('doctor/referral/') }}" method="GET">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" placeholder="Code, Firstname, Lastname" class="form-control" value="{{ $keyword }}" id="keyword" name="search"/>
            </div>
            <div class="form-group">
                <input type="text" id="daterange" value="{{ $start.' - '.$end }}" max="{{ date('Y-m-d') }}" name="date_range" class="form-control" />
            </div>
            <div class="form-group">
                <select class="select2" name="province_filter" id="province">
                    <option value="">All Province</option>
                    @foreach($provinces as $p)
                        <option {{ ($province==$p->id) ? 'selected':'' }} value="{{ $p->id }}">{{ $p->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="select2" name="facility_filter" id="facility">
                    <option value="">All Facility</option>
                    @foreach($facilities as $f)
                        <option {{ ($facility==$f->id) ? 'selected':'' }} value="{{ $f->id }}">{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="department_filter" id="department">
                    <option value="">All Department</option>
                    @foreach($departments as $d)
                        <option {{ ($department==$d->id) ? 'selected': '' }} value="{{ $d->id }}">{{ $d->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="option_filter" id="option">
                    <option value="">Select All</option>
                    <option {{ ($option=='referred') ? 'selected': '' }} value="referred">New Referral</option>
                    <option {{ ($option=='accepted') ? 'selected': '' }} value="accepted">Accepted</option>
                    <option {{ ($option=='seen_only') ? 'selected': '' }} value="seen_only">Seen Only</option>
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
                <button type="submit" name="filter_submit" value="submit" class="btn btn-flat btn-success">
                    <i class="fa fa-filter"></i> Filter Result
                </button>
            </div>
        </form>
    </div>
</div>