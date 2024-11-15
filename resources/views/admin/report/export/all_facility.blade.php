<html lang="en">
<body>

<br><br>
<div class='col-md-12' style='white-space: nowrap; background-color: lightgoldenrodyellow'>
    <h3>List of Facilities Registered in the E-Referral System</h3>
</div><br><br>

<div class='col-md-12'>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr style="background-color: lightgrey;">
            <th class='text-center'>Facility Name</th>
            <th class='text-center'>Facility Code</th>
            <th class="text-center">Address</th>
            <th class='text-center'>Contact</th>
            <th class='text-center'>Email</th>
            <th class='text-center'>Chief of Hospital</th>
            <th class='text-center'>Service Capability</th>
            <th class='text-center'>Ownership</th>
            <th class='text-center'>Status</th>
            <th class='text-center'>Referral Used</th>
        </tr>
        <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->facility_code }}</td>
                <td>
                    <?php
                    isset($row->muncity) ? $comma_mun = "," : $comma_mun = " ";
                    isset($row->barangay) ? $comma_bar = "," : $comma_bar = " ";
                    !empty($row->address) ? $concat_addr = " - " : $concat_addr = " ";

                    echo $row->province.$comma_mun.$row->muncity.$comma_bar.$row->barangay.$concat_addr.$row->address;
                    ?></td>
                <td>{{ $row->contact }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->chief_hospital }}</td>
                <td class="text-center">{{ $row->level == 'primary_care_facility' ? 'Primary Care Facility' : ucfirst($row->level) }}</td>
                <td class="text-center">
                    @if($row->hospital_type == 'gov_birthing_home')
                        Government Birthing Home
                    @else
                        {{ $row->hospital_type == 'birthing_home' ? 'Birthing Home' : ucfirst($row->hospital_type) }}
                    @endif
                </td>
                <td class="text-center">{{ $row->status ? 'Active' : 'Inactive' }}</td>
                <td class="text-center">{{ ucfirst($row->referral_used) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>