<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\doacao;

class admMail extends Mailable
{
    use Queueable, SerializesModels;

    public $updDoa;

    public function __construct(doacao $updDoa)
    {
        $this->updDoa = $updDoa;
    }

    public function build()
    {
        return $this->subject('Cancelamento de Doação Sanepar')
                    ->cc('evandrocortiano@hotmail.com')
                    ->view('mail.admMail')
                    ->with([
                        'doacao' => $this->updDoa,
                        'doador' => $this->updDoa->doador,
                    ]);
    }
}
