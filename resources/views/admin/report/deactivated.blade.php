<?php
$user = Session::get('auth');
$facilities = \App\Facility::select('id','name')
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();

$dateReportDeact = \Illuminate\Support\Facades\Session::get('dateReportDeact');
if(!$dateReportDeact)
    $dateReportDeact = \Carbon\Carbon::now()->startOfMonth();
?>
@extends('layouts.app')

@section('content')
    <style>
        label {
            padding: 0px !important;
        }
    </style>

    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="pull-right">
                    <form action="{{ url('admin/report/deactivated') }}" method="POST" class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group-sm" style="margin-bottom: 10px;">
                            <input type="month" name="date" class="form-control" value="{{$dateReportDeact}}">
                            <button type="submit" class="btn btn-success btn-sm btn-flat">
                                <i class="fa fa-search"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
                <h3>{{ $title }}<br />
                    <small class="text-success">
                        {{ date('F Y',strtotime($dateReportDeact))}}
                    </small></h3>
            </div>
            <div class="box-body">
                @if(count($data) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-fixed-header">
                            <thead class='header'>
                            <tr class="bg-black">
                                <th>Facility</th>
                                <th>Name of User</th>
                                <th>Level</th>
                                <th>Department</th>
                                <th>Date Deactivated</th>
                            </tr>
                            </thead>
                            <?php
                            $h = 0;
                            $count = 0;
                            ?>
                            @foreach($data as $row)
                                <tr>
                                    <td class="text-warning text-bold">
                                        @if($h != $row->facility_id)
                                            {{ \App\Facility::find($row->facility_id)->name }}
                                            <?php $h = $row->facility_id; ?>
                                        @endif
                                    </td>
                                    <td class="text-success">
                                        <?php
                                        $count++;
                                        echo $count;
                                        ?>.
                                        {{ ucwords(mb_strtolower($row->lname)) }}, {{ ucwords(mb_strtolower($row->fname)) }}<br>
                                        <small class="text-warning">{{ $row->contact }}</small>
                                    </td>
                                    <td class="text-danger">
                                        {{ ucfirst($row->level) }}
                                    </td>
                                    <td class="text-danger">
                                        @if($row->department_id>0)
                                            {{ ucfirst(\App\Department::find($row->department_id)->description) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('F d, Y',strtotime($row->updated_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <span class="text-warning">
                            <i class="fa fa-warning"></i> No data found!
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });
    </script>
@endsection

