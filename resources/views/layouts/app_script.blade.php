<script>
    tinymce.init({
        selector: ".mytextarea1",
        plugins: "emoticons autoresize",
        toolbar: "emoticons",
        toolbar_location: "bottom",
        menubar: false,
        statusbar: false
    });
    $(".select2").select2({ width: '100%' });

    var path_gif = "<?php echo asset('resources/img/loading.gif'); ?>";
    var loading = '<center><img src="'+path_gif+'" alt=""></center>';

    var urlParams = new URLSearchParams(window.location.search);
    var query_string_search = urlParams.get('search') ? urlParams.get('search') : '';
    var query_string_date_range = urlParams.get('date_range') ? urlParams.get('date_range') : '';
    var query_string_typeof_vaccine = urlParams.get('typeof_vaccine_filter') ? urlParams.get('typeof_vaccine_filter') : '';
    var query_string_muncity = urlParams.get('muncity_filter') ? urlParams.get('muncity_filter') : '';
    var query_string_facility = urlParams.get('facility_filter') ? urlParams.get('facility_filter') : '';
    var query_string_department = urlParams.get('department_filter') ? urlParams.get('department_filter') : '';
    var query_string_option = urlParams.get('option_filter') ? urlParams.get('option_filter') : '';

    $(".pagination").children().each(function(index){
        var _href = $($(this).children().get(0)).attr('href');

        if(_href){
            _href = _href.replace("http:",location.protocol);
            $($(this).children().get(0)).attr('href',_href+'&search='+query_string_search+'&date_range='+query_string_date_range+'&typeof_vaccine_filter='+query_string_typeof_vaccine+'&muncity_filter='+query_string_muncity+'&facility_filter='+query_string_facility+'&department_filter='+query_string_department+'&option_filter='+query_string_option);
        }

    });

    function refreshPage(){
        <?php
        use Illuminate\Support\Facades\Route;
        $current_route = Route::getFacadeRoot()->current()->uri();
        ?>
        $('.loading').show();
        window.location.replace("<?php echo asset($current_route) ?>");
    }

    function loadPage(){
        $('.loading').show();
    }

    function openLogoutTime(){
        var login_time = "<?php echo date('H:i'); ?>";
        var logout_time = "<?php echo date('H:i',strtotime($logout_time)); ?>";
        var input_element = $("#input_time_logout");
        input_element.attr({
            "min" : login_time
        });
        input_element.val(logout_time);
    }

    // Set the date we're counting down to
    var countDownDate = new Date("{{ $logout_time }}").getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("logout_time").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("logout_time").innerHTML = "EXPIRED";
            window.location.replace("<?php echo asset('/logout') ?>");
        }
    }, 1000);

    @if(Session::get('logout_time'))
    Lobibox.notify('success', {
        title: "",
        msg: "Successfully set logout time",
        size: 'mini',
        rounded: true
    });
    <?php Session::put("logout_time",false); ?>
    @endif


    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        $('body,html').animate({
            scrollTop : 0 // Scroll to top of body
        }, 500);
    }

    $('.select_facility').on('change',function() {
        var id = $(this).val();
        referred_facility = id;
        if(referred_facility){
            var url = "{{ url('location/facility/') }}";
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(data){
                    $('.facility_address').html(data.address);
                    $('.select_department').empty()
                        .append($('<option>', {
                            value: '',
                            text : 'Select Department...'
                        }));
                    jQuery.each(data.departments, function(i,val){
                        $('.select_department').append($('<option>', {
                            value: val.id,
                            text : val.description
                        }));
                    });
                    facilityForTelemedicine(data.departments);
                },
                error: function(error){
                    $('#serverModal').modal();
                }
            });
        }
    });

    function facilityForTelemedicine(departments) {
        const telemedicine = parseInt($(".telemedicine").val());
        const checkOPD = departments.find(obj => obj.id === 5);
        if(telemedicine && !checkOPD) {
            Lobibox.alert("error", {
                msg: "This facility is not allowed to perform telemedicine because there is no doctor assigned to the OPD department. Please call this facility for verification."
            });
            const select_facility = $('.select_facility');
            select_facility.val(select_facility.find('option:first').val()).trigger('change');

            const select_department = $('.select_department');
            select_department.empty().append($('<option>', {
                value: '',
                text : 'Select Department...'
            })).trigger('change');
        }
        else if(telemedicine && checkOPD) {
            const select_department = $('.select_department');
            select_department.empty().append($('<option>', {
                value: '5',
                text : 'OPD'
            })).trigger('change');
        }
    }


    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
    }

    function getCookie(name) {
        const keyValue = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function generateAppointmentKey(length) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let key = '';

        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            key += characters.charAt(randomIndex);
        }

        return key;
    }

</script>