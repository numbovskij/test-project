<?php
namespace App\Services;

use App\Mail\NewTicketMail;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;

class MailNotificationService
{
    /**
     * отправка уведомления менеджеру
     * @param Ticket $ticket
     *
     * @return void
     */
    public function sendToManager(Ticket $ticket): void
    {
        Mail::to(env('MAIL_MANAGER'))->send(new NewTicketMail($this->mapping($ticket)));
    }

    /**
     * метод возвращает подготовленный массив данных
     * @param Ticket $ticket
     *
     * @return array
     */
    private function mapping(Ticket $ticket): array
    {
        return [
            'id'          => $ticket->id,
            'title'       => $ticket->title,
            'description' => $ticket->description,
            'user_id'     => $ticket->user_id,
        ];
    }
}
