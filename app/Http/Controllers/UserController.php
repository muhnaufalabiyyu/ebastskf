<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;
use Carbon\Carbon;

class UserController extends Controller
{
    // show data skf user
    public function skfuser()
    {
        $users = DB::table('users')->where('level', '!=', 0)->get();

        foreach ($users as $user) {
            $level = $user->level;
            if ($level == 1) {
                $jabatan = 'Manager';
            } elseif ($level == 2) {
                $jabatan = 'Supervisor';
            } elseif ($level == 3) {
                $jabatan = 'Staff';
            } else {
                $jabatan = 'Undefined';
            }

            $user->jabatan = $jabatan;
        }

        $depts = DB::table('departemen2')->get();

        return view('administrator.skfuser', compact('users', 'depts'));
    }

    // show data supplier user
    public function supplieruser()
    {
        $users = DB::table('users')
            ->select('users.*', 'PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies.NamaSupplier')
            ->where('users.acting', 1)
            ->join('PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies', 'users.supplier_id', '=', DB::raw("PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies.KodeSupplier COLLATE SQL_Latin1_General_CP1_CI_AS"))
            ->orderBy('users.last_access', 'desc')
            ->get();

        return view('administrator.supplieruser', compact('users'));
    }

    // data needed for skf user addition
    public function indexuserskf()
    {
        $departemen = DB::table('departemen2')->get();

        return view('administrator.addskfuser', compact('departemen'));
    }

    // store skf user to db
    public function addskfuser(Request $request)
    {
        try {
            $fullname = $request->input('fullname');
            $email = $request->input('email');
            $rawpassword = $request->input('password');
            $password = Hash::make($rawpassword);
            $dept = $request->input('departemen');
            $level = $request->input('level');
            $signature = $request->file('signature');

            if($signature != null)
            {
                $signaturefilename = uniqid() . '_' . $signature->getClientOriginalName();
                $signaturedestinationPath = 'storage/signature/';
                $signaturepath = 'storage/signature/' . $signaturefilename;
                Storage::disk('public')->putFileAs($signaturedestinationPath, $signature, $signaturefilename);
            }

            if (($level == '1' && $dept == 'PURCH') || $dept == 'EHS') {
                $acting = 2;
                $gol = 3;
            } elseif (($level == '2' && $dept == 'PURCH') || $dept == 'EHS') {
                $acting = 3;
                $gol = 3;
            } elseif ($level == '2') {
                $acting = 2;
                $gol = 3;
            } elseif ($level == '1') {
                $acting = 2;
                $gol = 4;
            } elseif ($level == '3') {
                $acting = 2;
                $gol = 2;
            } else {
                $acting = 2;
                $gol = 2;
                // other condition here
            }

            DB::beginTransaction();

            $queryadduser = DB::table('users')->insert(['email' => $email, 'name' => $fullname, 'password' => $password, 'dept' => $dept, 'acting' => $acting, 'gol' => $gol, 'level' => $level, 'signaturepath' => $signaturepath, 'created_at' => Carbon::now()]);

            if ($queryadduser) {
                if ($level == 1) {
                    DB::table('departemen2')
                        ->where('alias', $dept)
                        ->update(['manager1' => $fullname, 'emailmgr1' => $email]);
                } elseif ($level == 2) {
                    DB::table('departemen2')
                        ->where('alias', $dept)
                        ->update(['spv1' => $fullname, 'emailspv1' => $email]);
                }
            }

            DB::commit();
            toastr()->success('User berhasil dibuat!');
            return redirect()->route('userskf');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }
    }

    // delete skf user from db
    public function deleteuserskf($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();

        return redirect()->route('userskf');
    }

    // update user skf
    public function edituserskf(Request $request, $id)
    {
        $name = $request->input('newfullname');
        $email = $request->input('newmail');
        $rawpassword = $request->input('newpassword');
        $newdept = $request->input('newdept');
        $newjabatan = $request->input('newjabatan');
        if ($newdept == 'PURCH' || $newdept == 'EHS' || $newdept == 'SCWH') {
            $gol = 3;
        } else {
            $gol = 4;
        }

        DB::beginTransaction();
        
        if (empty($rawpassword)) {
            $queryeditusr = DB::table('users')
                ->where('id', $id)
                ->update(['name' => $name, 'email' => $email, 'dept' => $newdept, 'level' => $newjabatan, 'gol' => $gol, 'last_update' => Carbon::now()]);
        } else {
            $password = Hash::make($rawpassword);
            $queryeditusr = DB::table('users')
                ->where('id', $id)
                ->update(['name' => $name, 'email' => $email, 'dept' => $newdept, 'level' => $newjabatan, 'gol' => $gol, 'password' => $password, 'last_update' => Carbon::now()]);
        }

        if ($queryeditusr) {
            if ($newjabatan == 1) {
                DB::table('departemen2')
                    ->where('alias', $newdept)
                    ->update(['manager1' => $name, 'emailmgr1' => $email]);
            } elseif ($newjabatan == 2) {
                DB::table('departemen2')
                    ->where('alias', $newdept)
                    ->update(['spv1' => $name, 'emailspv1' => $email]);
            }
        }

        DB::commit();

        toastr()->success('Data user berhasil diubah!');
        return redirect()->route('userskf');
    }

    // data needed for supplier user addition
    public function indexusersupplier()
    {
        $suppliers = DB::table('PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies')->get();

        return view('administrator.addsupplieruser', compact('suppliers'));
    }

    // store data supplier to db
    public function addsupplieruser(Request $request)
    {
        try {
            $signaturepath = null;
            $fullname = $request->input('fullname');
            $email = $request->input('email');
            $rawpassword = $request->input('password');
            $password = Hash::make($rawpassword);
            $supplier = $request->input('supplier');
            $signature = $request->file('signature');

            if($signature != null)
            {
                $signaturefilename = uniqid() . '_' . $signature->getClientOriginalName();
                $signaturedestinationPath = 'storage/signature/user/';
                $signaturepath = 'storage/signature/user/' . $signaturefilename;
                Storage::disk('public')->putFileAs($signaturedestinationPath, $signature, $signaturefilename);
            }

            DB::table('users')->insert(['email' => $email, 'name' => $fullname, 'password' => $password, 'supplier_id' => $supplier, 'acting' => '1', 'gol' => '0', 'signaturepath' => $signaturepath, 'created_at' => Carbon::now()]);

            toastr()->success('User berhasil dibuat!');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('usersupplier');
    }

    // delete supplier user from db
    public function deleteusersupplier($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();

        return redirect()->route('usersupplier');
    }

    public function editusersupplier(Request $request, $id)
    {
        $name = $request->input('newfullname');
        $email = $request->input('newmail');
        $rawpassword = $request->input('newpassword');

        if (empty($rawpassword)) {
            DB::table('users')
                ->where('id', $id)
                ->update(['name' => $name, 'email' => $email, 'last_update' => Carbon::now()]);
        } else {
            $password = Hash::make($rawpassword);
            DB::table('users')
                ->where('id', $id)
                ->update(['name' => $name, 'email' => $email, 'password' => $password, 'last_update' => Carbon::now()]);
        }

        toastr()->success('Data user berhasil diubah!');
        return redirect()->route('usersupplier');
    }
}