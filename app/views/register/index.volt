{% extends "templates/base.volt" %}

{% block title %} Register {% endblock %}
{% block body_id %} register {% endblock %}

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

	<!-- BODY -->
	<form id="registerForm" class="register__form" method="POST" action="{{ url('api/v1/auth/register') }}">

		<div class="register__form__input">
			<input type="text" id="username" name="username" maxlength="25" required />
			<label for="username">Username</label>
		</div>

		<div class="register__form__input">
			<input type="text" id="first_name" name="first_name" maxlength="25" required />
			<label for="first_name">First Name</label>
		</div>

		<div class="register__form__input">
			<input type="text" id="last_name" name="last_name" maxlength="25" required />
			<label for="last_name">Last Name</label>
		</div>

		<div class="register__form__input">
			<input type="email" id="email_address" name="email_address" required />
			<label for="email_address">Email-address</label>
		</div>

		<div class="register__form__input">
			<input type="password" id="password" name="password" required />
			<label for="password">••••• •••• ••••••••</label>
		</div>

		<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

		<div class="register__form__input">
			<input id="register_submit" type="submit" value="Become Author" />
		</div>

	</form>
	<!-- BODY -->

	<a class="register__form__link" href="{{ url('login') }}">Already an author?</a>
</div>

<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>

{{ javascript_include('js/auth/authRegister.js') }}

{% endblock %}