<template>
    <div class="row">
        <div class="col-md-6 form-group">
            <input v-model="feedback.name" type="text" name="name" class="form-control" id="feedback_name" placeholder="Your Name/Facility Name" required>
        </div>
        <div class="col-md-6 form-group mt-3 mt-md-0">
            <input v-model="feedback.email" type="email" class="form-control" name="email" id="feedback_email" placeholder="Your Email" required>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-6 form-group mt-3 mt-md-0">
            <input v-model="feedback.subject" type="text" class="form-control" name="subject" id="feedback_subject" placeholder="Subject" required>
        </div>
        <div class="col-md-6 form-group mt-3 mt-md-0">
            <input v-model="feedback.contact" type="tel" class="form-control" name="contact" id="feedback_contact" placeholder="Your Contact Number" required>
        </div>
    </div>
    <div class="form-group mt-3">
        <textarea v-model="feedback.message" style="resize: none;" class="form-control" id="feedback_msg" name="message" rows="5" placeholder="Message" required></textarea>
    </div><br>
    <div class="text-center">
        <span class="text-danger">{{ warning }}</span><br><br>
        <button class="btn btn-sm btn-primary" id="feedback_btn" type="submit" :onclick="sendFeedback">Send Feedback</button>
    </div>
</template>

<script>
    import $ from "jquery";
    /*let path = window.location.origin;
    if(path === 'https://site.test' || path === 'http://site.test' || path === 'http://localhost') {
        path += '/referral';
    }*/
    let path = $("#login_root_url").val();

    export default {
        name: "User Feedback",
        data: () => ({
            feedback: {
                name: "",
                email: "",
                contact: "",
                subject: "",
                message: "",
            },
            doh_logo: path+"/resources/img/doh.png",
            warning: ""
        }),
        created() {
        },
        methods: {
            sendFeedback() {
                if(this.feedback.name === "" || this.feedback.email === "" || this.feedback.contact === "" || this.feedback.subject === "" || this.feedback.message === "") {
                    this.warning = "Please fill in all the details!"
                } else {
                    this.warning = ""
                    $('#feedback_btn').attr('disabled',true);
                    $('#feedback_btn').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                    axios.post('user_feedback/create', {
                        name: this.feedback.name,
                        email: this.feedback.email,
                        contact: this.feedback.contact,
                        subject: this.feedback.subject,
                        message: this.feedback.message
                    })
                        .then(response => {
                            $('#feedback_name').val('');
                            $('#feedback_email').val('');
                            $('#feedback_subject').val('');
                            $('#feedback_msg').val('');
                            $('#feedback_contact').val('');
                            $('#feedback_btn').attr('disabled',false);
                            $('#feedback_btn').html('Send Feedback');
                            Lobibox.notify('success', {
                                title: 'Feedback successfully sent!',
                                img: this.doh_logo
                            });
                        })
                }
            }
        }
    }
</script>