<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    
    public function index()
    {
        $serviceCategories = ServiceCategory::all();
        return view('pages.service_category.index', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'create_nama'  => 'required'
        ];
        
        $messages = [
            'create_nama.required'  => 'Nama tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama' => $request->create_nama
        ];

        ServiceCategory::create($data);
        
        return back()->with('success', 'Data Berhasil di Tambah');
    }


    public function update(Request $request)
    {
        $rules = [
            'edit_nama'  => 'required',
        ];
        
        $messages = [
            'edit_nama.required'  => 'Nama tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama' => $request->edit_nama
        ];

        ServiceCategory::findOrFail($request->_edit_id)->update($data);
        
        return back()->with('success', 'Data Berhasil di Ubah');
    }

    public function destroy(Request $request)
    {
        ServiceCategory::findOrFail($request->_id)->delete();
        return back()->with('success', 'Data Berhasil di Hapus');
    }

    public function getServices($id){
        $services = Service::select('name')->where(['category_id' => $id])->get();
        return response()->json($services, 200);
    }
}
