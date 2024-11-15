<div class="modal fade" role="dialog" id="import_icd">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border center-align">
                            <h4><b>IMPORT EXCEL FILE</b></h4>
                        </div>
                        <form action="{{ asset('excel/import') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="file-upload">
                                <div class="image-upload-wrap">
                                    <input class="file-upload-input" type='file' name="import_file" onchange="readURL(this);" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                                    <div class="drag-text">
                                        <h3>Drag and drop a file</h3>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title"></span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button class="btn btn-success btn-flat" type="submit"> Submit</button>
                            </div>
                        </form><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function readURL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };
            reader.readAsDataURL(input.files[0]);
        }else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
</script>