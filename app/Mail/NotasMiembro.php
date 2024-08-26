<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
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
            subject: 'Nota a Miembro CIAR SPORTS',
        );
    }

    // public function content()
    // {
    //     return new Content(
    //         view: 'mail.notasmiembros',
    //     );
    // }

    public function build(){
        $logo = Storage::url('/logocorreo/logo-azul.png');
        return $this->view("mail.notasmiembros")->with(['logo'=>$logo]);
    }

    public function attachments()
    {
        return [];
    }
}
