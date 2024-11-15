@extends('layouts.app')
<style>
    span{
        cursor: pointer;
    }
    .tooltip1 {
        position: relative;
        display: inline-block;
        /*border-bottom: 1px dotted black;*/
        cursor: help;
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 200px;
        background-color: #00a65a;
        color: white;
        text-align: center;
        border-radius: 6px;
        padding: 10px;
        position: absolute;
        z-index: 1;
        top: 150%;
        left: 50%;
        margin-left: -60px;
        font-weight: normal;
    }

    .tooltip1 .tooltiptext::after {
        content: "";
        position: absolute;
        bottom: 100%;
        left: 50%;
        margin-left: -40px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent #00a65a transparent;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
    }
</style>
@section('content')
    <div class="row col-md-12">
        <div class="box box-success">
            <div class="row">
                <form action="{{ asset('doctor/duplicate') }}" method="GET">
                    {{ csrf_field() }}
                    <div class="col-md-7 form-inline">
                        <div class="box-header with-border">
                            <h4> DUPLICATE REFERRALS</h4>
                            <div class="form-group-md form-inline">
                                <?php $date_range = date("m/d/Y",strtotime($start)).' - '.date("m/d/Y",strtotime($end)); ?>
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" placeholder="Filter daterange here..." id="date_range">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 form-inline"><br>
                        <input type="text" class="form-control" placeholder="Search name..." name="search" value="{{ $search }}">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm">
                            <i class="fa fa-eye"></i> View All
                        </button>
                    </div>
                </form>
            </div>
            @if(count($data) != 0)
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-fixed-header">
                            <thead class='header' style="background-color: #b6e9e8">
                            <tr>
                                <th></th>
                                <th>Patient Name</th>
                                <th class="text-center">Patient Code</th>
                                <th class="text-center">Type of Referral</th>
                                <th class="text-center">Referred To</th>
                                <th class="text-center">Date & Time of Referral</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <?php
                                $count = 1;
                                $bg = 'bg-gray-light';
                                $duplicate = 0;
                            ?>
                            @for($i = 0; $i < count($data); $i++)
                                <?php
                                $row = $data[$i];
                                $row2 = $data[$i+1];
                                $cur_name = $row->lname.",".$row->fname." ".$row->mname;
                                $next = $row2->lname.",".$row2->fname." ".$row2->mname;
                                ?>
                                <tr class="{{ $bg }}">
                                    <td width="3%;">
                                        <?php
                                        if($duplicate == 0) {
                                            echo $count++;
                                        }
                                        if($cur_name != $next) {
                                            $duplicate = 0;
                                            if($bg == 'bg-gray-light')
                                                $bg = 'bg-gray';
                                            else
                                                $bg = 'bg-gray-light';
                                        } else {
                                            $duplicate++;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ asset("doctor/referred")."?referredCode=".$row->code."&duplicate=true" }}" target="_blank">
                                            {{ $row->code }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ strtoupper($row->type) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->referred_facility }}
                                    </td>
                                    <td class="text-center" width="15%">
                                        {{ $row->date }} - {{ $row->time }}
                                    </td>
                                    <td class="text-center" width="5%">
                                        {{ ucfirst($row->status) }}
                                    </td>
                                </tr>
                            @endfor
                    </table><br>
                </div>
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
@endsection
@section('css')
@endsection

@section('js')
    <script>
        //Date range picker
        $('#date_range').daterangepicker();
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });
    </script>
@endsection

