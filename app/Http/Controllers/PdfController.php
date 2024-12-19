<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function generatePDF($id, $supplier_id, $action)
    {
        try {
            $user = Auth::user();
            $bast = DB::table('bast')->select('*', DB::raw('DATE_FORMAT(bastdt, "%d-%m-%Y") as bast_dt'), DB::raw('DATE_FORMAT(workstart, "%d-%m-%Y") as work_start'), DB::raw('DATE_FORMAT(workend, "%d-%m-%Y") as work_end'), DB::raw('DATE_FORMAT(userappvdt, "%d-%m-%Y %H:%i:%s") as userappv_dt'), DB::raw('DATE_FORMAT(ehsappvdt, "%d-%m-%Y %H:%i:%s") as ehsappv_dt'), DB::raw('DATE_FORMAT(purchappvdt, "%d-%m-%Y %H:%i:%s") as purchappv_dt'), DB::raw('DATE_FORMAT(rrdt, "%d-%m-%Y %H:%i:%s") as rr_dt'), DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as createdat'))->where('id_bast', $id)->get();
            $itemdetail = DB::table('bast')
                ->select('item_in_charge', 'item_in_charge_qty', 'item_in_charge_unit')
                ->where('id_bast', $id)
                ->first();

            $itemname = explode('||', $itemdetail->item_in_charge);
            $itemqty = explode('||', $itemdetail->item_in_charge_qty);
            $itemunit = explode('||', $itemdetail->item_in_charge_unit);

            $items = collect($itemname)->map(function ($name, $index) use ($itemqty, $itemunit) {
                return [
                    'name' => $name,
                    'qty' => $itemqty[$index] ?? null,
                    'unit' => $itemunit[$index] ?? null,
                ];
            });

            $bastno = json_decode($bast->pluck('bastno'), true)[0];
            $pono = $bast->pluck('pono');
            $spid = $bast->pluck('supplier_id');
            $dept = $bast->pluck('to_user');
            $spname = $bast->pluck('createdby');

            $supplier = DB::table('supplier')->where('supplier_code', $spid)->get();

            $userdata = DB::table('users')->where('dept', $dept)->where('level', '1')->value('name');
            $signatureuser = DB::table('users')->where('dept', $dept)->where('level', '1')->value('signaturepath');
            $signaturepurch = DB::table('users')->where('dept', 'PURCH')->where('level', '1')->value('signaturepath');

            // Signature User
            $signature = DB::table('users')->where('name', $spname)->value('signaturepath');

            if ($user->acting == 2 || $user->acting == 3 || $user->acting == 999) {
                $pdf = app('dompdf.wrapper')->loadView('pdfbast', compact('bast', 'supplier', 'userdata', 'items', 'signature', 'signatureuser', 'signaturepurch'));
            } elseif ($user->acting == 1) {
                if ($user->supplier_id == $supplier_id) {
                    $pdf = app('dompdf.wrapper')->loadView('pdfbast', compact('bast', 'supplier', 'userdata', 'items', 'signature', 'signatureuser', 'signaturepurch'));
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

    public function generatePDFSPR($supplier_code, $periode, $id)
    {
        try {
            $user = Auth::user();

            $appv = DB::table('spr_data')->where('id', $id)->get();

            $suppliers = DB::table('supplier')->where('supplier_code', $supplier_code)->get();

            // Menguraikan periode untuk mendapatkan bulan dan tahun
            $carbonPeriode = Carbon::parse($periode);
            $year = $carbonPeriode->year;
            $month = $carbonPeriode->month;
            $monthName = $carbonPeriode->format('F');
            $period = $monthName . ' ' . $year;

            // Mendapatkan tanggal awal tahun dan akhir bulan yang diberikan
            $startOfYear = Carbon::create($year, 1, 1)->startOfDay()->toDateString(); // '2024-01-01'
            $endOfMonth = $carbonPeriode->endOfMonth()->toDateString(); // '2024-06-30'

            // Query untuk mendapatkan data dengan kondisi yang ditentukan
            $spr = DB::table('spr_data')
                ->where('supplier_code', $supplier_code)
                ->whereBetween('periode', [$startOfYear, $endOfMonth])
                ->get();

            $spname = $appv->pluck('created_by');
            $appname = $appv->pluck('user_appv');

            // Mendapatkan tanda tangan user
            $signature = DB::table('users')->whereIn('name', $spname)->value('signaturepath');
            $signatureapp = DB::table('users')->whereIn('name', $appname)->value('signaturepath');

            // Membuat PDF
            $pdf = app('dompdf.wrapper')->loadView('pdfspr', compact('spr', 'signature', 'signatureapp', 'year', 'period', 'suppliers', 'appv'));
            return $pdf->stream('document.pdf');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }
}
