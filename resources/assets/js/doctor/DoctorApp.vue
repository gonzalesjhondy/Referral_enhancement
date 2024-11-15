<template>
    <div class="row">
        <div class="col-md-9">
            <div class="jim-content">
                <div class="alert alert-danger" v-if="error">
                    <span class="text-danger">
                        <i class="fa fa-times"></i> Error switching account! Please try again.
                    </span>
                </div>

                <h3 class="page-header">Referral Activity</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card flat-card widget-primary-card clickable-card" @click="redirectToReferredView">
                            <div class="row-table">
                                <div class="col-sm-3 card-body">
                                    <i class="fa fa-ambulance custom-icon"></i>
                                </div>
                                <div class="col-sm-9">
                                    <h4>{{ total_referred }}</h4>
                                    <h5>Referred Patients {{ year }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card flat-card widget-primary-card clickable-card" @click="redirectToIncomingView">
                            <div class="row-table">
                                <div class="col-sm-3 card-body">
                                    <i class="fa fa-users custom-icon"></i>
                                </div>
                                <div class="col-sm-9">
                                    <h4>{{ incoming_reffered }}</h4>
                                    <h5>Incoming Patients {{ year }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="page-header">Monthly Activity</h3>
                <div class="chart">
                    <canvas id="barChart"></canvas>
                </div>
                <h3 class="page-header" style="margin-top: 5%">Incoming Transaction as of <span class="text-primary" style="font-size: 10pt;"><i>{{ date_start }} to {{ date_end }}</i></span></h3>
                <div class="row" style="margin-top: 3%;">
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            <br>
                            <h5 class="description-header">
                                <!--<a href="#dashboard_modal" @click="showIncomingModal('incoming_total')">{{ incoming_total }}</a>-->
                                {{ incoming_total }}
                            </h5>
                            <span class="description-text">Incoming</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-green" v-if="accept_percent >= 50">
                                <i class="fa fa-thumbs-o-up"></i> <b>({{ accept_percent+"%" }})</b>
                            </span>
                            <span class="description-percentage text-red" v-else>
                                <i class="fa fa-thumbs-o-down"></i> <b>({{ accept_percent+"%" }})</b>
                            </span>
                            <h5 class="description-header">
                                <a href="#dashboard_modal" @click="showIncomingModal('accepted')">{{ incoming_statistics.accepted }}</a>
                            </h5>
                            <span class="description-text">Accepted</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            <br>
                            <h5 class="description-header">
                                <!--<a href="#dashboard_modal" @click="showIncomingModal('seen_only')">{{ incoming_statistics.seen_only }}</a>-->
                                {{ incoming_statistics.seen_only }}
                            </h5>
                            <span class="description-text">Seen Only</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block">
                            <br>
                            <h5 class="description-header">
                                <a href="#dashboard_modal" @click="showIncomingModal('not_seen')">{{ incoming_statistics.not_seen }}</a>
                            </h5>
                            <span class="description-text">No Action</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div id="user_per_department" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div id="number_of_transaction" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <div class="row col-md-12">
        <div class="jim-content">
            <h3 class="page-header">Last 15 days transaction</h3>
            <div id="doctor_past_transaction" style="height: 370px; width: 100%;"></div>
            <div style="width: 20%;height:20px;background-color: white;position: absolute;margin-top: -12px;"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" role="dialog" data-backdrop="static" id="dashboard_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="dashboard-modal-title"></h3>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="close closeModalBtn" style="float: right" @click="closeModal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body dashboard_modal_body text-center" style="padding-top: 1px; padding-bottom: 1px;">
                    <img :src="loading">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModalBtn" @click="closeModal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : "DoctorApp",
        props : [
            "date_start",
            "date_end",
            "user",
            "error", 
            "incoming_reffered",
            "total_referred",
            "year",
        ],
        data() {
            return {
                incoming_statistics : Object,
                incoming_total : '',
                left_sum : 0,
                right_sum : 0,
                accept_percent : 0,
                seen_only : 0,
                data : "",
                loading : $('#loadingGif').val(),
            }
        },
        async created(){
            this.proceedForm()
            await this.barChart()
            await this.optionPerDepartment()
            await this.optionPerActivity()
            await this.optionLastTransaction()
        },
        methods : {
            redirectToReferredView() {
                window.location.href = 'doctor/referred';
            },
            redirectToIncomingView() {
                window.location.href = 'doctor/referral';
            },
            showIncomingModal(type) {
                console.log(type);
                $('#dashboard_modal').modal('show');
                $('#dashboard_modal_body').html(loading);
                axios.get('doctor/dashboard/getTransactions/'+type).then(response => {
                    $('.dashboard_modal_body').html(response.data);
                })
            },
            closeModal() {
                $('.dashboard_modal_body').html(loading);
                $('.dashboard-modal-title').html('');
            },
            proceedForm() {
                if (this.user.level !== "support") {
                    Lobibox.confirm({
                        msg: "Where do you want to proceed?",
                        buttons: {
                            referredPatients: {
                                'class': 'btn btn-success',
                                text: 'Referred Patients',
                                closeOnClick: true
                            },
                            incomingPatients: {
                                'class': 'btn btn-primary',
                                text: 'Incoming Patients',
                                closeOnClick: true
                            },
                            referralForm: {
                                'class': 'btn btn-info',
                                text: 'Referral Form',
                                closeOnClick: true
                            },
                            cancel: {
                                'class': 'btn btn-danger',
                                text: 'Close',
                                closeOnClick: true
                            }
                        },
                        callback: (lobibox, type, ev) => {
                            if (type === 'referredPatients') {
                                window.location.replace("doctor/referred");
                            } else if (type === 'incomingPatients') {
                                window.location.replace("doctor/referral");
                            } else if (type === 'referralForm') {
                                window.location.replace("doctor/patient");
                            } else if (type === 'cancel') {
                            }
                        }
                    });
                }
            },
            async barChart() {
                await axios.get('doctor/monthly/report').then(response => {
                    let doctor_monthly_report = response.data
                    let chartdata = {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            // labels: month,
                            datasets: [
                                {
                                    label: 'Referred',
                                    backgroundColor: '#8e9cff',
                                    data: doctor_monthly_report.referred
                                },
                                {
                                    label: 'Accepted',
                                    backgroundColor: '#26B99A',
                                    data: doctor_monthly_report.accepted
                                },
                                {
                                    label: 'Redirected',
                                    backgroundColor: '#03586A',
                                    data: doctor_monthly_report.redirected
                                }
                            ]
                        }
                    };

                    let ctx = document.getElementById('barChart').getContext('2d');
                    new Chart(ctx, chartdata);
                });
            },
            async optionPerDepartment() {
                await axios.get('doctor/option/per/department').then(response => {
                    let options_user_per_department = {
                        title: {
                            text: "Login users per department as of today",
                            fontFamily: "Arial"
                        },
                        legend: {
                            horizontalAlign: "center", // "center" , "right"
                            verticalAlign: "top"  // "top" , "bottom"
                        },
                        animationEnabled: true,
                        data: [{
                            type: "pie",
                            startAngle: 80,
                            showInLegend: "true",
                            legendText: "{label}",
                            indexLabel: "{label} ({y})",
                            yValueFormatString:"#,##0.#"%"",
                            dataPoints: response.data
                        }]
                    };
                    $("#user_per_department").CanvasJSChart(options_user_per_department);
                });
            },
            async optionPerActivity() {
                await axios.get('doctor/option/per/activity').then(response => {
                    //for statistics
                    this.incoming_statistics = response.data

                    this.left_sum += this.incoming_statistics.referred + this.incoming_statistics.redirected + this.incoming_statistics.transferred
                    this.right_sum += this.incoming_statistics.accepted + this.incoming_statistics.denied + this.incoming_statistics.seen_only + this.incoming_statistics.not_seen
                    if(this.left_sum > this.right_sum) {
                        console.log("first")
                        this.incoming_statistics.seen_only += this.left_sum - this.right_sum
                        this.right_sum += this.left_sum - this.right_sum
                    }
                    else if(this.left_sum < this.right_sum) {
                        console.log('second')
                        this.incoming_statistics.referred += this.right_sum - this.left_sum
                        this.left_sum += this.right_sum - this.left_sum;
                    }
                    this.incoming_total += this.right_sum;

                    this.accept_percent = this.incoming_statistics.accepted / (this.incoming_statistics.referred + this.incoming_statistics.redirected + this.incoming_statistics.transferred ) * 100
                    this.accept_percent = this.accept_percent.toFixed(2)
                    this.seen_only = this.incoming_statistics.seen_total - this.incoming_statistics.seen_accepted_redirected
                    //
                    let options_activity = {
                        title: {
                            text: "Number of Activity",
                            fontFamily: "Arial"
                        },
                        legend: {
                            horizontalAlign: "center", // "center" , "right"
                            verticalAlign: "top"  // "top" , "bottom"
                        },
                        animationEnabled: true,
                        data: [{
                            type: "doughnut",
                            startAngle: 80,
                            showInLegend: "true",
                            legendText: "{label}",
                            indexLabel: "{label} ({y})",
                            yValueFormatString:"#,##0.#"%"",
                            dataPoints: [
                                { label: "Referred", y: this.incoming_statistics.referred },
                                { label: "Accepted", y: this.incoming_statistics.accepted },
                                { label: "Redirected", y: this.incoming_statistics.redirected },
                                { label: "Called", y: this.incoming_statistics.calling },
                                { label: "Arrived", y: this.incoming_statistics.arrived },
                                { label: "Transferred", y: this.incoming_statistics.transferred },
                                { label: "Admitted", y: this.incoming_statistics.accepted },
                                { label: "Discharge", y: this.incoming_statistics.discharged }
                            ]
                        }]
                    };
                    $("#number_of_transaction").CanvasJSChart(options_activity);
                });
            },
            async optionLastTransaction() {
                await axios.get('doctor/option/last/transaction').then(response => {
                    //line chart
                    let datapoints_referred = [];
                    let datapoints_accepted = [];
                    let datapoints_redirected = [];
                    let options_days = {
                        animationEnabled: true,
                        theme: "light2",
                        title:{
                            text: ""
                        },
                        axisX:{
                            valueFormatString: "DD MMM"
                        },
                        axisY: {
                            title: "",
                            suffix: "",
                            minimum: 0
                        },
                        toolTip:{
                            shared:true
                        },
                        legend:{
                            cursor:"pointer",
                            verticalAlign: "bottom",
                            horizontalAlign: "center",
                            dockInsidePlotArea: false,
                            fontSize: 15,
                            itemclick: toogleDataSeries
                        },
                        data: [
                            {
                                type: "line",
                                showInLegend: true,
                                name: "Referred",
                                markerType: "square",
                                xValueFormatString: "DD MMM, YYYY",
                                yValueFormatString: "#,##",
                                dataPoints: datapoints_referred
                            }
                            ,
                            {
                                type: "line",
                                showInLegend: true,
                                name: "Accepted",
                                markerType: "square",
                                yValueFormatString: "#,##",
                                dataPoints: datapoints_accepted
                            },
                            {
                                type: "line",
                                showInLegend: true,
                                name: "Redirected",
                                markerType: "square",
                                yValueFormatString: "#,##",
                                dataPoints: datapoints_redirected
                            },
                        ]
                    };

                    $.each(response.data.referred_past, function( index, value ) {
                        datapoints_referred.push({
                            x: new Date(value.date),
                            y: value.value
                        });
                    });

                    $.each(response.data.accepted_past, function( index, value ) {
                        datapoints_accepted.push({
                            x: new Date(value.date),
                            y: value.value
                        });
                    });

                    $.each(response.data.redirected_past, function( index, value ) {
                        datapoints_redirected.push({
                            x: new Date(value.date),
                            y: value.value
                        });
                    });

                    $("#doctor_past_transaction").CanvasJSChart(options_days);

                    function toogleDataSeries(e){
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else{
                            e.dataSeries.visible = true;
                        }
                        e.chart.render();
                    }

                });
            },
        }
    }
</script>

<style>
    .widget-primary-card.flat-card, .flat-card.widget-purple-card {
        border-top: none;
        background-color: #1abc9c;
        color: #fff;
    }
    .card {
        box-shadow: 0 2px 1px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: box-shadow 0.2s ease-in-out;
        border-top: 3px solid #8CDDCD;
    }
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0px solid rgba(0, 0, 0, 0.125);
        border-radius: 2px;
    }
    .widget-primary-card.flat-card .row-table > [class*=col-]:first-child, .flat-card.widget-purple-card .row-table > [class*=col-]:first-child {
        background-color: #17a689;
        text-align: center;
    }
    .widget-primary-card.flat-card .row-table > [class*=col-], .flat-card.widget-purple-card .row-table > [class*=col-] {
        display: inline-block;
        vertical-align: middle;
    }
    .flat-card .row-table > [class*=col-] {
        display: table-cell;
        float: none;
        table-layout: fixed;
        vertical-align: middle;
    }
    .card .card-block, .card .card-body {
        padding: 20px;
    }
    .card-body {
        flex: 1 1 auto;
    }
    .custom-icon {
        font-size: 20px;
        width: 20px;
        height: 20px;
        display: inline-block;
    }
    .clickable-card {
        cursor: pointer;
    }
    .lobibox .lobibox-footer .btn {
        margin: 8px 8px 8px 0 !important;
    }
</style>