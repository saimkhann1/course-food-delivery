<x-mail::message>
# Order #{{ $order->id }}
 
# {{ $restaurant->name }}
 
## Customer
 
{{ $customer->name }}
[{{ $customer->email }}](mailto:{{ $customer->email }})
 
## Order Items
 
@foreach($items as $item)
- {{ $item->name }} {{ number_format($item->price / 100, 2) }} &euro;
@endforeach
 
## Total {{ (number_format($order->total / 100, 2)) }} &euro;
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>