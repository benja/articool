{% extends "templates/base.volt" %}

{% block title %} Profile Settings {% endblock %}

{% block content %}
{{ partial('templates/navbar') }}
<div class="settingspage">

    <div class="settingspage__content">
        <div class="settingspage__left">

            <div id="backgrounddiv" class="settingspage__left--info {% if user.background is 2 %}bg1{% elseif user.background is 3 %}bg2{% endif %}">
                <div class="settingspage__left--center">
                    <div class="settingspage__left--image" style="background-image: url({{ url('img/avatars/') }}{{ user.avatar }})"></div>
                    <h1 class="settingspage__left--name">{{ user.first_name }} {{ user.last_name }}</h1>
                    <p class="settingspage__left--username">(@{{ user.username }})</p>
                    {% if user.rank_id >= 2 %}
                    <div class="role {% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}">{% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}</div>
                    {% endif %}
                </div>
            </div>

            <div class="settingspage__left--menu">
                <a class="settingspage__left--button" href="{{ url('settings/profile') }}">Profile Settings</a>
                <a class="settingspage__left--button" href="{{ url('settings/security') }}">Security Settings</a>
                {% if getPeopleReached >= 1000 %} <a class="settingspage__left--button active" href="{{ url('settings/extension') }}">Extension Settings</a> {% endif %}
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

                <form id="extensionSettings" class="settings__form" method="POST" action="{{ url('api/v1/settings/extension-settings') }}" enctype="multipart/form-data">
                    <div class="input__div">

                        <div class="input__box">
                            <h1 class="input__box--title">Background Gradient</h1>
                            <select class="input__box--field" id="background" name="background" required>
                                <option value="{{ user.background }}" hidden selected>{% if user.background is 1 %}Default Gradient{% elseif user.background is 2 %}First Gradient{% elseif user.background is 3 %}Second Gradient{%endif%}</option>
                                <optgroup label="Default">
                                    <option value="1">Default Gradient</option>
                                </optgroup>
                                <optgroup label="Special">
                                    <option value="2">First Gradient</option>
                                    <option value="3">Second Gradient</option>
                                </optgroup>
                            </select>
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
{{ javascript_include("js/auth/extensionSettings.js") }}
{% endblock %}