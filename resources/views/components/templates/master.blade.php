@php
// set some variables
$locales = config('app.locales');
$locale = config('app.locale');

@endphp
<!DOCTYPE html><html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<title>{{ __('main.title') }}</title>
<x-embed-style src='/static/main.css'></x-embed-style>
<x-embed-style src='{{"/static/css/$locale.css"}}'></x-embed-style>


<link rel="apple-touch-icon" sizes="180x180" href="/static/ico/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/static/ico/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/static/ico/favicon-16x16.png">
<link rel="manifest" href="/static/ico/site.webmanifest">
{{isset($head) ? $head : ''}}
</head>

<body>
{{-- Actual contents --}}

    <div class='center-login-form'>
        <h1 align='center' style='margin:0;padding:0;transform:translateY(-16px)'>
            {{-- Title (from locale) --}}
            {{__('main.title')}}
            {{-- Locale ID --}}
            <span style='font-size:9pt;vertical-align:top;color:#a2a4a2;user-select:none'>{{strtoupper(config('app.locale'))}}</span>
        </h1>

        {{$slot}}
    </div>

    <div class='language'>
        <p>Select your language | <span class='locale-font'>{{__('main.lang_sel')}}</span></p>
        <select style='margin:8px auto;display:block' id='lang'>

            @foreach ($locales as $c => $k)
            <option value='{{$c}}'
            {{-- If this locale is selected already, then select it --}}
            {{config('app.locale') == $c ? ' selected' : ''}}
            >{{$k}}</option>
            @endforeach

        </select>
    </div>
    <script type='text/javascript'>document.getElementById('lang').value = '{{Config::get('app.locale')}}'</script>

<p class='footerText'>blek! ID version {{ENV('APP_VERSION', '?')}} | Forged in the depths of hell by blek!</p>
{{-- Scripts --}}
<x-embed-script src='/static/js/jquery.js'></x-embed-script>
<x-embed-script src='/static/js/sha512.js'></x-embed-script>
<x-embed-script src='/static/js/main.js'></x-embed-script>
</body>

</html>
