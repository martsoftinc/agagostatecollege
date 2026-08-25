<?php

namespace App\Mail;

use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Notice $notice) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agogo State College Notice Board: ' . $this->notice->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notice',
            with: ['notice' => $this->notice],
        );
    }
}