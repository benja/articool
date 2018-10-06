{% extends "templates/base.volt" %}

{% block title %} Set New Password {% endblock %}
{% block body_id %}forgot{% endblock %}

{% block content %}
<div class="authpage">
	<div class="authpage__content">

		<div class="authpage__left">

			<div class="authpage__left--box">
				<!--<h1 class="authpage__left--title">Forgot</h1>
				<p class="authpage__left--description">Text</p>-->

				<h2 class="authpage__left--smalltitle">Reset Password</h2>
				<ul class="authpage__left--list">
					<li>Fill in the form on the right side, and we will change your password. It's that simple!</li>
				</ul>

				<a class="authpage__left--goback" href="javascript:history.go(-1)">
					<i class="fas fa-arrow-left"></i>
					<p style="color: white;">Go Back</p>
				</a>
			</div>

		</div>

		<div class="authpage__right">

			<form id="forgotNewPassword" method="POST" action="{{ url('api/v1/forgot/set-new-password/{token}') }}">
				<input type="hidden" name="token" value="{{ dispatcher.getParam('token') }}">
                <div class="input__div">
					<h1 class="authpage__right--title">Forgot</h1>

					<div class="input__box">
						<div id="alert_div" class="feedback">
							<h1 id="alert_title" class="feedback--title">TITLE</h1>
							<div id="feedback_message" class="feedback__messages">message</div>
						</div>
					</div>

					<div class="input__box">
						<h1 class="input__box--title">New Password</h1>
						<input class="input__box--field" type="password" id="password" name="password" placeholder="Enter your new password" required>
					</div>

					<div class="input__box">
						<h1 class="input__box--title">Confirm Password</h1>
						<input class="input__box--field" type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>
					</div>

					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

					<div class="input__box">
						<input class="input__box--field fullwidth button success" type="submit" id="forgot_submit" value="Update Password">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
{{ javascript_include('js/auth/forgotNewPassword.js') }}
{% endblock %}