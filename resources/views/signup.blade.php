@php

$invonly = DB::table('app_invites')->where('appid', $_GET['appid'])->count();

@endphp
<x-templates.master>

    <style>#err {color:darkred;font-size:9pt;font-weight:bold}</style>

    <div class='locale-font'>

        <h3 align='center'>{{__('main.signup')}}</h3>

        <form action='/signup'>
            @csrf
            <input type='hidden' name='complete' value='true'></input>
            <input type='hidden' name='password' value='' id='password'></input>
            <input type='hidden' name='action' value='signup'></input>
            <input type='hidden' name='appid' value='{{$_GET['appid']}}'></input>


            <table align='center'><tr><td>

                    <table align='left'>
                        <tr>
                            <td align='right'>{{__('main.login')}}</td>
                            <td><input type='text' id='login' name='login'{!! isset($_GET['login']) ? ' value=\''.$_GET['login'].'\'' : '' !!}></input></td>
                        </tr>
                        <tr>
                            <td align='right'>{{__('main.email')}}</td>
                            <td><input type='email' name='email'{!! isset($_GET['email']) ? ' value=\''.$_GET['email'].'\'' : '' !!}></input></td>
                        </tr>
                    </table>

                    </td><td>

                    <table align='right'>
                        <tr>
                            <td align='right'>{{__('main.name')}}<a href='#' id='what_name'>(?)</a>: </td>
                            <td><input type='text' name='name' name='password'></input></td>
                        </tr>
                        <tr>
                            <td align='right'>{{__('main.password')}}</td>
                            <td><input type='password' id='pass'></input></td>
                        </tr>
                    </table>

            </td></tr></table>

            <p>
                @if ($invonly)
                    {{__('main.invite')}}: <input type='text' id='invcode' name='invite'></input><br/>
                @endif
                <span id='err'>{!! isset($err) ? $err : '' !!}</span><br/>
                <br/>
                <input type='submit' value='{{__('main.submit')}}'></input>
            </p>

        </form>

    </div>

    {{-- Scripts --}}
    <script>

    document.getElementById('what_name').onclick = function() {
        alert('{{__('main.name_help')}}');
    }
    {{-- Password hashing --}}
    document.getElementById('pass').onchange = function() {
        setTimeout(function() {
            document.getElementById('password').value = sha512(document.getElementById('pass').value);
        }, 32);
    }

    </script>

</x-templates.master>
