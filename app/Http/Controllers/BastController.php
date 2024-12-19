<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class BastController extends Controller
{
    public function store_bast(Request $request)
    {
        try {
            $user = Auth::user();
            $copypo = $request->file('copypo');
            $offerfile = $request->file('offerfile');
            $reportfile = $request->file('reportfile');

            $copyponame = $copypo->getClientOriginalName();
            $offerfilename = $offerfile->getClientOriginalName();
            $reportfilename = $reportfile->getClientOriginalName();

            $copypopath = 'public/files/copypo/' . $copyponame;
            $offerfilepath = 'public/files/offerfile/' . $offerfilename;
            $reportfilepath = 'public/files/reportfile/' . $reportfilename;

            Storage::disk('local')->put($copypopath, file_get_contents($copypo));
            Storage::disk('local')->put($offerfilepath, file_get_contents($offerfile));
            Storage::disk('local')->put($reportfilepath, file_get_contents($reportfile));

            $lastbast = DB::table('bast')
                ->orderBy('id_bast', 'desc')
                ->first();

            $currentdate = Carbon::now();
            $romanized_arr = [
                'I' => 'January',
                'II' => 'February',
                'III' => 'March',
                'IV' => 'April',
                'V' => 'May',
                'VI' => 'June',
                'VII' => 'July',
                'VIII' => 'August',
                'IX' => 'September',
                'X' => 'October',
                'XI' => 'November',
                'XII' => 'December',
            ];

            $months = $currentdate->format('n');
            $rom_month = array_search(date('F', mktime(0, 0, 0, $months, 1)), $romanized_arr);

            if ($lastbast) {
                $lastbastno = explode('/', $lastbast->bastno);
                $number = intval($lastbastno[0]);
                $nextnum = $number + 1;

                $nextbastnum = str_pad($nextnum, strlen($lastbastno[0]), '0', STR_PAD_LEFT) . '/' . implode('/', array_slice($lastbastno, 1));
            } else {
                $nextbastnum = '0001/SKF/' . $rom_month . '/' . Carbon::now()->year;
            }

            $items = $request->input('items');

            $itemNames = array_column($items, 'itemname');
            $quantities = array_column($items, 'qtyitem');
            $units = array_column($items, 'unititem');

            $itemNamesString = implode('||', $itemNames);
            $quantitiesString = implode('||', $quantities);
            $unitsString = implode('||', $units);

            // dd($itemNamesString, $itemSpecsString, $quantitiesString, $unitsString);

            DB::transaction(function () use ($request, $copypopath, $offerfilepath, $reportfilepath, $nextbastnum, $itemNamesString, $quantitiesString, $unitsString) {
                $bastData = [
                    'pono' => $request->input('ponumber'),
                    'offerno' => $request->input('offernumber'),
                    'bastno' => $nextbastnum,
                    'bastdt' => now(),
                    'createdby' => $request->input('createdby'),
                    'workstart' => $request->input('startdate'),
                    'workend' => $request->input('enddate'),
                    'workdesc' => $request->input('jobname'),
                    'status' => '1',
                    'supplier_id' => Auth::user()->supplier_id,
                    'copypofile' => $copypopath,
                    'offerfile' => $offerfilepath,
                    'reportfile' => $reportfilepath,
                    'to_user' => $request->input('userapproval'),
                    'created_at' => Carbon::now(),
                    'item_in_charge' => $itemNamesString,
                    'item_in_charge_qty' => $quantitiesString,
                    'item_in_charge_unit' => $unitsString
                ];

                DB::table('bast')->insert($bastData);
            }, 5);

            DB::table('activity')->insert(['name' => $user->supplier_id, 'activity' => 'createbast', 'time' => Carbon::now()]);

            Session::flash('successbast', 'Berita Acara anda berhasil dibuat');
            return redirect('history');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect('history');
        }
    }

    public function inputedit(Request $request)
    {
        try {
            $user = Auth::user();
            $bastno = $request->input('bastnumber');

            DB::table('bast')
                ->where('bastno', $bastno)
                ->update([
                    'bastno' => $bastno . '-1',
                    'editedby' => $user->name,
                    'updated_at' => Carbon::now(),
                    'workdesc' => $request->input('jobname'),
                    'workstart' => $request->input('startdate'),
                    'workend' => $request->input('enddate'),
                    'to_user' => $request->input('userapproval'),
                    'status' => '1'
                ]);

            Session::flash('successbast', 'Berita Acara anda berhasil diedit');
            return redirect('history');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect('history');
        }
    }
}
