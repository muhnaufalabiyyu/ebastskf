<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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
            ->select("*", DB::raw("FORMAT(bastdt, 'dd-MM-yyyy') as bast_dt"), DB::raw("FORMAT(workstart, 'dd-MM-yyyy') as work_start"), DB::raw("FORMAT(workend, 'dd-MM-yyyy') as work_end"), DB::raw("FORMAT(userappvdt, 'dd-MM-yyyy HH:mm:ss') as userappv_dt"), DB::raw("FORMAT(ehsappvdt, 'dd-MM-yyyy HH:mm:ss') as ehsappv_dt"), DB::raw("FORMAT(purchappvdt, 'dd-MM-yyyy HH:mm:ss') as purchappv_dt"), DB::raw("FORMAT(rrdt, 'dd-MM-yyyy HH:mm:ss') as rr_dt"), DB::raw("FORMAT(created_at, 'dd-MM-yyyy HH:mm:ss') as createdat"))
            ->where('id_bast', $id)
            ->get();

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

        $supplier = DB::table('supplier')
            ->where('supplier_code', $supplier_id)
            ->get();

        return view('detail', compact('detail', 'supplier', 'items'));
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