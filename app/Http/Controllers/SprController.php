<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use Carbon\Carbon;

class SprController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->dept;

        $supplier = DB::table('supplier')->orderBy('supplier_name', 'asc')->get();

        return view('createspr', compact('supplier'));
    }

    public function store_spr(Request $request)
    {
        try {
            $user = Auth::user();

            DB::transaction(function () use ($request, $user) {
                $sprData = [
                    'supplier_code' => $request->input('supplier_code'),
                    'periode' => $request->input('periode'),
                    'qualitygrade' => $request->input('qualitygrade'),
                    'deliverygrade' => $request->input('deliverygrade'),
                    'sne1' => $request->input('sne1'),
                    'sne2' => $request->input('sne2'),
                    'sne3' => $request->input('sne3'),
                    'sne4' => $request->input('sne4'),
                    'auditresultgrade' => $request->input('auditresultgrade'),
                    'notequalitygrade' => $request->input('notequalitygrade'),
                    'notedeliverygrade' => $request->input('notedeliverygrade'),
                    'notesnegrade' => $request->input('notesnegrade'),
                    'created_at' => Carbon::now(),
                    'created_by' => $user->name,
                ];
                DB::table('spr_data')->insert($sprData);
            }, 5);

            // DB::table('activity')->insert(['name' => $user->supplier_id, 'activity' => 'createbast', 'time' => Carbon::now()]);

            Session::flash('sprsuccess', 'Supplier Performance Report berhasil dibuat');
            return redirect('historyspr');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect('historyspr');
        }
    }

    public function history()
    {
        $user = Auth()->user();

        // Mengambil data spr_data dan melakukan join dengan tabel supplier
        $sprdata = DB::table('spr_data')
            ->leftJoin('supplier', 'spr_data.supplier_code', '=', 'supplier.supplier_code')
            ->select('spr_data.*', 'supplier.supplier_name')
            ->get()
            ->map(function($item) {
                // Mengubah format kolom periode menggunakan Carbon
                $item->periode = Carbon::parse($item->periode)->format('F Y');
                return $item;
            });

        return view('historyspr', compact('sprdata'));
    }


    public function indexapproval()
    {
        $user = Auth()->user();

        $sprdata = DB::table('spr_data')
            ->where('status', '1')
            ->get();

        return view('approvalspr', compact('sprdata'));
    }

    public function approvespr($id, $userappv)
    {
        try {
            DB::transaction(function () use ($id, $userappv) {
                DB::table('spr_data')
                    ->where('id', $id)
                    ->update(['status' => '2', 'user_appv' => $userappv, 'updated_at' => Carbon::now()]);
            });

            Session::flash('successapprove', 'SPR berhasil diapprove');
            return redirect()->route('approvalspr');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->route('approvalspr');
        }
    }
}
