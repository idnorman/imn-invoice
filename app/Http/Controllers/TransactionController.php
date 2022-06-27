<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Transaction;
use App\Models\Tagihan;

use App\Exports\TransactionExport;

use Illuminate\Support\Facades\Mail;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $clients = Client::all();
        $serviceCategories = ServiceCategory::all();

        $transactions = Transaction::with('client','service')->orderBy('date', 'desc')->get();
        // dd($transactions);

        return view('pages.transaction.index', compact('clients', 'serviceCategories', 'transactions'));
    }

    public function store(Request $request){

        $data = [
            'date'      => Carbon::now()->format('Y-m-d'),
            'client_id'    => $request->klien,
            'service_id'   => $request->layanan,
            'user_id'      => auth()->user()->id
        ];

        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambah');

    }

    public function show($id){
        $transaction = Transaction::with('client','service')->find($id);
        $tagihans    = Tagihan::where('transaction_id', $id)->get()->sortByDesc('end_date');

        $endDate = null;
        if($tagihans->first() != null){
            $endDate = Carbon::parse($tagihans->first()->end_date)->addDays(1);
        }

        return view('pages.transaction.detail', compact('transaction', 'tagihans', 'endDate'));
    }

    public function destroy(Request $request){
        $transaction = Transaction::find($request->id);

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil di Hapus'); 
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

    public function createInvoice(Request $request){

        $tagihan = Tagihan::create([
            'reff'              => $request->reff,
            'invoice_date'      => Carbon::now()->format('Y-m-d'),
            'due_date'          => Carbon::parse(formatDate($request->tanggal_mulai, 'Y-m-d'))->addDays(10)->format('Y-m-d'),
            'start_date'        => formatDate($request->tanggal_mulai, 'Y-m-d'),
            'end_date'          => formatDate($request->tanggal_selesai, 'Y-m-d'),
            'total_harga'       => $request->total_harga,
            'transaction_id'    => $request->transaction_id,
            'user_id'           => auth()->user()->id
        ]);

        return redirect()->back()->with('success', 'Tagihan berhasil dibuat');

    }

    public function paidOff($id){
        $tagihan = Tagihan::findOrFail($id)->update([
                        'is_paid' => 1
                    ]);
        return redirect()->back()->with('success', 'Status pembayaran berhasil diubah');
    }

    public function preview($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.template', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
    }

    public function download($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.template', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }

    public function previewSign($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateSign', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
    }

    public function downloadSign($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateSign', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }


    public function sendInvoice($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateSign', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        Mail::send('pages.transaction.template.mailTagihan', ['invoice' => $invoice, 'reff' => $reff, 'jatuhTempo' => $jatuhTempo], function($message) use ($invoice, $pdf){
            $message->to($invoice->transaction->client->email)
                    ->subject('Tagihan ' . $invoice->transaction->service->nama)
                    ->attachData($pdf->output(), $invoice->transaction->client->nama . '-' . $invoice->transaction->service->nama . '.pdf');
        });

        $invoice->update([
            'is_sent' => 1    
        ]);

        return redirect()->back()->with('success', 'Invoice tagihan berhasil dikirim');

    }


    public function sendProof($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateLunasSign', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        Mail::send('pages.transaction.template.mailLunas', ['invoice' => $invoice, 'reff' => $reff, 'jatuhTempo' => $jatuhTempo], function($message) use ($invoice, $pdf){
            $message->to($invoice->transaction->client->email)
                    ->subject('Tanda Terima Pembayaran Layanan ' . $invoice->transaction->service->nama)
                    ->attachData($pdf->output(), $invoice->transaction->client->nama . '-' . $invoice->transaction->service->nama . '.pdf');
        });

        $invoice->update([
            'is_paid' => 1    
        ]);

        return redirect()->back()->with('success', 'Tanda terima pembayaran berhasil dikirim');
    }

    public function downloadProof($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateLunas', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
    }

    public function downloadProofSign($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateLunasSign', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
    }

    public function previewProof($id){

        $invoice = Tagihan::with('transaction', 'transaction.service', 'transaction.client', 'transaction.user')->where('id', $id)->first();

        $month = numberToRoman(Carbon::parse($invoice->invoice_date)->format('m'));
        $year = Carbon::parse($invoice->invoice_date)->format('Y');
        $jatuhTempo = $invoice->due_date;

        $reff = $invoice->reff . '/INV-IMN/' . $invoice->user->inisial . '/' . $month . '/' . $year;

        $filename = $invoice->transaction->client->nama . '_' . $invoice->transaction->service->nama . '.pdf';

        $pdf = PDF::loadView('pages.transaction.template.templateLunas', compact('invoice', 'reff', 'jatuhTempo'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($filename);
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

            $invoices = Client::with(['invoice' => function($q){
                            $q->orderBy('tanggal_invoice', 'desc');
                        }, 'invoice.client', 'invoice.service'])
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

            $invoices = Service::with(['invoice' => function($q){
                            $q->orderBy('tanggal_invoice', 'desc');
                        }, 'invoice.service', 'invoice.client'])
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

        $filename = 'Data Transaksi PT. Instanet Media Nusantara.pdf';

        $pdf = PDF::loadView('pages.transaction.pdf', compact('invoices', 'clients', 'services', 'klien', 'layanan'));
        $pdf->setPaper('a4', 'portrait');


        return $pdf->stream($filename);

    }

    public function excel(Request $request){
        return Excel::download(new TransactionExport($request), 'Data Transaksi PT. IMN.xlsx');
    }

}
