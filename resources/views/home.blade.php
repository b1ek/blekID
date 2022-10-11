<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>

<style>
@font-face {
    src: url(/static/opensans.ttf);
    font-family: 'Open Sans';
}
.main {
    position: fixed;
    top: 50%;
    left:50%;
    transform:translate(-50%, -50%);
    font-family: 'Open Sans', sans-serif;
}
</style>

</head>

<body>

<div class='main'>

<h1 align='center' style='margin-top:0;padding-top:0'>{!! __('front_page.title') !!}</h1>
<p align='center'>{!! __('front_page.p1') !!}</p>

<h4 align='center'>{!! __('front_page.p2') !!}</h4>
<p align='center'>{!! __('front_page.p3') !!}</p>

<h4 align='center'>C{!! __('front_page.p4') !!}</h4>
<p align='center'>{!! __('front_page.p5') !!}</p>

</div>

</body>

</html>
