@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/welcome.css')}}">
@endsection

@section('title')
<title>Aston CV</title>
@endsection

@section('body')

<body>
    <!-- SCRIPT needed to store the route where an AJAX request will be sent from the search input box -->
    <script type="text/javascript">
        let searchCVRoute = "{{route('searchCV')}}";
        let normalViewCVRoute = "{{route('viewCV',0)}}";
        let csfrToken = "{{csrf_token()}}";

        let areNoCVs = false;
    </script>
    <h1 class="title title--cv_collection">CV Collection</h1>
    <div class="container container--search">
        <h2 class="search__header">Search:</h2>
        <div class="search__configure_search_category_text">Configure search category:</div>
        <select name="cv_configure_search_category" id="cv_configure_search_category" class="search__configure_search_category">
            <option value="Name">Name</option>
            <option value="Programming Language">Programming Language</option>
        </select>
        <input type="text" name="cv_search_input" id="cv_search_input" class="search__search_box" placeholder="Enter search here">
    </div>

    <div class="container container--cv" id="cv_container">
        @if(count($cvs))
        @for($i=0;$i < count($cvs); $i++) <!-- SCRIPT TO SORT OUT STYLING FOR CV LIST ITEM -->
            @php
                $baseClass = 'cv__list_item_container';
                if(fmod(floatval($i), 3.0) === 0.0){
                    $baseClass .= ' cv__list_item_container--left';
                }else if(fmod(floatval($i), 3.0) === 1.0){
                    $baseClass .= ' cv__list_item_container--middle';
                }else if(fmod(floatval($i), 3.0) === 2.0){
                    $baseClass .= ' cv__list_item_container--right';
                }

               if(fmod(floatval($i), 2.0) === 0.0){
                    $baseClass .= ' cv__list_item_container--medium_left';
               }else if(fmod(floatval($i), 2.0) === 1.0){
                    $baseClass .= ' cv__list_item_container--medium_right';
               }
            @endphp
            <div class="{{$baseClass}}">
                <div class="cv__list_item">
                    <h2 class="cv__name">{{$cvs[$i]->name}}</h2>
                    <a href="{{route('viewCV',$cvs[$i]->id)}}" class="cv__view_cv_btn">View CV</a>
                </div>
            </div>
            @endfor
        @else
        <div class="cv__sorry_no_matches_msg">There are no CVs at the moment.</div>
        <script type="text/javascript">
            areNoCVs = true;
        </script>
        @endif
    </div>
    <!-- Welcome SCRIPT -->
    <script src="{{asset('public/js/welcome.js')}}"></script>
</body>

</html>
@endsection
