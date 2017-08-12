<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

@include('includes.header')

<div class="container" style="margin-top: 20px;">
    <h1>@yield('title')</h1>
    <hr>
</div>

<div class="container">
    <div id="main" class="row">
        <div id="content" class="col">
            @yield('content')
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div id="content" class="col">
            @include('includes.modal')
            <hr>
            @include('includes.footer')
        </div>
    </div>
</div>

</body>
</html>