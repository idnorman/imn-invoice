<?php

namespace App\Exports;

use App\Models\Service;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ServiceExport implements FromView, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $kategori; 

    function __construct($kategori){
        $this->kategori = $kategori;
    }

    public function view(): View
    {
        $services = Service::with('service_category')->withCount('invoice')->get();

        $kategori = 'null';

        if($this->kategori != 'null'){
                $kategori = $this->kategori;
                $services = ServiceCategory::with(['service' => function($q){
                    $q->withCount('invoice');
                }])
                ->where('id', $kategori)
                ->get()
                ->pluck('service')
                ->flatten();
            $kategori = $services->service_category->nama;
        }

        return view('pages.service.excel', compact('services', 'kategori'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 25,
            'D' => 25,
            'E' => 15        
        ];
    }
}
