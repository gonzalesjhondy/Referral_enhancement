<section class="content-area">
    <div style="font-size: 6pt;" class="table-responsive">
        <table class="table table-striped table-fixed-header" border="1">
            <thead class='header'>
            <tr >
                <th rowspan="4" class="info" style="vertical-align: middle;border: black;"><center>Name of Hospital</center></th>
                <th class="success" style="vertical-align: middle;border: black" rowspan="4"><center>Hospital Category</center></th>
                <th style="background-color: rgb(251, 233, 218);border-top: black;" colspan="20"><center>Number of Available Beds</center></th>
                <th style="border-top: black;" class="info" colspan="4"><center>Number of Waitlist</center></th>
                <th class="bg-pink" style="background-color: #ffb3b8;width: 10%;vertical-align: middle;margin-left: 20px;border-top: black" rowspan="4"><center>Remarks</center></th>
                <th class="bg-pink" style="background-color: #ffb3b8;vertical-align: middle;border-top: black;" rowspan="4"><center>Encoded By</center></th>
            </tr>
            <tr>
                <th colspan="8" class="danger"><center>COVID BEDS</center></th>
                <th class="info" colspan="2"><center>Mechanical Ventilators</center></th>
                <th class="warning" colspan="8"><center>Non-COVID BEDS</center></th>
                <th class="info" colspan="2"><center>Mechanical Ventilators</center></th>
                <th class="danger" colspan="2" rowspan="2" style="vertical-align: middle"><center>COVID BEDS</center></th>
                <th class="warning" colspan="2" rowspan="2" style="vertical-align: middle"><center>Non-COVID BEDS</center></th>
            </tr>
            <tr>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Emergency Room (ER)</center></th>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>ICU - Intensive Care Units</center></th>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>COVID Beds</center></th>
                <th colspan="2" class="success"><center>Isolation Beds</center></th>
                <th class="info"><center>Used</center></th>
                <th class="info"><center>Vacant</center></th>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Emergency Room (ER)</center></th>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>ICU - Intensive Care Units</center></th>
                <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Regular Beds</center></th>
                <th colspan="2" class="success"><center>Isolation Beds</center></th>
                <th class="info"><center>Used</center></th>
                <th class="info"><center>Vacant</center></th>
            </tr>
            <tr>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th class="success">Vacant</th>
                <th class="success">Occupied</th>
                <th class="info"></th>
                <th class="info"></th>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                <th class="success">Vacant</th>
                <th class="success">Occupied</th>
                <th class="info"></th>
                <th class="info"></th>
                <th class="danger"><center>Emergency Room (ER)</center></th>
                <th class="danger"><center>ICU - Intensive Care Units</center></th>
                <th class="warning"><center>Emergency Room (ER)</center></th>
                <th class="warning"><center>ICU - Intensive Care Units</center></th>
            </tr>
            </thead>
            <tbody>
            @foreach(Session::get('bed_facility') as $row)
                @if(!isset($facility_checker[$row->province]))
                    <?php $facility_checker[$row->province] = true; ?>
                    <tr>
                        <th style="font-size: 14pt;" colspan="36">{{ strtoupper(\App\Province::find($row->province)->description) }} PROVINCE</th>
                    </tr>
                @endif
                <tr>
                    <td>
                        <b class="text-green">{{ $row->name }}</b><br>
                        <span class="text-yellow">({{ $row->contact }})</span>
                    </td>
                    <td><span class="text-green"><center>{{ ucfirst($row->level) }}</center></span></td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_vacant ? $row->emergency_room_covid_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_occupied ? $row->emergency_room_covid_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_vacant ? $row->icu_covid_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_occupied ? $row->icu_covid_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->beds_covid_vacant ? $row->beds_covid_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->beds_covid_occupied ? $row->beds_covid_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_covid_vacant ? $row->isolation_covid_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_covid_occupied ? $row->isolation_covid_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_used_covid ? $row->mechanical_used_covid : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_vacant_covid ? $row->mechanical_vacant_covid : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_vacant ? $row->emergency_room_non_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_occupied ? $row->emergency_room_non_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_vacant ? $row->icu_non_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_occupied ? $row->icu_non_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->beds_non_vacant ? $row->beds_non_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->beds_non_occupied ? $row->beds_non_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_non_vacant ? $row->isolation_non_vacant : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_non_occupied ? $row->isolation_non_occupied : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_used_non ? $row->mechanical_used_non : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_vacant_non ? $row->mechanical_vacant_non : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_wait ? $row->emergency_room_covid_wait : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_wait ? $row->icu_covid_wait : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_wait ? $row->emergency_room_non_wait : 0 }}</span>
                    </td>
                    <td>
                        <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_wait ? $row->icu_non_wait : 0 }}</span>
                    </td>
                    <td>
                        <span style="font-size: 10pt;">{{ $row->remarks }}</span>
                    </td>
                    <td style="font-size: 10pt;">
                        <?php
                        $encoded_by = \App\BedTracker::
                        select("bed_tracker.id","users.fname","users.mname","users.lname","bed_tracker.created_at")
                            ->leftJoin("users","users.id","=","bed_tracker.encoded_by")
                            ->where("bed_tracker.facility_id","=",$row->id)
                            ->where("users.level","!=","opcen")
                            ->orderBy("bed_tracker.id","desc")
                            ->first();
                        $created_at = $encoded_by->created_at;
                        $encoded_by = ucfirst($encoded_by->fname).' '.strtoupper($encoded_by->mname[0]).'. '.ucfirst($encoded_by->lname);
                        echo $encoded_by;
                        ?><br>
                        @if($created_at)
                            <small class="text-blue">{{ date("F d,Y",strtotime($created_at)) }}</small><br>
                            <small class="text-yellow">({{ date('g:i a',strtotime($created_at)) }})</small>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>