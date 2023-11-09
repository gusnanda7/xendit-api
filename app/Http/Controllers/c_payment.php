<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;
use App\Models\pembayaran;
use autoload;

class c_payment extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey('xnd_development_GfFUto261RPKTbnkIOMaLZ2D2HpWjKLoXe1qN3CtUYMlOeUNPoZHW1C3ltJ');
        $this->invoice = new InvoiceApi;
        $this->pembayaran = new pembayaran;
    }

    public function create(Request $request)
    {
        $eid = (string) Str::uuid();

        $params = [
            'external_id' => $eid,
            'payer_email' => $request->payer_email,
            'description' => $request->description,
            'amount' => $request->amount,
        ];

        $invoice = $this->invoice->createInvoice($params);

        $data = [
            'external_id' => $eid,
            'payer_email' => $request->payer_email,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => "Pending",
            'checkout_link' => $invoice['invoice_url']
        ];
        $this->pembayaran->addData($data);

        return response()->json($data);
    }
    public function bayar(Request $request)
    {
        $invoice = $this->invoice->getInvoiceById($request['id']);


        $id = $invoice['external_id'];
        $status = ucwords($invoice['status']);
        $data = ['status'=>$status];
        $this->pembayaran->editData($id, $data);

        return response()->json($request);
    }
}
