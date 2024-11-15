<?php
    $user = Illuminate\Support\Facades\Session::get('auth');
    $cacheBuster = time();
?>
<style>
    center-align {
        text-align: center;
    }


    .file_upload {
        background-color: #ffffff;
        width: 450px;
        margin: 0 auto;
        padding: 20px;
    }


    .file_upload_btn {
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


    .file_upload_btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }


    .file_upload_btn:active {
        border: 0;
        transition: all .2s ease;
    }


    .file_upload_content {
        display: none;
        text-align: center;
    }


    .file_upload_input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }


    .image_upload_wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }


    .image_dropping,
    .image_upload_wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }


    .image_title_wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }
/* for image and sign upload signature */
    section {
        display: flex;
        flex-flow: row wrap;
        justify-content: center; /* Center the buttons */
        gap: 10px;
    }
    section > div {
        padding: 0.5rem;
    }
    .radioSig {
        display: none;
        &:not(:disabled) ~ label {
            cursor: pointer;
        }
        &:disabled ~ label {
            color: hsla(150, 5%, 75%, 1);
            border-color: hsla(150, 5%, 75%, 1);
            box-shadow: none;
            cursor: not-allowed;
        }
    }
    .label-sign {
        height: 100px; /* Adjust the height */
        width: 200px;
        display: block;
        background: white;
        border: 2px solid hsla(150, 75%, 50%, 1);
        border-radius: 20px;
        padding: -1rem;
        margin-bottom: 1rem;
        margin: 1rem;
        text-align: center;
        box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
        position: relative;
    }


    input[type="radio"]:checked + .label-sign {
        /* background: hsla(150, 75%, 50%, 1); */
        background: #1ABC9C;
        color: hsla(215, 0%, 100%, 1);
        box-shadow: 0px 0px 20px hsla(150, 100%, 50%, 0.75);
        &::after {
            color: hsla(215, 5%, 25%, 1);
            font-family: FontAwesome;
            border: 2px solid hsla(150, 75%, 45%, 1);
            content: "\f00c";
            font-size: 24px;
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            height: 50px;
            width: 50px;
            line-height: 50px;
            text-align: center;
            border-radius: 50%;
            background: white;
            box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
        }
    }
    input[type="radio"]#control_05:checked + .label-sign {
        background: red;
        border-color: red;
    }


    @media only screen and (max-width: 500px) {
    section {
        flex-direction: column;
        align-items: center;
    }
    }
    /* end of image and sign upload */
</style>


<div class="modal fade" role="dialog" id="editProfileModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ asset('doctor/editProfile') }}" id="profile_Upload">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" class="user_id" name="id" value="{{ $user->id }}" />
                    <fieldset>
                        <legend><i class="fa fa-user-md"></i> Edit Profile</legend>
                    </fieldset>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span> <label for="fname">First Name:</label>
                                </div>
                                <input type="text" class="form-control fname" autofocus name="fname" value="{{ $user->fname }}" required>
                                <small class="form-text text-muted">Your given name (e.g., John).</small>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span><label for="mname"> Middle Name:</label>
                                </div>
                                <input type="text" class="form-control mname" name="mname" value="{{ $user->mname }}">
                                <small class="form-text text-muted">Your middle name (optional).</small>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span><label for="lname"> Last Name:</label>
                                </div>
                                <input type="text" class="form-control lname" name="lname" value="{{ $user->lname }}" required>
                                <small class="form-text text-muted">Your surname or family name.</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phon"></i></span> <label for="contact">Contact Number:</label>
                                </div>
                            </div>
                            <input type="text" class="form-control contact" name="contact" value="{{ $user->contact }}" required >
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span><label for="email"> Email Address:</label>
                                </div>
                            </div>
                            <input type="text" class="form-control email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-md-4">                          
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-briefcase"></i></span><label for="designation"> Designation:</label>
                                </div>
                            </div>
                            <input type="text" class="form-control designation" name="designation" value="{{ $user->designation }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span><label for="license"> License No.:</label>
                                </div>
                            </div>
                            <input type="text" class="form-control license" name="license" value="{{ $user->license }}" autocomplete="license">
                        </div>
                    </div>
                    <div>
                        <div class="input-group-prepend">
                            <span class="input-group-text"></span> <label for="Privacy">Privacy Policy</label>
                        </div>
                        <div id="privacy-policy-container" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                            <p>This Privacy Policy will enable you to better understand how DOHCVCHD collects, processes, retains and uses your data. We hope you read through the policy. Statement of Policy The DOHCVCHD is the regional arm in Central Visayas of the Department of Health. It is the principal health agency in the country and is responsible for the enforcement of laws on health, ensuring access to basic public health services and quality health care, and regulation of health facilities, goods and services.</p>
                            <p>Guided by the Data Privacy Principles, we collect, process, retain, use and share your data when you visit our office premises, avail of our services and systems, file for applications/renewals, submit requests and inquiries, lodge complaints, or when it is necessary in the performance of our statutory and regulatory mandates, including the operation of health information services, and implementation of disease surveillance and response initiatives, among others, subject to your consent or when expressly allowed by law.</p>
                            <p>The DOHCVCHD faithfully adheres to the requirements of the Data Privacy Act, its implementing rules, and the regulations promulgated by the National Privacy Commission. We highly value the security of your data and your rights as data subjects.</p>
                            <p>Collection and Use of Data</p>
                            <p>Data is collected when the DOHCVCHD performs its governmental functions such as, but not limited to, provision of technical assistance to government and private partners, disease surveillance and health events response per Republic Act No. 11332 and related statutes, management of public health information systems, enforcement of regulatory authority (e.g. receipt of applications of health facilities), handling of complaints, and operations of health and laboratory services. Data is also collected when you avail of our programs and services such as the E-health Referral System and the DOHCVCHD Telemedicine, provided you have granted your consent.</p>
                            <p>Data Retention, Protection and Disposition</p>
                            <p>For the services and systems available to the public, the DOHCVCHD may necessarily store and retain your data as part of its inherent and operational functions, without prejudice to the enforcement of the relevant rights of data subjects. </p>
                            <p>Data collected are retained depending on the nature of the data being handled. Physical data are retained by the respective end-users or program managers through proper record filing and keeping. Electronic data which passes through online systems are saved in our local and cloud servers using encryption, firewall, or similar security features. It may also require entering a One-Time Password (OTP) as an added layer of protection. Access to these data is granted only to select personnel, all of whom are required to execute a Non-Disclosure Agreement.</p>
                            <p>The DOHCVCHD does not warrant a foolproof or 100% breach-free data system. However, it commits to continually update its security features, review existing data protection policies, coordinate with the NPC for any data incidents, and keep you informed in all stages.</p>
                            <p>The data subject may request for the deletion of his/her data, subject to the provisions of the data privacy act. As such, upon the data subject’s request or when necessitated by the circumstances, the DOHCVCHD shall fully dispose of the data retained in the most prompt manner. The length of time in the retention and subsequent disposition of data, as the case may be, shall be in accordance with the records retention and disposition schedule of the National Archives of the Philippines and pertinent internal office protocols, taking into account the legitimate purpose(s) of the collection. When applicable, data shall be returned to the data owners. At all times, the data subject shall be informed that the data has been deleted and disposed of by issuing a certification to such effect. </p>
                            <p>Data Subject's Rights</p>
                            <p>Pursuant to the DPA, the data subject is entitled to the following rights: </p>
                            <p>Right to be informed.
                                The data subject has a right to be informed whether personal data pertaining to him or her shall be, are being, or have been processed, including the existence of automated decision-making and profiling.
                                The data subject shall be notified and furnished with information indicated hereunder before the entry of his or her personal data into the processing system of the personal information controller, or at the next practical opportunity:
                                Description of the personal data to be entered into the system
                                Purposes for which they are being or will be processed, including processing for direct marketing, profiling or historical, statistical or scientific purpose;
                                Basis of processing, when processing is not based on the consent of the data subject;
                                Scope and method of the personal data processing;
                                Methods utilized for automated access, if the same is allowed by the data subject, and the extent to which such access is authorized, including meaningful information about the logic involved, as well as the significance and the envisaged consequences of such processing for the data subject;
                                The identity and contact details of the personal data controller or its representative;
                                The period for which the information will be stored; and
                                The existence of their rights as data subjects, including the right to access, correction, and object to the processing, as well as the right to lodge a complaint before the Commission.
                                Right to object. The data subject shall have the right to object to the processing of his or her personal data, including processing for direct marketing, automated processing or profiling. The data subject shall also be notified and given an opportunity to withhold consent to the processing in case of changes or any amendment to the information supplied or declared to the data subject in the preceding paragraph.
                            </p>
                        </div>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" id="terms" value="accepted" {{ old('terms') ? 'checked' : '' }}>
                             <a>I Agree.</a>
                        </label>
                    </div>


                    @if($user->level == "doctor")
                        <div class="form-group">
                            <label for="signature"><i class="fa fa-pencil"></i> Signature:</label>
                            <input type="hidden" name="signature" id="signature_final" value="">
                            <input type="hidden" name="sign_type" id="sign_type" value="">
                            <div class="text-center" id="signature_field">
                            @if(isset($user->signature) && $user->signature != null)


                                <img src="{{ asset($user->signature.'?cache='.$cacheBuster) }}" id="stored_sign"  width="408" height="245" style="border: 1px solid black;"><br><br>
                                <input class="btn btn-info btn-flat" id="sign_draw" value="Replace Signature" readonly onclick="replaceSignature()">
                            @else                            
                               
                                <section>
                                   
                                    <div>
                                        <input type="radio" class="btn btn-success btn-flat radioSig" name="choose" id="sign_upload" value="Upload Image" readonly onclick="setTimeout(showUploadField, 2000)">
                                        <label for="sign_upload" class="label-sign">
                                            <h3>Upload Image</h3>
                                            <p>Signature</p>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" class="btn btn-info btn-flat radioSig" name="choose" id="sign_draw" value="Draw" readonly onclick="setTimeout(showDrawField, 2000)">
                                        <label for="sign_draw" class="label-sign">
                                            <h3>Draw</h3>
                                            <p>Signature</p>
                                        </label>
                                    </div>
                                </section>
                                    <div id="signature_choice"></div>
                            @endif
                            </div>
                        </div>
                    @endif
                    <!-- <hr /> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" onclick="resetSignatureField()"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-info btn-sm" id="update_btn"><i class="fa fa-pencil"></i> Update</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{--<script src="https://www.marvinj.org/releases/marvinj-1.0.js"></script> NOT USED--}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var termsCheckbox = document.getElementById('terms');
        var signature_field = document.getElementById('signature_field');


        // Initially hide or show the signature section based on checkbox state
            if (termsCheckbox.checked) {
                signature_field.style.display = 'block';
        } else {
                signature_field.style.display = 'none';
        }


        // Add event listener to the checkbox to show/hide signature section
        termsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                    signature_field.style.display = 'block';
            } else {
                    signature_field.style.display = 'none';
            }
        });
    });


    var signaturePad, sign_type, finalImage;


    $('#update_btn').on('click', function(e) {  
        e.preventDefault();
        $('#stored_sign').src = null;
        $('.loading').show();
     
        if(sign_type === "upload") {
            $('#signature_final').val(finalImage);
            $('#sign_type').val(sign_type);
        } else if(sign_type === "draw") {
            var data = signaturePad.toDataURL('image/png');
            $('#signature_final').val(data);
            $('#sign_type').val(sign_type);
        }
        $('#profile_Upload').submit();
    });


    function replaceSignature() {
       
        $('#signature_field').html(
            //'<input class="btn btn-success btn-flat" id="sign_upload" value="Upload Image" readonly onclick="showUploadField()">&emsp;&emsp;&emsp;\n' +
            //'<input class="btn btn-info btn-flat" id="sign_draw" value="Draw" readonly onclick="showDrawField()">'
            `
             <section>                    
                <div>
                    <input type="radio" class="btn btn-success btn-flat radioSig" name="choose" id="sign_upload" value="Upload Image" readonly onclick="setTimeout(showUploadField, 2000)">
                    <label for="sign_upload" class="label-sign">
                        <h3>Upload Image</h3>
                        <p>Signature</p>
                    </label>
                </div>
                <div>
                    <input type="radio" class="btn btn-info btn-flat radioSig" name="choose" id="sign_draw" value="Draw" readonly onclick="setTimeout(showDrawField, 2000)">
                    <label for="sign_draw" class="label-sign">
                        <h3>Draw</h3>
                        <p>Signature</p>
                    </label>
                </div>
            </section>
                <div id="signature_choice"></div>
            `
        )
    }


    function resetSignatureField(){
        $('#stored_sign').src = null;
        var esign = '{{ $user->signature }}';
        if(esign !== null && esign !== '') {
            $('#signature_field').html(
                '<img src="{{ asset($user->signature) }}" style="border: 1px solid black;"><br><br>\n' +
                '<input class="btn btn-info btn-flat" id="sign_draw" value="Replace Signature" readonly onclick="showDrawField()">'
            );
        } else {
            $('#signature_field').html(
              ` <section>
                    <div>
                        <input type="radio" class="btn btn-success btn-flat radioSig" name="choose" id="sign_upload" value="Upload Image" readonly onclick="setTimeout(showUploadField, 2000)">
                        <label for="sign_upload" class="label-sign">
                            <h2>Upload Image</h2>
                            <p>Signature</p>
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn btn-info btn-flat radioSig" name="choose" id="sign_draw" value="Draw" readonly onclick="setTimeout(showDrawField, 2000)">
                        <label for="sign_draw" class="label-sign">
                            <h2>Draw</h2>
                            <p>Signature</p>
                        </label>
                    </div>
                </section>`
            );
        }
    }


    function showUploadField(){
        sign_type = "upload";
        console.log('sign_type::',sign_type)
        var src = '{{ asset('resources/img/add_file.png') }}';
        $('#signature_choice').html(
            '<div class="file_upload">\n' +
            '   <div class="text-center image_upload_wrap" id="image_upload_wrap">\n' +
            '       <input class="file_upload_input files" id="file_upload_input" type="file" onchange="readFile(this);" accept="image/png, image/jpeg, image/jpg"/>\n' +
            '       <img src="'+src+'" style="width: 30%; height: 30%;">\n' +
            '   </div>\n' +
            '   <div class="file_upload_content" id="file_upload_content">\n' +
            '       <canvas width="408" height="245" style="border: 1px solid black" id="file_upload_image"/></canvas><br><br><br>\n' +
            '   </div>\n' +
            '</div><br><br>'
            /*'<button type="button" class="btn btn-md btn-danger" id="remove_signature" onclick="removeSign(\'upload\')">Remove Signature</button><br><br>' */
            /* '<input class="btn btn-info btn-flat" id="sign_draw" value="Draw" onclick="showDrawField()" readonly>'*/
        );
        $('#remove_signature').hide();
    }


    function readFile(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if(file && file !== null) {
                var reader = new FileReader();
                reader.onloadend = function(e) {
                   $('#file_upload_image').attr('src', e.target.result);
                   $('#tempo').attr('src',e.target.result);
                    filterImage(e.target.result);
                };
                $('#image_upload_wrap').hide();
                $('#file_upload_content').show();
                reader.readAsDataURL(file);
            }
        }
        $('#remove_signature').show();
    }


    function filterImage(imgSrc) {
        var canvas = document.getElementById("file_upload_image"),
            ctx = canvas.getContext("2d");
           
        var img = new Image();
        img.onload = function() {
            ctx.drawImage(img,0,0,canvas.width, canvas.height);
            console.log("canvas width:",canvas.width, canvas.height);
            var imgd = ctx.getImageData(0, 0, canvas.width, canvas.height),
                pix = imgd.data,
                newColor = {r:0,g:0,b:0, a:0};


            for (var i = 0, n = pix.length; i <n; i += 4) {
                var r = pix[i],
                    g = pix[i+1],
                    b = pix[i+2];


                if(r == 255 && g == 255 && b == 255){
                    // Change the white to the new color.
                    pix[i] = newColor.r;
                    pix[i+1] = newColor.g;
                    pix[i+2] = newColor.b;
                    pix[i+3] = newColor.a;
                }
            }


            ctx.putImageData(imgd, 0, 0);
            var final = new Image();
            final.src = canvas.toDataURL();
            console.log(final);
        };
        img.src = imgSrc;
        finalImage = img.src;
    }


    function showDrawField() {
        sign_type = "draw";
        $('#signature_choice').html(
            '<canvas class="canvas_sign" style="border: 2px solid black;" width="450" height="200" id="signature-pad"></canvas><br><br>' +
            '<button type="button" class="btn btn-md btn-danger" id="remove_signature" onclick="removeSign(\'draw\')">Remove Signature</button><br><br>'
          /* '<input class="btn btn-success btn-flat" id="sign_upload" value="Upload Image" readonly onclick="showUploadField()">' */
        );
        triggerDraw();
    }


    function removeSign(type) {
        $('#remove_signature').hide();
        if(type === 'upload')
            showUploadField();
        else if(type === 'draw')
            showDrawField();
    }


    function triggerDraw() {
        var SignaturePad = (function(document) {
            "use strict";


            var SignaturePad = function(canvas, options) {
                var self = this,
                    opts = options || {};


                this.velocityFilterWeight = opts.velocityFilterWeight || 0.7;
                this.minWidth = opts.minWidth || 0.5;
                this.maxWidth = opts.maxWidth || 2.5;
                this.dotSize = opts.dotSize || function() {
                    return (self.minWidth + self.maxWidth) / 2;
                };
                this.penColor = opts.penColor || "black";
                this.backgroundColor = opts.backgroundColor || "rgba(0,0,0,0)";
                this.throttle = opts.throttle || 0;
                this.throttleOptions = {
                    leading: true,
                    trailing: true
                };
                this.minPointDistance = opts.minPointDistance || 0;
                this.onEnd = opts.onEnd;
                this.onBegin = opts.onBegin;


                this._canvas = canvas;
                this._ctx = canvas.getContext("2d");
                this._ctx.lineCap = 'round';
                this.clear();


                // we need add these inline so they are available to unbind while still having
                //  access to 'self' we could use _.bind but it's not worth adding a dependency
                this._handleMouseDown = function(event) {
                    if (event.which === 1) {
                        self._mouseButtonDown = true;
                        self._strokeBegin(event);
                    }
                };


                var _handleMouseMove = function(event) {
                    event.preventDefault();
                    if (self._mouseButtonDown) {
                        self._strokeUpdate(event);
                        if (self.arePointsDisplayed) {
                            var point = self._createPoint(event);
                            self._drawMark(point.x, point.y, 5);
                        }
                    }
                };


                this._handleMouseMove = _.throttle(_handleMouseMove, self.throttle, self.throttleOptions);
                //this._handleMouseMove = _handleMouseMove;


                this._handleMouseUp = function(event) {
                    if (event.which === 1 && self._mouseButtonDown) {
                        self._mouseButtonDown = false;
                        self._strokeEnd(event);
                    }
                };


                this._handleTouchStart = function(event) {
                    if (event.targetTouches.length == 1) {
                        var touch = event.changedTouches[0];
                        self._strokeBegin(touch);
                    }
                };


                var _handleTouchMove = function(event) {
                    // Prevent scrolling.
                    event.preventDefault();


                    var touch = event.targetTouches[0];
                    self._strokeUpdate(touch);
                    if (self.arePointsDisplayed) {
                        var point = self._createPoint(touch);
                        self._drawMark(point.x, point.y, 5);
                    }
                };
                this._handleTouchMove = _.throttle(_handleTouchMove, self.throttle, self.throttleOptions);
                //this._handleTouchMove = _handleTouchMove;


                this._handleTouchEnd = function(event) {
                    var wasCanvasTouched = event.target === self._canvas;
                    if (wasCanvasTouched) {
                        event.preventDefault();
                        self._strokeEnd(event);
                    }
                };


                this._handleMouseEvents();
                this._handleTouchEvents();
            };


            SignaturePad.prototype.clear = function() {
                var ctx = this._ctx,
                    canvas = this._canvas;


                ctx.fillStyle = this.backgroundColor;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                this._reset();
            };


            SignaturePad.prototype.showPointsToggle = function() {
                this.arePointsDisplayed = !this.arePointsDisplayed;
            };


            SignaturePad.prototype.toDataURL = function(imageType, quality) {
                var canvas = this._canvas;
                return canvas.toDataURL.apply(canvas, arguments);
            };


            SignaturePad.prototype.fromDataURL = function(dataUrl) {
                var self = this,
                    image = new Image(),
                    ratio = window.devicePixelRatio || 1,
                    width = this._canvas.width / ratio,
                    height = this._canvas.height / ratio;


                this._reset();
                image.src = dataUrl;
                image.onload = function() {
                    self._ctx.drawImage(image, 0, 0, width, height);
                };
                this._isEmpty = false;
            };


            SignaturePad.prototype._strokeUpdate = function(event) {
                var point = this._createPoint(event);
                if(this._isPointToBeUsed(point)){
                    this._addPoint(point);
                }
            };


            var pointsSkippedFromBeingAdded = 0;
            SignaturePad.prototype._isPointToBeUsed = function(point) {
                // Simplifying, De-noise
                if(!this.minPointDistance)
                    return true;


                var points = this.points;
                if(points && points.length){
                    var lastPoint = points[points.length-1];
                    if(point.distanceTo(lastPoint) < this.minPointDistance){
                        // log(++pointsSkippedFromBeingAdded);
                        return false;
                    }
                }
                return true;
            };


            SignaturePad.prototype._strokeBegin = function(event) {
                this._reset();
                this._strokeUpdate(event);
                if (typeof this.onBegin === 'function') {
                    this.onBegin(event);
                }
            };


            SignaturePad.prototype._strokeDraw = function(point) {
                var ctx = this._ctx,
                    dotSize = typeof(this.dotSize) === 'function' ? this.dotSize() : this.dotSize;


                ctx.beginPath();
                this._drawPoint(point.x, point.y, dotSize);
                ctx.closePath();
                ctx.fill();
            };


            SignaturePad.prototype._strokeEnd = function(event) {
                var canDrawCurve = this.points.length > 2,
                    point = this.points[0];


                if (!canDrawCurve && point) {
                    this._strokeDraw(point);
                }
                if (typeof this.onEnd === 'function') {
                    this.onEnd(event);
                }
            };


            SignaturePad.prototype._handleMouseEvents = function() {
                this._mouseButtonDown = false;


                this._canvas.addEventListener("mousedown", this._handleMouseDown);
                this._canvas.addEventListener("mousemove", this._handleMouseMove);
                document.addEventListener("mouseup", this._handleMouseUp);
            };


            SignaturePad.prototype._handleTouchEvents = function() {
                // Pass touch events to canvas element on mobile IE11 and Edge.
                this._canvas.style.msTouchAction = 'none';
                this._canvas.style.touchAction = 'none';


                this._canvas.addEventListener("touchstart", this._handleTouchStart);
                this._canvas.addEventListener("touchmove", this._handleTouchMove);
                this._canvas.addEventListener("touchend", this._handleTouchEnd);
            };


            SignaturePad.prototype.on = function() {
                this._handleMouseEvents();
                this._handleTouchEvents();
            };


            SignaturePad.prototype.off = function() {
                this._canvas.removeEventListener("mousedown", this._handleMouseDown);
                this._canvas.removeEventListener("mousemove", this._handleMouseMove);
                document.removeEventListener("mouseup", this._handleMouseUp);


                this._canvas.removeEventListener("touchstart", this._handleTouchStart);
                this._canvas.removeEventListener("touchmove", this._handleTouchMove);
                this._canvas.removeEventListener("touchend", this._handleTouchEnd);
            };


            SignaturePad.prototype.isEmpty = function() {
                return this._isEmpty;
            };


            SignaturePad.prototype._reset = function() {
                this.points = [];
                this._lastVelocity = 0;
                this._lastWidth = (this.minWidth + this.maxWidth) / 2;
                this._isEmpty = true;
                this._ctx.fillStyle = this.penColor;
            };


            SignaturePad.prototype._createPoint = function(event) {
                var rect = this._canvas.getBoundingClientRect();
                return new Point(
                    event.clientX - rect.left,
                    event.clientY - rect.top
                );
            };


            SignaturePad.prototype._addPoint = function(point) {
                var points = this.points,
                    c2, c3,
                    curve, tmp;


                points.push(point);


                if (points.length > 2) {
                    // To reduce the initial lag make it work with 3 points
                    // by copying the first point to the beginning.
                    if (points.length === 3) points.unshift(points[0]);


                    tmp = this._calculateCurveControlPoints(points[0], points[1], points[2]);
                    c2 = tmp.c2;
                    tmp = this._calculateCurveControlPoints(points[1], points[2], points[3]);
                    c3 = tmp.c1;
                    curve = new Bezier(points[1], c2, c3, points[2]);
                    this._addCurve(curve);


                    // Remove the first element from the list,
                    // so that we always have no more than 4 points in points array.
                    points.shift();
                }
            };


            SignaturePad.prototype._calculateCurveControlPoints = function(s1, s2, s3) {
                var dx1 = s1.x - s2.x,
                    dy1 = s1.y - s2.y,
                    dx2 = s2.x - s3.x,
                    dy2 = s2.y - s3.y,


                    m1 = {
                        x: (s1.x + s2.x) / 2.0,
                        y: (s1.y + s2.y) / 2.0
                    },
                    m2 = {
                        x: (s2.x + s3.x) / 2.0,
                        y: (s2.y + s3.y) / 2.0
                    },


                    l1 = Math.sqrt(1.0 * dx1 * dx1 + dy1 * dy1),
                    l2 = Math.sqrt(1.0 * dx2 * dx2 + dy2 * dy2),


                    dxm = (m1.x - m2.x),
                    dym = (m1.y - m2.y),


                    k = l2 / (l1 + l2),
                    cm = {
                        x: m2.x + dxm * k,
                        y: m2.y + dym * k
                    },


                    tx = s2.x - cm.x,
                    ty = s2.y - cm.y;


                return {
                    c1: new Point(m1.x + tx, m1.y + ty),
                    c2: new Point(m2.x + tx, m2.y + ty)
                };
            };


            SignaturePad.prototype._addCurve = function(curve) {
                var startPoint = curve.startPoint,
                    endPoint = curve.endPoint,
                    velocity, newWidth;


                velocity = endPoint.velocityFrom(startPoint);
                velocity = this.velocityFilterWeight * velocity +
                    (1 - this.velocityFilterWeight) * this._lastVelocity;


                newWidth = this._strokeWidth(velocity);
                this._drawCurve(curve, this._lastWidth, newWidth);


                this._lastVelocity = velocity;
                this._lastWidth = newWidth;
            };


            SignaturePad.prototype._drawPoint = function(x, y, size) {
                var ctx = this._ctx;


                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                this._isEmpty = false;
            };


            SignaturePad.prototype._drawMark = function(x, y, size) {
                var ctx = this._ctx;


                ctx.save();
                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'rgba(255, 0, 0, 0.2)';
                ctx.fill();
                ctx.restore();
            };


            SignaturePad.prototype._drawCurve = function(curve, startWidth, endWidth) {
                var ctx = this._ctx,
                    widthDelta = endWidth - startWidth,
                    drawSteps, width, i, t, tt, ttt, u, uu, uuu, x, y;


                drawSteps = Math.floor(curve.length());
                ctx.beginPath();
                for (i = 0; i < drawSteps; i++) {
                    // Calculate the Bezier (x, y) coordinate for this step.
                    t = i / drawSteps;
                    tt = t * t;
                    ttt = tt * t;
                    u = 1 - t;
                    uu = u * u;
                    uuu = uu * u;


                    x = uuu * curve.startPoint.x;
                    x += 3 * uu * t * curve.control1.x;
                    x += 3 * u * tt * curve.control2.x;
                    x += ttt * curve.endPoint.x;


                    y = uuu * curve.startPoint.y;
                    y += 3 * uu * t * curve.control1.y;
                    y += 3 * u * tt * curve.control2.y;
                    y += ttt * curve.endPoint.y;


                    width = startWidth + ttt * widthDelta;
                    this._drawPoint(x, y, width);
                }
                ctx.closePath();
                ctx.fill();
            };


            SignaturePad.prototype._strokeWidth = function(velocity) {
                return Math.max(this.maxWidth / (velocity + 1), this.minWidth);
            };


            var Point = function(x, y, time) {
                this.x = x;
                this.y = y;
                this.time = time || new Date().getTime();
            };


            Point.prototype.velocityFrom = function(start) {
                return (this.time !== start.time) ? this.distanceTo(start) / (this.time - start.time) : 1;
            };


            Point.prototype.distanceTo = function(start) {
                return Math.sqrt(Math.pow(this.x - start.x, 2) + Math.pow(this.y - start.y, 2));
            };


            var Bezier = function(startPoint, control1, control2, endPoint) {
                this.startPoint = startPoint;
                this.control1 = control1;
                this.control2 = control2;
                this.endPoint = endPoint;
            };


            // Returns approximated length.
            Bezier.prototype.length = function() {
                var steps = 10,
                    length = 0,
                    i, t, cx, cy, px, py, xdiff, ydiff;


                for (i = 0; i <= steps; i++) {
                    t = i / steps;
                    cx = this._point(t, this.startPoint.x, this.control1.x, this.control2.x, this.endPoint.x);
                    cy = this._point(t, this.startPoint.y, this.control1.y, this.control2.y, this.endPoint.y);
                    if (i > 0) {
                        xdiff = cx - px;
                        ydiff = cy - py;
                        length += Math.sqrt(xdiff * xdiff + ydiff * ydiff);
                    }
                    px = cx;
                    py = cy;
                }
                return length;
            };


            Bezier.prototype._point = function(t, start, c1, c2, end) {
                return start * (1.0 - t) * (1.0 - t) * (1.0 - t) +
                    3.0 * c1 * (1.0 - t) * (1.0 - t) * t +
                    3.0 * c2 * (1.0 - t) * t * t +
                    end * t * t * t;
            };


            return SignaturePad;
        })(document);
        signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)',
            velocityFilterWeight: .7,
            minWidth: 0.5,
            maxWidth: 2.5,
            throttle: 16, // max x milli seconds on event update, OBS! this introduces lag for event update
            minPointDistance: 3,
        });
    }
</script>

