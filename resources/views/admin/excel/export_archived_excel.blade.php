<html lang="en">
<body>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class="text-green">Patient Type</th>
        <th class='text-green'>Patient Name</th>
        <th class="text-green">Facility Name</th>
        <th class='text-green'>Date Accepted</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <?php
            $current = \App\Activity::where('code',$row->code)
                ->orderBy('id','desc')
                ->first();
        ?>
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->type }}</td>
            <td>{{ $row->patient_name }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->date_accepted }}</td>
            <td>{{ $current->status == 'archived' ? "Didn't Arrived" : 'Not Accepted' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>