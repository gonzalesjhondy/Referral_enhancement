import req from "./req";

const base = $("#broadcasting_url").val();

export function getLaboratories() {
    return req.get(base+"/api/laboratories");
}

export function saveLabRequest(params) {
    return req.post(base+"/api/laboratories", params);
}