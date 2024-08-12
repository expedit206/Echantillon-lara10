<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CodeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $data;
    public $formAddress;
    public $formName;
    /**
     * Create a new message instance.
     */
    public function __construct($subject, $data, $formAddress, $formName)
    {
        
        $this->subject = $subject;
        $this->data = $data;
        $this->fromAddress = $formAddress;
        $this->fromName = $formName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:new Address($this->fromAddress, $this->fromName),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'codeMail',
            with:['data'=>$this->data]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
