<?php

namespace App\Http\Controllers;

use App\Models\DashboardCache;
use App\Models\Organization;
use App\Models\Originator;
use App\Models\SendLog;
use App\Models\SendLogArchiveView;
use App\Models\SendLogView;
use App\Models\SmsRequestView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    protected $dashboardTotal = null;
    protected $total_send_sms_by_originators = [];
    protected $monthly_send_graph = [];


    public function getDashboardData()
    {
        return DashboardCache::first()->data;
    }

    public function prepareOrgDashboardData(Organization $org)
    {
        $dashboardData = collect([]);
        $monthlyCount = collect([]);

        $sendLog = SendLogView::where("org_id", $org->id);
        $sendLogArchive = SendLogArchiveView::where("org_id", $org->id);
        $smsRequest = SmsRequestView::where("org_id", $org->id);

        //request
        $dashboardData->put('total_completed_request', $smsRequest->where('request_status', 'c')->count());
        $dashboardData->put('total_pending_request', $smsRequest->where('request_status', null)->orwhere('request_status', '')->count());
        $dashboardData->put('total_sms_request', $smsRequest->count());

        //send + send_archive
        $dashboardData->put('total_send_sms', ($sendLog->where('status', 'T')->count()) + ($sendLogArchive->where('status', 'T')->count()));
        $total_send_sms_by_originators = $sendLog->groupBy('originator')->select('originator', DB::raw('count(*) as count'))->get();
        $total_send_sms_by_originators_archive = $sendLogArchive->groupBy('originator')->select('originator', DB::raw('count(*) as count'))->get();
        $total_send_sms_by_originators_collection = collect();
        foreach ($total_send_sms_by_originators as $key => $value) {
            $count = $value->count;
            foreach ($total_send_sms_by_originators_archive as $k => $v) {
                if ($value->originator == $v->originator) {
                    $count = $count + $v->count;
                }
            }
            if (!$total_send_sms_by_originators_collection->contains('originator', $value->originator)) {
                $total_send_sms_by_originators_collection->add(["originator" => $value->originator, "count" => $count]);
            }
        }
        $dashboardData->put('total_send_sms_by_originators', $total_send_sms_by_originators_collection);


        //send_log plus send_log_archive based on month regarding originators
        /**
        $result = $sendLog->selectRaw('originator,originator_id, year(send_date) as send_year,month(send_date) send_month, count(*) as count')
            ->groupBy('originator', 'send_month')->orderBy("send_month")->get();

        $resultArchive = $sendLogArchive->selectRaw('originator,originator_id, year(send_date) as send_year,month(send_date) send_month, count(*) as count')
            ->groupBy('originator', 'send_month')->orderBy("send_month")->get();

        foreach (collect($result)->groupBy('originator') as $key => $value) {
            $month_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            foreach (collect($resultArchive)->groupBy('originator') as $k => $v) {
                foreach ($value as $key1 => $value1) {
                    $count = 0;
                    foreach ($v as $k4 => $v4) {
                        if ($value1->originator_id == $v4->originator_id && $value1->send_month == $v4->send_month) {
                            $count += $value1->count + $v4->count;
                        }
                        else{
                            $count = ($v4->count)?$v4->count:$value->count;
                        }
                    }
                    $month_data[$value1->send_month - 1] = $count;
                }
            }
            $monthlyCount->add((["name" => $key, "data" => $month_data]));
        };
        $dashboardData->put("monthly_send_graph", $monthlyCount);
        **/
        return $dashboardData;
    }

    function refreshDashboardCache()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 2000);

        $this->dashboardTotal = collect();
        //DashboardCache::truncate();
        /**
         * This function is not using for now
         *
         * $organizations = \App\Models\Organization::all();
         *
         * foreach ($organizations as $org):
         * $dashboardData = $this->prepareOrgDashboardData($org);
         * DashboardCache::insert(['org_id' => $org->id, 'related_to' => $org->english_name,
         * 'data' => json_encode($dashboardData->toArray())]);
         * $this->storeDashboardTotalCache($dashboardData);
         * endforeach;
         *
         * DashboardCache::insert(['org_id' => 1, 'related_to' => "super-admin", 'data' => json_encode($this->dashboardTotal)]);
         **/
        //return $this->updateOrSetOrgDashboardDataByOriginator(5, 6, 51);
        return $this->dashboardTotal;

    }

    function storeDashboardTotalCache($dr)
    {
        $this->total_send_sms_by_originators = array_merge($dr->get('total_send_sms_by_originators')->toArray(), $this->total_send_sms_by_originators);
        //$this->monthly_send_graph = array_merge($dr->get('monthly_send_graph')->toArray(), $this->monthly_send_graph);
        $this->dashboardTotal->put('total_completed_request', $this->dashboardTotal->get('total_completed_request') + $dr->get('total_completed_request'));
        $this->dashboardTotal->put('total_pending_request', $this->dashboardTotal->get('total_pending_request') + $dr->get('total_pending_request'));
        $this->dashboardTotal->put('total_sms_request', $this->dashboardTotal->get('total_sms_request') + $dr->get('total_sms_request'));
        $this->dashboardTotal->put('total_send_sms', $this->dashboardTotal->get('total_send_sms') + $dr->get('total_send_sms'));
        $this->dashboardTotal->put('total_send_sms_by_originators', $this->total_send_sms_by_originators);
        //$this->dashboardTotal->put('monthly_send_graph', $this->monthly_send_graph);
    }

    public function updateOrSetOrgDashboardDataByOriginator($org_id, $originator_id, $request_id)
    {
        $dashboardData = collect([]);

        $originator = Originator::where('id', $originator_id)->first();
        $organization = Organization::where('id', $org_id)->first();
        $sendLog = SendLogView::where("org_id", $org_id);
        $smsRequest = SmsRequestView::where("org_id", $org_id);
        $currentOrganizationData = DashboardCache::where('org_id', $org_id)->first();

        if ($currentOrganizationData) {
            //request
            $dashboardData->put('total_completed_request',
                $smsRequest->where('request_status', 'c')->count());
            $dashboardData->put('total_pending_request',
                $smsRequest->where('request_status', null)->orwhere('request_status', '')->count());
            $dashboardData->put('total_sms_request', $smsRequest->count());
            $dashboardData->put('total_send_sms', ($sendLog->where('status', 'T')->count()));

            //get count form desired request_id
            $sendLog = $sendLog->where('originator_id', $originator_id)->where('request_id', $request_id);
            $total_send_sms_by_originator = $sendLog->select(DB::raw('count(*) as count'))->first();

            //send
            $total_send_sms_by_originators_collection = collect($currentOrganizationData->data['total_send_sms_by_originators']);
            if (!$total_send_sms_by_originators_collection->contains('originator', $originator->name)) {
                $total_send_sms_by_originators_collection->add(["originator" => $originator->name, "count" => $total_send_sms_by_originator->count]);
            } else {
                $total_send_sms_by_originators_collection=$total_send_sms_by_originators_collection->map(function ($r)use ($originator,$total_send_sms_by_originator){
                    if ($r['originator'] == $originator->name) {
                        $r['count'] += $total_send_sms_by_originator->count;
                    }
                    return $r;
                });
            }
            $dashboardData->put('total_send_sms_by_originators', $total_send_sms_by_originators_collection);
            $currentOrganizationData->data = $dashboardData->toArray();
            $currentOrganizationData->updated_at = Carbon::now("Asia/Kabul")->format('Y-m-d H:i:s');
            $currentOrganizationData->update();
            return $currentOrganizationData;

        } else {
            //request
            $dashboardData->put('total_completed_request',
                $smsRequest->where('request_status', 'c')->count());
            $dashboardData->put('total_pending_request',
                $smsRequest->where('request_status', null)->orwhere('request_status', '')->count());
            $dashboardData->put('total_sms_request', $smsRequest->count());
            $dashboardData->put('total_send_sms', ($sendLog->where('status', 'T')->count()));

            //send
            $total_send_sms_by_originators = $sendLog->groupBy('originator')->select('originator', DB::raw('count(*) as count'))->get();
            $dashboardData->put('total_send_sms_by_originators', collect($total_send_sms_by_originators));

            DashboardCache::insert(['org_id' => $org_id, 'related_to' => $organization->english_name,
                'data' => json_encode($dashboardData->toArray())]);
            return $dashboardData->toArray();
        }
    }

}
