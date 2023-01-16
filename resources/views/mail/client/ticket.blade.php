<x-mail::message>
    Новый тикет #{{ $data['id'] }} #{{ $data['title'] }} от пользователя с id {{ $data['user_id'] }}
    Текст:
    {{ $data['description'] }}
</x-mail::message>
