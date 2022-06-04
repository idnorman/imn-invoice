<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

use PDF;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ServiceExport;

class ServiceController extends Controller
{
    
    public function index(Request $request)
    {
        $services = Service::with('service_category')->withCount('invoice')->get();
        $serviceCategories = ServiceCategory::all();

        $kategori = 'null';

        if($request->kategori != 'null'){
                $kategori = $request->kategori;
                $services = ServiceCategory::with(['service' => function($q){
                    $q->withCount('invoice');
                }])
                ->where('id', $kategori)
                ->get()
                ->pluck('service')
                ->flatten();
        }

        return view('pages.service.index', compact('services', 'serviceCategories', 'kategori'));
    }

    public function store(Request $request)
    {
        $rules = [
            'create_nama'       => 'required',
            'create_harga'      => 'required|numeric',
            'create_kategori'   => 'required'
        ];
        
        $messages = [
            'create_nama.required'      => 'Nama layanan tidak boleh kosong',
            'create_harga.required'     => 'Harga tidak boleh kosong',
            'create_harga.numeric'      => 'Harga harus berupa angka',
            'create_kategori.required'  => 'Kategori layanan tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama'      => $request->create_nama,
            'harga'     => $request->create_harga,
            'kategori'  => $request->create_kategori
        ];

        Service::create($data);
        
        return back()->with('success', 'Data berhasil ditambah');
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_nama'       => 'required',
            'edit_harga'      => 'required|numeric',
            'edit_kategori'   => 'required'
        ];
        
        $messages = [
            'edit_nama.required'      => 'Nama layanan tidak boleh kosong',
            'edit_harga.required'     => 'Harga tidak boleh kosong',
            'edit_harga.numeric'      => 'Harga harus berupa angka',
            'edit_kategori.required'  => 'Kategori layanan tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama'      => $request->edit_nama,
            'harga'     => $request->edit_harga,
            'kategori'  => $request->edit_kategori
        ];

        Service::findOrFail($request->_edit_id)->update($data);
        
        return back()->with('success', 'Data berhasil diubah');
    }

    public function destroy(Request $request)
    {
        Service::findOrFail($request->_id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }


    public function pdf(Request $request)
    {
        $services = Service::with('service_category')->withCount('invoice')->get();

        $kategori = 'null';

        if($request->kategori != 'null'){
                $kategori = $request->kategori;
                $services = ServiceCategory::with(['service' => function($q){
                    $q->withCount('invoice');
                }])
                ->where('id', $kategori)
                ->get()
                ->pluck('service')
                ->flatten();
            $kategori = $services->service_category->nama;
        }

        $filename = 'Data Layanan PT. Instanet Media Nusantara.pdf';

        $pdf = PDF::loadView('pages.service.pdf', compact('services', 'kategori'));
        $pdf->setPaper('a4', 'portrait');


        return $pdf->stream($filename);
    }

    public function excel(Request $request){

        return Excel::download(new ServiceExport($request->kategori), 'Data Layanan PT. IMN.xlsx');
  
    }
}
