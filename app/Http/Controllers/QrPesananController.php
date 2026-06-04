<?php

namespace App\Http\Controllers;

class QrPesananController extends Controller
{
    public function index()
    {
        $pesanUrl = route('pesan.index');

        return view('admin.qr-pesanan.index', compact('pesanUrl'));
    }
}
