<template>
    <section id="appointment" class="appointment section-bg">
        <div class="container">
            <div class="section-title">
                <h2>Make an Appointment</h2>
                <p>
                    Connect with our DOH CV CHD Team to set up a <b><u style="font-size: 17pt;">Training Request Schedule</u></b>
                    or to address any <b><u style="font-size: 17pt;">System Issues and Concerns</u></b> you may have.
                </p>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <input v-model="appt.faci_name" type="text" name="name" class="form-control" id="pointment_faci" placeholder="Facility Name" required>
                </div>
                <div class="col-md-4 form-group">
                    <input v-model="appt.requester" type="text" name="name" class="form-control" id="pointment_requester" placeholder="Name of Requester" required>
                </div>
                <div class="col-md-4 form-group">
                    <input v-model="appt.email" type="email" class="form-control" name="email" id="pointment_email" placeholder="Email" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mt-3">
                    <small>Contact Number: </small>
                    <input v-model="appt.contact" type="tel" class="form-control" name="contact" id="pointment_phone" placeholder="Contact Number" required>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <small>Preferred Date of Training (If Training Request):</small>
                    <input type="date" v-model="appt.date" name="date" id="pointment_date" class="form-control" :min="tomorrow">
                </div>
                <div class="col-md-4 form-group mt-3">
                    <small>Category:</small>
                    <select v-model="appt.category" name="category" id="pointment_category" class="form-select" required>
                        <option value="">Select...</option>
                        <option value="Training Request">Training Request</option>
                        <option value="System Issues/Concerns">System Issues/Concerns</option>
                    </select>
                </div>
            </div>

            <div class="form-group mt-3">
                <textarea v-model="appt.message" class="form-control" style="resize: none;" name="message" id="pointment_msg" rows="7" placeholder="Message" required></textarea>
                <small class="text-danger" id="warning_pointment">
                    *Note: Please check if the entered information is correct before clicking submit button!</small><br>
            </div><br>
            <div class="text-center">
                <span class="text-danger">{{ warning }}</span><br><br>
                <button class="btn btn-success" type="submit" id="btn_appt" :onclick="createAppointment">Make an Appointment </button>
            </div>
        </div>
    </section>
</template>

<script>
    let path = window.location.origin;
    if(path === 'https://site.test' || path === 'http://site.test') {
        path += '/referral';
    }
    export default {
        name: "Appointment",
            data: () => ({
            appt: {
                faci_name: "",
                requester: "",
                email: "",
                contact: "",
                date: "",
                category : "",
                message: ""
            },
            tomorrow: "",
            doh_logo: path+"/resources/img/doh.png",
            warning: ""
        }),
            created() {
            let tom = new Date()
            tom.setDate(tom.getDate() + 1)
            tom = tom.toISOString().substr(0, 10)
            this.tomorrow = tom
        },
        methods: {
            createAppointment() {
                if(this.appt.faci_name === "" || this.appt.requester === "" || this.appt.email === "" || this.appt.contact === "" || this.appt.message === "" || this.appt.category === "") {
                    this.warning = "Please fill in the required details!"
                } else {
                    this.warning = ""
                    $('#btn_appt').attr('disabled',true);
                    $('#btn_appt').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                    axios.post('appointment/create', {
                        faci_name: this.appt.faci_name,
                        requester: this.appt.requester,
                        email: this.appt.email,
                        contact: this.appt.contact,
                        date: this.appt.date,
                        category: this.appt.category,
                        message: this.appt.message
                    })
                        .then(response => {
                            $('#pointment_faci').val('');
                            $('#pointment_requester').val('');
                            $('#pointment_email').val('');
                            $('#pointment_phone').val('');
                            $('#pointment_category').val('');
                            $('#pointment_msg').val('');
                            $('#pointment_date').val('');
                            $('#btn_appt').attr('disabled',false);
                            $('#btn_appt').html('Make an Appointment');
                            Lobibox.notify('success', {
                                title: 'Appointment request sent successfully!',
                                img: this.doh_logo,
                                msg: ""
                            });
                        })
                }
            }
        }
    }
</script>