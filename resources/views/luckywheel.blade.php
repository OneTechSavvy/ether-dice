@extends('layouts.test')

@section('title', 'Home')

@section('content')
    <head>
        <style>
           iframe {
    display: block;
    margin: 0 auto;
    width: 800px;
    height: 1000px;
}
        </style>

</head>
<body>
   

    <div>
        <iframe src="{{ asset('luckywheels/index.html') }}" frameborder="0"></iframe>
    </div>

</body>

<head>

@endsection
