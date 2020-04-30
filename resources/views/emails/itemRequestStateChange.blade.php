@component('mail::message')
# Item Request Update

Dear {{$userName}}

One of your item requests has been judged.

Your item request has been {{$itemRequestState}}

@component('mail::button', ['url' => "http://localhost:8000/itemrequests/$itemRequestId"])
Click here to view the item request
@endcomponent

<br>
Kind regards,<br>
{{ config('app.name') }}
@endcomponent
