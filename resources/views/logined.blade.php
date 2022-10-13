@php
use Illuminate\Support\Facades\DB;
@endphp

<x-templates.master>
        <div class='locale-font'>
            <p style='text-align:center;margin-top:40px'>
                {{__('main.logged_in')}}
                @if (\App\ExtApp::getRedirect($appid) == false)
                <br/><br/><span style='color:darkred;font-weight:bold'>{{
                    __('main.no_link',
                        array(
                            'site' =>
                            DB::table('apps')->where('id', $appid)->get()[0]->public_name
                        )
                    )}}</span>
                @endif
            </p>
            @if (\App\ExtApp::getRedirect($appid) !== false)
            <p style='text-align:center'>
                <img src='/static/loading.gif'></img>
            </p>
            @endif
        </div>

    @if (!isset($showcase) && \App\ExtApp::getRedirect($appid) !== false)
    <script>
    setTimeout(function() {
        @php
        $red_link = \App\ExtApp::getRedirect($appid) . "?from=" . $from . "&session=" . request()->session()->get('user_session');
        @endphp
        window.location.href = '{!! $red_link !!}';
    }, 1000);
    </script>
    @endif

</x-templates.master>
