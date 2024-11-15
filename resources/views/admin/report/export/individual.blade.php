<html lang="en">
<body>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class='text-green'>Patient Name</th>
        <th class='text-green'>Referring Doctor</th>
        <th class='text-green'>Reason for Referral</th>
        <th class='text-green'>Diagnosis</th>
        <th class='text-green'>Address</th>
        <th class='text-green'>Age</th>
        <th class='text-green'>Referring Facility</th>
        <th class='text-green'>Referred Facility</th>
        <th class='text-green'>Referred Date</th>
        @if(in_array($status, ['rejected', 'cancelled']))
            <th class='text-green'>Remarks</th>
        @endif
        <th class='text-green'>Status</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->patient_name }}</td>
            <td>{{ $row->referring_doctor }}</td>
            <td>{{ $row->reason_for_referral }}</td>
            <td>
                @if($row->other_diagnosis)
                    =>{{ $row->other_diagnosis }}<br>
                @else
                    @foreach(\App\Icd::select("icd10.description")->where("icd.code",$row->code)->leftJoin("icd10","icd10.id","=","icd.icd_id")->get() as $icd)
                        =>{{ $icd->description }}<br>
                    @endforeach
                @endif
            </td>
            <td>{{ $row->province.", ".$row->muncity .", ".$row->barangay }}</td>
            <td>{{ $row->age }}</td>
            <td>{{ $row->referring_facility }}</td>
            <td>{{ $row->referred_facility }}</td>
            <td>{{ $row->referred_date }}</td>
            @if(in_array($status, ['rejected', 'cancelled']))
                <td>{{ $row->remarks }}</td>
            @endif
            <td>{{ $status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>