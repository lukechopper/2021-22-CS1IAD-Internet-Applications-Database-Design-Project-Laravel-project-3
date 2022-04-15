@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/view-cv.css')}}">
@endsection

@section('title')
<title>View CV</title>
@endsection


@section('body')

<body>
    <section class="about container" id="about">
        <h1 class="title about__title">About</h1>
        <div class="underline about__title-underline"></div>
        <h1 class="about__sub-title">{{$name}}</h1>
        <hr class="about__hr" />
        <div class="about__main-section">
            <div class="about__main-section-col-1">
                <h2 class="about__main-section-header">Profile:</h2>
                <p>
                    {{$profile}}
                </p>
            </div>
            <div class="about__main-section-col-2">
                <div class="about__main-section-info-desc">
                    <h2 class="about__main-section-header">Email:</h2>
                    <a href="{{'mailto:'.$email}}">
                        <p class="inline">{{$email}}</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="education container" id="education">
        <h1 class="title education__title">Education</h1>
        <div class="underline education__title-underline"></div>
        @for($i=0; $i < count($formattedEducationInfo); $i++)
        <div class="general-list-item">
            <h2>{{$formattedEducationInfo[$i][0]}}</h2>
            <em>{{$formattedEducationInfo[$i][1]}}</em>
        </div>
        <p>{{$formattedEducationInfo[$i][2]}}</p>
        @endfor
    </section>
    <section class="programming container">
        <h1 class="title programming__title">Programming Languages</h1>
        <div class="underline programming__title-underline"></div>
        @for($i=0; $i < count($formattedProgrammingInfo); $i++)
        <div class="general-list-item">
            <h2>{{$formattedProgrammingInfo[$i][0]}}</h2>
            <em>{{$formattedProgrammingInfo[$i][1]}}</em>
        </div>
        <p>{{$formattedProgrammingInfo[$i][2]}}</p>
        @endfor
    </section>
    <section class="url container">
        <h1 class="title url__title">URL Links</h1>
        <div class="underline url__title-underline"></div>
        @for($i=0; $i < count($formattedUrlLinksInfo); $i++)
        <div class="general-list-item">
            <h2>{{$formattedUrlLinksInfo[$i][0]}}</h2>
        </div>
        <p><a href="{{$formattedUrlLinksInfo[$i][1]}}" class="url__link" target="_blank">{{$formattedUrlLinksInfo[$i][1]}}</a></p>
        @endfor
    </section>
</body>

</html>
@endsection
