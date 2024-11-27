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
        $users = DB::table('users')->select('users.*', 'supplier.supplier_name')->where('users.acting', 1)->join('supplier', 'users.supplier_id', '=', 'supplier.supplier_code')->orderBy('users.last_access', 'desc')->get();

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
            $jabatan = $request->input('jabatan');
            $signature = $request->file('signature');

            $signaturefilename = uniqid() . '_' . $signature->getClientOriginalName();
            $signaturedestinationPath = 'storage/signature/';
            $signaturepath = 'storage/signature/' . $signaturefilename;

            Storage::disk('public')->putFileAs($signaturedestinationPath, $signature, $signaturefilename);

            if (($jabatan == 'mgr' && $dept == 'PURCH') || $dept == 'EHS' || $dept == 'SCWH') {
                $acting = 2;
                $gol = 3;
                $level = 1;
            } elseif (($jabatan == 'spv' && $dept == 'PURCH') || $dept == 'EHS' || $dept == 'SCWH') {
                $acting = 3;
                $gol = 3;
                $level = 2;
            } elseif ($jabatan == 'spv') {
                $acting = 2;
                $gol = 3;
                $level = 2;
            } elseif ($jabatan == 'mgr') {
                $acting = 2;
                $gol = 4;
                $level = 1;
            } elseif ($jabatan == 'staff') {
                $acting = 2;
                $gol = 2;
                $level = 3;
            } else {
                $acting = 2;
                $gol = 2;
                $level = 5;
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
        DB::table('users')->where('id', $id)->delete();

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
        $suppliers = DB::table('supplier')->get();

        return view('administrator.addsupplieruser', compact('suppliers'));
    }

    // store data supplier to db
    public function addsupplieruser(Request $request)
    {
        try {
            $fullname = $request->input('fullname');
            $email = $request->input('email');
            $rawpassword = $request->input('password');
            $password = Hash::make($rawpassword);
            $supplier = $request->input('supplier');
            $signature = $request->file('signature');

            $signaturefilename = uniqid() . '_' . $signature->getClientOriginalName();
            $signaturedestinationPath = 'storage/signature/user/';
            $signaturepath = 'storage/signature/user/' . $signaturefilename;

            Storage::disk('public')->putFileAs($signaturedestinationPath, $signature, $signaturefilename);

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
        DB::table('users')->where('id', $id)->delete();

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
