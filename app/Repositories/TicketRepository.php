<?php

namespace App\Repositories;

use App\Http\Requests\CreateTicketRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TicketRepository
{
    /**
     * метод создания тикета
     * @param CreateTicketRequest $input
     *
     * @return Ticket
     * @throws Throwable
     */
    public function create(CreateTicketRequest $input): Ticket
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::create([
                'title'       => $input->title,
                'description' => $input->description,
                'user_id'     => Auth::id()
            ]);

            DB::commit();

            return $ticket->refresh();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
