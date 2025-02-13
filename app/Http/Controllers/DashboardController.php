<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
    
    public function test_email()
    {
        $sendMail = DB::table('departemen2')->select('emailmgr1', 'emailspv1')->where('alias','EHS')->get()
        ->flatMap(function ($item) {
            return [$item->emailmgr1, $item->emailspv1];
        })->toArray();
        $approvalHeader = array('to' => 'EHS, Sustainability & BE', 'no' => "13229821", 'note' => "-");
        //dd($sendMail);
        Mail::send('mail.approvalmail', ["data" => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
            $message->subject('Pemberitahuan Approval BAST: 212123');
            $message->to(["fauzi@unzypsoft.com", 'muhammadjakaria8@gmail.com']);
        });

        return redirect("/");
    }
}
