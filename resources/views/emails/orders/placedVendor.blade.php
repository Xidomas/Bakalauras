@component('mail::message')

# Užsakymas Gautas

**Kliento Vardas:** {{ $vendorOrder['billing_name']}}

**Kliento El. paštas:** {{ $vendorOrder['billing_email']}}

**Užsakymo Galutinė kaina:** €{{ round(($vendorOrder['price'] / 100 * $vendorOrder['quantity'] * $vendorOrder['days']) + ($vendorOrder['price'] / 100 * $vendorOrder['quantity'] * $vendorOrder['days'] * 0.15) , 2) }}

**Užsakytas nuomos pasiūlymas:**

    Pavadinimas: {{ $vendorOrder['name'] }}
    Kaina per dieną: €{{ round($vendorOrder['price'] / 100, 2)}}
    Kiekis: {{ $vendorOrder['quantity'] }}
    Dienos: {{ $vendorOrder['days'] }}


@component('mail::button', ['url' => "http://localhost:8000/vendorUpdate?id=". $vendorOrder['rent_offer_id']. "&quantity=". $vendorOrder['quantity'], 'color' => 'green'])
Numota prekė gražinta
@endcomponent

Thank you again for choosing us.

Regards,<br>
{{ config('app.name') }}
@endcomponent