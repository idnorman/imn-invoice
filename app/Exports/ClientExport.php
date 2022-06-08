<?php

namespace App\Exports;

use App\Models\Client;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ClientExport implements FromView, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $clientStatus; 

    function __construct($clientStatus){
        $this->clientStatus = $clientStatus;
    }

    public function view(): View
    {
        $clients = Client::all();
        $clientStatus = 'unknown';

        if($this->clientStatus == 'semua'){
            $clientStatus = 'semua';
            $clients = Client::all();
        }

        if($this->clientStatus == 'aktif'){
            $clientStatus = 'aktif';
            $now = date('Y-m-d');
            
            $clients = Client::whereHas('invoice', function($q) use ($now){
                $q->whereDate('tanggal_selesai', '>=', $now);
            })->orderBy('id', 'desc')->get();
        }

        if($this->clientStatus == 'nonaktif'){
            $clientStatus = 'nonaktif';
            $now = date('Y-m-d');
            $clients = Client::doesntHave('invoice')->orderBy('id', 'desc')->get();
        }

        return view('pages.client.excel', compact('clients', 'clientStatus'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15           
        ];
    }
}
