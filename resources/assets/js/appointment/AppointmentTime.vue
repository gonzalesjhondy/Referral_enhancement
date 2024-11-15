<script>
export default {
  name: "AppointmentTime",
  props: {
    appointedTimes: {
      type: Object,
    },
    facilitySelectedId: {
      type: Number,
    },
  },
  data() {
    return {
      selectedAppointmentTime: null,
      selectedAppointmentDoctor: null,
      showAppointmentTime: false,
      base: $("#broadcasting_url").val(),
      followUpReferredId: 0,
      followUpCode: null,
    };
  },
  mounted() {
    const telemedicineFollowUp = JSON.parse(
      decodeURIComponent(
        new URL(window.location.href).searchParams.get("appointment")
      )
    );
    if (telemedicineFollowUp) {
      this.followUpReferredId = telemedicineFollowUp[0].referred_id;
      this.followUpCode = telemedicineFollowUp[0].code;
    }
  },
  watch: {
    appointedTimes: async function (payload) {
      this.showAppointmentTime = true;
      this.selectedAppointmentTime = null;
      this.selectedAppointmentDoctor = null;
    },
    facilitySelectedId: async function (newValue, oldValue) {
      this.showAppointmentTime = false;
    },
  },
  computed: {
    areAllAppointmentFull() {
      return this.appointedTimes.every((appointment) =>
        this.areAllDoctorsNotAvailable(
          appointment.telemed_assigned_doctor,
          appointment.appointed_date,
          appointment.appointed_time
        )
      );
    },
  },
  methods: {
    areAllDoctorsNotAvailable(doctors, date, time) {
      let currentDateTime = new Date();
      let currentDate = currentDateTime.toISOString().split("T")[0];
      let currentTime = currentDateTime
        .toTimeString()
        .split(" ")[0]
        .substring(0, 5);
      console.log("time", time);
      var doctor_available = doctors.every((doctor) => doctor.appointment_by);
      console.log("doctor_available", doctor_available);

      if (date) {
        // Check if the date is in the past
        if (date < currentDate) {
          return true;
        }
        // If the date is today, check if the time is in the past
        if (date === currentDate) {
          if (time < currentTime) {
            return true;
          }
        }
        return doctor_available; // Disable if all doctors are not available
      }
      return doctor_available; // Default to doctor availability if date is not provided

      // if(date){
      //     //return date < currentDate || doctors.every(doctor => doctor.appointment_by);
      //     return date < currentDate;
      // }

      // // document.querySelector('input[name="appointed_date"]').setAttribute('min', today);
      // // document.querySelector('.hours_radio').setAttribute('min', currentDat);
      // // $('.hours_radio').setAttribute('min', currentDate);
      return doctors.every((doctor) => doctor.appointment_by);
    },
    isPastDatetime(appointedDate, appointedTime){
       const now = new Date();
       const appointmentDateTime = new Date(`${appointedDate}T${appointedTime}`);

    // If the appointment time is before the current time, return true (disabled)
        return appointmentDateTime < now;
    },
    proceedAppointment() {
      if (!this.selectedAppointmentTime) {
        Lobibox.alert("error", {
          msg: "Please Select Time",
        });
        return;
      } else if (!this.selectedAppointmentDoctor) {
        Lobibox.alert("error", {
          msg: "Please Select Doctor",
        });
        return;
      }

      if (this.followUpReferredId) {
        $("#telemed_follow_code").val(this.followUpCode);
        $("#telemedicine_follow_id").val(this.followUpReferredId);
        $(".telemedicine").val(1);
        $("#AppointmentId").val(this.selectedAppointmentTime);
        $("#DoctorId").val(this.selectedAppointmentDoctor);
        $("#followup_header").html("Follow Up Patient");
        $("#telemedicineFollowupFormModal").modal("show");
        $("#followup_facility_id").val(this.facilitySelectedId);
      } else {
        const appointment = {
          facility_id: this.facilitySelectedId,
          appointmentId: this.selectedAppointmentTime,
          doctorId: this.selectedAppointmentDoctor,
        };
        console.log(appointment);
        window.location.href = `${
          this.base
        }/doctor/patient?appointmentKey=${this.generateAppointmentKey(
          255
        )}&appointment=${encodeURIComponent(JSON.stringify([appointment]))}`;
      }
    },
    generateAppointmentKey(length) {
      const characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      let key = "";

      for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        key += characters.charAt(randomIndex);
      }

      return key;
    },
    handleAppointmentTimeChange() {
      this.selectedAppointmentDoctor = null;
    },
    handleDoctorChange(doctorId, appointmentId) {
      console.log(doctorId, 'appointmentId', appointmentId);

      this.selectedAppointmentDoctor = doctorId;
    },
  },
};
</script>
<template>
  <div class="col-md-3">
    <div class="jim-content">
      <h3 class="page-header">Time Slot</h3>
      <div class="calendar-container">
        <section class="content">
          <!-- <div class="row"> -->
            <div class="box box-primary">
              <div class="box-body no-padding">
                <!-- <div class="box-header with-border">
                  <h4 class="box-title">Legends</h4>
                </div> -->
                <div>
                  <div class="external-event bg-green">Available Slot</div>
                  <div
                    class="external-event"
                    style="background-color: rgb(255 214 214); color: #ffff"
                  >
                    Not Available
                  </div>
                </div>
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title timeDoctor">
                      Please choose Time and Doctor
                    </h3>
                    <div id="date-selected"></div>
                  </div>
                  <div
                    class="box-body"
                    v-if="appointedTimes.length > 0 && showAppointmentTime"
                  >
                    <div
                      class="appointment-time-list"
                      v-for="appointment in appointedTimes"
                      :key="appointment.id"
                    >
                      <input
                        type="radio"
                        class="hours_radio"
                        v-model="selectedAppointmentTime"
                        :value="appointment.id"
                        @change="handleAppointmentTimeChange"
                        :disabled="
                          areAllDoctorsNotAvailable(
                            appointment.telemed_assigned_doctor,
                            appointment.appointed_date,
                            appointment.appointed_time
                          ) || isPastDatetime(appointment.appointed_date,appointment.appointed_time)
                        "
                      />&nbsp;&nbsp;
                      <span
                        :class="{
                          'text-green': !areAllDoctorsNotAvailable(
                            appointment.telemed_assigned_doctor
                          ),
                          'text-red': areAllDoctorsNotAvailable(
                            appointment.telemed_assigned_doctor
                          ),
                        }"
                        >{{ appointment.appointed_time }} to
                        {{ appointment.appointedTime_to }}</span
                      >
                      <ul
                        v-if="appointment.id == selectedAppointmentTime"
                        class="doctor-list"
                        v-for="assignedDoctor in appointment.telemed_assigned_doctor"
                        :key="assignedDoctor.id"
                      >
                        <li>
                          <input
                            type="radio"
                            class="hours_radio"
                            v-model="selectedAppointmentDoctor"
                            :value="assignedDoctor.doctor.id"
                            @change="
                              handleDoctorChange(assignedDoctor.doctor.id, appointment.id)
                            "
                            :disabled="assignedDoctor.appointment_by"
                          />&nbsp;&nbsp;
                          <small
                            :class="{
                              'text-green': !assignedDoctor.appointment_by,
                              'text-red': assignedDoctor.appointment_by,
                            }"
                          >
                            {{
                              `Dr. ${assignedDoctor.doctor.fname} ${assignedDoctor.doctor.lname}`
                            }}
                          </small>
                        </li>
                      </ul>
                    </div>
                    <button
                      v-if="!areAllAppointmentFull"
                      type="button"
                      id="consultation"
                      class="btn btn-success bt-md btn-block"
                      @click="proceedAppointment"
                    >
                      <i class="fa fa-calendar"></i>&nbsp;&nbsp;Appointment
                    </button>
                    <button
                      v-else
                      type="button"
                      id="consultation"
                      class="btn btn-danger bt-md btn-block"
                      disabled
                    >
                      <i class="fa fa-calendar"></i>&nbsp;&nbsp;All appointments
                      are full
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </section>
      </div>
    </div>
  </div>
</template>
<style scoped>
.appointment-time-list {
  /* display: flex;  */
  padding: 10px;
}
.appointment-time-list > .doctor-list {
  display: block !important;
  list-style-type: none;
  margin-top: 7px;
}
.hours_radio {
  margin-bottom: 5px;
  transform: scale(1.5);
  cursor: pointer;
  accent-color: #00a65a;
}
#consultation {
  margin-top: 20px;
}
.timeDoctor {
  font-size: 16px;
}
.page-header {
  margin: 10px 0 0 0;
  font-size: 22px;
}
</style>
