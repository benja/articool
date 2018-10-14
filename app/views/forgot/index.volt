{% extends "templates/base.volt" %}

{% block title %} Forgot Password {% endblock %}

{% block content %}
<div class="authpage">
	<div class="authpage__content">

		<div class="authpage__left">

			<div class="authpage__left--box">
				<!--<h1 class="authpage__left--title">Forgot</h1>
				<p class="authpage__left--description">Text</p>-->

				<h2 class="authpage__left--smalltitle">Forgot</h2>
				<ul class="authpage__left--list">
					<li>Can't remember your password? No worries. Follow the instructions on the right, and we'll help you regain access to your account.</li>
				</ul>

				<a class="authpage__left--goback" href="javascript:history.go(-1)">
					<i class="fas fa-arrow-left"></i>
					<p style="color: white;">Go Back</p>
				</a>
			</div>

		</div>

		<div class="authpage__right">

			<form id="forgotPassword" method="POST" action="{{ url('api/v1/forgot/forgot-password') }}">
				<div class="input__div">
					<h1 class="authpage__right--title">Forgot</h1>

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
					
					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

					<div class="input__box">
						<input class="input__box--field fullwidth button success" type="submit" id="forgot_submit" value="Send Password Reset Instructions">
					</div>

					<div class="input__box">
					    <a href="{{ url('login') }}">Back to Login</a>
                    </div>
				</div>
			</div>
		</form>
	</div>
</div>
{{ javascript_include('js/auth/forgotPassword.js') }}
{% endblock %}