<?php

namespace App\Mail;

use App\Models\horario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class agndarCita extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $horario;
    /**
     * Create a new message instance.
     */
    public function __construct($data,$horario)
    {
        $this->data = $data;
        $this->horario = $horario;
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
            view: 'emails.cita',
            with: [
                    'data' => $this->data,
                    'horario'=>$this->horario,
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
