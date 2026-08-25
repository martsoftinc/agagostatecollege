<x-mail::message>
# {{ $notice->title }}

{!! nl2br(e($notice->body)) !!}

Thanks,<br>
{{ config('app.name') }} – Agogo State College
</x-mail::message>