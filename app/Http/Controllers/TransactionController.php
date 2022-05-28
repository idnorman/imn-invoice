<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;

class TransactionController extends Controller
{

    public function index()
    {
        $invoices = Invoice::with(['client', 'service'])->get();
        return view('pages.transaction.index', compact('invoices'));
    }

}
