<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Filter Patients</h3>
    </div>
    <form action="{{ url('doctor/patient') }}" method="POST" class="form-submit">
        {{ csrf_field() }}
        <input type="hidden" name="telemedicine" class="Appointment" value="">
        <div class="panel-body">
            <div class="form-group">
                <input type="text" placeholder="Search Keyword..." class="form-control" name="keyword" required />
            </div>
            <div class="form-group">
                <select class="form-control region" name="region" onchange="othersRegion($(this),'{{ $province }}');" required>
                    <option value="Region VII">Region VII</option>
                    <option value="NCR">NCR</option>
                    <option value="CAR">CAR</option>
                    <option value="Region I">Region I</option>
                    <option value="Region II">Region II</option>
                    <option value="Region III">Region III</option>
                    <option value="Region IV-A">Region IV-A</option>
                    <option value="Mimaropa">Mimaropa</option>
                    <option value="Region V">Region V</option>
                    <option value="Region VI">Region VI</option>
                    <option value="Region VIII">Region VIII</option>
                    <option value="Region IX">Region IX</option>
                    <option value="Region X">Region X</option>
                    <option value="Region XI">Region XI</option>
                    <option value="Region XII">Region XII</option>
                    <option value="Region XIII">Region XIII</option>
                    <option value="RBARMM">RBARMM</option>
                </select>
            </div>
            <small><i>Province</i></small>
            <div class="form-group province_holder">
                <select class="form-control province" name="province" onchange="filterSidebar($(this),'muncity')" required>
                    <option value="">Please select province</option>
                    @foreach($province as $prov)
                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                    @endforeach
                </select>
            </div>
            <small><i>Municipality</i></small>
            <div class="form-group muncity_holder">
                <select class="muncity select2" name="muncity" onchange="filterSidebar($(this),'barangay')" required>
                    <option value="">Please select municipality</option>
                </select>
            </div>
            <small><i>Barangay</i></small>
            <div class="form-group barangay_holder">
                <select class="barangay select2" name="brgy" required>
                    <option value="">Please select barangay</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-flat btn-success">
                    <i class="fa fa-search"></i> Filter
                </button>
                <a href="{{ url('doctor/patient/add') }}" id="addPatientBtn" class="btn btn-block btn-flat btn-warning">
                    <i class="fa fa-user-plus"></i> Add Patient
                </a>
            </div>
        </div>
    </form>
</div>