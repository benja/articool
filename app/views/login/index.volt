{% extends "templates/base.volt" %}

{% block title %} Login {% endblock %}
{% block body_id %} login {% endblock %}

{% block content %}
<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>

<div class="col-xs-12 col-md-6 col-lg-6">

	<div id="alert_div" class="alert hidden">
		<span>
			<label id="alert_title" class="alert__title">ERROR</label>
		</span>
		<ul>
			<div id="feedback_message"></div>
		</ul>
	</div>

	<form class="login__form" id="loginForm" method="POST" action="{{ url('api/v1/auth/login') }}">
		<div class="login__form__input">
			<input type="text" id="usernameoremail_address" name="usernameoremail_address" maxlength="255" required>
			<label for="usernameoremail_address">Username or Email</label>
		</div>

		<div class="login__form__input">
			<input type="password" id="password" name="password" maxlength="255" required>
			<label for="password">••••• •••• ••••••••</label>
		</div>

		<input type="checkbox" name="remember_me" id="remember_me" />
		<label style="margin-bottom: 2rem; margin-top: -1rem;" for="remember_me">
			<span>
				
			</span>
			Remember me
		</label>

		<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

		<div class="login__form__input">
			<input id="login_submit" type="submit" value="Log In">
		</div>
		
	</form>
	<a class="login__form__link" href="{{ url('forgot') }}">Forgot Password?</a>
	<a class="login__form__link" href="{{ url('register') }}">Become an Author</a>
</div>

<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>

{{ javascript_include("js/auth/authLogin.js") }}
{% endblock %}