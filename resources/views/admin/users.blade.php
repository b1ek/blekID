<h2 style='margin:0;padding:2px 4px'>Users</h2>
<hr/>

@php
use Illuminate\Support\Facades\DB;
$users = DB::table('users')->where('deleted', 0)->get();
$apps = DB::table('apps')->get();
$root = url('/');
@endphp

<style>

table, tr, td {
    border: 1px solid #c2c4c2;
    border-collapse: collapse;
}
td {
    padding: 4px;
}
td.userid {
    background: #e2e4e2
}
tr.header {
    background: #eaeeea
}
tr:hover {
    background: #e2e4e2
}

</style>

<table>
<tr class='header'>
    <td>ID</td>
    <td>Login</td>
    <td>Email</td>
    <td>Created</td>
    <td>IP</td>
    <td>Registrator</td>
    <td>User agent</td>
    <td>Actions</td>
</tr>

@foreach($users as $i => $user)
<tr>
    <td class='userid'><a id='user_{{$user->id}}' href='#user_{{$user->id}}'>{{$user->id}}</a></td>
    <td>{{$user->login}}</td>
    <td>{{$user->email}}</td>
    <td>{{date('m/d/Y H:i:s', $user->created)}}</td>
    <td>{{$user->ip}}</td>
    <td>
    @php
    foreach ($apps as $ii => $app) {
        if ($app->id == $user->registrator) {
            echo $app->public_name;
            break;
        }
    }
    @endphp
    </td>
    <td>{{((array)$user)['user-agent']}}</td>
    <td>
        <a id='delete' title='Delete the account' href='#'><img user={{$user->id}} src='/static/ico/delete.png'></img></a>
        <a id='change_pwd' title='Change password' href='#'><img user={{$user->id}} src='/static/ico/key.png'></img></a>
        <a id='view' title='View data' href='#'><img user={{$user->id}} src='/static/ico/docs.png'></img></a>
        @if (!$user->frozen)
        <a id='pause' title='Freeze the account' href='#'><img user={{$user->id}} src='/static/ico/pause.png'></img></a>
        @else
        <a id='resume' title='Unfreeze the account' href='#'><img user={{$user->id}} src='/static/ico/resume.png'></img></a>
        @endif
    </td>
</tr>
@endforeach

</table>
<script>

{{-- Delete button --}}
document.getElementById('delete').onclick = async function(e) {
    let id = (Number(e.target.attributes['user'].value));

    await fetch('{!! $root !!}/api/admin/delete/' + id);

    window.location.href = window.location.pathname + window.location.search + '#user_' + id;
    window.location.reload();
    return;
};

{{-- Password button --}}
document.getElementById('change_pwd').onclick = async function(e) {
    let id = (Number(e.target.attributes['user'].value));
    let str = window.prompt('Enter the new password:');
    if (str == '') {
        alert('Password can\'t be empty!');
        return;
    }
    let pass = sha512(str);

    await fetch('{!! $root !!}/api/admin/change_pass/' + id + '/' + pass);

    window.location.href = window.location.pathname + window.location.search + '#user_' + id;
    window.location.reload();
    return;
};

</script>
