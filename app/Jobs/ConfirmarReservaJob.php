<?php

namespace App\Jobs;

use App\Mail\ConfirmacionReservaMail;
use App\Models\MailConfirmacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ConfirmarReservaJob implements ShouldQueue
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
    Mail::to($this->mailConfirmacion->correo_miembro)->send(new ConfirmacionReservaMail($this->mailConfirmacion));
  }
}
