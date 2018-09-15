{% extends "templates/base.volt" %}

{% block title %} Profile Settings {% endblock %}
{% block body_id %}settings{% endblock %}

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
    <p class="settings__title">Profile Settings</p>

    <div id="alert_div" class="alert hidden">
        <span>
            <label id="alert_title" class="alert__title">ERROR</label>
        </span>
        <ul>
            <div id="feedback_message"></div>
        </ul>
    </div>

    <form id="profileSettings" class="settings__form" method="POST" action="{{ url('api/v1/settings/profile-settings') }}" enctype="multipart/form-data">

        <div class="settings__form__input">
            <input type="text" id="username" name="username" value="{{ user.username }}"  maxlength="25" required />
            <label for="username">Username</label>
        </div>

        <div class="settings__form__input">
            <input type="text" id="first_name" name="first_name" value="{{ user.first_name }}"  maxlength="25" required />
            <label for="first_name">First Name</label>
        </div>

        <div class="settings__form__input">
            <input type="text" id="last_name" name="last_name" value="{{ user.last_name }}"  maxlength="25"  required />
            <label for="last_name">Last Name</label>
        </div>

        <div class="settings__form__input">
            <input type="email" id="email_address" name="email_address" value="{{ user.email_address }}"  maxlength="255" placeholder="{% if(user.email_address is null) %}Please confirm your email-address {% else %}Enter a new email-address {% endif %}" required />
            <label for="email_address">Email Address</label>
        </div>

        <div class="settings__form__input">
            <textarea id="description" name="description" maxlength="255" placeholder="Enter a fitting description">{{ user.description }}</textarea>
            <label for="description">Description</label>
        </div>

        <div class="settings__form__input__file">
            <input type="file" name="avatar" id="avatar" accept="image/x-png,image/jpeg,image/jpg" />
            <label class="settings__form__input__file__select" for="avatar"><i  style="margin-right: .5rem;" class="fa fa-upload" aria-hidden="true"></i>Choose a file</label>
        </div>

        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

        <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
        <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

        <div class="settings__form__input">
            <input id="settings_submit" type="submit" name="submit" value="Update" />
        </div>

    </form>

    <!-- Remove avatar -->
    <form style="color:black;" method="POST" id="removeAvatar" action="{{ url('api/v1/settings/profile-settings/remove-avatar') }}">
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

        <div style="font-style: italic; margin-top: 1rem;">
            If you wish to remove your avatar, click <input id="avatar__remove" style="background-color: white; border: none; font-size: .97rem; text-decoration: underline; font-style: italic; cursor: pointer;" type="submit" name="submit" value="here ">
        </div>
    </form>

</div>
<!-- BODY -->

{{ javascript_include("js/auth/profileSettings.js") }}

{% endblock %}