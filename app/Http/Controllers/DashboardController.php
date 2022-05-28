<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\ServiceCategory;
use App\Models\Service;

use Carbon\Carbon; 

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

        return view('pages.dashboard.index', compact('total'));
    }
}
