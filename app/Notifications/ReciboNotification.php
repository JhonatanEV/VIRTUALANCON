<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReciboNotification extends Notification
{
    use Queueable;
    protected $data;
    protected $pdfOutputs;

    public function __construct($data, $pdfOutput)
    {
        $this->data = $data;
        $this->pdfOutputs = $pdfOutput;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
        ->subject('Tu Recibo de Pago - Municipalidad de Ancón')
        ->view('pagalo.pago_linea.mails.reciboMail', ['jsonData' => $this->data]);

        foreach ($this->pdfOutputs as $pdf) {
            if (!empty($pdf['content'])) {
                $mailMessage->attachData($pdf['content'], $pdf['filename'], [
                    'mime' => 'application/pdf',
                ]);
            }
        }
        // if (!empty($this->pdfOutput)) {
        //     $mailMessage->attachData($this->pdfOutput, 'recibo.pdf', [
        //         'mime' => 'application/pdf',
        //     ]);
        // }

        return $mailMessage;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
