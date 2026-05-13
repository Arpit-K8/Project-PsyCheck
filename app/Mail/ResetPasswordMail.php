<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ResetPasswordMail extends Mailable
{
    public function __construct(
        public string $email,
        public string $token,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
            with: [
                'resetUrl' => route('password.reset', [
                    'token' => $this->token,
                    'email' => $this->email,
                ]),
            ],
        );
    }
}