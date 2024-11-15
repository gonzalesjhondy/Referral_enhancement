<template>
  <div class="row">
    <div class="col-md-12">
      <div class="jim-content">
        <h3 class="page-header">Select Facility</h3>
        <div class="row">
          <div class="scroll-container">
            <appointment-facility
              v-if="appointment_slot"
              v-for="appointment in appointment_slot"
              :key="appointment.id"
              :facilitySelectedId="facilitySelectedId"
              :appointment="appointment"
              :user="user"
              @facilitySelected="facilitySelected"
            ></appointment-facility>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <appointment-calendar
          :facilitySelectedId="facilitySelectedId"
          :appointmentSlot="appointment_slot"
          @appointedTime="appointedTime"
        ></appointment-calendar>
        <appointment-time
          :facilitySelectedId="facilitySelectedId"
          :appointedTimes="appointedTimes"
        ></appointment-time>
      </div>
    </div>
  </div>
</template>
<script>
import AppointmentFacility from "./AppointmentFacility.vue";
import AppointmentCalendar from "./AppointmentCalendar.vue";
import AppointmentTime from "./AppointmentTime.vue";
export default {
  name: "AppointmentApp",
  components: {
    AppointmentFacility,
    AppointmentCalendar,
    AppointmentTime,
  },
  props: ["user", "appointment_slot"],
  data() {
    return {
      facilitySelectedId: 0,
      appointedTimes: [],
    };
  },
  mounted() {},
  methods: {
    facilitySelected(payload) {
      this.facilitySelectedId = payload;
    },
    appointedTime(payload) {
      this.appointedTimes = payload;
    },
  },
};
</script>
<style>
@import "./css/index.css";
</style>
