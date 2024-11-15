@extends('layouts.app')

@section('content')

    <div class="row col-md-offset-1">
        <div class="col-md-10">
            <div class="box box-success">
                <form action="{{ asset('admin/report/top/reason_for_declined') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <span class="text-green" style="font-size: 17pt;">Top Reason for Declined </span>
                        <span style="font-size: 12pt;"><i>as of </i></span>
                        <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                        <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="consolidate_date_range">
                        <select name="facility_category" id="" class="form-control">
                            <option value="">Select Facility</option>
                            @foreach($data as $facility => $reasons)
                            <option value="{{ $facility }}">{{ $facility }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i> Filter</button>
                        <button type="button" class="btn btn-md btn-warning"><i class="fa fa-search"></i> View All</button>
                    </div
                </form>
            </div>
        </div>
        
        <div class="col-md-10">
                <div class="jim-content">
                    <div class="box-body table-responsive no-padding">
                        <table class="table">
                            <tbody>
                            <tr class="bg-success">
                                <th>Reason</th>
                                <th>Count</th>
                            </tr>
                            @if(isset($selected_category))
                                @foreach($data[$selected_category] as $reason)
                                    <tr>
                                        <td>{{$reason['remarks']}}</td>
                                        <td>
                                            <label for="">{{$reason['count']}}</label>
                                        </td>
                                    </tr>
                                
                                @endforeach
                              @else
                                <tr>
                                    <td colspan="2" class="text-center bg-red">Select a facility category to view top reasons.</td>
                                </tr>
                              @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div>

@endsection
@section('js')

    <script>
           
            $('#consolidate_date_range').daterangepicker({
                minDate: new Date("2022-01-13"),
            locale: {
                format: 'MM/DD/YYYY'
            }
            });

    </script>

@endsection