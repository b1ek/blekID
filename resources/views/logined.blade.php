@php
use Illuminate\Support\Facades\DB;
@endphp

<x-templates.master>
    <div class='center-login-form'>
        <h1 align='center' style='margin:0;padding:0'>
            {{-- Title (from locale) --}}
            {{__('main.title')}}

            {{-- Locale ID --}}
            <span style='font-size:9pt;vertical-align:top;color:#a2a4a2;user-select:none'>{{strtoupper(config('app.locale'))}}</span>
        </h1>
        <div class='locale-font'>
            <p style='text-align:center;margin-top:40px'>
                You have been logged in. Please wait to be redirected...
            </p>
            <p style='text-align:center'>
                <img src='/static/loading.gif'></img>
            </p>
        </div>
    </div>
    @if ($appid != 1)
    <script>
    setTimeout(function() {
        @php
        $app_url = DB::table('app_redirect')->where('appid', $appid)->where('id', 'success');
        if (count($app_url) == 0) {
            abort(500);
        }
        $red_link = $app_url[0]->link . '?' . request()->session()->get('user_session');
        @endphp
        window.location.href = '{!! $red_link !!}';
    }, 1000);
    </script>
    @endif
</x-templates.master>
