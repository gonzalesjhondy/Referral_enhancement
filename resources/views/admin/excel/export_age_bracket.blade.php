<html lang="en">
<body>
<h3>{{ $description }} - <span class="text-green">{{ count($data) }}</span></h3><br>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class='text-green'>Patient Name</th>
        <th class='text-green'>Address</th>
        <th class="text-green">Date of Birth</th>
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
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->patient_name }}</td>
            <td>{{ $row->barangay }}, {{ $row->muncity }}, {{ $row->province }}</td>
            <td>{{ $row->dob }}</td>
            <td>{{ $row->age }}</td>
            <td>{{ $row->type }}</td>
            <td>{{ $row->diagnosis }}</td>
            <td>{{ $row->facility_referred }}</td>
            {{--<td>{{ $row->status }}</td>--}}
            <td>{{ $row->date_referred }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>