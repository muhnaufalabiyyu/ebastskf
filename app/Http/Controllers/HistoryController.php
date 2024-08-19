<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    function index()
    {
        $user = Auth()->user();

        if ($user->acting == 1) {
            $bast = DB::table('bast')
                ->where('supplier_id', $user->supplier_id)
                ->get();
        } else {
            $bast = DB::table('bast')->get();
        }

        return view('history', compact('bast'));
    }

    function detail($id, $supplier_id)
    {
        $detail = DB::table('bast')
            ->select('*', DB::raw('DATE_FORMAT(bastdt, "%d-%m-%Y") as bast_dt'), DB::raw('DATE_FORMAT(workstart, "%d-%m-%Y") as work_start'), DB::raw('DATE_FORMAT(workend, "%d-%m-%Y") as work_end'), DB::raw('DATE_FORMAT(userappvdt, "%d-%m-%Y %H:%i:%s") as userappv_dt'), DB::raw('DATE_FORMAT(ehsappvdt, "%d-%m-%Y %H:%i:%s") as ehsappv_dt'), DB::raw('DATE_FORMAT(purchappvdt, "%d-%m-%Y %H:%i:%s") as purchappv_dt'), DB::raw('DATE_FORMAT(rrdt, "%d-%m-%Y %H:%i:%s") as rr_dt'), DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as createdat'))
            ->where('id_bast', $id)
            ->get();

        $pono = $detail->pluck('pono');
        $purchaseorder = DB::table('purchase_order')
            ->where(function ($query) use ($pono) {
                $query->whereIn('no_po', $pono);
            })
            ->get();

        $supplier = DB::table('supplier')
            ->where('supplier_code', $supplier_id)
            ->get();

        return view('detail', compact('detail', 'supplier', 'purchaseorder'));
    }

    function editbast($id, $supplier_id)
    {
        $detail = DB::table('bast')
            ->where('id_bast', $id)
            ->get();

        $pono = $detail->pluck('pono');

        $itempo = DB::table('purchase_order')
            ->where('no_po', $pono)
            ->get();

        $supplier = DB::table('supplier')
            ->where('supplier_code', $supplier_id)
            ->get();

        $dept = DB::table('departemen2')
            ->where('acting', 1)
            ->get();

        return view('editbast', compact('detail', 'supplier', 'dept', 'itempo'));
    }
}
