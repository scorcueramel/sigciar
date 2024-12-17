<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Mail\Mailable;
	use Illuminate\Mail\Mailables\Address;
	use Illuminate\Mail\Mailables\Content;
	use Illuminate\Mail\Mailables\Envelope;
	use Illuminate\Queue\SerializesModels;
	
	class NotificacionMembresiaVencer extends Mailable
	{
		use Queueable, SerializesModels;
		
		public string $nombreMiembro;
		/**
		 * Create a new message instance.
		 *
		 * @return void
		 */
		public function __construct(string $nombreMiembro)
		{
			$this->nombreMiembro = $nombreMiembro;
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
				subject: 'Membresía por vencer - CIAR SPORTS',
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
				view: 'mail.notificar-vencimiento-membresia',
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
