<html lang="en">
<body>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class='text-green'>Patient Name</th>
        <th class='text-green'>Age</th>
        <th class="text-green">Date Referred</th>
        <th class='text-green'>Referring Facility</th>
        <th class='text-green'>Referred Facility</th>
        <th>Status</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->patient_name }}</td>
            <td>{{ $row->age }}</td>
            <td>{{ $row->date_referred }}</td>
            <td>{{ \App\Facility::find($row->referred_from)->name }}</td>
            <td>{{ $row->facility_name }}</td>
            <td>{{ $row->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>