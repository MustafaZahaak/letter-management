<?php

namespace App\Http\Controllers;

use App\Models\SendLogArchiveView;
use App\Models\SendLogView;
use App\Models\SmsRequest;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ReportController extends Controller
{
    protected $sendLog;
    protected $sendLogArchive;
    protected $headerStyle;
    protected $rowsStyle;

    public function config()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 2000);
    }

    public function __construct()
    {
        $this->sendLog = new SendLogView();
        $this->sendLogArchive = new SendLogArchiveView();
        $this->headerStyle = (new StyleBuilder())->setBackgroundColor("a2e167")->setFontBold()->build();
        $this->rowsStyle = (new StyleBuilder())->setFontSize(13)->build();
    }

    public function monthlyDetail(Request $r)
    {
        $this->config();
        $uniqueField = $r->input('originator', "");
        $from = Carbon::createFromFormat('Y-m-d', $r->input('from'))->startOfDay();
        $to = Carbon::createFromFormat('Y-m-d', $r->input('to'))->endOfDay();
        if ($from->diff($to)->days <= 31) {
            if ($uniqueField) {
                $list = collect($this->sendLog::where('originator_id', $uniqueField)->whereBetween('send_date', [$from, $to])->get($this->sendLog->reportFields))
                    ->merge($this->sendLogArchive::where('originator_id', $uniqueField)->whereBetween('send_date', [$from, $to])->get($this->sendLog->reportFields));

                return FastExcel::data($list)->headerStyle($this->headerStyle)->rowsStyle($this->rowsStyle)->download('sent_sms_detail_report_' . date('Y-m-d') . '.xlsx');
            }
            /*else {
                $list = collect($this->sendLog::whereBetween('send_date', [$from, $to])->get($this->sendLog->reportFields))
                    ->merge($this->sendLogArchive::whereBetween('send_date', [$from, $to])->get($this->sendLog->reportFields));
            }
            */

        } else {
            return response()->json([
                "message" => "Selected date range is more then one month!"
            ], 422);
        }


    }

    public function monthlySummary(Request $r)
    {
        $this->config();
        $uniqueField = $r->input('originator', "");
        $from = Carbon::createFromFormat('Y-m-d', $r->input('from'))->startOfDay();
        $to = Carbon::createFromFormat('Y-m-d', $r->input('to'))->endOfDay();

        if ($from->diff($to)->days <= 31) {
            if ($uniqueField) {
                $result = $this->sendLog->selectRaw('originator, year(send_date) as send_year,month(send_date) send_month, count(*) as count, message_length,"send_log" as `in`')
                    ->where('originator_id', $uniqueField)->groupBy('originator', 'send_month', 'message_length')->orderBy("send_month")->whereBetween('send_date', [$from, $to])->get();

                $resultArchive = $this->sendLogArchive->selectRaw('originator, year(send_date) as send_year,month(send_date) send_month, count(*) as count, message_length, "archive" as `in`')
                    ->where('originator_id', $uniqueField)->groupBy('originator', 'send_month', 'message_length')->orderBy("send_month")->whereBetween('send_date', [$from, $to])->get();
                return FastExcel::data(collect($result)->merge($resultArchive))->headerStyle($this->headerStyle)->rowsStyle($this->rowsStyle)->download('sent_sms_summary_report_' . date('Y-m-d') . '.xlsx');

            }
            /*else {
                $result = $this->sendLog->selectRaw('originator, year(send_date) as send_year,month(send_date) send_month, count(*) as count, message_length,"send_log" as `in`')
                    ->groupBy('originator', 'send_month', 'message_length')->orderBy("send_month")->whereBetween('send_date', [$from, $to])->get();

                $resultArchive = $this->sendLogArchive->selectRaw('originator, year(send_date) as send_year,month(send_date) send_month, count(*) as count, message_length, "archive" as `in`')
                    ->groupBy('originator', 'send_month', 'message_length')->orderBy("send_month")->whereBetween('send_date', [$from, $to])->get();
                return FastExcel::data(collect($result)->merge($resultArchive))->headerStyle($this->headerStyle)->rowsStyle($this->rowsStyle)->download('sent_sms_summary_report_' . date('Y-m-d') . '.xlsx');

            }*/
        } else {
            return response()->json([
                "message" => "Selected date range is more then one month!"
            ], 422);
        }
    }

    public function dailySummary(Request $r)
    {
        $this->config();
        $by = $r->user_id;
        $today  = now()->subDays(1)->format('Y-m-d');
        $result = smsRequest::where('created_at', 'LIKE', $today . '%')->where("created_by", $by)->get();
        $report = collect([]);

        foreach ($result as $r):
            $QR = collect([
                "Request Number" => $r->id,
                "Request Status" => ($r->job_status == 'c') ? " Completed " : " Under Process ",
                "Request Date" => $today,
                "Total Sent" => $this->sendLog::where('request_id', $r->id)->count(),
                "Message" => $r->message
            ]);
            $report = $report->push($QR);
        endforeach;

        if (!$report->isEmpty()) {
            return FastExcel::data($report->all())
                ->headerStyle($this->headerStyle)
                ->rowsStyle($this->rowsStyle)
                ->download('Daily_sent_sms_summary_report_' . $today . '.xlsx');
        }

        return response()->json([
            "message" => "No Data For Today"
        ], 200);

    }
}
