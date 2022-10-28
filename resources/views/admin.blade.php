<x-templates.master>

    <x-slot:head>
    <script>
    @php

    $session = DB::table('user_session')
        ->where('key', request()->session()->get('user_session'))->get();
    if (count($session) == 0) {
        \App\Session::revoke();
        ob_clean();
        header('Location: /auth/1');
        exit();
    }
    $user = DB::table('users')->where('id', $session[0]->user)->get();
    $user_name = DB::table('user_names')->where('uid', $user[0]->id)->where('active', true)->get();
    @endphp
    var js_data = @json(array(
        'session' => request()->session()->all(),
        'user_name' => $user_name[0]->name,
        'god_mode' => $session[0]->user == 2
    ))
    </script>

    @viteReactRefresh
    @vite('resources/js/adm.jsx')
    </x-slot:head>

    <div id='adm_panel'>
    </div>
</x-template.master>
