<template>
    <div class="modal fade" id="prescriptionModal" data-backdrop="static" data-keyboard="false" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="prescriptionModalLabel"><i class="bi bi-prescription"></i> Prescription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">Ex.
                        <div class="row row-circle">
                            <div class="circle1">1</div>
                            <div class="circle2">2</div>
                            <div class="circle3">3</div>
                            <div class="circle4">4</div>
                            <div class="circle5">5</div>
                        </div>
                        <div class="row row-presLabel">
                            <div class="col col-presLabel">
                                <div class="col-Label">
                                    <span class="underline">Paracetamol</span>
                                    <span class="underline">(Biogesic)</span>
                                    <span class="underline">500mg</span>
                                    <span class="underline">#30</span>
                                    <span class="underline">Tablet</span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-circle">
                            <div class="circle6">6</div>
                            <div class="circle7">7</div>
                        </div>
                        <div class="row row-presLabel">
                            <div class="col col-presLabel">
                                <div class="col-Label">Sig:
                                    <span class="underline">1 Tab</span> for
                                    <span class="underline">Every 4 hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="border: solid 1px lightgray; margin-top: 10px; padding: 5px;">
                        <div class="row prescription">
                            <div class="col">
                                <label for="generic_name">1.) Generic Name:<span style="color:red;">*</span></label>
                                <input type="text" v-model="generic_name" class="form-control form-control-sm" >
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">   
                                <label for="brandname">2.) Brand Name: (Optional)</label>
                                <input type="text" v-model="brandname" class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="dosage">3.) Dosage:<span style="color:red;">*</span></label>
                                <input type="text" v-model="dosage" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="quantity">4.) Quantity:<span style="color:red;">*</span></label>
                                <input type="number" v-model="quantity"  class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="formulation">5.) Formulation:<span style="color:red;">*</span></label>
                                <input type="text" v-model="formulation" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="frequency">6.) Frequency:<span style="color:red;">*</span></label>
                                <input type="text" v-model="frequency" class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="duration">7.) Duration:<span style="color:red;">*</span></label>
                                <input type="text" v-model="duration" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <!--FOR DUPLICATE PRESCRIPTION-->
                    <div v-for="(prescription, index) in prescriptions" :key="index" style="border: solid 1px slategray; margin-top: 10px; padding: 5px;">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-danger btn-sm" @click="deletePrescription(index)"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="generic_name">1.) Generic Name:<span style="color:red;">*</span></label>
                                <input type="text" v-model="prescription.generic_name" class="form-control form-control-sm" >
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="brandname">2.) Brand Name: (Optional)</label>
                                <input type="text" v-model="prescription.brandname" class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="dosage">3.) Dosage:<span style="color:red;">*</span></label>
                                <input type="text" v-model="prescription.dosage" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="quantity">4.) Quantity:<span style="color:red;">*</span></label>
                                <input type="number" v-model="prescription.quantity"  class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="formulation">5.) Formulation:<span style="color:red;">*</span></label>
                                <input type="text" v-model="prescription.formulation" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row prescription">
                            <div class="col">
                                <label for="frequency">6.) Frequency:<span style="color:red;">*</span></label>
                                <input type="text" v-model="prescription.frequency" class="form-control form-control-sm">
                            </div>
                            <div class="col">
                                <label for="duration">7.) Duration:<span style="color:red;">*</span></label>
                                <input type="text" v-model="prescription.duration" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary btn-sm" type="button" @click="addEmptyPrescriptionBlock()"><i class="bi bi-prescription2"></i> Add Prescription</button>
                    <button class="btn btn-success btn-sm" type="button" @click="savePrescriptions()" v-if="prescriptionSubmitted"><i class="bi bi-prescription"></i> Update Prescription</button>
                    <button class="btn btn-success btn-sm" type="button" @click="savePrescriptions()" v-else><i class="bi bi-prescription"></i> Submit Prescription</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        props: {
            activity_id: {
                type: Number
            },
            baseUrl: {
                type: String
            },
            code: {
                type: String
            },
            form_type: {
                type: String
            },
        },
        data() {
            return {
                prescriptionSubmitted: false,
                generic_name: "",
                brandname: "",
                dosage: "",
                quantity: "",
                formulation: "",
                frequency: "",
                duration: "",
                prescribed_activity_id: "",
                prescriptions: [],
            };

        },
        created() {
            const prescriptionCode = this.code;
            this.fetchPrescriptions(prescriptionCode);
        },
        methods: {
            checkRequiredProperties(obj) {
                if (!obj.generic_name) {
                    Lobibox.alert("error", {
                        msg: "Please input generic name",
                    });
                    return false;
                }
                // else if (!obj.brandname) {
                //     Lobibox.alert("error", {
                //         msg: "Please input brandname",
                //     });
                //     return false;
                // }
                else if (!obj.dosage) {
                    Lobibox.alert("error", {
                        msg: "Please input dosage",
                    });
                    return false;
                }
                else if (!obj.quantity) {
                    Lobibox.alert("error", {
                        msg: "Please input quantity",
                    });
                    return false;
                }
                else if (!obj.formulation) {
                    Lobibox.alert("error", {
                        msg: "Please input formulation",
                    });
                    return false;
                }
                else if (!obj.frequency) {
                    Lobibox.alert("error", {
                        msg: "Please input frequency",
                    });
                    return false;
                }
                else if (!obj.duration) {
                    Lobibox.alert("error", {
                        msg: "Please input duration",
                    });
                    return false;
                }

                return true;
            },
            savePrescriptions() {
                if (!this.checkRequiredProperties(this)) {
                    return;
                }
                for (const prescription of this.prescriptions) {
                    if (!this.checkRequiredProperties(prescription)) {
                        return;
                    }
                }
                const combinedPrescriptions = {
                    singlePrescription: {
                        generic_name: this.generic_name,
                        brandname: this.brandname,
                        dosage: this.dosage,
                        quantity: this.quantity,
                        formulation: this.formulation,
                        frequency: this.frequency,
                        duration: this.duration,
                        code: this.code,
                        activity_id: this.activity_id,
                        form_type: this.form_type,
                        prescribed_activity_id: this.prescribed_activity_id,
                    },
                    multiplePrescriptions: this.prescriptions,
                };

                Lobibox.alert("success", {
                    msg: "Prescriptions saved successfully!",
                });
                $("#prescriptionModal").modal("hide");   
                console.log('Combined Prescription Data:', combinedPrescriptions);

                axios.post(`${this.baseUrl}/api/video/prescriptions`, combinedPrescriptions)
                    .then(response => {
                        console.log("Prescription submitted successfully", response.data);

                        this.prescriptions = []; // Clear prescription data
                        this.fetchPrescriptions(this.code); // Fetch fresh data

                    })
                    .catch(error => {
                        console.error("Error submitting prescription", error);
                    });
            },
            addEmptyPrescriptionBlock() {
                const emptyPrescription = {
                    generic_name: "",
                    brandname: "",
                    dosage: "",
                    quantity: "",
                    formulation: "",
                    frequency: "",
                    duration: "",
                };
                this.prescriptions.push(emptyPrescription);
            },
            deletePrescription(index) {
                const prescriptionToDelete = this.prescriptions[index];
                if (prescriptionToDelete.id) {
                    if (confirm("Are you sure you want to delete this prescription?")) {
                        axios.delete(`${this.baseUrl}/api/video/prescriptions/${prescriptionToDelete.id}`)
                        .then(response => {
                            Lobibox.alert("success", {
                                msg: "Prescription deleted successfully!",
                            });
                            console.log("Prescription deleted successfully", response.data);
                            this.prescriptions.splice(index, 1);
                        })
                        .catch(error => {
                            console.error("Error deleting prescription", error);
                        });
                    }
                } else {
                    this.prescriptions.splice(index, 1);
                }
            },
            async fetchPrescriptions(code) {
                try {
                    const response = await axios.get(`${this.baseUrl}/api/video/prescriptions/${code}`);

                    this.prescriptions = response.data.prescriptions;
                    const firstPrescription = this.prescriptions[0];
                    
                    if (firstPrescription) {
                        this.generic_name = firstPrescription.generic_name || '';
                        this.brandname = firstPrescription.brandname || '';
                        this.dosage = firstPrescription.dosage || '';
                        this.quantity = firstPrescription.quantity || '';
                        this.formulation = firstPrescription.formulation || '';
                        this.frequency = firstPrescription.frequency || '';
                        this.duration = firstPrescription.duration || '';
                        this.prescribed_activity_id = firstPrescription.prescribed_activity_id || '';
                        this.prescriptions = this.prescriptions.slice(1);
                    } 
                    else {
                        console.error('No prescriptions available.');
                    }
                } 
                catch (error) {
                    console.error('Error fetching prescriptions:', error);
                }
            },
        },

    
       

    };
</script>

<style scoped>
    .container {
        border: solid 1px lightgray;
        padding-bottom: 12px;
    }
    .row-presLabel {
        display: flex;
    }
    .col-presLabel {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .row-presLabel, .col-presLabel{
        font-size: 13px;
    }
    label {
        margin-bottom: 2px;
    }

    .col-Label {
        font-style: italic;
    }
    .underline {
        text-decoration: underline;
        margin: 5px;
    }
    .row-circle {
        display: flex;

    }
    .circle1, .circle2, .circle3, .circle4, .circle5, .circle6, .circle7 {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: solid 1px lightgrey;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        font-weight: bold;
    }
    .circle1 {
        margin-left: 28%;
    }
    .circle2 {
        margin-left: 13%;
    }
    .circle3 {
        margin-left: 9%;
    }
    .circle4 {
        margin-left: 5%;
    }
    .circle5 {
        margin-left: 5%;
    }
    .circle6 {
        margin-top: 2%;
        margin-left: 39%;
    }
    .circle7 {
        margin-top: 2%;
        margin-left: 15%;
    }
</style>