@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/form.css')}}">
@endsection

@section('title')
<title>Login</title>
@endsection


@section('body')

<body>
    @if(session('success'))
    <div class="centre-container centre-container__info_box">
        <div class="info_box">
            <div>Success. You are now logged in!</div>
            <div>Click <a href="{{route('home')}}">here</a> to go back to the homepage.</div>
        </div>
        <!-- SCRIPT TAG to delete the incumbent CV form localStorage data -->
        <script type="text/javascript">
            localStorage.clear();
        </script>
    </div>
    @else
    <div class="centre-container centre-container--login_form">
        <form action="{{route('createAccount')}}" method="post" class="form">
            @csrf
            <h1>Login</h1>
            @if(session('error'))
            <div class="error_msg">Wrong account details. Try again.</div>
            @endif
            <div class="form__label_container">
                <label for="form_email">Email:</label>
                <div class="form__sub_label">Need an account? <a href="{{route('signup')}}">Sign up</a></div>
            </div>
            @error('email')
            <div class="error_msg">{{$message}}</div>
            @enderror
            <input type="text" name="email" id="form_email" class="form__input" value="@if(!empty(old('email'))){{old('email')}}@else{{session('email')}}@endif" />
            <div class="form__label_container">
                <label for="form_password">Password:</label>
                <div class="form__sub_label form__sub_label--show_hide"><i class="fa-solid fa-eye"></i>Show</div>
            </div>
            @error('password')
            <div class="error_msg">{{$message}}</div>
            @enderror
            <input type="password" name="password" id="form_password" class="form__input" />
            <div class="form__checkbox_container">
                <label for="form_remember">Remember me: </label>
                <input type="checkbox" name="remember" id="form_remember">
            </div>
            <input type="submit" class="form__submit" value="Login" />
            <a href="{{route('requestToChangePassword')}}" class="form__forgot_password_msg">Forgot Password?</a>
        </form>
    </div>
    <!-- FORM SCRIPT -->
    <script src="{{asset('public/js/form.js')}}"></script>
    @endif
</body>

</html>
@endsection
