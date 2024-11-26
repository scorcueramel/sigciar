<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscripcionExitosa extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
//    public function __construct(public $lastRegister, public $sede, public $lugar, public $response, public $persona)
    public function __construct(
        public string $nombre_miembro,
        public string $estado_pago,
        public string $nombre_programa,
        public string $registro_id,
        public string $sede,
        public string $lugar,
        public string $fechasDefinidas,
        public string $fecha_pago,
        public string $nro_tarjeta,
        public string $brand_tarjeta,
        public string $importe_pagado,
    )
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Inscripcion Exitosa',
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
            view: 'mail.notificacionmiembro',
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
