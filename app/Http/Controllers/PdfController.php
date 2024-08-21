<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class PdfController extends Controller
{
    public function generatePDF($id, $supplier_id, $action)
    {
        try {
            $user = Auth::user();
            $bast = DB::table('bast')
                ->select("*", DB::raw("FORMAT(bastdt, 'dd-MM-yyyy') as bast_dt"), DB::raw("FORMAT(workstart, 'dd-MM-yyyy') as work_start"), DB::raw("FORMAT(workend, 'dd-MM-yyyy') as work_end"), DB::raw("FORMAT(userappvdt, 'dd-MM-yyyy HH:mm:ss') as userappv_dt"), DB::raw("FORMAT(ehsappvdt, 'dd-MM-yyyy HH:mm:ss') as ehsappv_dt"), DB::raw("FORMAT(purchappvdt, 'dd-MM-yyyy HH:mm:ss') as purchappv_dt"), DB::raw("FORMAT(rrdt, 'dd-MM-yyyy HH:mm:ss') as rr_dt"), DB::raw("FORMAT(created_at, 'dd-MM-yyyy HH:mm:ss') as createdat"))
                ->where('id_bast', $id)
                ->get();

            $bastno = json_decode($bast->pluck('bastno'), true)[0];
            $pono = $bast->pluck('pono');
            $spid = $bast->pluck('supplier_id');
            $dept = $bast->pluck('to_user');
            $spname = $bast->pluck('createdby');

            $supplier = DB::table('supplier')
                ->where('supplier_code', $spid)
                ->get();

            $userdata = DB::table('users')
                ->where('dept', $dept)
                ->where('acting', '2')
                ->whereIn('gol', ['3', '4'])
                ->value('name');

            // Signature User
            $signature = DB::table('users')
                ->where('name', $spname)
                ->value('signaturepath');
            if ($user->acting == 2 || $user->acting == 999) {
                $pdf = app('dompdf.wrapper')->loadView('pdfbast', compact('bast', 'supplier', 'userdata', 'signature'));
            } elseif ($user->acting == 1) {
                if ($user->supplier_id == $supplier_id) {
                    $pdf = app('dompdf.wrapper')->loadView('pdfbast', compact('bast', 'supplier', 'userdata', 'signature'));
                } else {
                    return redirect()->route('history');
                }
            } else {
                return redirect()->route('history');
            }

            if ($action == 'stream') {
                return $pdf->stream($bastno . '.pdf');
            } elseif ($action == 'download') {
                return $pdf->download($bastno . '.pdf');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            Session::flash('error', $e->getMessage());
        }
    }
}
