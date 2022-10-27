@php

$reg_disabled = DB::table('app_option')->where('appid', $appid)->where('key', 'reg_disabled')->count();
$invonly = DB::table('app_option')->where('appid', $appid)->where('key', 'invonly')->count();

@endphp

<x-templates.master><x-slot:head><script src='/static/auth.js'></script></x-slot:head>
    <div class='locale-font'>
        <p style='font-size:9pt;text-align:center;color:#777777;margin:6px 0;padding:0'>

            {{-- Please login to continue... --}}
            @if (!isset($app_name))
            {{__('main.please_login')}}
            @else
            {{__('main.login_to', array('app' => $app_name))}}
            @endif

        </p>


        <form action='/login' id='main-form'>
            <input type='hidden' name='action' id='action' value='login'></input>
            <input type='hidden' name='password' id='pass_hash'></input>
            @if (isset($appid))
            <input type='hidden' name='appid' value='{{isset($appid) ? $appid : 1}}'></input>
            @endif
            @csrf

            <table align='center'>
                <tr>
                    <td align='right'>{{__('main.login')}}</td>
                    <td><input type='text' name='login'{!! isset($_GET['login']) ? ' value=\''.$_GET['login'].'\'' : '' !!}></input><br/></td>
                </tr>
                <tr style='transform:translateY(8px)'>
                    <td align='right'>{{__('main.password')}}</td>
                    <td><input type='password' id='pass'></input><br/></td>
                </tr>
            </table>

            <p align='center' style='margin:20px 0;font-size:10pt'>
                {{--
                This wont work either way for now, so theres no reason for it to be here
                <input type='checkbox' id='remember' name='remember'{{isset($_GET['remember']) ? ($_GET['remember'] == 'on' ? 'checked' : '') : ''}}></input><label for='remember' style='user-select:none'> {{__('main.remember')}}</label><br/>
                --}}
                <br/>
                <input type='button' id='login_btn' value='{{__('main.login_btn')}}'></input>
                <input type='button' id='signup_btn'{{--

                --}} value='{{__('main.signup_btn')}}{!! $invonly ? ' ' . __('main.invonly') : '' !!}' {{--

                     If registration is disabled

                --}}{!! $reg_disabled ? 'disabled' : '' !!}{{--

                --}}></input>
            </p>
            <p>
                <a href='/reset'>{{__('main.forgot')}}</a>
            </p>
        </form>
        @if (isset($errors))

        @foreach($errors as $i => $err)
        <p class='error'>{!! $err !!}</p>
        @endforeach

        @endif
        @if (request()->session()->has('user_session'))
            <p align='center'>You are logged in</p>
        @endif
        <p style='text-align:center;font-size:11px;color:#292929;user-select:none;filter:blur(0.15px)'><img src='/static/lock.png'></img> {{__('main.bottom_text')}}</p>
    </div>
    <div class='mobile-qr'>
        <p class='locale-font' align='center' style='font-size:9pt'>{{__('main.qrcode')}}<br/>
            @if (ENV('APP_AVAILABLE', false))
            @php
            $id = Str::uuid()->toString();
            if (Request::session()->has('mobile_auth_id')) {
                $id = Request::session()->get('mobile_auth_id');
            } else
            Request::session()->put('mobile_auth_id', $id);
            @endphp
            <img src='/qr/{{base64_encode(Crypt::encryptString($id))}}' width=200 style='margin: 16px 0'></img>
            @else
            <p style='height: 128px;width:128px;display:block;margin:0;border:1px solid #c2c4c2;box-sizing:border-box;user-select:none;filter:blur(0.15px)' align='center'>
                <span style='display:block;position:relative;top:50%;transform:translateY(-50%)'>{{__('main.no_app_qr')}}</span>
            </p>
            @endif
        </p>
    </div>
    <x-embed-script src='/static/js/auth.js'></x-embed-script>
</x-templates.master>
