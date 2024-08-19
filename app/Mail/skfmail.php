<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SKFMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('mail.approvalmail')
                    ->subject('Pemberitahuan Approval BAST');
    }
}
