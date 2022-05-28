<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\ServiceCategory;
use App\Models\Service;

use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with(['client', 'service'])->get();
        return view('pages.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients  = Client::all();
        $serviceCategories = ServiceCategory::all();

        return view('pages.invoice.create', compact('clients', 'serviceCategories'));
    }

    public function generate(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'klien' => 'required',
            'kategori' => 'required',
            'layanan' => 'required',
            'nomor_invoice' => 'required',
            'total_harga' => 'required'
        ];
        
        $messages = [
            'klien.required' => 'Klien belum dipilih',
            'kategori.required' => 'Kategori layanan belum dipilih',
            'layanan.required' => 'Layanan belum dipilih',
            'nomor_invoice.required' => 'Nomor Invoice tidak boleh kosong',
            'total_harga.required' => 'Total Harga tidak boleh kosong'         
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nomor_invoice'  => $request->nomor_invoice,
            'tanggal_invoice'  => formatDate($request->tanggal_invoice, 'Y-m-d'),
            'tanggal_mulai'  => formatDate($request->tanggal_mulai, 'Y-m-d'),
            'tanggal_selesai'  => formatDate($request->tanggal_selesai, 'Y-m-d'),
            'jatuh_tempo'  => formatDate($request->jatuh_tempo, 'Y-m-d'),
            'masa_aktif'  => $request->masa_aktif,
            'total_harga'  => $request->total_harga,
            'user'  => auth()->user()->id,
            'klien'  => $request->klien,
            'layanan'  => $request->layanan
        ];
        
        Invoice::create($data);
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::with(['client', 'service.service_category'])->where('invoices.id', $id)->first();
        $serviceCategories = ServiceCategory::all();
        $clients  = Client::all();
        $services = Service::where('kategori', $invoice->service->service_category->id)->get();
        return view('pages.invoice.edit', compact('invoice', 'serviceCategories', 'clients', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'klien' => 'required',
            'kategori' => 'required',
            'layanan' => 'required',
            'nomor_invoice' => 'required',
            'total_harga' => 'required'
        ];
        
        $messages = [
            'klien.required' => 'Klien belum dipilih',
            'kategori.required' => 'Kategori layanan belum dipilih',
            'layanan.required' => 'Layanan belum dipilih',
            'nomor_invoice.required' => 'Nomor Invoice tidak boleh kosong', 
            'total_harga.required' => 'Total Harga tidak boleh kosong'                 
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nomor_invoice'  => $request->nomor_invoice,
            'tanggal_invoice'  => formatDate($request->tanggal_invoice, 'Y-m-d'),
            'tanggal_mulai'  => formatDate($request->tanggal_mulai, 'Y-m-d'),
            'tanggal_selesai'  => formatDate($request->tanggal_selesai, 'Y-m-d'),
            'jatuh_tempo'  => formatDate($request->jatuh_tempo, 'Y-m-d'),
            'masa_aktif'  => $request->masa_aktif,
            'total_harga'  => $request->total_harga,
            'user'  => auth()->user()->id,
            'klien'  => $request->klien,
            'layanan'  => $request->layanan
        ];

        Invoice::findOrFail($request->id)->update($data);
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Invoice::findOrFail($request->id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }


    public function getServices($id){
        
        if (!$id) {
            $html = '<option value="" selected disabled> Pilih Layanan </option>';
        } else {
            $html = '<option value="" selected disabled> Pilih Layanan </option>';
            $services = Service::where(['kategori' => $id])->get();
            foreach ($services as $service) {
                $html .= '<option value="'.$service->id.'" data-harga="' . $service->harga . '" >'.$service->nama.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function editGetServices($id){
        
        if (!$id) {
            $html = '<option value="" selected disabled> Pilih Layanan </option>';
        } else {
            $services = Service::where(['kategori' => $id])->get();

            if(!$services->isEmpty()){
                $html = '<option value="" disabled> Pilih Layanan </option>';
                foreach ($services as $service) {
                    $html .= '<option value="'.$service->id.'" data-harga="' . $service->harga . '" >'.$service->nama.'</option>';
                }
            }else{
                $html = '<option value="" selected disabled> Pilih Layanan </option>';
            }
            
        }

        return response()->json(['html' => $html]);
    }

    public function preview($id){
        $invoice = Invoice::with(['client', 'service.service_category', '_user'])->where('invoices.id', $id)->first();

        $filename = $invoice->client->nama . '_' . $invoice->service->nama . '.pdf';
        // return view('pages.invoice.template', compact('invoice'));

        // dd($invoice);
        // share data to view
        // view()->share('invoice',$invoice);
        $tanda_tangan['status'] = false;
        $pdf = PDF::loadView('pages.invoice.template', compact('invoice', 'tanda_tangan'));
        $pdf->setPaper('letter', 'portrait');


        // download PDF file with download method
        return $pdf->stream($filename);
    }

    public function download($id){
        $invoice = Invoice::with(['client', 'service.service_category', '_user'])->where('invoices.id', $id)->first();

        $filename = $invoice->client->nama . '_' . $invoice->service->nama . '.pdf';
        // return view('pages.invoice.template', compact('invoice'));

        // dd($invoice);
        // share data to view
        // view()->share('invoice',$invoice);
        $tanda_tangan['status'] = false;
        $pdf = PDF::loadView('pages.invoice.template', compact('invoice', 'tanda_tangan'));
        $pdf->setPaper('letter', 'portrait');


        // download PDF file with download method
        return $pdf->download($filename);
    }
}
