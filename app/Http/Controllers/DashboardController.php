<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usrlogin = DB::table('users')
            ->where('is_login', 'Y')
            ->where('acting', '!=', '999')
            ->count();

        $bastcount = DB::table('bast')->count();
        $spcount = DB::table('PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies')->count();

        $activity = DB::table('activity')
            ->orderBy('time', 'desc')
            ->limit(10)
            ->get();

        foreach ($activity as $act) {
            if ($act->activity == 'createbast') {
                $supplier = DB::table('PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies')
                    ->where('KodeSupplier', $act->name)
                    ->first();
                if ($supplier) {
                    $act->supplier_name = $supplier->NamaSupplier;
                } else {
                    $act->supplier_name = 'NO NAME SUPPLIER';
                }
            } else {
                $act->supplier_name = null;
            }
        }

        $userlogin = DB::table('users')
            ->where('is_login', 'Y')
            ->where('acting', '!=', '999')
            ->orderBy('last_access', 'desc')
            ->get();

        return view('administrator.dashboard', compact('activity', 'userlogin'), ['total_users' => $usrlogin, 'total_bast' => $bastcount, 'total_supplier' => $spcount]);
    }
    
}
