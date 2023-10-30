<x-mail::message>
# {{__('Dashboard/mail.Billingmanagement')}}

{{$nameclient}}

<x-mail::button :url="$url">
    {{__('Dashboard/mail.ViewInvoice')}}
</x-mail::button>

{{__('Dashboard/mail.Thanks')}},<br>
{{ config('app.name') }} : {{$message}}
</x-mail::message>
