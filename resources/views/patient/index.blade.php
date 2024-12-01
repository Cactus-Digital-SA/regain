@php use App\Domains\Questions\Models\Question; @endphp
@php
    /**
     * @var \App\Domains\Questions\Repositories\Eloquent\Models\Question $question
    */
@endphp<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/gif"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title>Regain</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}"/>

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet"/>

    <!-- font awesome style -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet"/>

    <style>
        .rounded {
            border-radius: 55px; /* Adjust the px value as needed */
        }
    </style>
</head>

<body>

<div>
    <!-- header section strats -->
    <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.html">
          <span>
            Regain
          </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
                    <ul class="navbar-nav  ">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.html">Regain <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html"> MyRegain</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="furniture.html">Community</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.html">Help</a>
                        </li>
                    </ul>
                </div>
                <div class="quote_btn-container">
                    <a href="{{route("logout")}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <span>
                Logout
              </span>
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </a>
                    <form class="form-inline">
                        <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <!-- end header section -->
</div>

<section class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 mx-auto">
                <div class="box rounded">
                    <div class="detail-box">
                        <h5>
                            {{$question->getTitle()}}
                        </h5>
                        @foreach ($question->getResponses() as $response)
                            <form method="POST" id="submit-form_{{$response->getId()}}" action="{{ route('patient.store') }}">
                                @csrf
                                <input type="hidden" name="response_id" value=""/>
                                <div class="form-group">
                                    <button class="btn btn-primary">{{$response->getTitle()}}</button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end blog section -->

<!-- client section -->

<!-- footer section -->
<footer class="footer_section">
    <div class="container">
        <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="https://www.cactusweb.gr/">Cactus</a>
        </p>
    </div>
</footer>
<!-- footer section -->

<!-- jQery -->
<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<!-- End Google Map -->

<form method="POST" id="logout-form" action="{{ route('logout') }}">
    @csrf
</form>

</body>

</html>