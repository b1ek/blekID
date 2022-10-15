<x-templates.master>

    <x-slot:head>
        <style>
            .left {
                background:#e1e3e1;
                min-width:100px;
                padding: 8px 12px;
            }
            .right {
                background:#f4f6f4;
                min-width:650px;
                max-width:650px;

            }
            .panel {
                min-height:100%;
                vertical-align:top;
                padding: 8px 6px;
                font-size: 9pt;
            }
            .left.panel ul {
                margin: 0;
                padding: 0;list-style: none
            }
            .adm_panel {
                min-width:600px;
                border:1px solid lightgray;
                background:#fefffe;
                box-shadow:0 1px 1px #33333310;
            }
            pre {
                overflow-x: scroll;
            }
            {{--.left_panel ul:--}}
        </style>
    </x-slot:head>

    @php
    $buttons = array(
        'Users' => '/admin/users',
        'Apps' => '/admin/apps',
        'Control panel' => '/admin/cp',
        'Logs' => '/admin/log',
    )
    @endphp

    <div class='adm_panel'>
        <p style='padding:2px;margin:0;font-size:9pt;background:linear-gradient(0deg, #bfdaea, #d2e1ea)' align='center'>Admin panel</p>
        <table width='100%' height='256px'>
            <tr>
                <td class='left panel'>
                    <ul>
                        @foreach ($buttons as $text => $href)
                            <li><a href='{!! $href !!}'>{!! $text !!}</a></li>
                        @endforeach
                    </ul>
                </td>
                <td class='right panel' {!! !isset($panel) ? "style='vertical-align:middle'" : '' !!}>
                    @if (!isset($panel))
                    <p align='center' style='font-size:11pt'>Choose the option</p>
                    @else
                    @include("admin.$panel")
                    @endif

                </td>
            </tr>
        </table>
    </div>
</x-template.master>
