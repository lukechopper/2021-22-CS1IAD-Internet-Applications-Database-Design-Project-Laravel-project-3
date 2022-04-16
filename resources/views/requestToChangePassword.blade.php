@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/form.css')}}">
@endsection

@section('title')
<title>Change Password</title>
@endsection


@section('body')

<body>
    <div class="centre-container centre-container__request_to_change_password">
        <form action="{{route('forgotPassword')}}" method="post" class="form">
            @csrf
            <h1>Request To Change Password</h1>
            @if(session('success'))
            <div class="success_msg">{{session('success')}}</div>
            @elseif(session('error'))
            <div class="error_msg">{{session('error')}}</div>
            @endif
            <label for="form_email">Email:</label>
            @error('email')
            <div class="error_msg">{{$message}}</div>
            @enderror
            <input type="text" name="email" id="form_email" class="form__input" value="{{old('email')}}" />
            <input type="submit" class="form__submit" value="Send Email" />
        </form>
    </div>
</body>

</html>
@endsection
