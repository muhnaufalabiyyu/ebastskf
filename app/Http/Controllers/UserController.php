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
        $users = DB::table('users')
            ->select('users.*', 'departemen2.nama_dept')
            ->where('users.acting', 2)
            ->orWhere('users.acting', 3)
            ->join('departemen2', 'users.dept', '=', 'departemen2.alias')
            ->orderBy('users.last_access', 'desc')
            ->get();

        foreach ($users as $user) {
            $acting = $user->acting;
            if ($acting == 3) {
                $jabatan = 'Supervisor';
            } elseif ($acting == 2) {
                $jabatan = 'Manager';
            } else {
                // other condition for role here
            }

            $user->jabatan = $jabatan;
        }

        return view('administrator.skfuser', compact('users'));
    }

    // show data supplier user
    public function supplieruser()
    {
        $users = DB::table('users')
            ->select('users.*', 'supplier.supplier_name')
            ->where('users.acting', 1)
            ->join('supplier', 'users.supplier_id', '=', 'supplier.supplier_code')
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
            $jabatan = $request->input('jabatan');

            if (($jabatan == 'mgr' && $dept == 'PURCH') || $dept == 'EHS') {
                $acting = 2;
                $gol = 3;
            } elseif (($jabatan == 'spv' && $dept == 'PURCH') || $dept == 'EHS') {
                $acting = 3;
                $gol = 3;
            } elseif ($jabatan == 'spv') {
                $acting = 2;
                $gol = 3;
            } elseif ($jabatan == 'mgr') {
                $acting = 2;
                $gol = 4;
            } else {
                // other condition here
            }

            DB::table('users')->insert(['email' => $email, 'name' => $fullname, 'password' => $password, 'dept' => $dept, 'acting' => $acting, 'gol' => $gol, 'created_at' => Carbon::now()]);

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