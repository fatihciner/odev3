<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand" href="/">ÖDEV</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/transaction/list">Transaction List</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/transaction/report">Transaction Report <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <span class="navbar-text">

@if (Auth::check())
    {{ Auth::user()['email'] }}
@else
    <a href="/login">LOGIN</a>
@endif

        </span>
        </div>
    </div>
</nav>