<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Icd10;
use App\Imports\ExcelImport;
use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Exports\QueryExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCtrl extends Controller
{
    public function ExportExcelIncoming()
    {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=incoming.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $title = 'Incoming Report';
        $table_body = "";
        foreach(Session::get('data') as $row) {
            $table_body .= "<tr>
                <td>".$row->name."</td>
                <td>$row->count_incoming</td>
                <td>".Session::get('accepted_incoming')[$row->id]."</td>
                <td>".Session::get('seenzoned_incoming')[$row->id]."</td>
                <td>".Session::get('common_source_incoming')[$row->id]."</td>
                <td>".Session::get('referring_doctor_incoming')[$row->id]."</td>
                <td>".Session::get('turnaround_time_accept_incoming')[$row->id]."</td>
                <td>".Session::get('turnaround_time_arrived_incoming')[$row->id]."</td>
                <td>".Session::get('diagnosis_ref_incoming')[$row->id]."</td>
                <td>".Session::get('reason_ref_incoming')[$row->id]."</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>".Session::get('transport_ref_incoming')[$row->id]."</td>
                <td>".Session::get('department_ref_incoming')[$row->id]."</td>
                <td>".Session::get('issue_ref_incoming')[$row->id]."</td>
            </tr>";
        }

        $display =
            '
                <h1>'.$title.'</h1>
                <table cellspacing="1" cellpadding="5" border="1">
                <tr>
                    <td style="background-color:lightgreen">Name of Facility</td>
                    <td style="background-color:lightgreen">Total Incoming  Referrals</td>
                    <td style="background-color:lightgreen">Total Accepted Referrals</td>
                    <td style="background-color:lightgreen">Total Viewed Only Referrals</td>
                    <td style="background-color:lightgreen">Common Sources(Facility)</td>
                    <td style="background-color:lightgreen">Common Referring Doctor HCW/MD (Top 10)</td>
                    <td style="background-color:lightgreen">Average Referral Acceptance Turnaround time</td>
                    <td style="background-color:lightgreen">Average Referral Arrival Turnaround Time</td>
                    <td style="background-color:lightgreen">Diagnoses (Top 10)</td>
                    <td style="background-color:lightgreen">Reasons (Top 10)</td>
                    <td style="background-color:lightgreen">Number of Horizontal referrals</td>
                    <td style="background-color:lightgreen">Number of Vertical Referrals</td>
                    <td style="background-color:lightgreen">Common Methods of Transportation</td>
                    <td style="background-color:lightgreen">Department</td>
                    <td style="background-color:lightgreen">Remarks</td>
                </tr>'
                .$table_body.
            '</table>';

        return $display;

        /*return Excel::download(new QueryExport, 'export.xlsx');*/
    }

    public function ExportExcelOutgoing(){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=outgoing.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $title = 'Outgoing Report';
        $table_body = "";
        foreach(Session::get('data') as $row) {
            $table_body .= "<tr>
                <td>".$row->name."</td>
                <td>".Session::get('total_outgoing1')[$row->id]."</td>
                <td>".Session::get('accepted_outgoing1')[$row->id]."</td>
                <td>".Session::get('seenzoned_outgoing1')[$row->id]."</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>".Session::get('common_referred_facility_outgoing1')[$row->id]."</td>
                <td>".Session::get('common_referred_doctor_outgoing1')[$row->id]."</td>
                <td>".Session::get('turnaround_time_accept_outgoing1')[$row->id]."</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>".Session::get('diagnosis_ref_outgoing1')[$row->id]."</td>
                <td>".Session::get('reason_ref_outgoing1')[$row->id]."</td>
                <td>Under development this column</td>
                <td>Under development this column</td>
                <td>".Session::get('transport_ref_outgoing1')[$row->id]."</td>
                <td>".Session::get('department_ref_outgoing1')[$row->id]."</td>
                <td>".Session::get('issue_ref_outgoing1')[$row->id]."</td>
            </tr>";
        }

        $display =
            '
                <h1>'.$title.'</h1>
                <table cellspacing="1" cellpadding="5" border="1">
                <tr>
                    <td style="background-color:lightgreen">Name of Facility</td>
                    <td style="background-color:lightgreen">Total Outgoing Referrals</td>
                    <td style="background-color:lightgreen">Total Accepted Referrals</td>
                    <td style="background-color:lightgreen">Total Viewed Only Referrals</td>
                    <td style="background-color:lightgreen">Total Archived Referrals</td>
                    <td style="background-color:lightgreen">Total Redirected Referrals</td>
                    <td style="background-color:lightgreen">Common Sources(Facility)</td>
                    <td style="background-color:lightgreen">Common Referring Doctor HCW/MD (Top 10)</td>
                    <td style="background-color:lightgreen">Average Referral Viewed Only Acceptance Turnaround time </td>
                    <td style="background-color:lightgreen">Average Referral Viewed Only Redirection Turnaround time</td>
                    <td style="background-color:lightgreen">Average Referral Acceptance Turnaround time </td>
                    <td style="background-color:lightgreen">Average Referral Redirection Turnaround Time </td>
                    <td style="background-color:lightgreen">Average Referral to Transport Turnaround Time </td>
                    <td style="background-color:lightgreen">Diagnoses for Outgoing Referral(Top 10)</td>
                    <td style="background-color:lightgreen">Reasons for Referral(Top 10)</td>
                    <td style="background-color:lightgreen">Reasons for Redirection(Top 10)</td>
                    <td style="background-color:lightgreen">Number of Horizontal referrals</td>
                    <td style="background-color:lightgreen">Common Methods of Transportation</td>
                    <td style="background-color:lightgreen">Department</td>
                    <td style="background-color:lightgreen">Remarks</td>
                </tr>'
            .$table_body.
            '</table>';

        return $display;
    }

    public function EocExcel(){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=inventory.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $title = 'Levels of Care Inventory';
        $table_body = "";

        $count = 0;
        $facility = [];
        foreach(Session::get('inventory') as $row) {
            if(!isset($facility[$row->facility])){
                $facility[$row->facility] = true;
                $count++;

                $table_body .= "<tr>
                    <td style='background-color:yellow'>$count</td>
                    <td colspan='4' style='background-color:yellow'><b style='font-size: 17pt;'>$row->facility</b> <br><b> No. of Patients Waiting for Admisstion: </b><b style='color: red;font-size: 15pt;'>".Inventory::where("name","Patients Waiting for Admission")->where("facility_id",$row->facility_id)->first()->capacity."</b></td>
                </tr>";

                $table_body .= "<tr>
                    <td style=\"background-color:lightgreen\"></td>
                    <td style=\"background-color:lightgreen\">Description</td>
                    <td style=\"background-color:lightgreen\">Capacity</td>
                    <td style=\"background-color:lightgreen\">Occupied</td>
                    <td style=\"background-color:lightgreen\">Available</td>
                </tr>";
            }

            $available = $row->capacity - $row->occupied;
            if($row->name != 'Patients Waiting for Admission'){
                $table_body .= "<tr>
                    <td></td>
                    <td >$row->name</td>
                    <td >$row->capacity</td>
                    <td >$row->occupied</td>
                    <td >$available</td>
                </tr>";
            }

        }

        $display =
                '<h1>'.$title.'</h1>'.
                '<table cellspacing="1" cellpadding="5" border="1">'.$table_body.'</table>';

        return $display;
    }

    public function ExportExcelAll()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        Excel::create('Consolidate Report', function($excel) {
            $this->IncomingProcess($excel,"Incoming Report");
            $this->OutgoingProcess($excel,"Outgoing Report");
        })->download('xlsx');
    }

    public function IncomingProcess($excel,$title){
        $excel->sheet($title, function($sheet) {
            $data = Session::get('data');
            $data = json_decode( json_encode($data), true);
            $headerColumn = [
                "Name of Facility",
                "Total Incoming  Referrals",
                "Total Accepted Referrals",
                "Total Viewed Only Referrals",
                "Common Sources(Facility)",
                "Common Referring Doctor HCW/MD (Top 10)",
                "Average Referral Acceptance Turnaround time ",
                "Average Referral Arrival Turnaround Time",
                "Diagnoses (Top 10)",
                "Reasons (Top 10)",
                "Number of Horizontal referrals",
                "Number of Vertical Referrals",
                "Common Methods of Transportation",
                "Department",
                "Remarks"
            ];

            $sheet->appendRow($headerColumn);
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontFamily('Comic Sans MS');
                $row->setFontSize(10);
                $row->setFontWeight('bold');
                $row->setBackground('#FFFF00');
            });

            foreach($data as $row){
                $data = [
                    $row['name'],
                    $row['count_incoming'],
                    Session::get('accepted_incoming')[$row['id']],
                    Session::get('seenzoned_incoming')[$row['id']],
                    Session::get('common_source_incoming')[$row['id']],
                    Session::get('referring_doctor_incoming')[$row['id']],
                    Session::get('turnaround_time_accept_incoming')[$row['id']],
                    Session::get('turnaround_time_arrived_incoming')[$row['id']],
                    Session::get('diagnosis_ref_incoming')[$row['id']],
                    Session::get('reason_ref_incoming')[$row['id']],
                    "Under development this column",
                    "Under development this column",
                    Session::get('transport_ref_incoming')[$row['id']],
                    Session::get('department_ref_incoming')[$row['id']],
                    Session::get('issue_ref_incoming')[$row['id']],
                ];
                $sheet->appendRow($data);
            }
            //$sheet->getStyle('A1')->getAlignment()->setWrapText(true);

        });
    }

    public function OutgoingProcess($excel,$title){
        $excel->sheet($title, function($sheet) {
            $data = Session::get('data');
            $data = json_decode( json_encode($data), true);

            $headerColumn = [
                "Name of Facility",
                "Total Outgoing Referrals",
                "Total Accepted Referrals",
                "Total Viewed Only Referrals",
                "Total Archived Referrals",
                "Total Redirected Referrals",
                "Common Sources(Facility)",
                "Common Referring Doctor HCW/MD (Top 10)",
                "Average Referral Viewed Only Acceptance Turnaround time ",
                "Average Referral Viewed Only Redirection Turnaround time ",
                "Average Referral Acceptance Turnaround time ",
                "Average Referral Redirection Turnaround Time",
                "Average Referral to Transport Turnaround Time",
                "Diagnoses for Outgoing Referral(Top 10)",
                "Reasons for Referral(Top 10)",
                "Reasons for Redirection(Top 10)",
                "Number of Horizontal referrals",
                "Number of Vertical Referrals",
                "Common Methods of Transportation",
                "Department",
                "Remarks"
            ];

            $sheet->appendRow($headerColumn);
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontFamily('Comic Sans MS');
                $row->setFontSize(10);
                $row->setFontWeight('bold');
                $row->setBackground('#FFFF00');
            });

            foreach($data as $row){
                $data = [
                    $row['name'],
                    Session::get('total_outgoing1')[$row['id']],
                    Session::get('accepted_outgoing1')[$row['id']],
                    Session::get('seenzoned_outgoing1')[$row['id']],
                    "Under development this column",
                    "Under development this column",
                    Session::get('common_referred_facility_outgoing1')[$row['id']],
                    Session::get('common_referred_doctor_outgoing1')[$row['id']],
                    Session::get('turnaround_time_accept_outgoing1')[$row['id']],
                    "Under development this column",
                    "Under development this column",
                    "Under development this column",
                    "Under development this column",
                    Session::get('diagnosis_ref_outgoing1')[$row['id']],
                    Session::get('reason_ref_outgoing1')[$row['id']],
                    "Under development this column",
                    "Under development this column",
                    "Under development this column",
                    Session::get('transport_ref_outgoing1')[$row['id']],
                    Session::get('department_ref_outgoing1')[$row['id']],
                    Session::get('issue_ref_outgoing1')[$row['id']]
                ];
                $sheet->appendRow($data);
            }
        });

    }

    public function importExcel(Request $request) {
        if($request->isMethod('post')) {
            $import = new ExcelImport();
            Excel::import($import, request()->file('import_file'));
            foreach($import->data as $row){
                if(
                    !(
                        $row[0] == "code" &&
                        $row[1] == "description" &&
                        $row[2] == "group" &&
                        $row[3] == "case_rate" &&
                        $row[4] == "professional_fee" &&
                        $row[5] == "health_care_fee" &&
                        $row[6] == "source"
                    )

                ){
                    if(!Icd10::where("code",$row[0])->first()){
                        Icd10::create([
                            "code" => $row[0],
                            "description" => $row[1],
                            "group" => $row[2],
                            "case_rate" => $row[3],
                            "professional_fee" => $row[4],
                            "health_care_fee" => $row[5],
                            "source" => $row[6]
                        ]);
                    }
                }
            }
            Session::put('icd_notif',true);
            Session::put('icd_msg','Successfully imported!');
            return back();
        }
        return view('admin.icd.icd');
    }
}
