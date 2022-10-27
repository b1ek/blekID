<x-templates.master>
    <style>*{text-align:center}</style>
    <h3>{{__('main.reset_title')}}</h3>
    <form action='/reset'>
        <p>{{__('main.reset')}}</p>
        <table style='margin:0 auto'>
            <tr>
                <td align='right'>
                    {{__('main.email')}}
                </td>
                <td>
                    <input type='text' name='email'></input>
                </td>
            </tr>
        </table>
        <p><input type='submit' value='{{__('main.submit')}}'></input></p>
    </form>
</x-templates.master>
