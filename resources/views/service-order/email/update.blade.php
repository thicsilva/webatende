@component('mail::message')
# Entrada/Saída Atualizada

Algumas informações foram atualizadas

@component('mail::table')
## Dados internos
| OS | Documentos | Enviado para fábrica |
| -- | :---------- | :-------------------- |
|{{$order->os_number}} | {{$order->documents}} | {{$order->factory?'Sim':'Não'}}
@endcomponent

@component('mail::panel')
## Dados do cliente
###{{ $order->customer->name }}
Contato: {{ $order->contact}}
@endcomponent

@component('mail::table')
## Dados da Entrada/Saída
| Data Entrada | Tipo de Entrada | Data Saída | Tipo de Saída |
| :----------- | --------------- | :--------- | ------------- |
| {{$order->entrance_date->format('d/m/Y')}} | {{$order->entranceMovement->description}} | {{$order->exit_date?$order->exit_date->format('d/m/Y'):'' }}| {{$order->exit_date?optional($order->exitMovement)->description:''}} |
@endcomponent

@component('mail::panel')
## Dados do relógio
| Equipamento | Série |
| :---------- | ---- |
|{{$order->equipment->model}}| {{$order->serial}} |

Acessórios:

@foreach($order->accessories as $accessory)
  + {{$accessory->description}}
@endforeach

Defeito: **{{$order->fault}}**
@endcomponent

@component('mail::panel')
## Dados de orçamento
{!! $order->budget !!}
@endcomponent


Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent

