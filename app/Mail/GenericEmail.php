<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenericEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tajukEmail;
    public $kandunganEmail;
    public $attachmentPaths;

    /**
     * Create a new message instance.
     */
    public function __construct($tajukEmail, $kandunganEmail, $attachmentPaths)
    {
        $this->tajukEmail = $tajukEmail;
        $this->kandunganEmail = $kandunganEmail;
        $this->attachmentPaths = $attachmentPaths;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->tajukEmail,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.template-kandungan-email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->attachmentPaths as $path) {
            $attachments[] = Attachment::fromPath(Storage::path($path));
        }

        return $attachments;
    }
}
