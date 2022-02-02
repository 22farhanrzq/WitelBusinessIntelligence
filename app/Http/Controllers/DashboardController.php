<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Customer;
use App\Models\Distribution;
use App\Models\Mitra;
use App\Models\Team;
use App\Models\Channel;
use App\Models\Status;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();
    
        $current_date = date('Y-m-d');
        $current_date_month = date('l, d F Y');
        // $current_month = $current_date->format('F');
        // $current_month = Carbon::now()->monthName;

        $today_order = Customer::where('created_at', 'like', $current_date.'%')->count();

        $today_wo = Customer::where('updated_at', 'like', $current_date.'%')
        ->where('status_id', '!=', '')
        ->count();

        $today_ps = Customer::join('statuses', 'customers.status_id', 'statuses.id')
        ->where('kategori', '=', 'PS')
        ->where('updated_at', 'like', $current_date.'%')
        ->count();

        $ps = Customer::join('statuses', 'customers.status_id', 'statuses.id')
        ->where('kategori', '=', 'PS')
        ->where('updated_at', 'like', $current_date.'%')
        ->count();

        $kendala_teknis = Customer::join('statuses', 'customers.status_id', 'statuses.id')
        ->where('kategori', '=', 'Kendala Teknis')
        ->where('updated_at', 'like', $current_date.'%')
        ->count();

        $kendala_pelanggan = Customer::join('statuses', 'customers.status_id', 'statuses.id')
        ->where('kategori', '=', 'Kendala Pelanggan')
        ->where('updated_at', 'like', $current_date.'%')
        ->count();

        $total_kendala = $kendala_teknis + $kendala_pelanggan;

        $total_wo = $ps + $total_kendala;

        if ($ps == 0) {
            $pswo = 0;
        }else {
            $pswo = ($ps/$total_wo)*100;
        }

        $distribution_list = Distribution::all();
        $dist = array('ANT','BAL','BLK','BTN','JNP','KIM','MAL','MAR','MAT','PKN','PNK','SIN','SLY','SUD','SUG','TKA','TMA','WTP');
        // $dist = $dist->toArray();

        // dd($dist[0]);
        for($i = 0; $i < count($dist); $i++)
        {
            $query_ps = Customer::join('statuses', 'customers.status_id', 'statuses.id')
            ->join('distributions', 'customers.distribution_id', 'distributions.id')
            ->where('distributions.kode', $dist[$i])
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_date.'%')
            ->count();

            $ps_dashboard[] = $query_ps;

            $query_all_kendala = Customer::join('statuses', 'customers.status_id', 'statuses.id')
            ->join('distributions', 'customers.distribution_id', 'distributions.id')
            ->where('distributions.kode', $dist[$i])
            ->where('kategori', '!=', 'PS')
            ->where('created_at', 'like', $current_date.'%')
            ->count();

            $kendala_dashboard[] = $query_all_kendala;

            $kendala_teknis_dashboard = Customer::join('statuses', 'customers.status_id', 'statuses.id')
            ->join('distributions', 'customers.distribution_id', 'distributions.id')
            ->where('distributions.kode', $dist[$i])
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_date.'%')
            ->count();

            $kendala_pelanggan_dashboard = Customer::join('statuses', 'customers.status_id', 'statuses.id')
            ->join('distributions', 'customers.distribution_id', 'distributions.id')
            ->where('distributions.kode', $dist[$i])
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_date.'%')
            ->count();

            $total_kendala_dashboard = $kendala_teknis_dashboard + $kendala_pelanggan_dashboard;
  
            $total_wo_dashboard = $query_ps + $total_kendala_dashboard;

            if ($query_ps == 0) {
                $dist_pswo[] = 0;
            }else {
                $dist_pswo[] = ($query_ps/$total_wo_dashboard)*100;
            }
        }
        
        return view('index',[
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'nav_item' => 'dashboard_item',
            'nav_link' => 'dashboard_link',
            // 'current_month' => $current_month,
            'today_wo' => $today_wo,
            'today_ps' => $today_ps,
            'current_date_month' => $current_date_month,
            'total_kendala' => $total_kendala,
            'pswo' => $pswo,
            'kendala_teknis' => $kendala_teknis,
            'kendala_pelanggan' => $kendala_pelanggan,
            'distribution_list' => $distribution_list,
            'current_date' => $current_date,
            'ps_dashboard' => $ps_dashboard,
            'kendala_dashboard' => $kendala_dashboard,
            'dist_pswo' => $dist_pswo,
            'today_order' => $today_order,
        ]);
    }

    public function distribution($kode)
    {
        $distribution_list = Distribution::where('kode', $kode)->get();
        $mitra_list = Mitra::select('mitras.id', 'mitras.nama as nama_mitra')
        ->join('distributions', 'distributions.id', 'mitras.distribution_id')
        ->where('distributions.kode', $kode)
        // ->distinct()
        ->get();
        // return $mitra_list->toArray();

        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();

        $current_date_month = date('l, d F Y');
        $current_year = date('Y');
        
        $tes = DB::table('distributions')->select('kode')->get();

        $bulan = Customer::select(DB::raw('YEAR(created_at) as year'),DB::raw('DATE_FORMAT(created_at,"%M") as month'))
        ->whereYear('created_at',date('Y'))
        ->groupBy('month','year')
        ->get();

        return view('pages.table', [
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'distribution_list' => $distribution_list,
            'mitra_list' => $mitra_list,
            'nav_item' => 'perform_item',
            'nav_link' => 'perform_link',
            'nav_link_item' => $tes,
            'bulan' => $bulan,
            'current_date_month' => $current_date_month,
            'current_year' => $current_year,
        ]);
    }
}
