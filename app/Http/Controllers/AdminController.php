<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;

class AdminController extends Controller
{
    public function indexbast()
    {
        $bastdata = DB::table('bast')->get();

        return view('administrator.bastdata', compact('bastdata'));
    }

    public function deletebast(Request $request, $id)
    {
        try {
            $pono = request('pono');

            DB::table('bast')
                ->where('id_bast', $id)
                ->delete();

            DB::table('purchase_order')
                ->where('no_po', $pono)
                ->update(['baststatus' => 0]);

        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('bastdata');
    }
}
