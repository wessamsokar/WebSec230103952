<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tempPassword;
    public $userName;

    public function __construct($tempPassword, $userName)
    {
        $this->tempPassword = $tempPassword;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Reset Your Password')
                    ->view('emails.reset_password')
                    ->with(['tempPassword' => $this->tempPassword, 'userName' => $this->userName]);
    }
}
