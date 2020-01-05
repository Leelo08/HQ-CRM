@component('mail::message')

# Sender name:  {{ $new_arrival->fromName }}

Dear {{ $new_arrival->toName }},

<p>{{ $new_arrival->body }}</p>


Regards,<br>
{{ $new_arrival->fromEmail }}

{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <!-- footer here -->
        @endcomponent
    @endslot
@endcomponent