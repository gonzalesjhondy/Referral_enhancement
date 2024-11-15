<script>
    <?php $user=Session::get('auth');?>
    var myfacility_name = "{{ \App\Facility::find($user->facility_id)->name }}";

    function telemedicineReferPatient(alreadyRedirected,alreadyFollowup,code,referred_id) { 
        // console.log('upward level', endorseUpward);
        const upwardIsCompleted = $('#upward_progress'+code+referred_id).hasClass('completed');
        console.log('alreadyRedirected', alreadyRedirected, 'alreadyFollowup', alreadyFollowup);
        $(".telemedicine").val(0);
        $("#telemedicine_redirected_code").val(code);
        if(upwardIsCompleted && !alreadyRedirected && !alreadyFollowup) {
            $("#telemedicineRedirectedFormModal").modal('show');
        }
        else if(alreadyRedirected) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been referred!"
                });
        } 
        else if(alreadyFollowup) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been follow-up!"
                });
        }
        else {
            Lobibox.alert("error",
                {
                    msg: "You cannot refer a patient to an upward level because the receiving doctor has not yet endorsed your patient's referral to an upward level."
                });
        }
    }

    function telemedicineTreatedPatient(alreadyUpward, examinedPatient,alreadyTreated,code,referred_id, followTrack) { // I add this FollowTrack
        const prescriptionIsCompleted = $('#prescribed_progress'+code+referred_id).hasClass('completed');
        const upwardIsCompleted = $('#upward_progress'+code+referred_id).hasClass('completed');
        const treatedIsCompleted = $('#treated_progress'+code+referred_id).hasClass('completed'); // nag add ko ani kay para sa error messages kung ikaduha siya click para sa already treated
        const examPatientCompleted = document.getElementById(`examined_progress${code}${referred_id}`).classList.contains('completed');

        console.log('upward', alreadyUpward, !treatedIsCompleted, !alreadyTreated);

        if((alreadyUpward || upwardIsCompleted) && (!alreadyTreated || !treatedIsCompleted)){ // I add this condition para sa error nga treated kung ma upward na siya
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been upward!"
                });
        }else if (followTrack){ //I add this condition kung naka fllow na siya error ang treated niya
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been followed!"
                });
        }else if(treatedIsCompleted && alreadyTreated){//error messages para sa pag click ikaduha sa treated icon
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been treated!"
                });
        }else if(treatedIsCompleted){
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been treated!"
                });
        }else if(!examPatientCompleted && !examinedPatient){
            Lobibox.alert("error",
                {
                    msg: "You cannot treated on a patient because it has not yet been examined.!"
                });
        }
        else{

            //if((examinedPatient || prescriptionIsCompleted) && !alreadyTreated && (!alreadyUpward || !upwardIsCompleted)) {
                Lobibox.confirm({
                    msg: "Do you want to treat this patient?",
                    callback: function ($this, type, ev) {
                        if(type === 'yes') {
                            var json = {
                                "_token" : "<?php echo csrf_token(); ?>",
                                "code" : code
                            };
                            var url = "<?php echo asset('api/video/treated') ?>";
                            $.post(url,json,function(result){
                                result = result.trim(); // trim or removing whitespace characters
                                console.log('result:ddfdff', result);
                                if (result === 'success') {
                                    Lobibox.alert("success", {
                                        msg: "The patient was successfully treated."
                                    });
                                    $("#treated_progress" + code + referred_id).addClass('completed');
                                }
                            });
                        }
                    }
                });
                if(treatedIsCompleted){//error messages para sa pag click ikaduha sa treated icon
                    Lobibox.alert("error",
                        {
                            msg: "This tracking area has already been treated!"
                        });
                }
            // } else if(alreadyTreated || treatedIsCompleted) {
            //     console.log("treatedIsCompleted",treatedIsCompleted);
            //     Lobibox.alert("error",
            //         {
            //             msg: "This tracking area has already been treated!"
            //         });
            // } else if(alreadyUpward || upwardIsCompleted) {
            //     Lobibox.alert("error",
            //         {
            //             msg: "This tracking area has already been upward!"
            //         });
            // }
            // else {
            //     Lobibox.alert("error",
            //         {
            //             msg: "You can't treat a patient because the patient has not been examined."
            //         });
            // }


        }
    }

    document.addEventListener('DOMContentLoaded', function () {
            // starting my changes for empty error submission 
        document.getElementById('AddEmptyFileFollowupForm').addEventListener('submit', function(event) {
            var filesInput = document.getElementById('files-input').files;
            if (filesInput.files.length === 0) {
                // File input is empty, prevent form submission
                event.preventDefault();
                $("#err-message").html("Please select at least one file.");
                $("#err-message").css('color', 'red');
                return;
            }
            var ext = filesInput[0].name.split('.').toLowerCase();
            if (!['png', 'jpeg', 'jpg', 'webp', 'jfif'].includes(ext)) {
                event.preventDefault(); // Prevent form submission if the file is not valid
                return;
            }
            //  $("#FollowupAddEmptyFileFormModal").modal('hide');
        });
        // Your code here
        document.getElementById('files-input').addEventListener('change', SelectedFile);
    });

    function SelectedFile(event) {
        const listfile = event.target.files;
        console.log('listfile :', listfile);
        const prevContainer = document.getElementById('container-preview');
        prevContainer.innerHTML = '';
        console.log('container', prevContainer);
        for(const file of listfile){
            const listItems = document.createElement('div');
            listItems.textContent = file.name;
            let allowedextension =  ["pdf", "png", "jpeg", "jpg","webp","jfif"];
            let arrayfile = Array.from(listfile).map(file=>file.name);
            let allextension =  arrayfile.every(fileName => {
                let ext = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
                return allowedextension.includes(ext);
            });
            
            if(allextension){ 
                isvalidFiles = true;
                if (file.type.startsWith('image/')) {
                    console.log("imagesss:", file);
                    ImagePrev(file, prevContainer,listfile);
                }
                else if(file.type === 'application/pdf'){
                    // Create a container for each PDF and its remove icon
                    const Containerpdf = document.createElement('div');
                    Containerpdf.classList.add('pdf-container');
                    const pdfPreview = PdfPreview(file.name, '../public/fileupload/pdffile.png'); // Replace the placeholder URL
                    const removedFiles = [];
                    // Create the remove icon
                    const removeIcon = document.createElement('i');
                    removeIcon.classList.add('fa', 'fa-times', 'remove-icon');
                    removeIcon.addEventListener('click', function() {
                        const filename = file.name;
                        removedFiles.push(filename);
                        $("#filecount").val(removedFiles.join(''));
                        Containerpdf.remove();
                        const fileInput = document.getElementById('files-input');
                        const currentfile = fileInput.files;
                        const updatefiles = Array.from(currentfile).filter(file => !removedFiles.includes(file.name));
                        console.log('update files pdf',fileInput.files);
                        const newTransfer = new DataTransfer();
                        updatefiles.forEach(file => newTransfer.items.add(file));
                        fileInput.files = newTransfer.files;
                        if(prevContainer.children.length === 0) {
                            const fileInput = document.getElementById('files-input')
                            fileInput.value = '';
                            const event = new Event('change');
                            fileInput.dispatchEvent(event);
                        }           
                    });
                    Containerpdf.appendChild(pdfPreview);
                    Containerpdf.appendChild(removeIcon);
                    // Append the container to the main preview container
                    prevContainer.appendChild(Containerpdf);
                }

            }else if(!event.target.files.length && !prevContainer){
                event.preventDefault();
                alert('Please select a file before submitting.');
                return;
            }else{
                isvalidFiles = false;
                prevContainer.innerHTML = '';
                const errmsId = 'error-messages';
                let existmsg = document.getElementById(errmsId);
                    if(!existmsg){
                        const errmsg = document.createElement('p');
                        console.log('error: ', errmsg);
                        errmsg.textContent = 'Please upload a valid pdf or images file..';
                        errmsg.style.color = 'red';
                        errmsg.id = errmsId;
                        $("#err-message").html("");
                        prevContainer.appendChild(errmsg);
                    }
                     break; // Break out of the loop as there's an invalid file        
            }
        }
        $("#AddEmptyFileFollowupForm").submit(function(event){
            if(!isvalidFiles){
                event.preventDefault();
            }else{
                // $("#AddEmptyFileFollowupForm").show();
                    prevContainer.innerHTML = '';
            }  
        });
    }

    function ImagePrev(file, container, listFile){
        const reader = new FileReader();
        reader.onload = function (e){
            const imageCons = document.createElement('div');
            imageCons.classList.add('image-container');
            const prevImage = document.createElement('img');
            prevImage.setAttribute('src', e.target.result);
            prevImage.style.width = '150px';
            prevImage.style.height = '150px';
            prevImage.setAttribute('alt', file.name);
            prevImage.classList.add('preview');
            $("#err-message").html(""); // this will remove the display erro messages if empty
            prevImage.addEventListener('click', function () { 
                viewImage(e.target.result,file.name, container);
            });
            const removedFiles = []; 
            // Create the remove icon
            const removeIcon = document.createElement('i');
            removeIcon.classList.add('fa', 'fa-times', 'remove-icon');
            removeIcon.addEventListener('click', function() {
                container.removeChild(imageCons);
                const filename = file.name;
                removedFiles.push(filename);
                const fileInput = document.getElementById('files-input');
                const currentFiles = fileInput.files;
                const updatedFiles = Array.from(currentFiles).filter(file => !removedFiles.includes(file.name));
                // Create a new DataTransfer object to set the updated files
                const newTransfer = new DataTransfer();
                updatedFiles.forEach(file => newTransfer.items.add(file));
                // Set the new DataTransfer object to the file input
                fileInput.files = newTransfer.files;
                if(container.children.length === 0) {
                    const fileInput = document.getElementById('files-input')
                    fileInput.value = '';
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });
            imageCons.appendChild(prevImage);
            imageCons.appendChild(removeIcon);
            container.appendChild(imageCons);
        };
        reader.readAsDataURL(file);// to start reading the file's data and trigger the onload
    }

    function viewImage(imgsrc, filename){
        $(".modal-title").html(filename);
        $("#imageView").attr('src', imgsrc);
        $("#imageView").attr('width', '100%');
        $("#imageView").attr('height', 'auto');
        $("#viewLargerFileModal").css('z-index', 1060);
        $("#viewLargerFileModal").modal("show");
    }
        
    function PdfPreview(file, placeholderUrl, container){
        // displayFilePreview(file, container, placeholderUrl);
        const pdfPreview = document.createElement('embed');
        pdfPreview.setAttribute('src', placeholderUrl); // Replace with actual PDF preview logic
        pdfPreview.style.width = '150px';
        pdfPreview.style.height = '150px';
        pdfPreview.dataset.originalFilename = file;
        $("#err-message").html(""); // this will remove the display erro messages if empty
        pdfPreview.addEventListener('click', function () { 
            pdfshow(file,placeholderUrl);
        });
        return pdfPreview;
    }
    function SuccessNotify(message) { //adding a notification in each function of files
        Lobibox.notify("success", {
            size: 'mini', 
            rounded: true,
            delay: 5000, 
            position: 'bottom right',
            msg: message,
            showClass: 'fadeIn',
            hideClass: 'fadeOut',
            width: 400, 
            icon: true, 
            sound: true 
        });
    }
    function errorNotify(message){//adding error a notification in each function of files
        Lobibox.notify("error",
        {
            size: 'mini',
            rounded: true,
            delay: 5000,
            position: 'bottom right',
            msg: message,
            showClass: 'fadeIn',
            hideClass: 'fadeOut',
            width: 400,
            icon: true,
            sound: true
        });
    }
    //------------------------my adding for update file uploader Follow up-----------------------------//
    function editFileforFollowup(baseUrl,fileNames,code,activity_id,follow_id,position){
        console.log("updated filename: ", fileNames);
        event.preventDefault();
        $(".telemedicine").val(1);
        $("#edit_telemedicine_followup_code").val(code);
        $("#edit_telemedicine_referred_id").val(activity_id);
        $("#edit_telemedicine_followup_id").val(follow_id);
        //$("#file-list").text(fileNames);
        $("#selected-file-name-input").val(fileNames);
        $("#position_count_number").val(position);
        var currentPosition = $("#position_count_number").val();
        var Ext = fileNames.split('.').pop().toLowerCase();
        console.log("My EXT ", Ext);
        if(Ext === 'pdf'){
            $("#file-preview-black").html(fileNames);
             $("#img-preview").attr('src','../public/fileupload/pdffile.png');
             $("#img-preview").css('width', '50%');
             $("#img-preview").css('height', '110px');
        }else{
            $("#img-preview").attr('src', `${baseUrl}/${fileNames}`);
            $("#img-preview").css('width', '30%');
            $("#img-preview").css('height', '110px');
            $("#file-preview-black").html('');
        }
        $("#Update_followup_header").html("Update File");
        $("#telemedicineUpateFileFormModal").modal('show');
        // $("#carouselmodaId").modal('hide'); 
        $("#followup_submit_edit").off().on("click", function(event){//adding this to addFile as an Ajax 
            event.preventDefault();
            var formData = new FormData($("#telemedicineUpateFileForm")[0]);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                type: "POST",
                url: $("#telemedicineUpateFileForm").attr("action"),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log("my file response:", response.filename);
                    updateFilesInFollowup(response.filename, baseUrl,position,code,activity_id,follow_id);
                    SuccessNotify("File successfully updated.");
                    $("#carouselmodaId").remove();
                }

            });
            
            $("#telemedicineUpateFileFormModal").modal("hide");
        });
    }

    $('#telemedicineUpateFileFormModal').on('hidden.bs.modal', function () {
        $('#file-upload-update').val();
       // $("#carouselmodaId").remove();
    });
    //------------------------Add files if empty add more-----------------------------//
    function addfilesInFollowupIfempty(position,code,referred_id,follow_id,baseUrl,fileNames){
        event.preventDefault();
        console.log('my Base Url data', baseUrl);
        $(".telemedicine").val(1);
        $("#filenames").val(filenames);
        $("#position_counter").val(position);
        $("#telemedicine_followup_code").val(code);
        $("#telemedicine_referred_id").val(referred_id);
        $("#telemedicine_followup_id").val(follow_id);
        document.getElementById("container-preview").innerHTML = "";
        $("#err-message").html("");
        $("#Add_followup_headerform").html("Add Files")
        $("#FollowupAddEmptyFileFormModal").modal('show');
        // $("#AddEmptyFileFollowupForm").submit(function (event){
        //     $("#FollowupAddEmptyFileFormModal").modal('hide');
        // });
        $("#followup_submit_empty").off().on("click", function(event) {//adding this to addfilesInFollowupIfempty as an Ajax 
            event.preventDefault();
            var filesInput = document.getElementById('files-input');
            var fileslength = filesInput.files.length;
            var invalidfile = false;
            for(var i = 0; i < fileslength; i++){
                var file = filesInput.files[i];
                var ext = file.name.substring(file.name.lastIndexOf('.') + 1).toLowerCase();
                //mo check kung valid ba ang file
                if(!['png','jpeg','jpg', 'webp', 'pdf','jfif'].includes(ext)){
                    invalidfile = true;
                    break;// mo Break sa loop kung invalid file is found
                }
            }
            console.log("invalidfile", invalidfile);
            if(fileslength === 0 ){
                $("#err-message").html("Please select at least one file.");
                $("#err-message").css('color', 'red');
                return;
            } 
            else if(invalidfile){
                return false;
            }
            var openViewerCall = function (){
                $('#FollowupAddEmptyFileFormModal').modal('show');
            };
            var formData = new FormData($("#AddEmptyFileFollowupForm")[0]);
            console.log("form data update:", formData);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                type: "POST",
                url: $("#AddEmptyFileFollowupForm").attr("action"),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){

                    selectedFiles = [];//mao ni mo clear sa selectedFiles nga gi select previously sa folderModal

                    updateFilesInFollowup(response.filename, baseUrl,position,code,referred_id,follow_id,openViewerCall);

                    SuccessNotify("File already saved in Position " + position);

                    $("#carouselmodaId").remove();
                },
                error: function(xhr, status, error){
                     // Handle error here
                     console.error(xhr.responseText);	
                }
            });
            $("#FollowupAddEmptyFileFormModal").modal('hide');
        });
    }

    $('#FollowupAddEmptyFileFormModal').on('hidden.bs.modal', function () {
            $('#files-input').val('');
            $('#container-preview').empty();
            $("#imageView").attr('src', '');
        });

    $(document).keydown(function(event) { //this will close modal of press the keyboard Esc
        if (event.keyCode == 27) { 
            $("#FollowupAddEmptyFileFormModal").modal('hide');
            $("#telemedicineUpateFileFormModal").modal('hide');
            $("#telemedicineDeleteFileFollowupFormModal").modal('hide');
            $('#files-input').val('');
            $("#file-name").html('');
            $('#container-preview').empty();
            $("#imageView").attr('src', '');
        }
    }); 
    //------------------------ delete file-----------------------------//
    function DeleteFileforFollowup(baseUrl,fileNames,code,referred_id,follow_id,position){
        event.preventDefault();

        var ext = fileNames.split('.').pop().toLowerCase();
        $("#telemedicine_code").val(code);
        $("#delete_telemedicine_followup_id").val(follow_id);
        $("#delete_telemedicine_referred_id").val(referred_id);
        var position_counter = $("#position_counterer");
        var selectedFileNameInput = $("#selected-file-name");
        selectedFileNameInput.val(fileNames);
        position_counter.val(position);
        $("#Delete_followup_header").html("Are you sure You want to delete this file?");
        $("#telemedicineDeleteFileFollowupFormModal").modal('show');

        $(document).on("click", "#followup_submit_delete", async function(event) {//adding this to DeleteFileforFollowup as an Ajax 
            event.preventDefault();
            isDeletingFile = true;
            var formData = $("#telemedicineDeleteFileForm").serialize(); 
            // console.log('formDatasdsd', formData);

            try {
                const response = await $.ajax({
                    type: "POST",
                    url: $("#telemedicineDeleteFileForm").attr("action"),
                    data: formData
                 });
                  console.log("delete files Count", response.filename);
                  console.log('filename split?', fileNames);
                
                var removingFile = false;

                var activeItem = $(".item.active[data-filename='" + fileNames + "']");
                    if (activeItem.length > 0) {
                        removingFile = true;
                        setTimeout(function() {
                            $(document).keydown(function(e) { // I add this for disabled slide carousel
                                if (e.keyCode === 37) {
                                    // Previous
                                    $(".carousel-control.left").click();
                                    return false;
                                }
                                if (e.keyCode === 39) {
                                    // Next
                                    $(".carousel-control.right").click();
                                    return false;
                                }
                            });
                            activeItem.remove(); 
                            errorNotify("Selected file already Deleted in position " + position);
                            removingFile = false; 

                            var nextItem = activeItem.next(".item");
                            if (nextItem.length === 0) {
                                nextItem = $(".item").first(); 
                            }
                            nextItem.addClass("active").show();
                        }, 10); 
                        //activeItem.remove();
                    }
                    var filenames = response.filename.split('|');
                    if (filenames.length == 1) {
                        $("#carouselmodaId").remove();
                        $("#carouselmodaId").modal('hide');
                        if (!$(".lobibox-title").length) {
                            Lobibox.alert("success", {
                                msg: "All files already deleted!",
                                callback: function() {
                                   
                                }
                            });
                        }
                    }

                    updateFilesInFollowup(response.filename, baseUrl, position, code, referred_id, follow_id);
                    $("#telemedicineDeleteFileFollowupFormModal").modal('hide');
             } catch (error) {
                console.error("Error:", error);
            } finally {
                // Clear the flag to indicate file deletion operation is finished
                isDeletingFile = false;
            }
        });

    }//end of the function 

    function updateFilesInFollowup(filenames,baseUrl,position,code,referred_id,follow_id) { // I add this for appendinng File folder list

        $(document).on('keydown', function(event) {
            if (event.keyCode === 27) { // Check if Escape key is pressed
                location.reload(); // Reload the page to refresh modal content
            }
        });
        // console.log('upate file', baseUrl, 'position:', position);
        console.log("filenamesdfdffd", filenames);
        filenames = filenames || '';
        var Split_filesname = filenames.split('|').filter(filename => filename.trim() !== '');
        console.log("my sple folder", Split_filesname);
        var column_card = "";

        var allfilesImgPdf = Split_filesname.map(function(filename){
            var ext = filename.split('.').pop().toLowerCase();
            var checkboxHtml = `
                <div class="checkbox-container">
                    <input type="checkbox" class="file-checkbox" value="${filename}" onchange="toggleFileSelection('${filename}', event, '${baseUrl}','${code}','${referred_id}','${follow_id}','${position}')" />
                </div>`;
            var iconHtml;

            if (ext === 'pdf') {
                iconHtml = `<div class="d-flex flex-column align-items-center justify-content-center">
                                <img src="../public/fileupload/pdffile.png" width="100%" height="100px" class="pdf-file" alt="PDF File">
                            </div>`;
            } else {
                iconHtml = `<img src="${baseUrl}/${filename}" width="100%" height="100px" alt="PDF File">`;
            }
            return `<div class="${column_card} cardsfile">
                        <div class="card mb-4 shadow-sm card-body-file">
                            ${checkboxHtml}
                            <a href="javascript:void(0);" onclick="openFileViewer('${position}','${code}','${referred_id}','${follow_id}','${baseUrl}', '${filename}','${Split_filesname}')" class="file-link">
                                <div class="card-body card-body-card">
                                    ${iconHtml}
                                </div>
                            </a>
                        </div>
                    </div>`;
        }).join(""); // Join the HTML strings into a single string
        var modal = $('#folderModal');
        if(modal.length === 0) {
            var modalsContent = `
                <div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="folderModalLabel">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-vertical-list">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="folderModalLabel">File Folder List</h4>
                                <label><input type="checkbox" id="checkVisible" value="" onclick="checkVisibleFiles(this.checked, '${Split_filesname}','${baseUrl}','${code}','${referred_id}','${follow_id}','${position}')" />&nbsp; Select all files</label>
                                
                                <button type="button" id="removeFiles" class="btn btn-success btn-xs">remove files</button>
                                <a href="javascript:void(0);" class="btn btn-primary btn-xs" onclick="addfilesInFollowupIfempty('${position}','${code}','${referred_id}','${follow_id}','${baseUrl}','${Split_filesname}')">
                                    Add More Files
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        ${allfilesImgPdf}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#modalContainer').html(modalsContent); // Update the modal content
            modal = $('#folderModal');
        } else {
            modal.find('.modal-body .row').html(allfilesImgPdf);
        }
        $('.cardsfile').each(function() {
            if(Split_filesname.length === 1){
                $(this).addClass('col-md-12');
            }else if(Split_filesname.length === 2){
                $(this).addClass('col-md-6');
            }else if( Split_filesname.length === 3){
                $(this).addClass('col-md-4');
            }
            else{
                $(this).addClass('col-md-3');
            }
        });
        modal.modal('show'); // Show the modal

        modal.find('.close').off('click').on('click', function () {
           location.reload(true);
        });
    } // end of appending file folder list

    $('#telemedicineDeleteFileFollowupFormModal').on('hidden.bs.modal', function () {
        $("#telemedicine_code").val("");
        $("#delete_telemedicine_followup_id").val("");
        $("#delete_telemedicine_referred_id").val("");
        $("#position_counterer").val("");
        $("#selected-file-name").val("");
        // Clear text and image previews
        $("#file-name").text("");
        // $("#delete-image").attr("src", "");
        // $("#pdfViewer").remove();
        // $("#carouselmodaId").remove();
        // $("#carouselmodaId").modal("show");
    });

    $("#carouselmodaId").on('hidden.bs.modal', function (e){
        if(isDeleteModalOpen) {
            e.preventDefault();
            e.stopPropagation();
            isDeleteModalOpen = false;
        }
    });
     // select single image & pdf to preview
    function readURL(input) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        // console.log('input', input);
        if (input.files && input.files[0]) {
            var fileName = input.files[0].name;
            $('#img-preview').attr('src', '').css('display', 'none');
            $('#file-preview-black').html("");
            $("#file-preview-red").html("");
            $("#file-empty").html("");
            if (ext === "pdf") {
                isvalidFile = true;
                $("#followup_submit_edit").prop('disabled', false);
                $('#img-preview').attr('src', '../public/fileupload/pdffile.png').css('display', 'block');
                $("#img-preview").css('width', '50%');
                $('#file-preview-black').html('<i class="fa fa-file-pdf-o"></i> ' + fileName);
            } else if (ext === "png" || ext === "jpeg" || ext === "jpg" || ext === "PNG" || ext === "JPEG" || ext === "JPG" || ext === "webp" || ext === "jfif") {
                isvalidFile = true;
                $("#followup_submit_edit").prop('disabled', false);
                $('#file-preview-black').html('<i class="fa fa-file-image-o"></i> ' + fileName);
                $('#img-preview').attr('src', URL.createObjectURL(input.files[0])).css('display', 'block');
            } else {
                isvalidFile = false;
                $("#followup_submit_edit").prop('disabled', true);
                $("#file-preview-red").html("Please upload a valid pdf or image file.").css('color', 'red');
            }
            $("#telemedicineUpateFileForm").submit(function(event){
                if(!isvalidFile){
                    event.preventDefault();
                }else{
                    $("#telemedicineUpateFileForm").show();
                }
            })
        }
    }

    function telemedicineFollowUpPatient(alreadyReferred, alreadyEnded, examinedPatient, alreadyFollowUp, code, referred_id, alreadyTreated, alreadyUpward) { // I am adding  alreadyTreated and  alreadyUpward
        $("#telemed_follow_code").val(code);//I add this add this to get the followup_id jondy
        $("#telemedicine_follow_id").val(referred_id); //I add this add this to get the followup_id jondy
        $(".telemedicine").val(1);
        const upwardIsCompleted = $('#upward_progress'+code+referred_id).hasClass('completed');
        const treatedIsCompleted = $('#treated_progress'+code+referred_id).hasClass('completed');
        const prescribedIsCompleted = $('#prescribed_progress'+code+referred_id).hasClass('completed');
        //--------
        console.log("alreadyFollowup", alreadyFollowUp);
        //---------
        if(alreadyFollowUp) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been follow up!"
                });
        }
        else if(alreadyReferred) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been referred!"
                });
        }
        else if(alreadyEnded) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been ended!"
                });
        }else if(alreadyTreated){ //Gi add ni nako nga condition para dili nani siya mo follow up kung ang patiente ge treated na
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been treated!"
                });
        }else if(alreadyUpward || upwardIsCompleted){//Gi add ni nako nga condition para dili nani siya mo follow up kung ang patiente na upward na
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been Upward level!"
                });
        }
        else if(treatedIsCompleted) {
            telemedicine = 1;
            //$("#telemedicineFollowupFormModal").modal('show');
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been treated!"
                });
        }
        else if(!examinedPatient && !prescribedIsCompleted) {
            Lobibox.alert("error",
                {
                    msg: "You cannot follow up on a patient because it has not yet been examined."
                });
        }
        else {
            // $("#followup_header").html("Follow Up Patient");
            // telemedicine = 1;
            // $("#telemedicineFollowupFormModal").modal('show');
            const appointment = {
                code: code,
                referred_id: referred_id
            }
            window.location.href = `{{ asset('doctor/appointment/calendar') }}?appointmentKey=${generateAppointmentKey(255)}&appointment=${encodeURIComponent(JSON.stringify([appointment]))}`;
        }
         //immediately close the form modal after submission
      
    }


    // function telemedicineFollowUpPatient(alreadyReferred, alreadyEnded, examinedPatient, alreadyFollowUp, code, referred_id) {
    //     $("#telemed_follow_code").val(code);//I add this add this to get the followup_id jondy
    //     $("#telemedicine_follow_id").val(referred_id); //I add this add this to get the followup_id jondy
    //     $(".telemedicine").val(1);
    //     const treatedIsCompleted = $('#treated_progress'+code+referred_id).hasClass('completed');
    //     const prescribedIsCompleted = $('#prescribed_progress'+code+referred_id).hasClass('completed');
    //     if(alreadyFollowUp) {
    //         Lobibox.alert("error",
    //             {
    //                 msg: "This tracking area has already been follow up!"
    //             });
    //     }
    //     else if(alreadyReferred) {
    //         Lobibox.alert("error",
    //             {
    //                 msg: "This tracking area has already been referred!"
    //             });
    //     }
    //     else if(alreadyEnded) {
    //         Lobibox.alert("error",
    //             {
    //                 msg: "This tracking area has already been ended!"
    //             });
    //     }
    //     else if(treatedIsCompleted) {
    //         telemedicine = 1;
    //         $("#telemedicineFollowupFormModal").modal('show');
    //     }
    //     else if(!examinedPatient && !prescribedIsCompleted) {
    //         Lobibox.alert("error",
    //             {
    //                 msg: "You cannot follow up on a patient because it has not yet been examined."
    //             });
    //     }
    //     else {
    //         // $("#followup_header").html("Follow Up Patient");
    //         // telemedicine = 1;
    //         // $("#telemedicineFollowupFormModal").modal('show');
    //         const appointment = {
    //             code: code,
    //             referred_id: referred_id
    //         }
    //         window.location.href = `{{ asset('doctor/appointment/calendar') }}?appointmentKey=${generateAppointmentKey(255)}&appointment=${encodeURIComponent(JSON.stringify([appointment]))}`;
    //     }
    //      //immediately close the form modal after submission
      
    // }
       

    function consultToOtherFacilities(code) {
        $("#followup_header").html("Consult to other facilities");
        $("#telemedicine_followup_code").val(code);
        $(".telemedicine").val(1);
        telemedicine = 1;
        $("#telemedicineFollowupFormModal").modal('show');
    }

    function telemedicineExamined(tracking_id, code, action_md, referring_md, activity_id, form_tpe, referred_to, alreadyTreated, alreadyReferred, alreadyupward, alreadyfollow) {
        const upwardIsCompleted = $('#upward_progress'+code+activity_id).hasClass('completed');
        const treatedIsCompleted = $('#treated_progress'+code+activity_id).hasClass('completed');
        const acceptedComplete = $("#accepted_progress"+code+activity_id).hasClass('completed');
        console.log('accepted',acceptedComplete)
        if(alreadyTreated || alreadyfollow || treatedIsCompleted    ){// I am adding this condition for consultation tracking icon condition
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been followed or treated!"
                });
        }else if(!acceptedComplete){
            Lobibox.alert("error",
                {
                    msg: "You cannot Consult unless the user accept your Appointment!"
                });
        }
        else if(alreadyReferred || alreadyupward || upwardIsCompleted ){// I am adding this condition for consultation tracking icon condition
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been Upward or Refferred!"
                });
        }else{
            var url = "<?php echo asset('api/video/call'); ?>";
            var json = {
                "_token" : "<?php echo csrf_token(); ?>",
                "tracking_id" : tracking_id,
                "code" : code,
                "action_md" : action_md ? action_md : $("#accepted_progress"+code+activity_id).attr("data-actionmd"),
                "referring_md" : referring_md,
                "trigger_by" : "{{ $user->id }}",
                "form_type" : form_tpe,
                "activity_id" : activity_id,
                "referred_to" : referred_to
            };
            $.post(url,json,function(){});
            var windowName = 'NewWindow'; // Name of the new window
            var windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
            var newWindow = window.open("{{ asset('doctor/telemedicine?id=') }}"+tracking_id+"&code="+code+"&form_type="+form_tpe+"&referring_md=yes&activity_id="+activity_id, windowName, windowFeatures);
            if (newWindow && newWindow.outerWidth) {
                // If the window was successfully opened, attempt to maximize it
                newWindow.moveTo(0, 0);
                newWindow.resizeTo(screen.availWidth, screen.availHeight);
            }

        }

    }

    function telemedicinePrescription(track_id, activity_id, referred_code, referred_id) {
        const prescriptionIsCompleted = $('#prescribed_progress'+referred_code+referred_id).hasClass('completed');
        const url = "{{ asset('doctor/print/prescription') }}";
        if(activity_id) {
            window.open(`${url}/${track_id}/${activity_id}`);
        } else if(prescriptionIsCompleted) {
            window.open(`${url}/${track_id}/${referred_id}?prescription_new=true`);
        }
        else {
            Lobibox.alert("error",
            {
                msg: "No prescription has been created by the referred doctor"
            });
        }
    }

    function telemedicineLabResult(activity_id,lab_code) {
        const url = "{{ asset('api/check/labresult') }}";
        var json = {
            "activity_id" : activity_id
        };
  
        $.post(url,json,function(result) {
            if(result.id) {
                const pdf_url = "{{ asset('doctor/print/labresult') }}";
                window.open(`${pdf_url}/${activity_id}`);
            }else {
                Lobibox.alert("error",
                {
                    msg: "No lab request has been created by the referred doctor"
                });
            }
        });
    }

    function telemedicineEndPatient(alreadyTreated, alreadyReferred, alreadyFollowUp, alreadyEnd, code, referred_id) {
        const endIsCompleted = $('#end_progress'+code+referred_id).hasClass('completed');
        if(alreadyTreated && !alreadyReferred && !alreadyFollowUp && (!alreadyEnd || !endIsCompleted)) {
            Lobibox.confirm({
                msg: "Do you want to cycle end this patient?",
                callback: function ($this, type, ev) {
                    if(type === 'yes') {
                        var json = {
                            "_token" : "<?php echo csrf_token(); ?>",
                            "code" : code
                        };
                        var url = "<?php echo asset('api/video/end') ?>";
                        $.post(url,json,function(result){
                            if(result === 'success') {
                                Lobibox.alert("success",
                                    {
                                        msg: "The patient was successfully end cycle."
                                    });
                                $("#end_progress"+code+referred_id).addClass('completed');
                            }
                        })
                    }
                }
            });
        } else if(alreadyReferred) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been referred!"
                });
        } else if(alreadyFollowUp) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been follow up!"
                });
        }
        else if(alreadyEnd || endIsCompleted) {
            Lobibox.alert("error",
                {
                    msg: "This tracking area has already been end cycle!"
                });
        }
        else {
            Lobibox.alert("error",
                {
                    msg: "You can't end cycle a patient because the patient has not been examined."
                });
        }
    }

</script>

{{--Script for Call Button--}}
<script>
    $('body').on('click','.btn-call',function(){
        $('.loading').show();
        var action_md = $(this).data('action_md');
        var facility_name = $(this).data('facility_name');
        var activity_id = $(this).data('activity_id');
        var md_name = "{{ $user->fname }} {{ $user->mname }} {{ $user->lname }}";
        var div = $(this).parent().closest('.timeline-item');
        div.removeClass('normal-section').addClass('read-section');
        $(this).hide();
        div.find('.text-remarks').removeClass('hide').html('Remarks: Dr. '+md_name+' called '+facility_name);
        $.ajax({
            url: "{{ url('doctor/referral/call/') }}/" + activity_id,
            type: 'GET',
            success: function() {
                setTimeout(function(){
                    $('.loading').hide();
                },300);
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });
</script>

{{--script for refer to other facility--}}
<script>
    $('body').on('click','.btn-redirected',function(){
        console.log("redirected!");
        $("#redirected_code").val($(this).data('activity_code'));
    });
    $('body').on('submit','#redirectedForm',function(e){
        $("#redirected_submit").attr("disabled",true);
    });
    $('body').on('submit','#telemedicineRedirectedForm',function(e){
        $("#redirected_submit_telemedicine").attr("disabled",true);
    });
    $('body').on('submit','#telemedicineFollowupForm',function(e){
        $("#followup_submit_telemedicine").attr("disabled",true);
    });
</script>

{{--show and hide activity--}}
<script>
    $('ul.timeline li').not(":first-child").not(":nth-child(2)").hide();
    $('.btn-activity').on('click',function(){
        var item = $(this).parent().parent().parent().parent().parent().parent().find('li');
        item.not(":first-child").not(":nth-child(2)").toggle();
    });
//    $('ul.timeline li:first-child').on('click',function(){
//        var item = $(this).parent().find('li');
//        item.not(":first-child").not(":nth-child(2)").toggle();
//    });
</script>

@include('script.view_form')

{{--SEEN BY--}}
<script>
    $('body').on('click','.btn-seen',function(){
        var de = '<hr />\n' +
            '                    LOADING...\n' +
            '                    <br />\n' +
            '                    <br />';
        $('#seenBy_section').html(de);
        var id = $(this).data('id');
        var seenUrl = "{{ url('doctor/referral/seenBy/list/') }}/"+id;
        $.ajax({
            url: seenUrl,
            type: "GET",
            success: function(data){
                var content = '<div class="list-group">';
                jQuery.each(data, function(i,val){
                    content += '<a href="#" class="list-group-item clearfix">\n' +
                        '<strong class="text-green">Dr. '+val.user_md+'</strong>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Facility: <b>'+val.facility_name+'</b>\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Seen: <b>'+val.date_seen+'</b>\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Contact: <b>'+val.contact+'</b>\n' +
                        '</small>\n' +
                        '</a>';
                });
                content += '</div>';
                setTimeout(function () {
                    $('#seenBy_section').html(content);
                },500);
            },
            error: function () {
                $('#serverModal').modal('show');
            }
        });
    });

    $('body').on('click','.btn-caller',function(){
        var de = '<hr />\n' +
            '                    LOADING...\n' +
            '                    <br />\n' +
            '                    <br />';
        $('#callerBy_section').html(de);
        var id = $(this).data('id');
        var callerUrl = "{{ url('doctor/referral/callerBy/list/') }}/"+id;
        $.ajax({
            url: callerUrl,
            type: "GET",
            success: function(data){
                console.log(id);
                var content = '<div class="list-group">';

                jQuery.each(data, function(i,val){
                    content += '<a href="#" class="list-group-item clearfix">\n' +
                        '<span class="title-info">'+val.user_md+'</span>\n' +
                        '<br />\n' +
                        '<small class="text-primary">\n' +
                        'Time: '+val.date_call+'\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small class="text-success">\n' +
                        'Contact: '+val.contact+'\n' +
                        '</small>\n' +
                        '</a>';
                });
                content += '</div>';
                setTimeout(function () {
                    $('#callerBy_section').html(content);
                },500);
            },
            error: function () {
                $('#serverModal').modal('show');
            }
        });
    });
</script>

{{--CANCEL REFERRAL--}}
<script>
    $('body').on('click','.btn-cancel',function() {
        var id = $(this).data('id');
        var user = $(this).data('user');
        $("#cancelId").val(id);
        if(user === 'admin')
            $('#cancelAdmin').val(user);
        var url = "{{ url('doctor/referred/cancel') }}/"+id;
        $("#cancelReferralForm").attr('action',url);
    });
    $('#cancelReferralForm').on('submit', function(e) {
        $("#btn-cancel-submit").attr('disabled', true);
    });
    $('#undoCancelForm').on('submit', function(e) {
        $("#btn-undocancel-submit").attr('disabled', true);
    });
</script>