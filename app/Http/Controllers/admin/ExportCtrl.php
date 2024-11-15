<?php

namespace App\Http\Controllers\admin;

use App\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExportCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function dailyUsers()
    {
        $user = Session::get('auth');

        $date = Session::get('dateDailyUsers');
        if(!$date){
            $date = date('Y-m-d');
        }

        $facilities = Facility::where('status',1)
            ->orderBy('name','asc')
            ->get();

        $data[] = array('Monitoring Tool for Central Visayas Electronic Health Referral System');
        $data[] = array('Form 1');
        $data[] = array('DAILY REPORT FOR AVAILABLE USERS');
        $data[] = array('');
        $data[] = array('Date: '. date('F d, Y',strtotime($date)));
        $data[] = array('');
        $data[] = array('Name of Hospital','Health Professional','','','','IT','','','TOTAL');
        $data[] = array('','On Duty','Off Duty','Offline','Subtotal','Online','Offline','Subtotal');

        foreach($facilities as $row)
        {
            $log = DailyCtrl::countDailyUsers($row->id);
            $offline = $log['total'] - ($log['on'] + $log['off']);
            $it_offline = $log['it_total'] - $log['it_on'];

            $data[] = array(
                'users' => $row->name,
                'on' => $log['on'],
                'off' => $log['off'],
                'offline' => $offline,
                'h_total' => $log['total'],
                'it_on' => $log['it_on'],
                'it_offline' => $it_offline,
                'it_total' => $log['it_total'],
                'total' => $log['total'] + $log['it_total']
            );
        }



        return Excel::create("Daily_Users-$date",function ($excel) use ($data) {
            $excel->sheet('Users',function($sheet) use ($data) {
                $totalCell = count($data) + 1;

                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->mergeCells('A3:I3');
                $sheet->mergeCells('A4:I4');
                $sheet->mergeCells('A5:I5');
                $sheet->mergeCells('A6:I6');
                $sheet->mergeCells('A7:I7');

                $sheet->mergeCells('A8:A9');
                $sheet->mergeCells('B8:E8');
                $sheet->mergeCells('F8:H8');
                $sheet->mergeCells('I8:I9');

                $sheet->setWidth(array(
                    'A'     =>  40,
                    'I'     =>  15
                ));

                $sheet->setBorder("A1:I$totalCell", 'thin');

                $sheet->cell("A1:I4", function($cell){
                    $cell->setAlignment('center');
                });

                $sheet->cell("A8:I9", function($cell){
                    $cell->setValignment('center');
                });

                $sheet->cell("B8:I$totalCell", function($cell){
                    $cell->setAlignment('center');
                });

                $sheet->cell("B8:I9", function($cell){
                    $cell->setAlignment('center');
                });

                $sheet->getStyle('A1:I9')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                $sheet->fromArray($data);

            });
        })->download('xlsx');
    }

    public function dailyReferral()
    {
        $user = Session::get('auth');

        $date = Session::get('dateReportReferral');
        if(!$date){
            $date = date('Y-m-d');
        }

        $users = Facility::where('status',1)
            ->orderBy('name','asc')
            ->get();

        $data[] = array('Monitoring Tool for Central Visayas Electronic Health Referral System');
        $data[] = array('Form 2');
        $data[] = array('DAILY REPORT FOR REFERRALS');
        $data[] = array('');
        $data[] = array('Date: '. date('F d, Y',strtotime($date)));
        $data[] = array('');
        $data[] = array('Name of Hospital','Number of Referrals To','','','','TOTAL','Number of Referrals From','','','TOTAL');
        $data[] = array('','Accepted','Redirected','Seen','Unseen','','Accepted','Redirected','Seen');

        foreach($users as $row)
        {
            $referral = DailyCtrl::countOutgoingReferral($row->id);
            $incoming = DailyCtrl::countIncommingReferral($row->id);
            $data[] = array(
                'users' => $row->name,
                'accepted' => $referral['accepted'],
                'redirected' => $referral['redirected'],
                'seen' => $referral['seen'],
                'unseen' => $referral['unseen'],
                'total' => $referral['total'],
                'i_accepted' => $incoming['accepted'],
                'i_redirected' => $incoming['redirected'],
                'i_seen' => $incoming['seen'],
                'i_total' => $incoming['total']
            );
        }



        return Excel::create("Daily_Referral-$date",function ($excel) use ($data) {
            $excel->sheet('Users',function($sheet) use ($data) {
                $totalCell = count($data) + 1;

                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');
                $sheet->mergeCells('A3:J3');
                $sheet->mergeCells('A4:J4');
                $sheet->mergeCells('A5:J5');
                $sheet->mergeCells('A6:J6');
                $sheet->mergeCells('A7:J7');

                $sheet->mergeCells('A8:A9');
                $sheet->mergeCells('B8:E8');
                $sheet->mergeCells('F8:F9');
                $sheet->mergeCells('G8:I8');
                $sheet->mergeCells('J8:J9');

                $sheet->setWidth(array(
                    'A'     =>  40,
                    'B'     =>  11,
                    'C'     =>  11,
                    'D'     =>  11,
                    'E'     =>  11,
                    'F'     =>  11,
                    'G'     =>  11,
                    'H'     =>  11,
                    'I'     =>  11,
                    'J'     =>  11
                ));

                $sheet->cell("A8:J9", function($cell){
                    $cell->setValignment('center');
                    $cell->setAlignment('center');
                });

                $sheet->setBorder("A1:J$totalCell", 'thin');

                $sheet->cell("A1:J4", function($cell){
                    $cell->setAlignment('center');
                });

                $sheet->cell("B9:J$totalCell", function($cell){
                    $cell->setAlignment('center');
                });

                $sheet->getStyle('A1:J9')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                $sheet->getStyle('A9:J9')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                $sheet->getStyle('B10:J10')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);


                $sheet->fromArray($data);

            });
        })->download('xlsx');
    }
}
