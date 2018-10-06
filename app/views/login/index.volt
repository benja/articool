{% extends "templates/base.volt" %}

{% block title %} Login {% endblock %}
{% block body_id %} login {% endblock %}

{% block content %}
<div class="authpage">
	<div class="authpage__content">

		<div class="authpage__left">

			<div class="authpage__left--box">
				<!--<h1 class="authpage__left--title">Login</h1>
				<p class="authpage__left--description">/* A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind. */</p>-->

				<h2 class="authpage__left--smalltitle">Login</h2>
				<ul class="authpage__left--list">
					<li>Login to your Articool account to start publishing your writing.</li>
				</ul>

				<a class="authpage__left--goback" href="javascript:history.go(-1)">
					<i class="fas fa-arrow-left"></i>
					<p style="color: white;">Go Back</p>
				</a>
			</div>

		</div>

		<div class="authpage__right">

			<form id="loginForm" method="POST" action="{{ url('api/v1/auth/login') }}">
				<div class="input__div">
					<h1 class="authpage__right--title">Login</h1>

					<div class="input__box">
						<div id="alert_div" class="feedback">
							<h1 id="alert_title" class="feedback--title">TITLE</h1>
							<div id="feedback_message" class="feedback__messages">message</div>
						</div>
					</div>

					<div class="input__box">
						<h1 class="input__box--title">Username or Email</h1>
						<input class="input__box--field" type="text" id="usernameoremail_address" name="usernameoremail_address" maxlength="255" placeholder="Enter your username or email" required>
					</div>

					<div class="input__box">
						<h1 class="input__box--title">Password</h1>
						<input class="input__box--field" type="password" id="password" name="password" maxlength="255" placeholder="Enter your first name" required>
					</div>

					<div class="input__box inline checkbox">
						<input class="input__box--checkbox" name="remember_me" id="remember_me" type="checkbox">
						<label for="accepttos" class="input__box--title">Remember me</h1>
					</div>

					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

					<div class="input__box">
						<input class="input__box--field fullwidth button success" type="submit" id="login_submit" value="Log In">
					</div>

					<div class="input__box">
						<a href="{{ url('forgot') }}" style="margin-bottom: .5rem;">Forgot Password?</a>
						<br><br>
					    <a href="{{ url('register') }}">Become an Author</a>
                    </div>
				</div>
			</div>
		</form>
	</div>
</div>
{{ javascript_include("js/auth/authLogin.js") }}
{% endblock %}