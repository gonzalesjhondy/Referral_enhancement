<template>
  <div
    class="col-md-4 scroll-item"
    v-if="appointment.id !== user.facility_id && shouldDisplayFacility"
  >
    <div
      :class="{ highlighted: appointment.id == facilitySelectedId }"
      class="box box-widget widget-user with-badge"
    >
      <div class="widget-user-header">
        <h3 class="widget-user-username">
          {{ appointment.name }}
        </h3>
        <h5 class="widget-user-desc">
          {{ appointment.address }}
        </h5>
      </div>
      <div class="widget-user-image">
        <img :src="doh_logo" class="img-circle" alt="User Avatar" />
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">
                {{ balanceSlotThisMonth }}
              </h5>
              <span class="description-text">Total Appointments</span>
            </div>
          </div>
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">
                {{ emptyAppointmentByCount }}
              </h5>
              <span class="description-text">Available Slot</span>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="description-block">
              <button
                class="btn btn-block btn-success btn-select"
                id="selected_data"
                name="selected_data"
                @click="facilitySelected(appointment.id)"
              >
                Select
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "AppointmentFacility",
  data() {
    return {
      doh_logo:
        $("#broadcasting_url").val() + "/resources/img/video/doh-logo.png",
    };
  },
  props: {
    user: {
      type: Object,
    },
    appointment: {
      type: Object,
    },
    facilitySelectedId: {
      type: Number,
    },
  },
  computed: {
    emptyAppointmentByCount() {
      let count = 0;
      const now = new Date();
      console.log("user", this.appointment);
      if (this.appointment && this.appointment.appointment_schedules) {
        const appointmentIdMap = new Map();

        this.appointment.appointment_schedules.forEach((sched) => {
          // Combine appointed_date and appointed_time into a single Date object
          const appointedDatetime = new Date(
            `${sched.appointed_date}T${sched.appointed_time}`
          );

          // Check if the schedule is in the future
          if (appointedDatetime > now) {
            sched.telemed_assigned_doctor.forEach((doctor) => {
              const appointmentId = doctor.appointment_id;
              // Initialize the map for this appointment_id if not done already
              if (!appointmentIdMap.has(appointmentId)) {
                appointmentIdMap.set(appointmentId, {
                  allNull: true, // Assume all appointment_by are null initially
                  hasNull: false, // Track if there's at least one null
                });
              }
              // Initialize the map for this appointment_id if not done already
              const status = appointmentIdMap.get(appointmentId);
              if (doctor.appointment_by) {
                status.allNull = false;
              } else {
                status.hasNull = true;
              }
            });
          }
        });
        // Count the number of appointment_ids where all appointment_by are null
        appointmentIdMap.forEach((status, appointmentId) => {
          if (status.hasNull) {
            count++;
          }
        });
      }
      return count;
    },
    // shouldDisplayFacility() {
    //   const now = new Date();
    //   const isAppointedExpire = this.appointment.appointment_schedules.every(
    //     (sched) => {
    //       const AppointedDate = new Date(`${sched.appointed_date}`);
    //       console.log(AppointedDate);
    //       return AppointedDate <= now;
    //     }
    //   );
    //   return !isAppointedExpire;
    //   //&& !this.emptyAppointmentByCount == 0
    // },
    // shouldDisplayFacility() {
    //   const now = new Date();

    //   const hasValidAppointment = this.appointment.appointment_schedules.some(
    //     (sched) => {
    //       const appointmentDatetime = new Date(
    //         `${sched.appointed_date} ${sched.appointed_time}`
    //       );

    //       const midnightTonight = new Date();
            
    //         midnightTonight.setHours(23,59,59,999);
            
    //       console.log("appointmentDatetime", appointmentDatetime >= now);
    //       console.log("midnightTonight", midnightTonight);
    //       return appointmentDatetime >= now && appointmentDatetime < midnightTonight;
    //     }
    //   );

    //   return hasValidAppointment;
    // },
    shouldDisplayFacility() {
      const now = new Date();

      const hasValidAppointment = this.appointment.appointment_schedules.some(
        (sched) => {
          const appointmentDatetime = new Date(
            `${sched.appointed_date} ${sched.appointed_time}`
          );

          // Set midnight of the appointment date
          const midnightAppointmentDay = new Date(appointmentDatetime);
          midnightAppointmentDay.setHours(24, 0, 0, 0);
          
          // Display facility if current time is before midnight of the appointment day
          return now < midnightAppointmentDay;
        }
      );

      return hasValidAppointment;
    },
    balanceSlotThisMonth() {
      let usedCount = 0;
      let expiredCount = 0;
      const now = new Date();
      const currentyear = now.getFullYear();
      const currentmonth = now.getMonth();
      if (this.appointment && this.appointment.appointment_schedules) {
        // Step 1: Filter schedules by appointed_date (current mnoth and year)
        const filteredSchedules = this.appointment.appointment_schedules.filter(
          (sched) => {
            const appointedDate = new Date(sched.appointed_date);
            const appointedYear = appointedDate.getFullYear();
            const appointedMonth = appointedDate.getMonth();
            return (
              appointedYear === currentyear && appointedMonth === currentmonth
            );
          }
        );

        const appointmentIdToDate = filteredSchedules.reduce((acc, sched) => {
          acc[sched.id] = sched.appointed_date;
          return acc;
        }, {});

        const groupedDoctorByDate = {};
        this.appointment.appointment_schedules.forEach((schedule) => {
          const doctors = schedule.telemed_assigned_doctor;
          if (doctors && Array.isArray(doctors)) {
            doctors.forEach((doctor) => {
              const appointedDate = appointmentIdToDate[doctor.appointment_id];
              if (appointedDate) {
                if (!groupedDoctorByDate[appointedDate])
                  groupedDoctorByDate[appointedDate] = [];
                groupedDoctorByDate[appointedDate].push(doctor);
              }
            });
          }
        });
        console.log("Grouped doctors by appointed_date:", groupedDoctorByDate);

        Object.entries(groupedDoctorByDate).forEach(
          ([appointedDate, doctors]) => {
            const doctorsByAppointmentId = doctors.reduce((acc, doctor) => {
              if (!acc[doctor.appointment_id]) acc[doctor.appointment_id] = [];
              acc[doctor.appointment_id].push(doctor);
              return acc;
            }, {});

            Object.values(doctorsByAppointmentId).forEach(
              (appointmentDoctors) => {
                // Find the schedule associated with this appointmentDoctors group
                const schedule = filteredSchedules.find(
                  (sched) => sched.id === appointmentDoctors[0].appointment_id
                );

                if (schedule) {
                  const appointedDatetime = new Date(
                    `${schedule.appointed_date}T${schedule.appointed_time}`
                  );
                  const allAssigned = appointmentDoctors.every(
                    (doctor) => doctor.appointment_by !== null
                  );

                  if (allAssigned) {
                    usedCount++;
                  }
                  // Check if the appointment is in the future or past (expired)
                  if (appointedDatetime > now) {
                    // If all doctors are assigned, increase the used count
                  } else {
                    // If the appointment has expired, but at least one doctor is assigned, count as expired
                    console.log("appointmentDoctors", appointmentDoctors);
                    const someAssigned = appointmentDoctors.some(
                      (doctor) => doctor.appointment_by === null
                    );
                    if (someAssigned) {
                      expiredCount++;
                    }
                  }
                }
              }
            );
          }
        );
      }
      const totalcount = usedCount + expiredCount;
      console.log(`Used count: ${usedCount}, Expired count: ${expiredCount}`);
      return totalcount;
    },
  },
  watch: {
    facilitySelectedId: function (value) {},
  },
  methods: {
    facilitySelected(id) {
      if (this.facilitySelectedId !== id) {
        //remove element
        $(".fc-day").css("background-color", "");
        $(".fc-day").removeClass("add-cursor-pointer");
        //
      }
      this.$emit("facilitySelected", id);
    },
  },
};
</script>
