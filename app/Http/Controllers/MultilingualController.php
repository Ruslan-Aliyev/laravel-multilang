<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class MultilingualController extends Controller
{
    public function show($locale)
    {
        return view("multilingual.{$locale}");
    }

    public function toPdf($locale)
    {
        $pdf = PDF::loadView("multilingual.{$locale}-pdf")->setPaper([0, 0, 594, 841], 'portrait');

        return $pdf->download("pdf_{$locale}.pdf");
    }
}
