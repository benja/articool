{% extends "templates/base.volt" %}

{% block title %} Register {% endblock %}
{% block body_id %} register {% endblock %}

{% block content %}
<div class="authpage">
	<div class="authpage__content">

		<div class="authpage__left">

			<div class="authpage__left--box">
				<!--<h1 class="authpage__left--title">Register</h1>
				<p class="authpage__left--description">/* A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind. */</p>-->

				<h2 class="authpage__left--smalltitle">Why should you register?</h2>
				<ul class="authpage__left--list">
					<li>Join <strong>{{ registeredUsers }}</strong> other authors and start sharing your creativity with the world today.</li>
					<li>Writing and publishing articools is very simple. Share to your preferred social network with one click.</li>
					<li>Creating an account is easy, just fill in the form, confirm your email, profit!</li>
				</ul>

				<a class="authpage__left--goback" href="javascript:history.go(-1)">
					<i class="fas fa-arrow-left"></i>
					<p style="color: white;">Go Back</p>
				</a>
			</div>

		</div>

		<div class="authpage__right">

			<form id="registerForm" method="POST" action="{{ url('api/v1/auth/register') }}">
				<div class="input__div">
					<h1 class="authpage__right--title">Register</h1>

					<div class="input__box">
						<div id="alert_div" class="feedback">
							<h1 id="alert_title" class="feedback--title">TITLE</h1>
							<div id="feedback_message" class="feedback__messages">message</div>
						</div>
					</div>

					<div class="input__box">
						<h1 class="input__box--title">Username</h1>
						<input class="input__box--field" type="text" id="username" name="username" maxlength="25" placeholder="Enter your username" required>
					</div>
					<div class="input__box">
						<h1 class="input__box--title">First Name</h1>
						<input class="input__box--field" type="text" id="first_name" name="first_name" maxlength="25" placeholder="Enter your first name" required>
					</div>
					<div class="input__box">
						<h1 class="input__box--title">Last Name</h1>
						<input class="input__box--field" type="text" id="last_name" name="last_name" maxlength="25" placeholder="Enter your last name" required>
					</div>
					<div class="input__box">
						<h1 class="input__box--title">Email-address</h1>
						<input class="input__box--field" type="email" id="email_address" name="email_address" placeholder="Enter your email" required>
					</div>
					<div class="input__box">
						<h1 class="input__box--title">Password</h1>
						<input class="input__box--field" type="password" id="password" name="password" placeholder="•••••••••">
					</div>

					<div class="input__box inline checkbox">
						<input class="input__box--checkbox" id="accepttos" name="accepttos" type="checkbox">
						<label for="accepttos" class="input__box--title">I have read and accept the <a href="{{ url('terms') }}" target="_blank">ToS</a> & <a href="{{ url('privacy') }}" target="_blank">Privacy Policy</a></h1>
					</div>

					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

					<div class="input__box">
						<input class="input__box--field fullwidth button success" type="submit" id="register_submit" value="Register">
					</div>

					<div class="input__box">
					<a href="{{ url('login') }}">Already an author?</a></div>
				</div>
			</div>
		</form>
	</div>
</div>

{{ javascript_include('js/auth/authRegister.js') }}

{% endblock %}