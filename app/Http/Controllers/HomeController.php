<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();
    //     $supplier_code = $user->supplier_id;

    //     $po = DB::table('purchase_order')
    //         ->select('no_po', 'date_po', 'no_pp', 'date_pp', 'date_eta', 'date_send', 'date_delivery_schedule', 'is_send', 'baststatus', 'supplier_code')
    //         ->where('supplier_code', $supplier_code)
    //         ->where('baststatus', 0)
    //         ->distinct()
    //         ->orderBy('date_po', 'asc')
    //         ->get();

    //     if (Auth::user()->acting == 1) {
    //         return view('home', compact('po'));
    //     } elseif (Auth::user()->acting == 2) {
    //         return redirect()->route('approval');
    //     }
    // }

    public function createbast()
    {
        $user = Auth::user();
        $supplier_code = $user->supplier_id;

        $dept = DB::table('departemen2')
            ->where('acting', 1)
            ->get();

        $supplier = DB::table('supplier')
            ->where('supplier_code', $supplier_code)
            ->get();

        return view('createbast', compact('supplier', 'dept'));
    }
}
