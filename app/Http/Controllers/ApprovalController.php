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
                ->where(function ($query) {
                    $query->where('status', '1')->orWhere(function ($subquery) {
                        $subquery->where('status', '2')->where('to_user', 'EHS');
                    });
                })
                ->get();
        } elseif ($role == 'PURCH') {
            $approval = DB::table('bast')->where('status', '3')->get();
        } elseif ($role == 'SCWH') {
            $approval = DB::table('bast')
                ->where(function ($query) {
                    $query->where('status', '4')->orWhere(function ($subquery) {
                        $subquery->where('status', '2')->where('to_user', 'SCWH');
                    });
                })
                ->get();
        } else {
            // User
            $approval = DB::table('bast')->where('status', '2')->where('to_user', $role)->get();
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
        $userappv = request('userappv');
        $rrno = request('rrno');
        $currstatus = request('currstatus');

        $user = Auth::user();
        $data = DB::table('bast')->where('id_bast', $id)->first();

        if ($user->dept == 'EHS') {
            if ($currstatus == 1) {
                $status = 2;
                $notes = $request->input('ehsnotes');
                $usrappv = 'ehsappv';
                $field = 'ehsappvdt';
                $field2 = 'ehsnotes';
                $rate = request('rateehs' . $id);
            } elseif ($currstatus == 2) {
                $status = 3;
                $usrappv = 'userappv';
                $field = 'userappvdt';
                $field2 = 'user_rate';
                $field3 = 'usernotes';
                $rate = request('rateid' . $id);
                $notes = request('userRemark');
                $actappv = request('actappv');
            }
        } elseif ($user->dept == 'PURCH') {
            $status = 4;
            $usrappv = 'purchappv';
            $field = 'purchappvdt';
        } elseif ($user->dept == 'SCWH') {
            if ($currstatus == 2) {
                $status = 3;
                $usrappv = 'userappv';
                $field = 'userappvdt';
                $field2 = 'user_rate';
                $field3 = 'usernotes';
                $rate = request('rateid' . $id);
                $notes = request('userRemark');
                $actappv = request('actappv');
            } elseif ($currstatus == 4) {
                $status = 5;
                $usrappv = 'rrusr';
            }
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

        try {
            if ($user->dept == 'SCWH') {
                if ($currstatus == '2') {
                    if ($actappv == '1') {
                        DB::transaction(function () use ($id, $field, $field2, $field3, $status, $rate, $notes, $userappv, $usrappv) {
                            DB::table('bast')
                                ->where('id_bast', $id)
                                ->update([
                                    'status' => $status,
                                    $usrappv => $userappv,
                                    $field => Carbon::now(),
                                    $field2 => $rate,
                                    $field3 => $notes,
                                    'updated_at' => Carbon::now(),
                                ]);
                        });

                        //send email to user APPROVAL PURCH OUTSTANDING
                        $sendMail = DB::table('departemen2')
                            ->select('emailmgr1', 'emailspv1')
                            ->where('alias', 'PURCH')
                            ->get()
                            ->flatMap(function ($item) {
                                return [$item->emailmgr1, $item->emailspv1];
                            })
                            ->toArray();
                        $approvalHeader = ['to' => 'Purchasing', 'no' => $data->bastno, 'note' => $request->input('userRemark') ?? '-'];
                        $mail = Mail::send('mail.approvalmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                            $message->subject('Pemberitahuan Approval BAST: ' . $approvalHeader['no']);
                            $message->to($sendMail);
                            // $message->cc('muhammadjakaria8@gmail.com');
                        });
                    } else {
                        DB::transaction(function () use ($id, $field, $field2, $field3, $rate, $notes, $userappv, $usrappv) {
                            DB::table('bast')
                                ->where('id_bast', $id)
                                ->update([
                                    $usrappv => $userappv,
                                    $field => Carbon::now(),
                                    $field2 => $rate,
                                    $field3 => $notes,
                                    'updated_at' => Carbon::now(),
                                ]);
                        });

                        //send email to user REJECT EHS OUTSTANDING
                        $sendMail = DB::table('departemen2')
                            ->select('emailmgr1', 'emailspv1')
                            ->where('alias', 'EHS')
                            ->get()
                            ->flatMap(function ($item) {
                                return [$item->emailmgr1, $item->emailspv1];
                            })
                            ->toArray();
                        $approvalHeader = ['to' => 'EHS, Sustainability & BE', 'no' => $data->bastno, 'note' => $request->input('userRemark') ?? '-'];
                        $mail = Mail::send('mail.rejectmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                            $message->subject('Pemberitahuan Reject BAST: ' . $approvalHeader['no']);
                            $message->to($sendMail);
                            // $message->cc('muhammadjakaria8@gmail.com');
                        });
                    }
                } elseif ($currstatus == '4') {
                    DB::transaction(function () use ($id, $user, $status, $userappv, $usrappv, $rrno) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update(['status' => $status, $usrappv => $userappv, 'rrno' => $rrno, 'rrdt' => Carbon::now(), 'rrusr' => $user->name, 'updated_at' => Carbon::now()]);

                        //send email to supplier
                        $supp = DB::table('PURCHASING.dbo.Unzyp_MasterSupplier_ShopSupplies')
                            ->where('KodeSupplier', $data->supplier_id)
                            ->first();
                        $validMail = $supp->Email;

                        //chek email tidak kosong
                        if (!empty($validMail)) {
                            //seleksi email dengan titik koma, dan koma
                            $emails = preg_split('/\s*[,;]\s*/', $validMail);
                            $emails = array_map('trim', $emails);

                            //check validitas email
                            foreach ($emails as $email) {
                                if (filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                                    $validEmails[] = trim($email);
                                }
                            }

                            if (!empty($validEmails)) {
                                $headerMail = ['to' => $supp->NamaSupplier, 'no' => $data->bastno, 'note' => '-'];
                                $mail = Mail::send('mail.suppliermail', ['data' => $headerMail], function ($message) use ($validEmails) {
                                    $message->subject('Pemberitahuan approval BAST telah selesai');
                                    $message->to($validEmails);
                                    // $message->cc('muhammadjakaria8@gmail.com');
                                });
                            }
                        }
                    });
                }
            } elseif ($user->dept == 'EHS') {
                if ($currstatus == 1) {
                    DB::transaction(function () use ($id, $field, $field2, $status, $notes, $userappv, $usrappv, $rate) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update([
                                'status' => $status,
                                $usrappv => $userappv,
                                'ehs_rate' => $rate,
                                $field => Carbon::now(),
                                $field2 => $notes,
                                'updated_at' => Carbon::now(),
                            ]);
                    });

                    //send email to user APPROVAL OUTSTANDING
                    $sendMail = DB::table('departemen2')
                        ->select('emailmgr1', 'emailspv1')
                        ->where('alias', $data->to_user)
                        ->get()
                        ->flatMap(function ($item) {
                            return [$item->emailmgr1, $item->emailspv1];
                        })
                        ->toArray();
                    $approvalHeader = ['to' => $data->to_user, 'no' => $data->bastno, 'note' => $request->input('ehsnotes') ?? '-'];
                    $mail = Mail::send('mail.approvalmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                        $message->subject('Pemberitahuan Approval BAST: ' . $approvalHeader['no']);
                        $message->to($sendMail);
                        // $message->cc('muhammadjakaria8@gmail.com');
                    });
                } else {
                    if ($actappv == '1') {
                        DB::transaction(function () use ($id, $field, $field2, $field3, $status, $rate, $notes, $userappv, $usrappv) {
                            DB::table('bast')
                                ->where('id_bast', $id)
                                ->update([
                                    'status' => $status,
                                    $usrappv => $userappv,
                                    $field => Carbon::now(),
                                    $field2 => $rate,
                                    $field3 => $notes,
                                    'updated_at' => Carbon::now(),
                                ]);
                        });

                        //send email to user APPROVAL PURCH OUTSTANDING
                        $sendMail = DB::table('departemen2')
                            ->select('emailmgr1', 'emailspv1')
                            ->where('alias', 'PURCH')
                            ->get()
                            ->flatMap(function ($item) {
                                return [$item->emailmgr1, $item->emailspv1];
                            })
                            ->toArray();
                        $approvalHeader = ['to' => 'Purchasing', 'no' => $data->bastno, 'note' => $request->input('userRemark') ?? '-'];
                        $mail = Mail::send('mail.approvalmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                            $message->subject('Pemberitahuan Approval BAST: ' . $approvalHeader['no']);
                            $message->to($sendMail);
                            // $message->cc('muhammadjakaria8@gmail.com');
                        });
                    } else {
                        DB::transaction(function () use ($id, $field, $field2, $field3, $rate, $notes, $userappv, $usrappv) {
                            DB::table('bast')
                                ->where('id_bast', $id)
                                ->update([
                                    $usrappv => $userappv,
                                    $field => Carbon::now(),
                                    $field2 => $rate,
                                    $field3 => $notes,
                                    'updated_at' => Carbon::now(),
                                ]);
                        });

                        //send email to user REJECT EHS OUTSTANDING
                        $sendMail = DB::table('departemen2')
                            ->select('emailmgr1', 'emailspv1')
                            ->where('alias', 'EHS')
                            ->get()
                            ->flatMap(function ($item) {
                                return [$item->emailmgr1, $item->emailspv1];
                            })
                            ->toArray();
                        $approvalHeader = ['to' => 'EHS, Sustainability & BE', 'no' => $data->bastno, 'note' => $request->input('ehsnotes') ?? '-'];
                        $mail = Mail::send('mail.rejectmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                            $message->subject('Pemberitahuan Reject BAST: ' . $approvalHeader['no']);
                            $message->to($sendMail);
                            // $message->cc('muhammadjakaria8@gmail.com');
                        });
                    }
                }
            } elseif ($user()->gol == 4 || ($user->gol == 3 && $user->acting == 2)) {
                // Untuk User
                if ($actappv == '1') {
                    DB::transaction(function () use ($id, $field, $field2, $field3, $status, $rate, $notes, $userappv, $usrappv) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update(['status' => $status, $usrappv => $userappv, $field => Carbon::now(), $field2 => $rate, $field3 => $notes, 'updated_at' => Carbon::now()]);
                    });

                    //send email to user APPROVAL PURCH OUTSTANDING
                    $sendMail = DB::table('departemen2')
                        ->select('emailmgr1', 'emailspv1')
                        ->where('alias', 'PURCH')
                        ->get()
                        ->flatMap(function ($item) {
                            return [$item->emailmgr1, $item->emailspv1];
                        })
                        ->toArray();
                    $approvalHeader = ['to' => 'Purchasing', 'no' => $data->bastno, 'note' => $request->input('userRemark') ?? '-'];
                    $mail = Mail::send('mail.approvalmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                        $message->subject('Pemberitahuan Approval BAST: ' . $approvalHeader['no']);
                        $message->to($sendMail);
                        // $message->cc('muhammadjakaria8@gmail.com');
                    });
                } else {
                    DB::transaction(function () use ($id, $field, $field2, $field3, $rate, $notes, $userappv, $usrappv) {
                        DB::table('bast')
                            ->where('id_bast', $id)
                            ->update([$usrappv => $userappv, $field => Carbon::now(), $field2 => $rate, $field3 => $notes, 'updated_at' => Carbon::now()]);
                    });

                    //send email to user REJECT EHS OUTSTANDING
                    $sendMail = DB::table('departemen2')
                        ->select('emailmgr1', 'emailspv1')
                        ->where('alias', 'EHS')
                        ->get()
                        ->flatMap(function ($item) {
                            return [$item->emailmgr1, $item->emailspv1];
                        })
                        ->toArray();
                    $approvalHeader = ['to' => 'EHS, Sustainability & BE', 'no' => $data->bastno, 'note' => $request->input('userRemark') ?? '-'];
                    $mail = Mail::send('mail.rejectmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                        $message->subject('Pemberitahuan Reject BAST: ' . $approvalHeader['no']);
                        $message->to($sendMail);
                        // $message->cc('muhammadjakaria8@gmail.com');
                    });
                }
            } else {
                // Untuk Purchasing saja
                DB::transaction(function () use ($id, $field, $status, $userappv, $usrappv) {
                    DB::table('bast')
                        ->where('id_bast', $id)
                        ->update(['status' => $status, $usrappv => $userappv, $field => Carbon::now(), 'updated_at' => Carbon::now()]);
                });

                //send email to user APPROVAL PURCH OUTSTANDING
                $sendMail = DB::table('departemen2')
                    ->select('emailmgr1', 'emailspv1')
                    ->where('alias', 'SCWH')
                    ->get()
                    ->flatMap(function ($item) {
                        return [$item->emailmgr1, $item->emailspv1];
                    })
                    ->toArray();
                $approvalHeader = ['to' => 'Supply Chain & Warehouse', 'no' => $data->bastno, 'note' => $request->input('ehsnotes') ?? '-'];
                $mail = Mail::send('mail.approvalmail', ['data' => $approvalHeader], function ($message) use ($approvalHeader, $sendMail) {
                    $message->subject('Pemberitahuan Approval BAST: ' . $approvalHeader['no']);
                    $message->to($sendMail);
                    // $message->cc('muhammadjakaria8@gmail.com');
                });
            }

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
