@php

echo view('components.embed-resource', array('tag' => 'script', 'text' => App\Minify::js(App\Resource::get($src))));
@endphp
