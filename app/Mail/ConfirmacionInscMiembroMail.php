<?php

namespace App\Mail;

use App\Models\MailConfirmacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionInscMiembroMail extends Mailable
{
  use Queueable, SerializesModels;

  public $mailConfirmacion;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(MailConfirmacion $mailConfirmacion)
  {
    $this->mailConfirmacion = $mailConfirmacion;
  }

  /**
   * Get the message envelope.
   *
   * @return \Illuminate\Mail\Mailables\Envelope
   */
  public function envelope()
  {
    return new Envelope(
      from: new Address('userweb@ciarsports.com', 'CIAR SPORTS (INSCRIPCION)'),
      subject: 'Confirmacion de inscripción - CIAR SPORTS',
    );
  }

  /**
   * Get the message content definition.
   *
   * @return \Illuminate\Mail\Mailables\Content
   */
  public function content()
  {
    return new Content(
      view: 'mail.confirmar-inscripcion-miembro',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array
   */
  public function attachments()
  {
    return [];
  }
}
