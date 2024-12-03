<?php

namespace App\Jobs;

use App\Mail\NotasMiembro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotesJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $correo;
  public $nota;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($correo,$nota)
  {
    $this->correo = $correo;
    $this->nota = $nota;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Mail::to($this->correo)->send(new NotasMiembro($this->nota));
  }
}
