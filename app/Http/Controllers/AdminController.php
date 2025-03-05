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

        return view('administrator.departemen', compact('deptdata'));
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

    public function updatestatus(Request $request)
    {
        $status = $request->status;
        $currdate = Carbon::now();

        if ($status == '2') {
            $update = DB::table('bast')
                ->where('id_bast', $request->id)
                ->update(['status' => $status, 'ehsappvdt' => $currdate, 'ehsappv' => 'Administrator']);
        } else if ($status == '3') {
            $update = DB::table('bast')
                ->where('id_bast', $request->id)
                ->update(['status' => $status, 'userappvdt' => $currdate, 'userappv' => 'Administrator']);
        } else if ($status == '4') {
            $update = DB::table('bast')
                ->where('id_bast', $request->id)
                ->update(['status' => $status, 'purchappvdt' => $currdate, 'purchappv' => 'Administrator']);
        }

        if ($update > 0) {
            return response()->json(['message' => 'Status updated successfully'], 200);
        }

        return response()->json(['message' => 'No changes made or invalid request'], 400);
    }

    public function adddept(Request $request)
    {
        try {
            DB::table('departemen2')->insert([
                'nama_dept' => $request->input('deptname'),
                'alias' => $request->input('alias'),
                'acting' => '1',
            ]);

            return redirect()->route('deptdata')->with('success', 'Departemen baru berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
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

    public function editdept(Request $request, $id)
    {
        try {
            DB::table('departemen2')
                ->where('id_dept', $id)
                ->update([
                    'nama_dept' => $request->input('newdeptname'),
                    'alias' => $request->input('newalias'),
                ]);

            return redirect()->route('deptdata')->with('success', 'Data departemen berhasil diupdate.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
}
