<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Service;

use App\Exports\TransactionExport;

use PDF;
use Maatwebsite\Excel\Facades\Excel;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $invoices = Invoice::with(['client', 'service'])->orderBy('tanggal_invoice', 'desc')->get();

        $klien = null;
        $layanan = null;

        $clients = Client::all();
        $services = Service::all();

        if($request->klien != null && $request->layanan != null){
            $klien = $request->klien;
            $layanan = $request->layanan;

            $invoices = Invoice::with('client', 'service')
                        ->whereHas(
                            'client', function($query) use ($klien){
                                $query->where('id', $klien);
                            }
                        )
                        ->whereHas(
                            'service', function($query) use ($layanan){
                                $query->where('id', $layanan);
                            }
                        )
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get();

        }

        if($request->klien != null && $request->layanan == null){
            $klien = $request->klien;

            $invoices = Client::with('invoice', 'invoice.client', 'invoice.service')
                        ->where('id', $klien)
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get()
                        ->pluck('invoice')
                        ->flatten();
        }

        if($request->klien == null && $request->layanan != null){

            $layanan = $request->layanan;

            $invoices = Service::with('invoice', 'invoice.service', 'invoice.client')
                        ->where('id', $layanan)
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get()
                        ->pluck('invoice')
                        ->flatten();
        }

        return view('pages.transaction.index', compact('invoices', 'clients', 'services', 'klien', 'layanan'));
    }

    public function pdf(Request $request){

        $invoices = Invoice::with(['client', 'service'])->orderBy('tanggal_invoice', 'desc')->get();

        $klien = null;
        $layanan = null;

        $clients = Client::all();
        $services = Service::all();

        if($request->klien != null && $request->layanan != null){
            $klien = $request->klien;
            $layanan = $request->layanan;

            $invoices = Invoice::with('client', 'service')
                        ->whereHas(
                            'client', function($query) use ($klien){
                                $query->where('id', $klien);
                            }
                        )
                        ->whereHas(
                            'service', function($query) use ($layanan){
                                $query->where('id', $layanan);
                            }
                        )
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get();

            if($invoices->isEmpty()){
                $klien = null;
                $layanan = null;
            }else{
                $klien = $invoices[0]->client->nama;
                $layanan = $invoices[0]->service->nama;
            }

        }

        if($request->klien != null && $request->layanan == null){
            $klien = $request->klien;

            $invoices = Client::with('invoice', 'invoice.client', 'invoice.service')
                        ->where('id', $klien)
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get()
                        ->pluck('invoice')
                        ->flatten();


            if($invoices->isEmpty()){
                $klien = null;
            }else{
                $klien = $invoices[0]->client->nama;
            }
        }

        if($request->klien == null && $request->layanan != null){

            $layanan = $request->layanan;

            $invoices = Service::with('invoice', 'invoice.service', 'invoice.client')
                        ->where('id', $layanan)
                        ->orderBy('tanggal_invoice', 'desc')
                        ->get()
                        ->pluck('invoice')
                        ->flatten();

            if($invoices->isEmpty()){
                $layanan = null;
            }else{
                $layanan = $invoices[0]->service->nama;
            }
        }

        $filename = 'Data Transaksi PT. Instanet Media Nusantara.pdf';

        $pdf = PDF::loadView('pages.transaction.pdf', compact('invoices', 'clients', 'services', 'klien', 'layanan'));
        $pdf->setPaper('a4', 'portrait');


        return $pdf->stream($filename);

    }

    public function excel(Request $request){
        return Excel::download(new TransactionExport($request), 'Data Transaksi PT. IMN.xlsx');
    }

}
