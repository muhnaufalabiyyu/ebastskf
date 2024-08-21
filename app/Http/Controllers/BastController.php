<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Exception;

class BastController extends Controller
{
    public function store_bast(Request $request)
    {
        try {
            $copypopath     = null;
            $offerfilepath  = null;
            $reportfilepath = null;
            $enofafilepath  = null;
            $fakturfilepath = null;

            $user = Auth::user();
            $copypo = $request->file('copypo');
            $offerfile = $request->file('offerfile');
            $reportfile = $request->file('reportfile');
            $enofafile = $request->file('enofafile');
            $fakturfile = $request->file('fakturpajak');

            $copypofilename = uniqid() . '_' . $copypo->getClientOriginalName();
            $offerfilename = uniqid() . '_' . $offerfile->getClientOriginalName();
            $reportfilename = uniqid() . '_' . $reportfile->getClientOriginalName();

            $copypodestinationPath = 'storage/files/copypo/';
            $offerfiledestinationPath = 'storage/files/offerfile/';
            $reportfiledestinationPath = 'storage/files/reportfile/';

            $copypopath = 'files/copypo/' . $copypofilename;
            $offerfilepath = 'files/offerfile/' . $offerfilename;
            $reportfilepath = 'files/reportfile/' . $reportfilename;

            Storage::disk('public')->putFileAs($copypodestinationPath, $copypo, $copypofilename);
            Storage::disk('public')->putFileAs($offerfiledestinationPath, $offerfile, $offerfilename);
            Storage::disk('public')->putFileAs($reportfiledestinationPath, $reportfile, $reportfilename);

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

            if($enofafile)
            {
                $enofafilename = uniqid() . '_' . $enofafile->getClientOriginalName();
                $enofafiledestinationPath = 'storage/files/enofa/';
                $enofafilepath = 'files/enofa/' . $enofafilename;
                Storage::disk('public')->putFileAs($enofafiledestinationPath, $enofafile, $enofafilename);
            }

            if($fakturfile)
            {
                $fakturfilename = uniqid() . '_' . $fakturfile->getClientOriginalName();
                $fakturfiledestinationPath = 'storage/files/faktur/';
                $fakturfilepath = 'files/faktur/' . $fakturfilename;
                Storage::disk('public')->putFileAs($fakturfiledestinationPath, $fakturfile, $fakturfilename);
            }

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

            DB::transaction(function () use ($request, $copypopath, $offerfilepath, $reportfilepath, $enofafilepath, $fakturfilepath, $nextbastnum) {
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
                    'enofafile' => $enofafilepath,
                    'fakturfile' => $fakturfilepath,
                    'to_user' => $request->input('userapproval'),
                    'created_at' => Carbon::now(),
                    'itemname1' => $request->input('itemname1'),
                    'itemname2' => $request->input('itemname2'),
                    'itemname3' => $request->input('itemname3'),
                    'itemname4' => $request->input('itemname4'),
                    'itemname5' => $request->input('itemname5'),
                    'qtyitem1' => $request->input('qtyitem1'),
                    'qtyitem2' => $request->input('qtyitem2'),
                    'qtyitem3' => $request->input('qtyitem3'),
                    'qtyitem4' => $request->input('qtyitem4'),
                    'qtyitem5' => $request->input('qtyitem5'),
                    'unititem1' => $request->input('unititem1'),
                    'unititem2' => $request->input('unititem2'),
                    'unititem3' => $request->input('unititem3'),
                    'unititem4' => $request->input('unititem4'),
                    'unititem5' => $request->input('unititem5'),
                ];

                DB::table('bast')->insert($bastData);
            }, 5);

            //send email to user APPROVAL OUTSTANDING
            $sendMail = DB::table('departemen2')->select('emailmgr1', 'emailspv1')->where('alias','EHS')->get()
                        ->flatMap(function ($item) {
                            return [$item->emailmgr1, $item->emailspv1];
                        })->toArray();
            $approvalHeader = array('to' => 'EHS, Sustainability & BE', 'no' => $nextbastnum, 'note' => "-");
            $mail = Mail::send('mail.approvalmail', ["data" => $approvalHeader], function ($message) use ($approvalHeader,$sendMail) {
                $message->subject('Pemberitahuan Approval BAST: '.$approvalHeader['no']);
                $message->to($sendMail);
                // $message->cc('muhammadjakaria8@gmail.com');

            });

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
                    'status' => '1',
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
