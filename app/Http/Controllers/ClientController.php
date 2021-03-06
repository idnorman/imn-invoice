<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use PDF;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ClientExport;

class ClientController extends Controller
{
    
    public function index(Request $request)
    {
        $clients = Client::all();
        $clientStatus = 'unknown';

        if($request->status == 'semua'){
            $clientStatus = 'semua';
            $clients = Client::all();
        }

        if($request->status == 'aktif'){
            $clientStatus = 'aktif';
            $now = date('Y-m-d');

            $clients = Client::whereHas('invoice', function($q) use ($now){
                $q->whereDate('tanggal_selesai', '>=', $now);
            })->get();
        }

        if($request->status == 'nonaktif'){
            $clientStatus = 'nonaktif';
            $now = date('Y-m-d');

            $clients = Client::doesntHave('invoice')->get();
        }

        return view('pages.client.index', compact('clients', 'clientStatus'));
    }

    public function store(Request $request)
    {
        $rules = [
            'create_nama'          => 'required',
            'create_sapaan'       => 'required',
            'create_email'         => 'email',
        ];

        $messages = [
            'create_nama.required'      => 'Nama tidak boleh kosong',
            'create_sapaan.required'   => 'Penanggung jawab tidak boleh kosong', 
            'create_email.email'        => 'Email tidak valid',
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama'      => $request->create_nama,
            'sapaan'   => $request->create_sapaan,
            'alamat'    => $request->create_alamat,
            'email'     => $request->create_email,
            'telepon'   => $request->create_telepon,
            'fax'       => $request->create_fax
        ];
                
        Client::insert($data);
        
        return back()->with('success', 'Klien Berhasil di Tambah');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('pages.client.edit', compact('client'));
    }

    public function update(Request $request)
    {

        $rules = [
            'edit_nama'          => 'required',
            'edit_sapaan'       => 'required',
            'edit_email'         => 'email',
        ];

        $messages = [
            'edit_nama.required'    => 'Nama tidak boleh kosong',
            'edit_sapaan.required' => 'Penanggung jawab tidak boleh kosong', 
            'edit_email.email'      => 'Email tidak valid',
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama'      => $request->edit_nama,
            'sapaan'   => $request->edit_sapaan,
            'alamat'    => $request->edit_alamat,
            'email'     => $request->edit_email,
            'telepon'   => $request->edit_telepon,
            'fax'       => $request->edit_fax
        ];

        $client = Client::find($request->_edit_id);
        $client->update($data);
        
        return back()->with('success', 'Data Berhasil di Ubah');
    }

    public function destroy(Request $request)
    {
        $client = Client::find($request->_delete_id);
        $client->delete();

        return back()->with('success', 'Data Berhasil di Hapus');
    }

    public function pdf(Request $request){
        $clients = Client::all();
        $clientStatus = 'unknown';

        if($request->status == 'semua'){
            $clientStatus = 'semua';
            $clients = Client::all();
        }

        if($request->status == 'aktif'){
            $clientStatus = 'aktif';
            $now = date('Y-m-d');

            $clients = Client::whereHas('invoice', function($q) use ($now){
                $q->whereDate('tanggal_selesai', '>=', $now);
            })->get();
        }

        if($request->status == 'nonaktif'){
            $clientStatus = 'nonaktif';
            $now = date('Y-m-d');
            $clients = Client::doesntHave('invoice')->get();
        }

        $filename = 'Data Klien PT. Instanet Media Nusantara.pdf';

        $pdf = PDF::loadView('pages.client.pdf', compact('clients', 'clientStatus'));
        $pdf->setPaper('a4', 'portrait');


        return $pdf->stream($filename);
    }

    public function excel(Request $request){

        return Excel::download(new ClientExport($request->status), 'Data Klien PT. IMN.xlsx');
  
    }
}
