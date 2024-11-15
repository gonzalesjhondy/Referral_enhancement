<html lang="en">
<body>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class='text-green'>Patient Name</th>
        <th class='text-green'>Address</th>
        <th class='text-green'>Age</th>
        <th class='text-green'>Reason for Referral</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->patient_name }}</td>
            <td>{{ $row->province.', '.$row->muncity.', '.$row->barangay }}</td>
            <td>{{ $row->age }}</td>
            <td>{{ $row->reason }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>