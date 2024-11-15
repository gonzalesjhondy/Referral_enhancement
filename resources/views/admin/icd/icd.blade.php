@extends('layouts.app')

@section('content')
    <style>
        .center-align {
            text-align: center;
        }

        .file-upload {
            background-color: #ffffff;
            width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #1FB264;
            border: none;
            padding: 50px;
            border-radius: 4px;
            border-bottom: 4px solid #15824B;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #1AA059;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #1FB264;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #1FB264;
            border: 4px dashed #ffffff;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #15824B;
            padding: 60px 0;
        }

        .remove-image {
            width: 150px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        @media
        only screen and (min-device-width: 280px)
        and (max-device-width: 568px) {
            #icd_table_group, tr td:nth-child(3) { display: none; visibility: hidden; }
            #icd_table_cr, tr td:nth-child(4) { display: none; visibility: hidden; }
            #icd_table_pf, tr td:nth-child(5) { display: none; visibility: hidden; }
            #icd_table_hcf, tr td:nth-child(6) { display: none; visibility: hidden; }
            #icd_table_source, tr td:nth-child(7) { display: none; visibility: hidden; }
        }
    </style>

    <div class="row">
        <title>ICD-10 Codes</title>
        <div class="box">
            <section class="content-header">
                <h1>
                    List of ICD-10 Codes    
                </h1>
                <ol class="breadcrumb form-inline my-2 my-lg-0">
                    <form action="{{ asset('admin/icd/search') }}" method="GET">
                        {{ csrf_field() }}
                        <input type="search" class="form-control" name="keyword" style="width: 45%;">
                        <button type="submit" class="btn btn-success btn-sm btn-flat"><i class="fa fa-search"></i> Search</button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" href="#import_icd" data-toggle="modal">
                            <i class="fa fa-file-excel-o"></i> Import
                        </button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" href="#add_icd" data-toggle="modal" onclick="addICD()">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </form>
                </ol><br>
            </section>

            <section class="content">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="box">
                            <div class="box-body no-padding table-responsive float-left">
                                <table class="table table-striped table-hover" data-pagination="true" >
                                    <tr>
                                        <th class="center-align">Code</th>
                                        <th class="center-align">Description</th>
                                        <th class="center-align">Group</th>
                                        <th class="center-align">Case Rate</th>
                                        <th class="center-align">Professional Fee</th>
                                        <th class="center-align">Health Care Fee</th>
                                        <th class="center-align">Source</th>
                                    </tr>
                                    @foreach($icd as $row)
                                        <tr>
                                            <td>
                                                <a href="#icd_update_modal" 
                                                   data-toggle="modal" 
                                                   data-id = "{{ $row->id }}"
                                                   onclick="editICD('<?php echo $row->id ?>')">
                                                    {{ $row->code }}
                                                </a>
                                            </td>
                                            <td>{{ $row->description }}</td>
                                            <td>{{ $row->group }}</td>
                                            <td>{{ $row->case_rate }}</td>
                                            <td>{{ $row->professional_fee }}</td>
                                            <td>{{ $row->health_care_fee }}</td>
                                            <td>{{ $row->source }}</td> 
                                        </tr>
                                    @endforeach
                                </table>
                                <div style="text-align: right;">
                                    {!! $icd->links() !!}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
    @include('admin.excel.import_excel')
@endsection

<div class="modal fade" role="dialog" id="icd_update_modal">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-body icd_body">
                <center>
                    <img src="{{ asset('resources/img/loading.gif') }}" alt="">
                </center>
            </div>
        </div>
    </div>
</div>

<form action="{{ asset('admin/icd/add') }}" method="POST">
    <div class="modal fade" role="dialog" id="add_icd">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-body icd_add_body">
                    <center>
                        <img src="{{ asset('resources/img/loading.gif') }}" alt="">
                    </center>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{ asset('admin/icd/delete') }}" method="POST">
    {{ csrf_field() }}
    <div class="modal modal-danger sm fade" id="icd_delete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" name="id_delete" class="icd_del">
                    <strong>Are you sure you want to delete?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-outline"><i class="fa fa-trash"></i> Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>

@section('js')
<script>
    @if(Session::get('icd_notif'))
        Lobibox.notify('success', {
            msg: "<?php echo Session::get('icd_msg'); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
            Session::put("icd_notif",false);
        ?>
    @endif

    function editICD(id) {
        var url = "<?php echo asset('admin/icd/update'); ?>";
        var json = {
            "icd_id" : id,
            "_token" : "<?php echo csrf_token(); ?>"
        };
        $.post(url,json,function(result){
            $(".icd_body").html(result);
        });
    }

    function addICD(){
        var url = "<?php echo asset('admin/icd/add'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>"
        }
        $.post(url,json, function(result){
            $(".icd_add_body").html(result);
        });
    }

    function deleteICD(id) {
        console.log("icd id: " + id);
        $(".icd_del").val(id);
    }
</script>
@endsection
