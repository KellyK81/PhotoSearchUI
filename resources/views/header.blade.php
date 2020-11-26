<div @if (Route::currentRouteName() == 'home') id="homepage" @endif class = "navlinks">
    <a id="lnkHome" href="/">Home</a>
    
    @if (Session::get('authenticated'))
        &nbsp;|&nbsp;<a id="lnkLogout" href="/logout">Log Out</a>
    @else
        @if (Route::currentRouteName() != 'login')
            &nbsp;|&nbsp;<a id="lnkLogin" href="/login">Log In <i class="glyphicon glyphicon-log-in"></i></a>
        @endif
    @endif
</div>