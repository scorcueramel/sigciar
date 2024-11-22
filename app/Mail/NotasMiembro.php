<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotasMiembro extends Mailable
{
    use Queueable, SerializesModels;

    public $nota;

    public function __construct($nota)
    {
        $this->nota = $nota;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('admin@ciar.com','CIAR SPORTS'),
            subject: 'NOTA DE CIAR SPORTS',
        );
    }

    public function build(){
        $logo = Storage::url('/logocorreo/logo-azul.png');
        return $this->view("mail.notasmiembros")->with(['logo'=>$logo]);
    }

    public function attachments()
    {
        return [];
    }
}
