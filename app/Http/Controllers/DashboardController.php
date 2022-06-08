<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\ServiceCategory;
use App\Models\Service;

use Carbon\Carbon; 
use DB;

class DashboardController extends Controller
{
    public function index(){

        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();

        $total = [
            'client'        => Client::count(),
            'service'       => Service::count(),
            'invoice'       => Invoice::count(),
            'active_client' => Client::select('clients.id')->join('invoices', 'clients.id', 'invoices.klien')->whereDate('invoices.tanggal_selesai', '>', $date)->groupBy('clients.id')->get()->count()
        ];

        $currMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        // $currMonthData = Service::whereHas('invoice', function($q) use ($currMonth){
        //                         $q->whereMonth('tanggal_invoice', $currMonth);
        //                     })->withCount([
        //                         'invoice' => function($q) use ($currMonth){
        //                             $q->whereMonth('tanggal_invoice', $currMonth)->select(DB::raw("SUM(total_harga) as harga_final"));
        //                         }
        //                     ])->get();

        // $lastMonthData = Service::whereHas('invoice', function($q) use ($lastMonth){
        //                         $q->whereMonth('tanggal_invoice', $lastMonth);
        //                     })->withCount([
        //                         'invoice' => function($q) use ($lastMonth){
        //                             $q->whereMonth('tanggal_invoice', $lastMonth)->select(DB::raw("SUM(total_harga) as harga_final"));
        //                         }
        //                     ])->get();

        $currMonthData = Service::whereHas('invoice')->withCount([
                                'invoice' => function($q) use ($currMonth){
                                    $q->whereMonth('tanggal_invoice', $currMonth)->select(DB::raw("SUM(total_harga) as harga_final"));
                                }
                            ])->with(['invoice' => function ($q) use ($currMonth){
                                $q->whereMonth('tanggal_invoice', $currMonth);
                            }])->get();

        $lastMonthData = Service::whereHas('invoice')->withCount([
                                'invoice' => function($q) use ($lastMonth){
                                    $q->whereMonth('tanggal_invoice', $lastMonth)->select(DB::raw("SUM(total_harga) as harga_final"));
                                }
                            ])->with(['invoice' => function ($q) use ($lastMonth){
                                $q->whereMonth('tanggal_invoice', $lastMonth);
                            }])->get();


        $currMonthTotal = getTotal(Invoice::with('service')->whereMonth('tanggal_invoice', $currMonth)->sum('total_harga'));
        $lastMonthTotal = getTotal(Invoice::with('service')->whereMonth('tanggal_invoice', $lastMonth)->sum('total_harga'));

// dd(getTotal($lastMonthTotal));

        $diff = $this->diff($lastMonthTotal, $currMonthTotal);

        $lastweek = Invoice::with('_user', 'client','service')->where('tanggal_invoice', '>=', Carbon::today()->subDays(7)->format('Y-m-d'))->orderBy('tanggal_invoice', 'desc')->get()->groupBy('tanggal_invoice', 'id', 'nomor_invoice', 'tanggal_mulai', 'tanggal_selesai', 'jatuh_tempo', 'masa_aktif', 'total_harga', 'user', 'klien', 'layanan', 'created_at', 'updated_at');
        // dd($last7days);
        return view('pages.dashboard.index', compact('total', 'currMonthData', 'lastMonthData', 'currMonthTotal', 'lastMonthTotal', 'diff', 'lastweek'));
    }

    public function diff($x1, $x2) {
        $diff = ($x2 - $x1) / $x1;
        return round($diff * 100, 2);
    }
}
