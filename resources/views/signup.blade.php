<x-templates.master>

    <style>
        #err {
            transition: 250ms ease;
            opacity: 0;
        }
    </style>

    <div class='locale-font'>

        <h3 align='center'>Signup</h3>

        <form>
            @csrf
            <input type='hidden' name='complete' value='true'></input>
            <input type='hidden' name='password' value='' id='password'></input>
            <input type='hidden' name='action' value='signup'></input>
            <input type='hidden' name='appid' value='{{$_GET['appid']}}'></input>


            <table align='center'><tr><td>

                    <table align='left'>
                        <tr>
                            <td align='right'>Login: </td>
                            <td><input type='text' id='login' name='login'{!! isset($_GET['login']) ? ' value=\''.$_GET['login'].'\'' : '' !!}></input></td>
                        </tr>
                        <tr>
                            <td align='right'>E-Mail: </td>
                            <td><input type='email' name='email'{!! isset($_GET['email']) ? ' value=\''.$_GET['email'].'\'' : '' !!}></input></td>
                        </tr>
                    </table>

                    </td><td>

                    <table align='right'>
                        <tr>
                            <td align='right'>Name <a href='#' id='what_name'>(?)</a>: </td>
                            <td><input type='text' name='name' name='password'></input></td>
                        </tr>
                        <tr>
                            <td align='right'>Password: </td>
                            <td><input type='password' id='pass'></input></td>
                        </tr>
                    </table>

            </td></tr></table>

            <p>
                <span id='err'></span><br/>
                <br/>
                <input type='submit' disabled value='Submit' id='submit'></input>
            </p>

        </form>

    </div>

    {{-- Scripts --}}
    <script>

    @php
    $domain = request()->root();
    @endphp

    document.getElementById('what_name').onclick = function() {
        alert('Name that is displayed to everyone. Could be your nickname, or a real name. Unlike login, you can change that later.');
    }
    {{-- Password hashing --}}
    document.getElementById('pass').onchange = function() {
        setTimeout(function() {
            document.getElementById('password').value = sha512(document.getElementById('pass').value);
        }, 32);
    }
    {{-- Login checker --}}
    document.getElementById('login').onchange = function() {
        document.getElementById('submit').disabled = true;
        document.getElementById('err').innerHTML = '';
        let login = document.getElementById('login');
        let req = new XMLHttpRequest();
        req.open('GET', '{{$domain}}/api/check_login?login=' + window.encodeURIComponent(login.value), true);
        req.send(null);
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200)
            if (req.responseText == 'true') {
                document.getElementById('submit').disabled = false;
                document.getElementById('err').style = 'opacity:0';
            } else {
                document.getElementById('submit').disabled = true;
                document.getElementById('err').innerHTML = 'This login is already taken. Try "' + req.responseText + '" instead.';
                document.getElementById('err').style = 'opacity:1';
                console.log(req.responseText);
            }
        }
    }
    </script>

</x-templates.master>
