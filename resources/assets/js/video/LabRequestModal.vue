<script>
    import { getLaboratories, saveLabRequest } from "./api/index"
    export default {
        data() {
            return {
                baseUrl: $("#broadcasting_url").val(),
                searchTerm: '',
                laboratories: [],
                laboratoriesHolder: [],
                checkedLaboratories: [],
            };

        },
        props: {
            activity_id: {
                type: Number
            },
            requested_by: {
                type: Number
            }
        },
        mounted() {
            console.log(this.activity_id)
            this.__getLaboratories()
        },
        methods: {
            searchLaboratories() {
                const searchTermLower = this.searchTerm.toLowerCase();
                const searchTermRegex = new RegExp(searchTermLower.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&'), 'i');
                if(searchTermLower) {
                    this.laboratories = Object.entries(this.laboratoriesHolder)
                        .filter(([laboratoryCode, laboratoryDescription]) => {
                            return (
                                searchTermRegex.test(laboratoryCode.toLowerCase()) ||
                                searchTermRegex.test(laboratoryDescription.toLowerCase())
                            );
                        })
                        .reduce((filtered, [laboratoryCode, laboratoryDescription]) => {
                            filtered[laboratoryCode] = laboratoryDescription;
                            return filtered;
                        }, {});
                }
                else {
                    this.laboratories = this.laboratoriesHolder
                }
                
            },
            submitForm() {
                if(this.checkedLaboratories.length > 0) {
                    const params = {
                        activity_id: this.activity_id,
                        requested_by: this.requested_by,
                        laboratory_code: this.checkedLaboratories
                    }
                    this.__saveLaboratories(params)
                    $("#labRequestModal").modal("hide");
                    Lobibox.notify('success', {
                        title: "Laboratory Request",
                        msg: "Laboratory successfully request",
                        img: this.baseUrl+"/resources/img/ro7.png"
                    });
                    return;
                }
                Lobibox.alert("error",
                {
                    msg: "Please select a laboratory to request"
                });
            },
            async __getLaboratories() {
                const response = await getLaboratories()
                this.laboratories = response.data;
                this.laboratoriesHolder = response.data;            
            },
            async __saveLaboratories(params) {
                const response = await saveLabRequest(params)
                console.log(response.data)          
            },
        }
    };
</script>

<template>
    <div class="modal fade" id="labRequestModal" data-backdrop="static" data-keyboard="false" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="prescriptionModalLabel"><i class="bi bi-prescription2"></i> Lab Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search Laboratory..." aria-label="Search..." aria-describedby="searchButton" v-model="searchTerm" @keyup="searchLaboratories">
                        <!-- <button class="btn btn-secondary" type="button" id="laboratorySearch" @click="searchLaboratories">Search</button> -->
                    </div>
                    <div id="modal-body-scroll">
                        <div class="form-check laboratory-check" v-for="(laboratoryDescription, laboratoryCode) in laboratories" :key="laboratoryCode" >
                            <input class="form-check-input" type="checkbox" v-model="checkedLaboratories" :value="laboratoryCode">
                            <label class="form-check-label" for="checkbox1">
                                {{ `${laboratoryCode} - ${laboratoryDescription}` }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success btn-sm" type="button" @click="submitForm"><i class="bi bi-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    #laboratorySearch {
        margin-top: -1px;    
    }

    .laboratory-check {
        padding: 5px;
        margin-left: 20px;
    }

    .form-check-label {
        margin-left: 10px;
    }

    .form-check-input {
        cursor: pointer;
        transform: scale(1.5);
    }

    #modal-body-scroll {
        max-height: 65vh; 
        overflow-y: auto;
    }
</style>
