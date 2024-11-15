<form method="POST" action="{{ asset('admin/facility/add') }}">
    {{ csrf_field() }}
    <fieldset>
        <legend><i class="fa fa-hospital-o"></i> {{ $facility->name }}</legend>
    </fieldset>
    <input type="hidden" value="@if(isset($facility->id)){{ $facility->id }}@endif" name="id">
    <input type="hidden" value="{{ $province_id }}" name="province">
    <div class="form-group">
        <label>Province Name:</label>
        <input type="text" class="form-control" value="{{ $province_name }} Province" disabled>
    </div>
    <div class="form-group">
        <label>Facility Name:</label>
        <input type="text" class="form-control" value="@if(isset($facility->name)){{ $facility->name }}@endif" autofocus name="name" readonly>
    </div>
    {{--<div class="form-group">
        <label>Facility Code:</label>
        <input type="text" class="form-control" value="@if(isset($facility->facility_code)){{ $facility->facility_code }}@endif" name="facility_code" readonly>
    </div>--}}
    <div class="form-group">
        <div class="col-md-6">
            <label>A1</label>
            <input type="text" class="form-control" value="@if(isset($facility->a1)){{ $facility->a1 }}@endif" name="a1" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A2</label>
            <input type="text" class="form-control" value="@if(isset($facility->a2)){{ $facility->a2 }}@endif" name="a2" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A3</label>
            <input type="text" class="form-control" value="@if(isset($facility->a3)){{ $facility->a3 }}@endif" name="a3" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A4</label>
            <input type="text" class="form-control" value="@if(isset($facility->a4)){{ $facility->a4 }}@endif" name="a4" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A5</label>
            <input type="text" class="form-control" value="@if(isset($facility->a5)){{ $facility->a5 }}@endif" name="a5" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B1</label>
            <input type="text" class="form-control" value="@if(isset($facility->b1)){{ $facility->b1 }}@endif" name="b1" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B2</label>
            <input type="text" class="form-control" value="@if(isset($facility->b2)){{ $facility->b2 }}@endif" name="b2" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B3</label>
            <input type="text" class="form-control" value="@if(isset($facility->b3)){{ $facility->b3 }}@endif" name="b3" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B4</label>
            <input type="text" class="form-control" value="@if(isset($facility->b4)){{ $facility->b4 }}@endif" name="b4" >
        </div>
    </div>
    <div class="modal-footer">

    </div>
    <br>
    <br>
    <div style="margin-left: 45%">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
    </div>
</form>



