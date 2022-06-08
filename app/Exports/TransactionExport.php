<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Service;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransactionExport implements FromView, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request; 

    function __construct($request){
        $this->request = $request;
    }

    public function view(): View
    {
    	$request = $this->request;
        
        $invoices = Invoice::with(['client', 'service'])->get();

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
                        ->get()
                        ->pluck('invoice')
                        ->flatten();

            if($invoices->isEmpty()){
                $layanan = null;
            }else{
                $layanan = $invoices[0]->service->nama;
            }
        }

        return view('pages.transaction.excel', compact('invoices', 'clients', 'services', 'klien', 'layanan'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 40,
            'E' => 20,  
        ];
    }
}
