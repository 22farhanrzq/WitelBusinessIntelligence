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

class CustomerController extends Controller
{
    //
    public function input()
    {
        $distribution_list = Distribution::all();
        $channel_list = Channel::all();
        $status_list = Status::all();

        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();

        $current_date_month = date('l, d F Y');

        return view('pages.input', [
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'distribution_list' => $distribution_list,
            'channel_list' => $channel_list,
            'status_list' => $status_list,
            'nav_item' => 'input_item',
            'nav_link' => 'input_link',
            'current_date_month' => $current_date_month,
        ]);
    }

    public function index($kode_dist)
    {
        $distribution_list = Distribution::where('kode', $kode_dist)
        ->get();

        $customer_list = Customer::join('distributions', 'distributions.id', 'customers.distribution_id')
        ->where('kode', $kode_dist)
        ->get();

        $count = $customer_list->count();

        $date = Customer::select('updated_at')
        ->join('distributions', 'distributions.id', 'customers.distribution_id')
        ->where('kode', $kode_dist)
        ->get();

        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();

        $current_date_month = date('l, d F Y');

        return view('pages.customer', [
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'distribution_list' => $distribution_list,
            'customer_list' => $customer_list,
            'count' => $count,
            'date' => $date,
            'nav_item' => 'customer_item',
            'nav_link' => 'customer_link',
            'current_date_month' => $current_date_month,
        ]);
    }

    public function store(Request $request)
    {
        $customer = new Customer;
        // return $request;
        $get_trackId = $request->input('track_type').'-'.$request->input('track_id');
        $alreadyHas = Customer::where('track_id', $get_trackId)->count();
        
        if($alreadyHas > 0)
        {
            $notification = array(
                'message' => 'Tiket dengan Track ID tersebut sudah ada!',
                'alert-type' => 'error'
            );
            return redirect('input')->with($notification);
        }

        $customer->track_id = $request->input('track_type').'-'.$request->input('track_id');
        $customer->nama_customer = $request->nama_customer;
        $customer->telepon = $request->telepon;
        $customer->email = $request->email;
        $customer->nomor_internet = $request->nomor_internet;
        $customer->alamat = $request->alamat;
        $customer->channel_id = $request->channel_id;
        $customer->distribution_id = $request->distribution_id;
        // $customer->mitra_id = $request->mitra_id;
        // $customer->team_id = $request->team_id;
        $customer->created_at = Carbon::now()->setTimezone('Asia/Makassar'); //->toDateSstring()
        $customer->updated_at = Carbon::now()->setTimezone('Asia/Makassar');
        $customer->odp_bookingan = $request->odp_bookingan;
        // $customer->odp_alternatif = $request->odp_alternatif;
        $customer->koordinat = $request->koordinat;
        // $customer->status_id = $request->status_id;
        // $customer->deskripsi = $request->deskripsi;
        // $customer->created_by = $request->created_by;
        $customer->user_id = $request->user_id;

        $request->validate([
            // 'created_by' => 'required',
            'user_id' => 'required',
            'track_id' => 'required',
            'nama_customer' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'nomor_internet' => 'required',
            'alamat' => 'required',
            'channel_id' => 'required',
            'distribution_id' => 'required',
            // 'mitra_id' => 'required',
            // 'team_id' => 'required',
            'odp_bookingan' => 'required',
            // 'status_id' => 'required',
            'koordinat' => 'required',
            // 'deskripsi' => 'required'
        ]);

        $customer->save();

        $success_notification = array(
            'message' => 'Tiket berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect('input')->with($success_notification);
        // return redirect('input');
        // return response()->json($data, 200, $headers);
        // return $request->all();
    }

    public function fetchMitra(Request $request)
    {

        $data = Mitra::select('id', 'nama')
        ->where('distribution_id', $request->id)
        ->take(100)
        ->get();

        // dd($data);

        return response()->json($data);
    }

    public function fetchTeam(Request $request_team)
    {

        $data = Team::select('id', 'nama')
        ->where('mitra_id', $request_team->id)
        ->take(100)
        ->get();

        // dd($data);

        return response()->json($data);
    }

    public function show($track_id)
    {
        $query = Customer::join('channels', 'channels.id', 'customers.channel_id')
        ->join('distributions', 'distributions.id', 'customers.distribution_id')
        ->join('mitras', 'mitras.id', 'customers.mitra_id')
        ->join('teams', 'teams.id', 'customers.team_id')
        ->join('statuses', 'statuses.id', 'customers.status_id')
        // ->join('users', 'users.id', 'customers.updated_by')
        ->where('track_id', $track_id)
        ->count();

        if($query == 0)
        {
            $customer = Customer::where('track_id', $track_id)
            // ->join('users', 'users.id', 'customers.created_at', 'customers.updated_at')
            // ->join('users', 'users.id', 'customers.updated_by')
            // ->first();
            ->get();

            // return $query;
        }
        else
        {
            $customer = Customer::join('channels', 'channels.id', 'customers.channel_id')
            ->join('distributions', 'distributions.id', 'customers.distribution_id')
            ->join('mitras', 'mitras.id', 'customers.mitra_id')
            ->join('teams', 'teams.id', 'customers.team_id')
            ->join('statuses', 'statuses.id', 'customers.status_id')
            // ->join('users', 'users.id', 'customers.updated_by')
            ->where('track_id', $track_id)
            ->get();
        }

        // dd($customer);

        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();

        $current_date_month = date('l, d F Y');

        return view('pages.detail', [
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'customer' => $customer,
            'nav_item' => 'customer_item',
            'nav_link' => 'customer_link',
            'current_date_month' => $current_date_month,
        ]);
    }

    public function edit($customer)
    {
        $query = Customer::join('channels', 'channels.id', 'customers.channel_id')
        ->join('distributions', 'distributions.id', 'customers.distribution_id')
        ->join('mitras', 'mitras.id', 'customers.mitra_id')
        ->join('teams', 'teams.id', 'customers.team_id')
        ->join('statuses', 'statuses.id', 'customers.status_id')
        ->where('track_id', $customer)
        ->count();
        
        if($query > 0)
        {
            $cust = Customer::join('channels', 'channels.id', 'customers.channel_id')
            ->join('distributions', 'distributions.id', 'customers.distribution_id')
            ->join('mitras', 'mitras.id', 'customers.mitra_id')
            ->join('teams', 'teams.id', 'customers.team_id')
            ->join('statuses', 'statuses.id', 'customers.status_id')
            ->where('track_id', $customer)
            ->first();
        }
        else
        {
            $cust = Customer::join('distributions', 'distributions.id', 'customers.distribution_id')
            ->where('track_id', $customer)
            ->first();
            // $cust = Customer::where('track_id', $customer)
            // ->get();
        }
        // return($cust);

        $distribution_list = Distribution::all();
        $channel_list = Channel::all();
        $status_list = Status::all();

        $sidebar_dist = Distribution::all();
        $sidebar_cust = Distribution::all();

        $current_date_month = date('l, d F Y');
        // dd($customer->nama_customer);
        return view('pages.edit', [
            'customer' => $cust,
            'sidebar_dist' => $sidebar_dist,
            'sidebar_cust' => $sidebar_cust,
            'distribution_list' => $distribution_list,
            'channel_list' => $channel_list,
            'status_list' => $status_list,
            'nav_item' => 'customer_item',
            'nav_link' => 'customer_link',
            'current_date_month' => $current_date_month,
        ]);
    }

    public function update(Request $request,$customer)
    {
        // return $customer;
        // $customer->updated_at = Carbon::now()->setTimezone('Asia/Makassar');
        // $customer->status_id = $request->status_id;
        // $customer->deskripsi = $request->deskripsi;
        
        // return $request;
        $validateData = $request->validate([
            'user_id' => 'required',
            'mitra_id' => 'required',
            'team_id' => 'required',
            'qrcode' => 'required',
            'status_id' => 'required',
            'deskripsi' => 'required',
        ]);
        

        Customer::where('track_id', $customer)
        ->update([
            'user_id' => $request->user_id,
            'odp_alternatif' => $request->odp_alternatif,
            'mitra_id' => $request->mitra_id,
            'team_id' => $request->team_id,
            'qrcode' => $request->qrcode,
            'status_id' => $request->status_id,
            'deskripsi' => $request->deskripsi,
            'updated_at' => Carbon::now()->setTimezone('Asia/Makassar'),
        ]);

        $success_notification = array(
            'message' => 'Tiket berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('edit', [$customer])->with($success_notification);
    }

    public function destroy($customer)
    {
        $cust = DB::table('customers')->where('track_id', $customer)->first();
        $dist_id = $cust->distribution_id;
        $dist = DB::table('distributions')->where('id', $dist_id)->first();
        $dist_kode = $dist->kode;
        
        DB::table('customers')->where('track_id', $customer)->delete();
        
        return redirect()->route('customer', [$dist_kode]);
    }
}
