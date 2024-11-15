<html lang="en">
<body>
<h4>
    {{ $title }} | {{ $data[0]['referred_facility'] }} ({{ count($data) }})
</h4>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th class='text-green'>Code</th>
        <th class='text-green'>Patient Name</th>
        <th class='text-green'>Address</th>
        <th class='text-green'>Age</th>
        @if($status === 'transferred')
            <th class="text-green">Transferred To</th>
        @endif
        <th class='text-green'>Status</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row['code'] }}</td>
            <td>{{ $row['name'] }}</td>
            <td>{{ $row['address'] }}</td>
            <td class="text-center">{{ $row['age'] }}</td>
            @if($status === 'transferred')
                <td>{{ $row['referred_facility'] }}</td>
            @endif
            <td>{{ $row['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>