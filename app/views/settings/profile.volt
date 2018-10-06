{% extends "templates/base.volt" %}

{% block title %} Profile Settings {% endblock %}
{% block body_id %}settings{% endblock %}

{% block content %}
{{ partial('templates/navbar') }}
<div class="settingspage">

    <div class="settingspage__content">
        <div class="settingspage__left">

            <div class="settingspage__left--info {% if user.background is 2 %}bg1{% elseif user.background is 3 %}bg2{% endif %}">
                <div class="settingspage__left--center">
                    <div class="settingspage__left--image" style="background-image: url({{ url('img/avatars/') }}{{ user.avatar }})"></div>
                    <form method="POST" id="removeAvatar" action="{{ url('api/v1/settings/profile-settings/remove-avatar') }}">
                        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />    
                        <input id="avatar__remove" class="settingspage__left--removeimage" type="submit" value="Remove Avatar">
                    </form>
                    <h1 class="settingspage__left--name">{{ user.first_name }} {{ user.last_name }}</h1>
                    <p class="settingspage__left--username">(@{{ user.username }})</p>
                    {% if user.rank_id >= 2 %}
                    <div class="role {% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}">{% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}</div>
                    {% endif %}
                </div>
            </div>

            <div class="settingspage__left--menu">
                <a class="settingspage__left--button active" href="{{ url('settings/profile') }}">Profile Settings</a>
                <a class="settingspage__left--button" href="{{ url('settings/security') }}">Security Settings</a>
                {% if getPeopleReached >= 1000 %} <a class="settingspage__left--button" href="{{ url('settings/extension') }}">Extension Settings</a> {% endif %}
                <a class="settingspage__left--button" href="{{ url('author/') }}{{ user.username }}">Back to Profile</a>
            </div>

        </div>

        <div class="settingspage__right">

            <div class="input__box">
                <div id="alert_div" class="feedback">
                    <h1 id="alert_title" class="feedback--title">TITLE</h1>
                    <div id="feedback_message" class="feedback__messages">message</div>
                </div>
            </div>
            
            <div class="settingspage__right--box">

                <form id="profileSettings" class="settings__form" method="POST" action="{{ url('api/v1/settings/profile-settings') }}" enctype="multipart/form-data">
                    <div class="input__div">

                        <div class="input__box">
                            <h1 class="input__box--title">Username</h1>
                            <input class="input__box--field" type="text" id="username" name="username" value="{{ user.username }}" maxlength="25" placeholder="Enter your username" required />
                        </div>

                        <div class="input__box">
                            <h1 class="input__box--title">First Name</h1>
                            <input class="input__box--field" type="text" id="first_name" name="first_name" value="{{ user.first_name }}" maxlength="25" placeholder="Enter your first name" required />
                        </div>

                        <div class="input__box">
                            <h1 class="input__box--title">Last Name</h1>
                            <input class="input__box--field" type="text" id="last_name" name="last_name" value="{{ user.last_name }}" maxlength="25" placeholder="Enter your last name" required />
                        </div>

                        <div class="input__box">
                            <h1 class="input__box--title">Email-address</h1>
                            <input class="input__box--field" type="email" id="email_address" name="email_address" value="{{ user.email_address }}"  maxlength="255" placeholder="{% if(user.email_address is null) %}Please confirm your email-address{% else %}Enter a new email-address{% endif %}" required />
                        </div>

                        <div class="input__box">
                            <h1 class="input__box--title">Description</h1>
                            <textarea class="input__box--field" id="description" name="description" maxlength="255" placeholder="Let people know who you are and what you like, this will be displayed on your profile page">{{ user.description }}</textarea>
                        </div>

                        <div class="input__box">
                            <h1 class="input__box--title">Upload profile avatar</h1>
                            <input type="file" name="avatar" id="avatar" accept="image/x-png,image/jpeg,image/jpg" value="Click to upload">
                            <label class="input__box--filebutton" for="avatar">Click to upload</label>
                        </div>

                        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

                        <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
                        <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

                        <div class="input__box">
                            <input class="input__box--field button success" type="submit" name="submit" id="settings_submit" value="Save changes">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
{{ javascript_include("js/auth/profileSettings.js") }}
{% endblock %}