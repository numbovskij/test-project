<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Jobs\QueueSenderEmail;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TicketController extends Controller
{
    /**
     * возвращает список тикетов
     *
     * @return View
     */
    public function index(): View
    {
        $tickets = Ticket::all();

        return view("ticket", compact('tickets'));
    }

    /**
     * метод создания заявки
     *
     * @param CreateTicketRequest $request
     * @param TicketRepository $repository
     *
     * @throws \Throwable
     * @return Application|RedirectResponse|Redirector
     */
    public function create(CreateTicketRequest $request, TicketRepository $repository): Application|RedirectResponse|Redirector
    {
      $ticket = $repository->create($request);

       if ($ticket) {
           $queue = (new QueueSenderEmail($ticket))->delay(now()->addMinutes(1));
           $this->dispatch($queue);

           return redirect(route('user.ticket'));
       }

        return redirect(route('user.ticket'))->withErrors([
            'formError' => 'Произошла ошибка при создании заявки'
        ]);
    }
}
