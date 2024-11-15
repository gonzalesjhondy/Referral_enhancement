<script>
    //var objDiv = document.getElementById("feedback-181105-023-134025");
    <?php $user = \Illuminate\Support\Facades\Session::get('auth'); ?>
    var code = 0;
    //var feedbackRef = dbRef.ref('Feedback');
    var last_id = 0;

    $('.btn-feedback').on('click',function () {
        console.log("feedback");
        code = $(this).data('code');
        $('.feedback_code').html(code);
        $('.direct-chat-messages').attr('id',code);
        $('#message').addClass("message input-"+code+"-{{ $user->id }}");

        $("#"+code).html("Loading...");
        var url = "<?php echo asset('doctor/feedback').'/'; ?>"+code;
        $.get(url,function(data){
            setTimeout(function(){
                $("#"+code).html(data);
                scrolldownFeedback(code);
            },500);
        });

        $("#current_code").val(code);
    });

    function scrolldownFeedback(code){
        console.log(code);
        var objDiv = document.getElementById(code);

        setTimeout(function () {
            objDiv.scrollTop = objDiv.scrollHeight;
        },500);
    }

    function reloadMessage() {
        $("#message").val('').focus();
        $("#"+code).html("Loading...");
        $("#"+code).load("{{ url('doctor/feedback/') }}/"+code);
        $("#current_code").val(code);

        scrolldownFeedback(code);
    }

    function viewReco(data) {
        code = data.data("code");
        console.log("viewRecos");

        var reco_seen_url = "<?php echo asset('reco/seen1').'/'; ?>"+code;
        $.get(reco_seen_url,function(){ });

        $('#feedbackModal').bind('shown', function() {
            $('textarea.mytextarea1').tinymce({

            });
            console.log("wew")
        });

        $('.feedback_code').html(code);
        $('.direct-chat-messages').attr('id',code);
        $('#message').addClass("message input-"+code+"-{{ $user->id }}");

        $("#"+code).html("Loading...");
        var url = "<?php echo asset('doctor/feedback').'/'; ?>"+code;
        $.get(url,function(data){
            setTimeout(function(){
                $("#"+code).html(data);
                scrolldownFeedback(code);
            },500);
        });

        $("#current_code").val(code);
    }

    $('.btn-doh').on('click',function () {
        console.log('doh');
        code = $(this).data('code');
        $('.feedback_monitoring_code').html(code);
        $("#doh_monitoring").html("Loading....");
        var url = "<?php echo asset('monitoring/feedback').'/'; ?>"+code;
        $.get(url,function(data){
            setTimeout(function(){
                $("#doh_monitoring").html(data);
            },500);
        });
    });

    $('#feedbackForm').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        tinyMCE.triggerSave();
        var str = $(".mytextarea1").val();
        str = str.replace(/^\<p\>/,"").replace(/\<\/p\>$/,"");
        console.log("feedback_sendsd");
        if(str) {
            tinyMCE.activeEditor.setContent('');
            const senderImager = "{{ asset("/resources/img/sender.png") }}";
            const senderMessage = str;
            const senderCurrentTime = moment().format('D MMM LT');
            const senderFacility = "{{ \App\Facility::find($user->facility_id)->name }}";
            const senderName = "{{ $user->fname.' '.$user->lname }}";
            const recoAppend = '<div class="direct-chat-msg right">\n' +
                '    <div class="direct-chat-info clearfix">\n' +
                '        <span class="direct-chat-name text-info pull-right">'+senderFacility+'</span><br>\n' +
                '        <span class="direct-chat-name pull-right">'+senderName+'</span>\n' +
                '        <span class="direct-chat-timestamp pull-left">'+senderCurrentTime+'</span>\n' +
                '    </div>\n' +
                '    <img class="direct-chat-img" title="" src="'+senderImager+'" alt="Message User Image"><!-- /.direct-chat-img -->\n' +
                '    <div class="direct-chat-text">\n' +
                '        '+senderMessage+
                '    </div>\n' +
                '</div>';
            $(".reco-body"+code).append(recoAppend);
            var objDiv = document.getElementById(code);
            objDiv.scrollTop = objDiv.scrollHeight;
            $("#message").val('').attr('placeholder','Type Message...');
            $.ajax({
                url: "{{ url('doctor/feedback') }}",
                type: 'post',
                data: {
                    _token : "{{ csrf_token() }}",
                    message: str,
                    code : code
                },
                success: function(data) {}
            });
        }
        else {
            Lobibox.alert("error",
            {
                msg: "ReCo message was empty!"
            });
        }
    });

    $('body').on('click','.btn-issue-referred',function(){
        var code = $(this).data('code');
        var tracking_id = $(this).data('tracking_id');
        var referred_from = $(this).data('referred_from');
        var user_facility_id = "<?php echo \Illuminate\Support\Facades\Session::get('auth')->facility_id; ?>";

        if(user_facility_id != referred_from)
            $(".issue_footer").remove();

        $('.issue_concern_code').html(code);
        $('#issue_tracking_id').val(tracking_id);
        $("#issue_and_concern_body").html("Loading....");
        var url = "<?php echo asset('issue/concern').'/'; ?>"+tracking_id+"/"+referred_from;
        $.get(url,function(data){
            setTimeout(function(){
                $("#issue_and_concern_body").html(data);
            },500);
        });
    });

    $('.btn-issue-incoming').on('click',function () {
        console.log('issue');
        $(".issue_footer").remove();
        var code = $(this).data('code');
        var tracking_id = $(this).data('tracking_id');
        var referred_from = $(this).data('referred_from');
        $('.issue_concern_code').html(code);
        $("#issue_and_concern_body").html("Loading....");
        var url = "<?php echo asset('issue/concern').'/'; ?>"+tracking_id+"/"+referred_from;
        $.get(url,function(data){
            setTimeout(function(){
                $("#issue_and_concern_body").html(data);
            },500);
        });
    });

    $('#sendIssue').submit(function (e) {
        e.preventDefault();
        var issue_message = $("#issue_message").val();
        $("#issue_message").val('').attr('placeholder','Sending...');
        $.ajax({
            url: "{{ url('issue/concern/submit') }}",
            type: 'post',
            data: {
                _token : "{{ csrf_token() }}",
                issue: issue_message,
                tracking_id : $("#issue_tracking_id").val()
            },
            success: function(data) {
                $("#issue_and_concern_body").append(data);
                $("#message").val('').attr('placeholder','Type a message for your issue and concern regarding your referral..');
            }
        });
    });

    /*$('.direct-chat-messages').scroll(function() {
        var current_top_element = $('.direct-chat-messages').children().first();
        var previous_height = 0;


        var pos = $('.direct-chat-messages').scrollTop();
        var objDiv = document.getElementById(code);


        if (pos == 0) {
            $.ajax({
                url: "{{ url('doctor/feedback/load/') }}/"+code,
                type: "get",
                success: function (data) {
                    if(data!=0){
                        $("#"+code).prepend(data);
                        current_top_element.prevAll().each(function() {
                            previous_height += $(this).outerHeight();
                        });

                        objDiv.scrollTop = previous_height;
                    }
                }
            })
        }
    });*/

    /*feedbackRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var c = data.code;

        $("#"+c).append(data.content);
        var url = "<?php echo asset('referral/doctor/feedback/reply')."/"; ?>"+data.id;
        $.ajax({
            url: url,
            type: 'get',
            success: function(content) {
                $("#"+c).append(content);

                if(data.user_id == "{{ $user->id }}"){
                    var input_id = ".input-"+data.code+"-"+data.user_id;
                    $(input_id).val('');
                    var objDiv = document.getElementById(code);
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            }
        });
    });*/
</script>
