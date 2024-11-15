@extends('layouts.app')

@section('content')
    <div class="row col-md-12">
        <div class="box box-success">
            <div class="row">
                <div class="col-md-8">
                    <div class="box-header with-border">
                        <h3> Coordinated Referral</h3>
                        <form action="{{ asset('admin/coordinated/referral') }}" style="margin-top:20px;display:flex;" id="myForm" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <select name="category" class="form-control" style="width:40%;">
                                <option value="cebu_province" {{ $category == 'cebu_province' ? 'selected' : '' }}>Cebu Province</option>
                                <option value="cebu_city" {{ $category == 'cebu_city' ? 'selected' : '' }}>Cebu City</option>
                                <option value="mandaue_city" {{ $category == 'mandaue_city' ? 'selected' : '' }}>Mandaue City</option>
                                <option value="lapulapu_city" {{ $category == 'lapulapu_city' ? 'selected' : '' }}>Lapu Lapu City</option>
                            </select>
                            <div class="form-group-sm" style="margin-bottom: 10px;display:flex;width:100%;">
                                <input type="text" class="form-control" name="date_range" value="{{ $start.' - '.$end }}" id="date_range" style="width: 40%;height:35px;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-fixed-header" style="border: ">
                    <thead class="header">
                        <tr class="bg-navy-active text-center">
                            <th>RHU</th>
                            <th>Refer / Redirected / Transferred</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $row)
                            @if (isset($row['total']) && $key != count($data) - 1)
                                <tr>
                                    <td></td>
                                    <td><strong>Total: {{ $row['total'] }}</strong></td>
                                    <td></td>
                                </tr>
                                <tr class="bg-navy-active text-center">
                                    <th>{{ $row['pointed'] }}</th>
                                    <th>Refer / Redirected / Transferred</th>
                                    <th>Percentage</th>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $row['coordinate'] }}</td>
                                    <td>{{ $row['refer'] }}</td>
                                    <td>{{ $row['percentage'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#date_range').daterangepicker();
        // main page position after refresh
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        window.addEventListener('load', function() {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
                localStorage.removeItem('scrollPosition');
            }
        });
    </script>
@endsection

