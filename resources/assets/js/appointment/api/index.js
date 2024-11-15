import req from "./req";

const base = $("#broadcasting_url").val();

export function appointmentScheduleDate(facility_id) {
    return req.get(base+"/appointment/getFacility/"+facility_id);
}

export function appointmentScheduleHours(params) {
    return req.post(base+"/appointment/available-time-slots", params);
}