@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/form.css')}}">
@endsection

@section('title')
<title>Logout</title>
@endsection


@section('body')

<body>
    <div class="centre-container centre-container__info_box">
        <div class="info_box">
            <div>Success. You have been logged out!</div>
            <div>Click <a href="{{route('home')}}">here</a> to go back to the homepage.</div>
        </div>
    </div>
</body>

</html>
@endsection
