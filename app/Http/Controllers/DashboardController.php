<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\ServiceCategory;
use App\Models\Service;

use App\Models\Tagihan;
use App\Models\Transaction;

use Carbon\Carbon; 
use DB;

class DashboardController extends Controller
{
    public function index(){

        $date = Carbon::now();;

        $active_client = Client::whereHas('transaction', function($q) use ($date){
            $q->whereHas('tagihan', function($q2) use ($date){
                $q2->where('is_paid', 1)->whereDate('end_date', '>=', $date);
            });
        })->count();

        $total = [
            'client'        => Client::count(),
            'service'       => Service::count(),
            'transaction'   => Transaction::count(),
            'active_client' => $active_client
        ];

        $currMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $currMonthData = Service::join('transactions', 'transactions.service_id', 'services.id')
                        ->join('tagihans', 'tagihans.transaction_id', 'transactions.id')
                        ->select(
                            'services.id as service_id',
                            'services.nama as service_nama',
                            'transactions.id as transaction_id',
                            'tagihans.id as tagihan_id',
                            DB::raw("SUM(tagihans.total_harga) as harga_final")
                        )
                        ->whereMonth('tagihans.invoice_date', $currMonth)
                        ->groupBy('services.id', 'services.nama', 'transactions.id', 'tagihans.id')
                        ->get()
                        ->groupBy('service_id');

        $lastMonthData = Service::join('transactions', 'transactions.service_id', 'services.id')
                        ->join('tagihans', 'tagihans.transaction_id', 'transactions.id')
                        ->select(
                            'services.id as service_id',
                            'services.nama as service_nama',
                            'transactions.id as transaction_id',
                            'tagihans.id as tagihan_id',
                            DB::raw("SUM(tagihans.total_harga) as harga_final")
                        )
                        ->whereMonth('tagihans.invoice_date', $lastMonth)
                        ->groupBy('services.id', 'services.nama', 'transactions.id', 'tagihans.id')
                        ->get()
                        ->groupBy('service_id');

        
        $currMonthValue = $currMonthData->mapWithKeys(function ($group, $key) {
            return [$key => $group->sum('harga_final')];
        });
        $lastMonthValue = $lastMonthData->mapWithKeys(function ($group, $key) {
            return [$key => $group->sum('harga_final')];
        });

        $key = array_merge(array_keys($lastMonthValue->toArray()),array_keys($currMonthValue->toArray()));

        $currMonthServices = Service::whereIn('id', array_keys($currMonthValue->toArray()))->get()->groupBy('id');
        $lastMonthServices = Service::whereIn('id', array_keys($lastMonthValue->toArray()))->get()->groupBy('id');

        $services = Service::whereIn('id', $key)->get()->groupBy('id');

        $finalTotal = [];
        $temp = [];
        $i = 0;
        foreach($services as $service){
            $temp = [
                'service_id' => $service[0]->id,
                'service_name' => $service[0]->nama,
                'curr_month_value' => isset($currMonthValue[$service[0]->id]) ? $currMonthValue[$service[0]->id] : 0,
                'last_month_value' => isset($lastMonthValue[$service[0]->id]) ? $lastMonthValue[$service[0]->id] : 0,
            ];
            $finalTotal[$i] = $temp;
            $i++;
        }
        // dd($finalTotal);
        $currMonthTotal = getTotal(Tagihan::with('transaction.service')->whereMonth('invoice_date', $currMonth)->sum('total_harga'));
        $lastMonthTotal = getTotal(Tagihan::with('transaction.service')->whereMonth('invoice_date', $lastMonth)->sum('total_harga'));

        $diff = $this->diff($lastMonthTotal, $currMonthTotal);

        // $lastweek = Invoice::with('_user', 'client','service')->where('tanggal_invoice', '>=', Carbon::today()->subDays(7)->format('Y-m-d'))->orderBy('tanggal_invoice', 'desc')->get()->groupBy('tanggal_invoice', 'id', 'nomor_invoice', 'tanggal_mulai', 'tanggal_selesai', 'jatuh_tempo', 'masa_aktif', 'total_harga', 'user', 'klien', 'layanan', 'created_at', 'updated_at');
        $lastweek = Tagihan::with('transaction.client', 'transaction.service', 'user')->where('invoice_date', '>=', Carbon::today()->subDays(7)->format('Y-m-d'))->orderBy('invoice_date', 'desc')->get();
        // dd($lastweek);
        return view('pages.dashboard.index', compact('total', 'currMonthTotal', 'lastMonthTotal', 'diff', 'finalTotal'));
    }

    public function diff($x1, $x2) {

        if(!$x1){
            $x1 = 1;
        }
        $diff = ($x2 - $x1) / $x1;
        return round($diff * 100, 2);
    }
}
