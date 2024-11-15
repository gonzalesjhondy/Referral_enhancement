<html lang="en">
<body>
<table border="1">
    <tr style="background-color: #dff0d8;">
        <th>Code</th>
        <th>Description</th>
        <th>Count</th>
    </tr>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->description }}</td>
            <td>{{ $row->count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>