<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $user)
    {
        $this->url = $url;
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.url') . ' - Thông báo đổi mật khẩu')
            ->view('mails.auth.reset_password_mail')
            ->with(['url' => $this->url, 'user' => $this->user]);
    }
}