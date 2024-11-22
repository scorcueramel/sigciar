<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaExitosa extends Mailable
{
    use Queueable, SerializesModels;

    public $lastRegister;
    public $response;
    public $persona;

    public function __construct($lastRegister, $response, $persona)
    {
        $this->lastRegister = $lastRegister;
        $this->response = $response;
        $this->persona = $persona;
    }

    public function build()
    {
        return $this->view("mail.reservaexitosa")->subject('RESERVA EXITOSA');
    }
}
