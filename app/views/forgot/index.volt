{% extends "templates/base.volt" %}

{% block title %} Forgot Password {% endblock %}
{% block body_id %}forgot{% endblock %}

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

    <form id="forgotPassword" class="forgot__form"  method="POST" action="{{ url('api/v1/forgot/forgot-password') }}">
        
        <div class="forgot__form__input">
            <input type="text" id="usernameoremail_address" name="usernameoremail_address" maxlength="255" required>
            <label for="usernameoremail_address">Username or Email</label>
        </div>

        <input type="hidden" name="{{ security.getTokenKey() }}"
        value="{{ security.getToken() }}" />

        <div class="forgot__form__input">
            <input id="forgot_submit" type="submit" value="Send Instructions">
        </div>

    </form>
    <a class="forgot__form__link" href="{{ url('login') }}">Go back to Login</a>
</div>

<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>

{{ javascript_include('js/auth/forgotPassword.js') }}
{% endblock %}