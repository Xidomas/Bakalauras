@component('mail::message')

# Užsakymas Gautas

Ačiū už jūsų užsakymą!

**Užsakymo ID:** {{ $order->id }}

**Jūsų vardas:** {{ $order->billing_name }}

**Jūsų el. paštas:** {{ $order->billing_email }}

**Užsakymo galutinė kaina:** €{{ round($order->billing_total / 100, 2) }}

**Užsakyti nuomos pasiūlymai:**

@foreach ($order->rentOffers as $rentOffer)
    Pavadinimas: {{ $rentOffer->name }}
    Kaina per dieną: €{{ round($rentOffer->price / 100, 2)}}
    Kiekis: {{ $rentOffer -> pivot-> quantity }}
    Dienos: {{ $rentOffer -> pivot-> days }}
@endforeach

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Grįžti į tinklapį
@endcomponent

Dar kartą ačiū, kad pasirinkote mus.

Pagarbiai,<br>
{{ config('app.name') }}
@endcomponent