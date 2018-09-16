{% if user is defined %}
<div id="navbar" class="navbar hidden">
    <div class="navbar__elements">

        <a href="{{ url('explore') }}">
            <div class="navbar__elements__element">
                <li>Explore</li>
            </div>
        </a>

        <a href="{{ url('settings/profile') }}">
            <div class="navbar__elements__element">
                <li>Settings</li>
            </div>
        </a>

        <form id="authLogout" method="POST" action="{{ url('api/v1/auth/logout') }}">
            <a href="{{ url('api/v1/auth/logout') }}">
                <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
                <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />
                
                <input id="logout_submit" class="navbar__elements__element" type="submit" value="Logout">
            </a>
        </form>

        <a href="{{ url('profile/') }}{{ user.username }}">
            <div class="navbar__elements__element">
                <li><img class="navbar__elements__image" src="{{ url('img/avatars/') }}{{ user.avatar }}" alt="{{ user.first_name }} {{ user.last_name }}" />{{ user.first_name }} {{ user.last_name }}</li>
            </div>
        </a>

    </div>
</div>
{{ javascript_include('js/auth/authLogout.js') }}

{% else %}

<div id="navbar" class="navbar hidden">
    <div class="navbar__elements">

        <a href="{{ url('') }}">
            <div class="navbar__elements__element">
                <li>Home</li>
            </div>
        </a>

        <a href="{{ url('login') }}">
            <div class="navbar__elements__element">
                <li>Login</li>
            </div>
        </a>

        <a href="{{ url('explore') }}">
            <div class="navbar__elements__element">
                <li>Explore</li>
            </div>
        </a>

        <a href="{{ url('register') }}">
            <div class="navbar__elements__element">
                <li>Register</li>
            </div>
        </a>

    </div>
</div>
{% endif %}