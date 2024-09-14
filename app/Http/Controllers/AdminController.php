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

    public function indexdept()
    {
        $deptdata = DB::table('departemen2')->get();
        $mgrdata = DB::table('users')->where('gol', '!=', '999')->where('gol', '!=', '0')->get();
        $spvdata = DB::table('users')->where('gol', '!=', '999')->where('gol', '!=', '0')->get();

        return view('administrator.departemen', compact('deptdata', 'mgrdata', 'spvdata'));
    }

    public function deletebast(Request $request, $id)
    {
        try {
            $pono = request('pono');

            DB::table('bast')->where('id_bast', $id)->delete();

            DB::table('purchase_order')
                ->where('no_po', $pono)
                ->update(['baststatus' => 0]);
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('bastdata');
    }

    public function deletedept($id)
    {
        try {
            DB::table('departemen2')->where('id_dept', $id)->delete();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('deptdata');
    }

    public function adddept(Request $request)
    {
        try {
            DB::table('departemen2')->insert([
                'nama_dept' => $request->input('deptname'),
                'alias' => $request->input('alias'),
                'manager1' => $request->input('newmgr1'),
                'emailmgr1' => $request->input('emailmgr1'),
                'manager2' => $request->input('newmgr2'),
                'emailmgr2' => $request->input('emailmgr2'),
                'spv1' => $request->input('newspv1'),
                'emailspv1' => $request->input('emailspv1'),
                'spv2' => $request->input('newspv2'),
                'emailspv2' => $request->input('emailspv2'),
            ]);

            return redirect()->route('deptdata')->with('success', 'Departemen baru berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    public function editdept(Request $request, $id)
    {
        try {
            DB::table('departemen2')
                ->where('id_dept', $id)
                ->update([
                    'nama_dept' => $request->input('newdeptname'),
                    'alias' => $request->input('newalias'),
                    'manager1' => $request->input('mgr1'),
                    'emailmgr1' => $request->input('newemailmgr1'),
                    'manager2' => $request->input('mgr2'),
                    'emailmgr2' => $request->input('newemailmgr2'),
                    'spv1' => $request->input('spv1'),
                    'emailspv1' => $request->input('newemailspv1'),
                    'spv2' => $request->input('spv2'),
                    'emailspv2' => $request->input('newemailspv2'),
                ]);

            return redirect()->route('deptdata')->with('success', 'Data departemen berhasil diupdate.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function getemail($name)
    {
        $users = DB::table('users')->where('name', $name)->first();

        if ($users) {
            return response()->json(['email' => $users->email]);
        } else {
            return response()->json(['email' => '']);
        }
    }
}
