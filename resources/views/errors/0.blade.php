@php
$code = strval($exception->getStatusCode());
@endphp

<x-templates.master>

    <style>
hr {
    border: 0;
    border-top: 1px solid #c2c4c2;
    border-bottom: 1px solid #e2e4e2;
    box-shadow: 0 1px 1px #7171711c;
}
    </style>

    <hr/>

    <h1 align='center'>{{ __("err.$code.code") }} {{ __("err.$code.text") }}</h1>
    <p align='center'>
        @if ($exception->getMessage() == false)
            {!! __("err.$code.help") !!}
        @else
            {!! $exception->getMessage() !!}
        @endif
    </p>

</x-templates.master>
