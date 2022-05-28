<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Client::all();
        return view('pages.client.index', compact('clients'));
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
            'create_sapaan.required'   => 'Gelar/sapaan tidak boleh kosong', 
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
            'edit_sapaan.required' => 'Gelar/sapaan tidak boleh kosong', 
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
}
