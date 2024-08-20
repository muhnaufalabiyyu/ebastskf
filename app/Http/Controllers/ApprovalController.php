<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SKFMail;
use Exception;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->dept;

        if ($user->acting == 999) {
            $approval = DB::table('bast')->get();
        } elseif ($role == 'EHS') {
            $approval = DB::table('bast')
                ->where('status', '1')
                ->get();
        } elseif ($role == 'PURCH') {
            $approval = DB::table('bast')
                ->where('status', '3')
                ->get();
        } elseif ($role == 'SCWH') {
            $approval = DB::table('bast')
                ->where('status', '4')
                ->get();
        } else {
            // User
            $approval = DB::table('bast')
                ->where('status', '2')
                ->where('to_user', $role)
                ->get();
        }

        return view('approval', compact('approval'));
    }

    public function rating(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $rate = $request->input('rateid' . $id);
            $notes = $request->input('userRemark');

            DB::table('bast')
                ->where('id_bast', $id)
                ->update(['user_rate' => $rate, 'status' => 2, 'userappv' => $user->name, 'usernotes' => $notes, 'userappvdt' => Carbon::now()]);

            DB::commit();
            return redirect()->route('approval');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $userappv = request('userappv');
            $rrno = request('rrno');

            $user = Auth::user();
            $data = DB::table('bast')->where('id_bast', $id)->first();

            if ($user->dept == 'EHS') {
                $status = 2;
                $notes = $request->input('ehsnotes');
                $usrappv = 'ehsappv';
                $field = 'ehsappvdt';
                $field2 = 'ehsnotes';
                $rate = request('rateehs' . $id);
            } elseif ($user->dept == 'PURCH') {
                $status = 4;
                $usrappv = 'purchappv';
                $field = 'purchappvdt';
            } elseif ($user->dept == 'SCWH') {
                $status = 5;
                $usrappv = 'rrusr';
            } else {
                // User except 3 above
                $status = 3;
                $usrappv = 'userappv';
                $field = 'userappvdt';
                $field2 = 'user_rate';
                $field3 = 'usernotes';
                $rate = request('rateid' . $id);
                $notes = request('userRemark');
                $actappv = request('actappv');
            }

            if ($user->dept == 'SCWH') {
                DB::transaction(function () use ($id, $user, $status, $userappv, $usrappv, $rrno) {
                    DB::table('bast')
                        ->where('id_bast', $id)
                        ->update(['status' => $status, $usrappv => $userappv, 'rrno' => $rrno, 'rrdt' => Carbon::now(), 'rrusr' => $user->name, 'updated_at' => Carbon::now()]);

                });
            } elseif ($user->dept == 'EHS') {
                DB::transaction(function () use ($id, $field, $field2, $status, $notes, $userappv, $usrappv, $rate) {
                    DB::table('bast')
                        ->where('id_bast', $id)
                        ->update(['status' => $status, $usrappv => $userappv, 'ehs_rate' => $rate, $field => Carbon::now(), $field2 => $notes, 'updated_at' => Carbon::now()]);


                });
            } elseif ($user->acting == 2 && $user->gol == 4) {
                // Untuk User
                if ($actappv == '1') {
                    DB::transaction(function () use ($id, $field, $field2, $field3, $status, $rate, $notes, $userappv, $usrappv) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update(['status' => $status, $usrappv => $userappv, $field => Carbon::now(), $field2 => $rate, $field3 => $notes, 'updated_at' => Carbon::now()]);


                    });
                } else {
                    DB::transaction(function () use ($id, $field, $field2, $field3, $rate, $notes, $userappv, $usrappv) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update([$usrappv => $userappv, $field => Carbon::now(), $field2 => $rate, $field3 => $notes, 'updated_at' => Carbon::now()]);
                    });
                }
            } else {
                // Untuk Purchasing saja
                DB::transaction(function () use ($id, $field, $status, $userappv, $usrappv) {
                  DB::table('bast')
                        ->where('id_bast', $id)
                        ->update(['status' => $status, $usrappv => $userappv, $field => Carbon::now(), 'updated_at' => Carbon::now()]);
                });

            }

            //send mail
            Mail::to('muhammadjakaria8@gmail.com')->send(new SKFMail($data));

            DB::table('activity')->insert(['name' => $userappv, 'activity' => 'approval', 'time' => Carbon::now()]);

            Session::flash('successapprove', 'Berita acara berhasil diapprove');
            return redirect()->route('approval');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', $e->getMessage());
        }
    }

    public function deny(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            DB::table('bast')
                ->where('id', $id)
                ->update(['status' => 3, 'denyact' => $request->input('denyact')]);

            DB::commit();
            return view('approval');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', $e->getMessage());
        }
    }
}
