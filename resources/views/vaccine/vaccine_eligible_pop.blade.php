<form method="POST" action="{{ asset('admin/municipality/crud/add') }}">
    {{ csrf_field() }}
    <fieldset>
        <legend><i class="fa fa-hospital-o"></i> {{ $muncity->description }}</legend>
    </fieldset>
    <input type="hidden" value="@if(isset($muncity->id)){{ $muncity->id }}@endif" name="id">
    <input type="hidden" value="{{ $province_id }}" name="province_id">
    <div class="form-group">
        <label>Province Name:</label>
        <input type="text" class="form-control" value="{{ $province_name }} Province" disabled>
    </div>
    <div class="form-group">
        <label>Municipality Name:</label>
        <input type="text" class="form-control" value="@if(isset($muncity->description)){{ $muncity->description }}@endif" autofocus name="description" readonly>
    </div>
   {{-- <div class="form-group">
        <label>Municipality Code:</label>
        <input type="text" class="form-control" value="@if(isset($muncity->muncity_code)){{ $muncity->muncity_code }}@endif" name="muncity_code" readonly>
    </div>--}}
    <div class="form-group">
            <div class="col-md-6">
                <label>A1</label>
                <input type="text" class="form-control" value="@if(isset($muncity->a1)){{ $muncity->a1 }}@endif" name="a1" >
            </div>
    </div>
    <div class="form-group">
            <div class="col-md-6">
                <label>A2</label>
                <input type="text" class="form-control" value="@if(isset($muncity->a2)){{ $muncity->a2 }}@endif" name="a2" >
            </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A3</label>
            <input type="text" class="form-control" value="@if(isset($muncity->a3)){{ $muncity->a3 }}@endif" name="a3" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A4</label>
            <input type="text" class="form-control" value="@if(isset($muncity->a4)){{ $muncity->a4 }}@endif" name="a4" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>A5</label>
            <input type="text" class="form-control" value="@if(isset($muncity->a5)){{ $muncity->a5 }}@endif" name="a5" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B1</label>
            <input type="text" class="form-control" value="@if(isset($muncity->b1)){{ $muncity->b1 }}@endif" name="b1" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B2</label>
            <input type="text" class="form-control" value="@if(isset($muncity->b2)){{ $muncity->b2 }}@endif" name="b2" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B3</label>
            <input type="text" class="form-control" value="@if(isset($muncity->b3)){{ $muncity->b3 }}@endif" name="b3" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label>B4</label>
            <input type="text" class="form-control" value="@if(isset($muncity->b4)){{ $muncity->b4 }}@endif" name="b4" >
        </div>
    </div>
    <div class="modal-footer">

    </div>
    <br>
    <div style="margin-left: 45%">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        @if(isset($muncity->id))
        <!-- <a href="#municipality_delete" data-toggle="modal" class="btn btn-danger btn-sm btn-flat" onclick="MunicipalityDelete('<?php echo $muncity->id; ?>')">
                    <i class="fa fa-trash"></i> Remove
                </a> -->
        @endif
        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
    </div>
</form>



