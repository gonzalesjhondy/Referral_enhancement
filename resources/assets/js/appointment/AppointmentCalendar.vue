<style scoped>
.page-header {
  margin: 10px 0 0 0;
  font-size: 22px;
}
</style>
<template>
  <div class="col-md-9">
    <div class="jim-content">
      <h3 class="page-header">Appointment Calendar</h3>
      <div class="calendar-container">
        <section class="content">
          <div class="row">
            <div class="box box-primary">
              <div class="box-body no-padding">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import { appointmentScheduleDate, appointmentScheduleHours } from "./api/index";
export default {
  name: "AppointmentCalendar",
  data() {
    return {
      calendar: null,
      header: {
        left: "prev,next today",
        center: "title",
        right: "month,agendaWeek,agendaDay",
      },
      buttonText: {
        today: "today",
        month: "month",
        week: "week",
        day: "day",
      },
      events: [],
    };
  },
  props: {
    facilitySelectedId: {
      type: Number,
    },
    appointmentSlot: {
      type: Array,
      default: () => [], // Ensure it's an empty array by default
    },
  },
  watch: {
    facilitySelectedId: async function (payload, old) {
      this.events = await this.__appointmentScheduleDate(payload);
      this.updateCalendarEvents();
    },
  },
  mounted() {
    this.ini_events($("#external-events div.external-event"));
    this.generateCalendar();
  },
  methods: {
    ini_events(ele) {
      ele.each(function () {
        var eventObject = {
          title: $.trim($(this).text()), // use the element's text as the event title
        };
        $(this).data("eventObject", eventObject);
        $(this).draggable({
          zIndex: 1070,
          revert: true,
          revertDuration: 0,
        });
      });
    },
    async generateCalendar() {
      let self = this;
      this.calendar = $("#calendar").fullCalendar({
        dayRender: this.dayRenderFunction.bind(this),
        eventRender: this.eventRenderFunction.bind(this),
        dayClick: this.dayClickFunction.bind(this),
        header: self.header,
        buttonText: self.buttonText,
        events: this.events,
        editable: true,
        droppable: true,
        drop: this.handleDrop,
      });
    },
    dayRenderFunction(date, cell) {
      var eventsOnDate = this.events.filter(function (event) {
        return moment(event.start).isSame(date, "day");
      });

      if (eventsOnDate.length > 0) {
        cell.css("background-color", "green");
        cell.addClass("add-cursor-pointer");
      }
    },
    eventRenderFunction(event, element) {
      //console.log(event,event.start.format('YYYY-MM-DD'))
      // let currentDate = new Date().toISOString().split("T")[0];
      let currentDateTime = new Date().toISOString().split("T")[0]; // get the current date and time
      this.$nextTick(() => {
        const targetTd = $(
          ".fc-day[data-date='" + event.start.format("YYYY-MM-DD") + "']"
        );
        const targetdrag = $(
          ".fc-draggable[data-date='" + event.start.format("YYYY-MM-DD") + "']"
        );
        const targetGrid = $(".fc-day-grid-event");
        const date = targetTd.attr("data-date");

        const isfullyBooked = this.appointmentSlot.some((appointment) => {
          if (appointment.appointment_schedules.length > 0) {
            const slotOndate = appointment.appointment_schedules.filter(
              (slot) => slot.appointed_date === date
            );

            // Group by appointment_id
            const groupedByAppointmentId = slotOndate.reduce((acc, slot) => {
              const id = slot.appointment_id;
              if (!acc[id]) acc[id] = [];
              acc[id].push(
                slot.telemed_assigned_doctor.map(
                  (doctor) => doctor.appointment_by
                )
              );
              return acc;
            }, {});
            // Check if all appointment_by for each appointment_id are assigned
            return Object.values(groupedByAppointmentId).some((appointments) =>
              appointments.every((appointment_by_list) =>
                appointment_by_list.every((appointment_by) => appointment_by)
              )
            );
          }
          return false;
        });

        if (date <= currentDateTime || isfullyBooked) {
          targetTd.css("background-color", "rgb(255 214 214)"); //disable color'
          targetTd.css("border-color", "rgb(230 193 193)");
        } else {
          targetTd.css("background-color", "#00a65a"); //available color green'
          targetdrag.css("border-color", "#00a65a");
        }
        targetGrid.remove();
        targetTd.addClass("add-cursor-pointer");
        $(".fc-content").remove();
      });
    },
    async dayClickFunction(date, allDay, jsEvent, view) {
      const eventsOnDate = this.events.filter(function (event) {
        return moment(event.start).isSame(date, "day");
      });
      if (eventsOnDate.length > 0) {
        const params = JSON.parse(JSON.stringify(eventsOnDate))[0];
        const responseBody = {
          selected_date: params.start,
          facility_id: params.facility_id,
        };
        const response = await this.__appointmentScheduleHours(responseBody);
        this.$emit("appointedTime", response.data);
      }
    },
    updateCalendarEvents() {
      this.calendar.fullCalendar("removeEvents");
      this.events.forEach((event) => {
        this.calendar.fullCalendar("renderEvent", event, true);
      });
    },
    getRandomInt(min, max) {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min + 1)) + min;
    },
    async __appointmentScheduleDate(facility_id) {
      const response = await appointmentScheduleDate(facility_id);
      return response.data.facility_data.map((item) => {
        return {
          title: "Appointment",
          start: new Date(item.appointed_date),
          backgroundColor: "#00a65a",
          borderColor: "#00a65a",
          facility_id: item.facility_id,
        };
      });
    },
    async __appointmentScheduleHours(params) {
      return await appointmentScheduleHours(params);
    },
  },
};
</script>
