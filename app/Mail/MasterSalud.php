<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MasterSalud extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $uuid;//factura
    public $product;
    /**
     * Create a new message instance.
     */
    public function __construct($data,$uuid,$product)
    {
        $this->data = $data;
        $this->uuid = $uuid;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:new Address('mastersalud@mastersalud.co','MasterSalud'),
            subject: 'MasterSalud',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.compra',
            with: [
                    'data' => $this->data,
                    'factura'=>['factura'=>$this->uuid],
                    'product'=>$this->product,
                ]
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
