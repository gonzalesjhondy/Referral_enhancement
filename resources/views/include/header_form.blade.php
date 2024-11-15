<center>
    <div class="web-view">
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-2">
                <img src="{{ asset('resources/img/doh.png') }}" width="100">
            </div>
            <div class="col-md-8">
                <div class="align small-text" style="font-size: 10pt;width:100%;">
                    Republic of the Philippines<br>
                    DEPARTMENT OF HEALTH<br>
                    <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                    Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                    Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                    Official Website: <a href="http://www.ro7.doh.gov.ph" target="_blank">http://www.ro7.doh.gov.ph</a> Email Address: dohro7@gmail.com<br>
                </div>
            </div>
            <div class="col-md-2">
                @if($form->code)
                    <script src="{{ asset('public/js/app_qr_'.$optionHeader.'.js?version='.date('YmdHis')) }}" defer></script>
                    <div id="app_qr_{{ $optionHeader }}">
                        <qr-app :patient_code="'{{ $form->code }}'" :telemedicine="{{ $form->telemedicine }}"></qr-app>
                    </div>
                @endif
            </div>
        </div>
        <h3 class="text-green clinical-form-title" style="font-size: 23pt;"><!-- TITLE HERE IS APPENDED FROM JQUERY--></h3>
    </div>
    <div class="mobile-view">
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-4">
                <img class="pull-left" src="{{ asset('resources/img/doh.png') }}" width="50">
                <img class="pull-right" src="{{ asset('resources/img/f1.jpg') }}" width="50">
            </div>
            <div class="col-md-8">
                <div class="align small-text" style="font-size: 11pt;">
                    Republic of the Philippines<br>
                    DEPARTMENT OF HEALTH<br>
                    <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                    Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                    Regional Director’s Office Tel. No. (032) 253-6355 <br> Fax No. (032) 254-0109<br>
                    Official Website: <a href="http://www.ro7.doh.gov.ph" target="_blank">http://www.ro7.doh.gov.ph</a><br>
                    Email Address: dohro7@gmail.com<br>
                </div>
            </div>
        </div>
        <h3 class="text-green clinical-form-title" style="font-size: 18pt;"><!-- TITLE HERE IS APPENDED FROM JQUERY--></h3>
    </div>
</center>
