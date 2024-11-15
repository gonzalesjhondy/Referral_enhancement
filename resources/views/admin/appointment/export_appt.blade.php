<html lang="en">
<body>
<h4>Appointments @if(isset($date)) for {{ date("M d, Y",strtotime($date)) }} @endif</h4>
<h4>Status: @if($status == "") All @else {{ ucfirst($status) }} @endif</h4>

<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Facility Name</th>
        <th class='text-green'>Requester</th>
        <th class='text-green'>Email</th>
        <th class='text-green'>Contact</th>
        <th class='text-green'>Category</th>
        <th class='text-green'>Date Requested</th>
        <th class='text-green'>Status</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->requester }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->contact }}</td>
            <td>{{ $row->category }}</td>
            <td>{{ date_format($row->created_at, 'F d, Y, h:i a') }}</td>
            <td>{{ strtoupper($row->status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>