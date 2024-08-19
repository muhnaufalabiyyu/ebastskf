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
                ->select('*', DB::raw('DATE_FORMAT(bastdt, "%d-%m-%Y") as bast_dt'), DB::raw('DATE_FORMAT(workstart, "%d-%m-%Y") as work_start'), DB::raw('DATE_FORMAT(workend, "%d-%m-%Y") as work_end'), DB::raw('DATE_FORMAT(userappvdt, "%d-%m-%Y %H:%i:%s") as userappv_dt'), DB::raw('DATE_FORMAT(ehsappvdt, "%d-%m-%Y %H:%i:%s") as ehsappv_dt'), DB::raw('DATE_FORMAT(purchappvdt, "%d-%m-%Y %H:%i:%s") as purchappv_dt'), DB::raw('DATE_FORMAT(rrdt, "%d-%m-%Y %H:%i:%s") as rr_dt'), DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as createdat'))
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
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        if ($action == 'stream') {
            return $pdf->stream($bastno . '.pdf');
        } elseif ($action == 'download') {
            return $pdf->download($bastno . '.pdf');
        }
    }
}
