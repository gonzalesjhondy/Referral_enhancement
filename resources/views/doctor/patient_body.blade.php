<?php
    $user = Session::get('auth');
    $status = session::get('status');
?>
<form method="POST" action="{{ asset('doctor/patient/update') }}">
    {{ csrf_field() }}
    <fieldset>
        <legend><i class="fa fa-pencil"></i> Update Patient</legend>
    </fieldset>
    <div class="form-group">
        <input type="hidden" name="patient_id" value="{{ $data->id }}">
        <label>PhilHealth Status:</label>
        <select class="form-control" name="phic_status" required>
            <option
            <?php
                if(isset($data->phic_status)){
                    if($data->phic_status == "None"){
                        echo 'selected';
                    }
                }
            ?>
            >None</option>
            <option
            <?php
                if(isset($data->phic_status)){
                    if($data->phic_status == "Member"){
                        echo 'selected';
                    }
                }
            ?>
            >Member</option>
            <option
            <?php
                if(isset($data->phic_status)){
                    if($data->phic_status == "Dependent"){
                        echo 'selected';
                    }
                }
            ?>
            >Dependent</option>
        </select>
    </div>
    <div class="form-group">
        <label>PhilHealth ID:</label>
        <input type="text" class="form-control" value="@if(isset($data->phic_id)){{ $data->phic_id }}@endif" autofocus name="phic_id">
    </div>
    <div class="form-group">
        <label>First Name:</label>
        <input type="hidden" name="old_fname" value="@if(isset($data->fname)){{ $data->fname }}@endif">
        <input type="text" class="form-control" value="@if(isset($data->fname)){{ $data->fname }}@endif" name="fname" required>
    </div>
    <div class="form-group">
        <label>Middle Name:</label>
        <input type="text" class="form-control" value="@if(isset($data->mname)){{ $data->mname }}@endif" name="mname" required>
    </div>
    <div class="form-group">
        <label>Last Name:</label>
        <input type="hidden" name="old_lname" value="@if(isset($data->lname)){{ $data->lname }}@endif">
        <input type="text" class="form-control" value="@if(isset($data->lname)){{ $data->lname }}@endif" name="lname" required>
    </div>
    <div class="form-group">
        <label>Contact Number:</label>
        <input type="text" class="form-control" value="@if(isset($data->contact)){{ $data->contact }}@endif" name="contact" required>
    </div>
    <div class="form-group">
        <label>Birth Date:</label>
        <input type="hidden" name="old_dob" value="@if(isset($data->dob)){{ $data->dob }}@endif">
        <input type="date" class="form-control" value="@if(isset($data->dob)){{ $data->dob }}@endif" min="1910-05-11" max="{{ date('Y-m-d') }}" name="dob" required>
    </div>
    <div class="form-group">
        <label>Sex:</label>
        <select class="form-control" name="sex" required>
            <option
            <?php
                if(isset($data->sex)){
                    if($data->sex == 'Male'){
                        echo 'selected';
                    }
                }
            ?>
            >Male
            </option>
            <option
            <?php
                if(isset($data->sex)){
                    if($data->sex == 'Female'){
                        echo 'selected';
                    }
                }
            ?>
            >Female</option>
        </select>
    </div>
    <div class="form-group">
        <label>Civil Status:</label>
        <select class="form-control" name="civil_status" required>
            <option
                <?php
                    if(isset($data->civil_status)){
                        if($data->civil_status == 'Single'){
                            echo 'selected';
                        }
                    }
                ?>
            >Single</option>
            <option
                <?php
                    if(isset($data->civil_status)){
                        if($data->civil_status == 'Married'){
                            echo 'selected';
                        }
                    }
                ?>
            >Married</option>
            <option
                <?php
                    if(isset($data->civil_status)){
                        if($data->civil_status == 'Divorced'){
                            echo 'selected';
                        }
                    }
                ?>
            >Divorced</option>
            <option
                <?php
                    if(isset($data->civil_status)){
                        if($data->civil_status == 'Separated'){
                            echo 'selected';
                        }
                    }
                ?>
            >Separated</option>
            <option
                <?php
                    if(isset($data->civil_status)){
                        if($data->civil_status == 'Widowed'){
                            echo 'selected';
                        }
                    }
                ?>
            >Widowed</option>
        </select>
    </div>
    <div class="form-group">
        <label>Region:</label>
        <select class="form-control region" name="region" onchange="othersRegion($(this),'{{ $province }}');" required>
            <option value="Region VII" @if($data->region == 'Region VII') selected @endif>Region VII</option>
            <option value="NCR" @if($data->region == 'NCR') selected @endif>NCR</option>
            <option value="CAR" @if($data->region == 'CAR') selected @endif>CAR</option>
            <option value="Region I" @if($data->region == 'Region I') selected @endif>Region I</option>
            <option value="Region II" @if($data->region == 'Region II') selected @endif>Region II</option>
            <option value="Region III" @if($data->region == 'Region III') selected @endif>Region III</option>
            <option value="Region IV-A" @if($data->region == 'Region IV-A') selected @endif>Region IV-A</option>
            <option value="Mimaropa" @if($data->region == 'Mimaropa') selected @endif>Mimaropa</option>
            <option value="Region V" @if($data->region == 'Region V') selected @endif>Region V</option>
            <option value="Region VI" @if($data->region == 'Region VI') selected @endif>Region VI</option>
            <option value="Region VIII" @if($data->region == 'Region VIII') selected @endif>Region VIII</option>
            <option value="Region IX" @if($data->region == 'Region IX') selected @endif>Region IX</option>
            <option value="Region X" @if($data->region == 'Region X') selected @endif>Region X</option>
            <option value="Region XI" @if($data->region == 'Region XI') selected @endif>Region XI</option>
            <option value="Region XII" @if($data->region == 'Region XII') selected @endif>Region XII</option>
            <option value="Region XIII" @if($data->region == 'Region XIII') selected @endif>Region XIII</option>
            <option value="BARMM" @if($data->region == 'BARMM') selected @endif>BARMM</option>
        </select>
    </div>
    <div class="form-group">
        <label>Province:</label>
        <div class="province_holder">
            @if($data->region == 'Region VII')
                <select class="form-control province" name="province" onchange="filterSidebar($(this),'muncity')" required>
                    <option value="">Select Province</option>
                    @foreach($province as $prov)
                        <option value="{{ $prov->id }}" @if($prov->id == $data->province) selected @endif>{{ $prov->description }}</option>
                    @endforeach
                </select>
            @else
                <input type='text' class='form-control' name='province_others' value="{{ $data->province_others }}" required>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>Municipality:</label>
        <div class="muncity_holder">
            @if($data->region == 'Region VII')
                <select class="form-control select2 select_muncity muncity" name="muncity" required>
                    @foreach(\App\Muncity::where("province_id",$data->province)->get() as $mun)
                        <option value="{{ $mun->id }}"
                        <?php
                            if(isset($data->muncity)){
                                if($data->muncity == $mun->id){
                                    echo 'selected';
                                }
                            }
                            ?>
                        >{{ $mun->description }}</option>
                    @endforeach
                </select>
            @else
                <input type='text' class='form-control' name='muncity_others' value="{{ $data->muncity_others }}" required>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>Barangay:</label>
        <div class="barangay_holder">
            @if($data->region == 'Region VII')
                <select class="form-control select2 select_barangay barangay" name="brgy" required>
                    @if(isset($data->brgy))
                        @foreach(\App\Barangay::where("province_id",$data->province)->where("muncity_id",$data->muncity)->get() as $row)
                            <option value="{{ $row->id }}" <?php if($data->brgy == $row->id)echo 'selected'; ?> >{{ $row->description }}</option>
                        @endforeach
                    @else
                        <option value="">Select Barangay</option>
                    @endif
                </select>
            @else
                <input type='text' class='form-control' name='brgy_others' value="{{ $data->brgy_others }}" required>
            @endif
        </div>
    </div>
    <hr />
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" value="true" name="patient_update_button" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
    </div>
</form>
@include('script.filterMuncity')



