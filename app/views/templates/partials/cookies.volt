{% if cookies.has('cookie_accept') is false %}

<div class="cookie">
    <div class="cookie__left">
        <h1 class="cookie__text">
            <b>Articool</b> uses cookies to offer you a better browsing experience.
            By browsing our site you hereby accept our use of cookies.
        </h1>
    </div>

    <div class="cookie__right">
        <form method="POST" action="{{ url('api/v1/auth/cookie-accept') }}">
            <input class="cookie__accept" type="submit" name="accept" value="Accept"/>
        </form>
    </div>
</div>

{% endif %}