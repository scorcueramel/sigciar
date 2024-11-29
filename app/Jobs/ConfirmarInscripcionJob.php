<?php

namespace App\Jobs;

use App\Mail\ConfirmacionInscMiembroMail;
use App\Mail\ConfirmacionInscResponsableMail;
use App\Models\MailConfirmacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ConfirmarInscripcionJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $mailConfirmacion;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(MailConfirmacion $mailConfirmacion)
  {
    $this->mailConfirmacion = $mailConfirmacion;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Mail::to($this->mailConfirmacion->correo_miembro)->send(new ConfirmacionInscMiembroMail($this->mailConfirmacion));
    Mail::to($this->mailConfirmacion->correo_encargado)->send(new ConfirmacionInscResponsableMail($this->mailConfirmacion));
  }
}
