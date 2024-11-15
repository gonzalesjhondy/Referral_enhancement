
<?php
$user = Session::get('auth');
$facilities = \App\Facility::select('id','name')
    ->where('id','!=',$user->facility_id)
    //->where('province',$user->province)
    ->where('status',1)
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();

?>
<style>
    /* jondy changes */
    .custom-img-size {
        max-width: 150px; /* or any other size */
        height: auto;
        display: block;
        margin: 0 auto; /* for centering if needed */
    }

    /* .custom-file{
          background-color: #3498db;
        display: inline-block;
        cursor: pointer;
        padding: 6px 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    } */
    /* #file-label {
      padding: 6px 20px;
      cursor: pointer;
      display: inline-block;
    }
    #file-label:hover {
        background-color: #2980b9; /* Adjusted hover state 
    } */

    #file-input {
      display: none;
    }
    #file-inputed {
      display: none;
    }
    /* #files-input{
      display: none;
    } */
    #file-upload {
      display: none;
    }
    #file-upload-update{
      display: none;
    }

    #file-list {
      margin-top: 20px;
      overflow: hidden;
    }

    .preview {
      width: 150px;
      height: 150px;
      margin: 10px;
    } 
    .preview-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .container-preview {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .preview-item {
        padding: 5px;
        margin-right: 12px;
        margin-left: 12px;  
        
    }
    /* .pdf-container,
    .image-container{
        margin-bottom: 10px;
    } */
    
 
    .image-container {
        position: relative;
        display: inline-block; /* Ensure the container only takes the necessary space */
    }
    .pdf-container {
        position: relative;
        display: inline-block; /* Ensure the container only takes the necessary space */
        margin-right: 10px; /* Adjust the margin as needed */
        margin-top: 10px;
    }
    .remove-icon {
        position: absolute;
        top: 0;
        right: 0;
        background-color: red; /* Set a background color to make the icon more visible */
        padding: 5px; /* Add some padding for better visibility */
        cursor: pointer; /* Change the cursor to a pointer to indicate it's clickable */
    }

    /* .custom-file {
    cursor: pointer;
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    display: inline-block;
} */

/* .custom-file:hover {
    background-color: #0056b3;
} */

/* Style for the file list container */
.container-preview {
    /* border: 1px solid #ccc; */
    padding: 10px;
    margin-top: 10px;
    background-color: #f9f9f9;
}

/* Style for individual file entries in the list */
.file-entry {
    margin-bottom: 5px;
    padding: 5px;
    background-color: #e9ecef;
    border-radius: 3px;
}

/* update form modal element */
.upload-header {
    display: flex;
    align-items: center;
    gap: 10px;
}
.custom-btn:hover {
    background-color: #0056b3;
} */

/* .custom-btn-default:hover {
    background-color: #545b62;
} */

/* .custom-btn-success:hover {
    background-color: #218838;
} */

.preview-container {
    margin-top: 15px;
}

.card {
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    border-radius: 5px;
}

.card-body {
    padding: 15px;
}

.custom-img-size {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}

.text-right {
    text-align: right;
}

hr {
    margin-top: 20px;
    margin-bottom: 20px;
}
#files-input{
    display: none;
}
/* end of my changes */
</style>

<script>
//jondy chnages for pdf and images file upload

document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('telemedicineFollowupForm').addEventListener('submit', function(event) {
        var filesInput = document.getElementById('file-input');
        if(filesInput.files.length === 0){
            event.preventDefault();
            $("#err-msgpdf").html("Please select at least one file.");
            $("#err-msgpdf").css('color', 'red');
            return;
        }
        $("#telemedicineFollowupFormModal").modal('hide');
    });

    document.getElementById('file-input').addEventListener('change', handleFileSelect);
});

function handleFileSelect(event) {
    const fileList = event.target.files;
    console.log('fileList', fileList);
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = '';
    console.log('containers', previewContainer);
    for (const file of fileList) {
        const listItem = document.createElement('div');
        listItem.textContent = file.name;
        let allowexten = ["pdf", "png", "jpeg", "jpg","webp","jfif"];
        let filearr = Array.from(fileList).map(file=>file.name);
        let validext = filearr.every(filename => {
            let ext = filename.substring(filename.lastIndexOf('.') + 1).toLowerCase();
            return allowexten.includes(ext);
        });
        if(validext){
            isvalidFile = true;
            $("#telemedicineFollowupForm").off('submit'); // Remove previous submit event handler
                // Display image preview for image files
                if (file.type.startsWith('image/')) {
                    displayImagePreview(file, previewContainer);
                }
                // Display PDF preview for .pdf files
                else if (file.type === 'application/pdf') {
                    // Create a container for each PDF and its remove icon
                    const pdfContainer = document.createElement('div');
                    pdfContainer.classList.add('pdf-container');
                    // Display PDF preview
                    const allowedFolderPath = "<?php echo  asset('public/fileupload') ?>"; //jondy changes
                    const pdffileIcon = 'pdffile.png'; //jondy changes
                    const pdfPreview = displayPdfPreview(file.name, allowedFolderPath +'/'+  pdffileIcon); // Replace the placeholder URL jondy
                    const removedFiles = [];
                    // Create the remove icon
                    const removeIcon = document.createElement('i');
                    removeIcon.classList.add('fa', 'fa-times', 'remove-icon');
                    removeIcon.addEventListener('click', function() {
                        const filename = file.name;
                        removedFiles.push(filename);
                        
                        const fileInput = document.getElementById('file-input');
                        const currentfile = fileInput.files;
                        const updatefile = Array.from(currentfile).filter(file => !removedFiles.includes(file.name));
                        console.log('current pdf file:',currentfile);
                        const newTransfer = new DataTransfer();
                        updatefile.forEach(file => newTransfer.items.add(file));
                        fileInput.files = newTransfer.files;
                        console.log('update pdf:', updatefile);
                        console.log('remove:', removedFiles);
                        pdfContainer.remove();
                    
                    });
                    
                    pdfContainer.appendChild(pdfPreview);
                    pdfContainer.appendChild(removeIcon);
                    // Append the container to the main preview container
                    previewContainer.appendChild(pdfContainer);
                }
        }else{
            isvalidFile = false;
            previewContainer.innerHTML = '';
            const errmsId = 'error-messages';
            let existmsg = document.getElementById(errmsId);
            console.log('filname', file.name);
            if(!existmsg){
                const errmsg = document.createElement('p');
                console.log('error: ', errmsg);
                
                errmsg.textContent = 'Please upload a valid pdf or images file..';
                errmsg.style.color = 'red';
                errmsg.id = errmsId;
                $("#err-msgpdf").html(""); //to empty the error messages submission
                previewContainer.appendChild(errmsg);
            }
            break;       
        }
        $("#telemedicineFollowupForm").submit(function(event){
            if(!isvalidFile){
                event.preventDefault();
            }else{
                //  $("#telemedicineFollowupForm").show();
                    previewContainer.innerHTML = '';
            }
        });
    }
    $("#followup_submit_telemedicine").prop('disabled', !isvalidFile);   
}
 
function displayImagePreview(file, container) {
    const reader = new FileReader();
    console.log('my container', container);
    reader.onload = function (e) {
        const imageContainer = document.createElement('div');
        imageContainer.classList.add('image-container');
        // Create the image preview
        const preview = document.createElement('img');
        preview.setAttribute('src', e.target.result);
        preview.setAttribute('id', 'imagesDisplay')
        preview.style.width = '150px';
        preview.style.height = '150px';
        preview.setAttribute('alt', file.name);
        preview.classList.add('preview');
        preview.addEventListener('click', function () { 
            displayLargeImage(e.target.result,file.name, container);    
        });
        const removedFiles = []; 
        $("#err-msgpdf").html(""); //to empty the error messages submission
        // Create the remove icon
        const removeIcon = document.createElement('i');
        removeIcon.classList.add('fa', 'fa-times', 'remove-icon');
        removeIcon.addEventListener('click', function() {
            container.removeChild(imageContainer);
            const filename = file.name;
            removedFiles.push(filename);

            const fileInput = document.getElementById('file-input');
            const currentfiles = fileInput.files;
            console.log('my current files: ',currentfiles);
            const updatefiles = Array.from(currentfiles).filter(file => !removedFiles.includes(file.name))
            console.log("update files:", updatefiles);
            const newTransfer = new DataTransfer();
            updatefiles.forEach(file => newTransfer.items.add(file));
            fileInput.files = newTransfer.files;
            // $("#filecounter").val(removedFiles.join(','));
            // var namefile = $("#filecount").val();
            console.log('remove:', removedFiles);
            if (container.children.length === 0) {
                // Reset the file input value
                const fileInput = document.getElementById('file-input'); 
                fileInput.value = '';
                // Optionally, trigger the change event
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        });
        // Append the image and remove icon to the container
        imageContainer.appendChild(preview);
        imageContainer.appendChild(removeIcon);
        // Append the container to the main container
        container.appendChild(imageContainer);
    };
    reader.readAsDataURL(file);
}
        // Function to display the larger image
function displayLargeImage(imgsrc, filename, container) {
    // Create a modal or overlay element
    console.log('img src:',imgsrc);    
    console.log('img src:',filename);
    $(".modal-title").html(filename);
    $("#imageView").attr('src', imgsrc);
    $("#imageView").attr('width', '100%');
    $("#imageView").attr('height', 'auto');
    $("#viewLargerFileModal").css('z-index', 1060);
    $("#viewLargerFileModal").modal("show");
}

function displayPdfPreview(file, placeholderUrl, container) {
    console.log('originame pdf filename:', file);
    const pdfPreview = document.createElement('embed');
    pdfPreview.setAttribute('src', placeholderUrl); // Replace with actual PDF preview logic
    pdfPreview.style.width = '150px';
    pdfPreview.style.height = '150px';
    pdfPreview.dataset.originalFilename = file;
    $("#err-msgpdf").html(""); //to empty the error messages submission
    pdfPreview.addEventListener('click', function () { 
        pdfshow(file,placeholderUrl);
        });
    return pdfPreview;
}

function pdfshow(file){
    $(".modal-title").html(file);
    $("#files").html('<i class="fa fa-file-pdf-o"></i> ' + file );
    $("#viewpdf").css('z-index', 1060);
    $("#viewpdf").modal("show");
}

function displayFilePreview(file, container, placeholderUrl) {
    // For unsupported file types, display a placeholder image
    const preview = document.createElement('img');
    preview.setAttribute('src', placeholderUrl);
    preview.setAttribute('alt', file.name);
    preview.classList.add('preview');
    container.appendChild(preview);
}
document.addEventListener("DOMContentLoaded", function() { // this will clear the display of file upload when close it the modal form jondy
    document.getElementById("close_telemedbtn").onclick = function() {
        $('.preview-container').empty();
        $('.imagesDisplay').attr('src', '');
    }
    document.getElementById("close_telemedModal").onclick =  function() {
        $('.preview-container').empty();
        $('.imagesDisplay').attr('src', '');
    }
});

// $("#telemedicineFollowupForm").submit(function (event){
//     $("#telemedicineFollowupFormModal").modal('hide');
// });

$(document).keydown(function(event) { //this will close modal of press the keyboard Esc jondy
    if (event.keyCode == 27) { 
        $("#telemedicineFollowupFormModal").modal('hide');
        $('.preview-container').empty();
        $('.imagesDisplay').attr('src', '');
    }
}); 
//end of my changes
</script>
<div class="modal fade" role="dialog" id="referFormModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>REFER TO OTHER FACILITY</h4>
                <hr />
                <form method="post" id="rejectForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding:0px;">REASON FOR REDIRECTION:</label>
                        <textarea class="form-control reject_reason" rows="5" style="resize: none;" name="remarks" required></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-send"></i> Send</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  
<div class="modal fade" role="dialog" id="redirectedFormModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4 class="text-green" style="font-size: 15pt;">Redirect to other facility</h4>
                <hr />
                <form method="POST" action="{{ asset("doctor/referral/redirect") }}" id="redirectedForm">
                    <input type="hidden" name="code" id="redirected_code" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding:0px;">SELECT FACILITY:</label>
                        <select class="form-control select2 new_facility select_facility" name="facility" style="width: 100%;" required>
                            <option value="">Select Facility...</option>
                            @foreach($facilities as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">SELECT DEPARTMENT:</label>
                        <select name="department" class="form-control select_department select_department_referred" style="padding: 3px" required>
                            <option value="">Select Department...</option>
                        </select>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" id="redirected_submit" class="btn btn-success btn-flat"><i class="fa fa-ambulance"></i> Redirect</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="telemedicineRedirectedFormModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4 class="text-green" style="font-size: 15pt;">Refer Patient</h4>
                <hr />
                <form method="POST" action="{{ asset("doctor/referral/redirect") }}" id="telemedicineRedirectedForm">
                    <input type="hidden" name="code" id="telemedicine_redirected_code" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding:0px;">SELECT FACILITY:</label>
                        <select class="form-control select2 new_facility select_facility" name="facility" style="width: 100%;" required>
                            <option value="">Select Facility...</option>
                            @foreach($facilities as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">SELECT DEPARTMENT:</label>
                        <select name="department" class="form-control select_department select_department_referred" style="padding: 3px" required>
                            <option value="">Select Department...</option>
                        </select>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" id="redirected_submit_telemedicine" class="btn btn-success btn-flat"><i class="fa fa-ambulance"></i> Refer</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- for viewing pdf file preview jondy changes -->
<!-- <div class="modal fade" id="viewpdf" tabindex="-1" role="dialog" aria-labelledby="viewpdfFileModalLabel" aria-hidden="true"  style="z-index: 1060;" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header"> -->
                <!-- Modal header content goes here -->
                <!-- <h5 class="modal-title" id="viewLargerFileModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row">
                            <div class="card">
                                <div class="card-body preview-item"> -->
                                    <!-- <embed src="" id="pdfPreviewContainer" type="application/pdf"/> -->
                                    <!-- <h4 id="files"></h>
                                    <img src="" id="pdfView">
                                </div>
                            </div>
                        </div>
            </div> -->
            <!-- <div class="modal-footer"> -->
                <!-- Modal footer content goes here -->
            <!-- </div>
        </div>
    </div>
</div> -->
<!-- for viewing images file preview jondy changes -->
<!-- <div class="modal fade" id="viewLargerFileModal" tabindex="-1" role="dialog" aria-labelledby="viewLargerFileModalLabel" aria-hidden="true"  style="z-index: 1060;" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header"> -->
                <!-- Modal header content goes here -->
                <!-- <h5 class="modal-title" id="viewLargerFileModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row">
                            <div class="card">
                                <div class="card-body preview-item"> -->
                                    <!-- <embed src="" id="pdfPreviewContainer" type="application/pdf"/> -->
                                    <!-- <h4 id="files"></h>
                                    <img src="" id="imageView">
                                </div>
                            </div>
                        </div>
                    <hr/>
                <div class="form-fotter pull-right">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
                <div class="modal-footer"> -->
                    <!-- Modal footer content goes here -->
                <!-- </div>
        </div>
    </div>
</div> ----end of my changes---- -->

<!------------------------------Starting Adding file in first follow up------------------------------------>
<div class="modal fade" id="telemedicineFollowupFormModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_telemedModal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="text-green" style="font-size: 15pt; margin-top: 0;" id="followup_header" ></h4>
               
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ asset("api/video/followup") }}" id="telemedicineFollowupForm" enctype="multipart/form-data">
                        <input type="hidden" name="code" id="telemed_follow_code" value="">
                        <input type="hidden" name="followup_id" id="telemedicine_follow_id" value="">
                        <input type="hidden" class="telemedicine" value="">
                        <input type="hidden" id="followup_facility_id" class="followup_facility_id" value="">
                        <input type="hidden" id="AppointmentId" name="Appointment_id">
                        <input type="hidden" id="DoctorId" name="Doctor_id">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label style="padding:0px;">FACILITY:</label>
                            <input type="text" class="form-control"  name="facility" id="followup_facility_name" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label style="padding: 0px">DEPARTMENT:</label>
                            <input type="text" class="form-control" name="department" id="department_Opd" value="OPD" readonly>
                        </div>

                        <div class="form-group">
                            <!-- <label style="padding: 0px">Note:</label> -->
                            <p style="color:red;">Note: &nbsp;Do you Have any lab request for upload</p>
                        </div>

                        <div class="form-group">
                            <label id="file-label" for="file-input" class="btn btn-primary custom-file form-control">Select Files</label>
                            <input type="file" id="file-input" name="files[]" multiple class="d-none">
                            <!-- <label for="file-label" class="btn btn-primary  form-control">Select Files</label> -->
                          
                        </div>  
                        <div class="row">
                            <div class="card">
                                <div class="card-body preview-item">
                                    <p id="err-msgpdf" class="text-center"></p>
                                    <div class="preview-container" id="preview-container"></div>
                                
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="form-fotter pull-right">
                            <button class="btn btn-default btn-flat" data-dismiss="modal" id="close_telemedbtn"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" id="followup_submit_telemedicine" class="btn btn-success btn-flat"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>
                        </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!------------------------------Add files if empty or more files----------------------------->

<div class="modal fade" id="FollowupAddEmptyFileFormModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="text-green" style="font-size: 15pt; margin-top: 0;" id="Add_followup_headerform"></h4>
                </div>
            <div class="modal-body">
                <form method="POST" action="{{ asset("api/video/addfileIfempty") }}" id="AddEmptyFileFollowupForm" enctype="multipart/form-data"><!--I add this enctype="multipart/form-data-->
                        <input type="hidden" name="code" id="telemedicine_followup_code" value="">
                        <input type="hidden" name="followup_id" id="telemedicine_followup_id" value=""><!--I add this for followup_id-->
                        <input type="hidden" name="referred_id" id="telemedicine_referred_id" value=""><!--I add this for followup_id-->
                        <input type="hidden" name="position_count" id="position_counter" value=""><!--I add this for followup_id-->
                        <input type="hidden" name="filename" id="filenames" value="">
                        <input type="hidden" class="telemedicine" value="">
                        <div id="removedFilesContainer"></div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <!-- <label style="padding: 0px">Note:</label> -->
                            <p style="color:red;">Note: &nbsp;Do you Have any lab request to upload ?</p>
                        </div>
                        <div class="form-group">
                            <label id="file-label" for="files-input" class="btn btn-primary custom-file form-control">Select Files
                            <input type="file" id="files-input" name="filesInput[]" multiple></label>

                            <!-- <input type="hidden" id="filecount" name="removefile[]" multiple class="d-none"> -->
                            <!-- <div id="file-list" class="mt-3"></div> -->
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-body preview-item">
                                    <p id="err-message" class="text-center"></p>
                                    <div class="container-preview file-entry" id="container-preview"></div>
                                </div>
                            </div>
                        </div> 

                        <hr /> 
                        <div class="form-fotter pull-right">
                            <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" id="followup_submit_empty" class="btn btn-success btn-flat"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>
                        </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!------------------------------End of file------------------------------------->

<!------------------------------for update the file----------------------------------------->
<div class="modal fade" role="dialog" id="telemedicineUpateFileFormModal" style="z-index: 10000;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4 class="text-green" style="font-size: 15pt;" id="Update_followup_header"></h4>
                <hr />
               
                <form method="POST" action="{{ asset("api/video/editfilefollowup") }}" id="telemedicineUpateFileForm" enctype="multipart/form-data">
                   
                    <input type="hidden" name="code" id="edit_telemedicine_followup_code" value="">
                    <input type="hidden" name="followup_id" id="edit_telemedicine_followup_id" value=""><!--I add this for followup_id-->
                    <input type="hidden" name="referred_id" id="edit_telemedicine_referred_id" value=""><!--I add this for followup_id-->
                    <input type="hidden" name="position_count_number" id="position_count_number" value="">
                    <input type="hidden" class="telemedicine" value="">
                    {{ csrf_field() }}
                    
                <div class="form-group formtogroup">
                    <div class="upload-header">
                    <!-- <button id="file-label" for="file-input" class="btn btn-primary custom-file form-control">Select Files</button> -->

                        <label id="file-label" for="file-upload-update" class="btn btn-primary custom-file form-control">Select Files
                            <input type="file" id="file-upload-update" name="files" class="d-none" onchange="readURL(this)">
                        </label>
                        <input type="hidden" id="selected-file-name-input" name="selectedFileName">
                    </div>
                    <div class="preview-container" id="preview-container">
                    <p id="file-preview-black" class="text-center"></p>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div id="preview-update">
                                    <img id="img-preview" src="#" class="custom-img-size" />
                                     <p id="file-preview-red"></p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="form-footer text-right">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="followup_submit_edit" class="btn btn-success">Submit</button>
                </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!---------------------------End of the file update---------------------------------------------------->


<!-- ----------------------------Add more file----------------------------------------->

<!-------------------------- delete modal file -------------------------------------->
<div class="modal fade" role="dialog" id="telemedicineDeleteFileFollowupFormModal" style="z-index: 10000;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4 class="text-danger" style="font-size: 15pt;" id="Delete_followup_header"></h4>
                <hr />
                <form method="POST" action="{{ asset("api/video/deletefilefollowup") }}" id="telemedicineDeleteFileForm" enctype="multipart/form-data">
                   
                    <input type="hidden"  name="code"  id="telemedicine_code" value="">
                    <input type="hidden" name="followup_id" id="delete_telemedicine_followup_id" value=""><!--I add this for followup_id-->
                    <input type="hidden" name="referred_id" id="delete_telemedicine_referred_id" value=""><!--I add this for followup_id-->
                    <input type="hidden"  id="position_counterer" name="position_counter" value="">
                    <input type="hidden" class="telemedicine" value="">
                    <input type="hidden" id="selected-file-name" name="selectedFileName" value="">
                    {{ csrf_field() }}
                    <!-- <div class="form-group">
                        <div id="file-name" class="mt-3 text-center"></div>

                        <div class="preview-container" id="preview-containerfor">
                            <img id="delete-image" src="" style="max-width: 100%; max-height: 300px;">
                        </div>
                    </div>
                    <hr /> -->
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal" id="delete_Modal_close"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" id="followup_submit_delete" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-------------------------- delete modal file End-------------------------------------->

<div class="modal fade" role="dialog" id="referAcceptFormModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4 class="text-green" style="font-size: 15pt;">Transfer to other facility</h4>
                <hr />
                <form method="post" id="referAcceptForm" action="{{ asset("doctor/referral/transfer") }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="transfer_tracking_id" name="transfer_tracking_id">
                    <div class="form-group">
                        <label style="padding:0px;">REMARKS:</label>
                        <textarea class="form-control reject_reason" rows="5" style="resize: none;" name="remarks" required></textarea>
                    </div>
                    <div class="form-group">
                        <label style="padding:0px;">FACILITY:</label>
                        <select class="form-control select2 new_facility select_facility" name="facility" required>
                            <option value="">Select Facility...</option>
                            @foreach($facilities as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">DEPARTMENT:</label>
                        <select name="department" class="form-control select_department select_department_accept" style="padding: 3px" required>
                            <option value="">Select Department...</option>
                        </select>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" id="transferred_submit"><i class="fa fa-ambulance"></i> Refer</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase.js"></script>
<script>// jondy changes

let firebase_key = "";
function sendNotifierData(key_firebase,age, chiefComplaint, department, diagnosis, patient, sex, referring_hospital, date_referred, patient_code) {
        // Check if Firebase app with name '[DEFAULT]' already exists
     
        if (!firebase.apps.length) {
            // Your web app's Firebase configuration
            var firebaseConfig = {
                apiKey: "AIzaSyB_vRWWDwfiJVCA7RWOyP4lxyWn5QLYKmA",
                authDomain: "notifier-5e4e8.firebaseapp.com",
                databaseURL: "https://notifier-5e4e8-default-rtdb.firebaseio.com",
                projectId: "notifier-5e4e8",
                storageBucket: "notifier-5e4e8.appspot.com",
                messagingSenderId: "359294836752",
                appId: "1:359294836752:web:87c854779366d0f11d2a95",
                measurementId: "G-HEYDWWHLKV"
            };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
        }

        //initialize firebase
        var dbRef = firebase.database();
        //create table
        var requestRef = dbRef.ref('23');
        const newRef = requestRef.push({
            age: age,
            chiefComplaint: chiefComplaint,
            department: department,
            diagnosis: diagnosis,
            patient: patient,
            sex: sex,
            referring_hospital : referring_hospital,
            date_referred : moment(date_referred).format("YYYY-MM-DD HH:mm:ss"),
            patient_code : patient_code
        });

        firebase_key = newRef.key;
        console.log(firebase_key)


        var form = new FormData();
            form.append("age", age);
            form.append("chiefComplaint", chiefComplaint);
            form.append("department", department);
            form.append("diagnosis", diagnosis);
            form.append("patient", patient);
            form.append("sex", sex);
            form.append("referring_hospital", referring_hospital);
            form.append("date_referred", moment(date_referred).format("YYYY-MM-DD HH:mm:ss"));
            form.append("patient_code", patient_code);
            form.append("firebase_key", firebase_key);

        var settings = {
            "url": "https://dohcsmc.com/notifier/api/insert_referral_5pm",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        var currentTime = new Date().toLocaleTimeString('en-GB', {hour12: false});

        if(currentTime >= "17:00:00" && currentTime <= "21:00:00") {

            $.ajax(settings).done(function (response) {
                console.log(response);
                
                if(firebase_key) {
                    requestRef.child(firebase_key).remove()
                        .then(function() {
                            console.log("Firebase record deleted:", firebase_key);

                            firebase_key = "";
                        })
                        .catch(function(error){
                            console.error("Error deleting Firebase record:", error);
                        });
                }
            });
        }
       
    }

    document.addEventListener('DOMContentLoaded', function () {
        let datastore = @json(Session::get('for_firebase_data'));
        if(datastore) {
            let pushDiagnosis = Array.isArray(datastore.push_diagnosis) ?
                datastore.push_diagnosis.join(', ') : 
                datastore.push_diagnosis;

            sendNotifierData(
                firebase_key,
                datastore.age,
                datastore.chiefComplaint, 
                datastore.referred_department, 
                // datastore.push_diagnosis, 
                // datastore.push_diagnosis.join(', '),
                pushDiagnosis,
                datastore.patient_name,
                datastore.patient_sex, 
                datastore.referring_name,
                datastore.referred_date,
                datastore.patient_code
            );
            <?php session()->put('for_firebase_data', null); ?>
        }
      
    });

$(document).ready(function() {

    @if(session('first_save'))
    var number = "{{ session('first_save') }}";
        Lobibox.notify('success', {
            msg: 'Successfully saved file!'
        });
    @endif

    @if(session('file_save'))
    var number = "{{ session('file_save') }}";
        Lobibox.notify('success', {
            msg: 'Successfully saved file!' + number +' Position'
        });
    @endif

    @if(session('delete_file'))
    var number = "{{ session('delete_file') }}";
        Lobibox.notify('success', {
            msg: 'Deleted file Successfully in ' + number + ' Position'
        });
    @endif

    @if(session('update_file'))
    var number = "{{ session('update_file') }}";
    Lobibox.notify('success', {
        msg: 'Updated Successfully in ' + number +' position'

    });
    @endif
});

//removing back ground if empty
$(document).ready(function (){
    $('#container-preview').hideFileEntryBackground();

    $('#files-input').change(function (){
        $('#container-preview').toggleFileEntryBackground(this.files.length > 0);
    });
});

$.fn.toggleFileEntryBackground = function (show){
    if(show){
        this.addClass('file-entry');
        this.show();
    }else{
        this.removeClass('file-entry');
        this.remove;
    }
}

$.fn.hideFileEntryBackground = function () {
    this.removeClass('file-entry');
    this.hide();
}

 $('#telemedicineFollowupFormModal').on('shown.bs.modal', function (e) {
    var facility_id = $("#followup_facility_id").val();
    //console.log('my facility',facility_id)
 //function facilityName() {
    $.ajax({
            url: '{{ route("api.getName", ["id" => ""]) }}/' + facility_id, 
            method: 'GET',
            // async: false,
            success: function(response) {
                // Handle the response from the controller
                // For example, you can update the UI based on the returned value
                $("#followup_facility_name").val(response.name);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);
            }
        });


    //  }
    //  facilityName();
    //  setInterval(facilityName, 500);
 });

</script>