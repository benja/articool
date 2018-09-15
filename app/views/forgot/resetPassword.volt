{% extends "templates/base.volt" %}

{% block title %} Set New Password {% endblock %}
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

    <form id="forgotNewPassword" class="forgot__form" method="POST" action="{{ url('api/v1/forgot/set-new-password/{token}') }}">

        <input type="hidden" name="token" value="{{ dispatcher.getParam('token') }}">

        <div class="forgot__form__input">
            <input type="password" id="password" name="password" required>
            <label for="password">New Password</label>
        </div>
        
        <div class="forgot__form__input">
            <input type="password" id="confirm_password" name="confirm_password" required>
            <label for="confirm_password">Confirm Password</label>
        </div>

        <input type="hidden" name="{{ security.getTokenKey() }}"
        value="{{ security.getToken() }}" />

        <div class="forgot__form__input">
            <input id="forgot_submit" type="submit" value="Update">
        </div>

    </form>
    </div>
    
    <div class="col-xs-12 col-md-3 col-lg-3">
    <!-- Something -->
    </div>

    {{ javascript_include('js/auth/forgotNewPassword.js') }}
{% endblock %}