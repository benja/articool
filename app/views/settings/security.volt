{% extends "templates/base.volt" %}

{% block title %} Security Settings {% endblock %}
{% block body_id %}settings{% endblock %}

{% block title %} Settings  {% endblock %}

{% block content %}

<!-- LEFT NAVBAR -->
<div class="col-xs-12 col-md-4 col-lg-4">
    <div class="settings__navbar">

	    <a href="{{ url('settings/profile') }}">
	        <button class="button black">Profile settings</button>
	    </a>

	    <a href="{{ url('settings/security') }}">
	        <button class="button black">Security settings</button>
	    </a>

        <a href="{{ url('profile/') }}{{ user.username }}">
            <button class="button white">Back to Profile</button>
        </a>

    </div>
</div>
<!-- LEFT NAVBAR -->

<!-- BODY -->
<div class="col-xs-12 col-md-8 col-lg-8">
    <p class="settings__title">Security Settings</p>

    <form id="securitySettings" class="settings__form" method="POST" action="{{ url('api/v1/settings/security-settings') }}" enctype="multipart/form-data">

        <div class="settings__form__input">
            <input type="password" id="old_password" name="old_password" required />
            <label for="old_password">Old Password</label>
        </div>

        <div class="settings__form__input">
            <input type="password" id="new_password" name="new_password" required />
            <label for="new_password">New Password</label>
        </div>

        <div class="settings__form__input">
            <input type="password" id="repeat_newpassword" name="repeat_newpassword" required />
            <label for="repeat_newpassword">Repeat New Password</label>
        </div>

        <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
        <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

        <div class="settings__form__input">
            <input id="settings_submit" type="submit" name="submit" value="Update" />
        </div>

        <div style="color:black;" id="feedback_message"></div>
    </form>
</div>
<!-- BODY -->

{{ javascript_include("js/auth/securitySettings.js") }}
{% endblock %}