{% extends "templates/base.volt" %}

{% block title %} Frequently Asked Questions {% endblock %}

{% block content %}
{{ partial('templates/navbar') }}
<div class="faqpage">
    <h1 class="faqpage__title">Frequently Asked Questions (click)</h1>
    <div class="faqpage__content">
        
        <div class="faqpage__list">

            <div class="faqpage__list--box">
                <div class="faqpage__list--question">
                    <p>Is it free to create an Articool account?</p>
                </div>
                <div class="faqpage__list--answer">
                    <p>Creating an Articool account is, and always will be, completely free of charge.</p>
                </div>
            </div>

            <div class="faqpage__list--box">
                <div class="faqpage__list--question">
                    <p>Why do some users have a colored background on their profile?</p>
                </div>
                <div class="faqpage__list--answer">
                    <p>Upon reaching <strong>1,000</strong> amount of people, you will unlock a feature that allows you to customize your background color. This number may increase in the future. Check your profile page to see the amount of people you have reached.</p>
                </div>
            </div>

            <div class="faqpage__list--box">
                <div class="faqpage__list--question">
                    <p>How do I delete my Articool account?</p>
                </div>
                <div class="faqpage__list--answer">
                    <p>If you wish to delete your account, send an email to <strong>support@articool.blog</strong> from the email in which you registered an account on. Let us know you want to delete your account, and we will take it from there.</p>
                </div>
            </div>

            <div class="faqpage__list--box">
                <div class="faqpage__list--question">
                    <p>How do I write an Articool?</p>
                </div>
                <div class="faqpage__list--answer">
                    <p>From your profile page, click on the "+" button. This will prompt you with a window where you can write and publish an articool.</p>
                </div>
            </div>

            <div class="faqpage__list--box">
                <div class="faqpage__list--question">
                    <p>I successfully logged in, but I'm not logged in?</p>
                </div>
                <div class="faqpage__list--answer">
                    <p>If this happens, reset your browser's cache and try logging in again. If this does not solve the issue, please email us at <strong>support@articool.blog</strong></p>
                </div>
            </div>

        </div>

    </div>
</div>
{{ partial('templates/footer') }}
<script>
    const questions = document.querySelectorAll(".faqpage__list--question");
    questions.forEach(function(e) {
        e.onclick = function(){
            e.classList.toggle("active")
        }
    });
</script>
{% endblock %}