<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Profile Settings </title>
        
        <link rel="apple-touch-icon" sizes="76x76" href="<?= $this->url->get('img/favicon/apple-touch-icon.png?v=OmyYv82BBp') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= $this->url->get('img/favicon/favicon-32x32.png?v=OmyYv82BBp') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= $this->url->get('img/favicon/favicon-16x16.png?v=OmyYv82BBp') ?>">
        <link rel="manifest" href="<?= $this->url->get('img/favicon/manifest.json?v=OmyYv82BBp') ?>">
        <link rel="mask-icon" href="<?= $this->url->get('img/favicon/safari-pinned-tab.svg?v=OmyYv82BBp') ?>" color="#5bbad5">
        <link rel="shortcut icon" href="<?= $this->url->get('img/favicon/favicon.ico?v=OmyYv82BBp') ?>">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:image" content="https://articool.benjaminakar.com/img/logo/facebook-logo.png" />
	    <meta property="og:image" content="https://articool.benjaminakar.com/img/logo/facebook-logo.png" />

        <!-- Output CSS & JS from controllerbase -->
        <?= $this->assets->outputCss() ?>
        <?= $this->assets->outputJs() ?>

        
    </head>

    <body id="body" class="settings">
    
        <!-- Navbar button -->
        <div class="navbar__button">
            <button id="navbar__button">menu</button>
        </div>

        <!-- Navbar -->
        <?= $this->partial('templates/navbar') ?>

        <?= $this->tag->javascriptInclude('js/config.js') ?>
        <div class="container">
            <div class="row">
                <!-- Content for website / body -->
                

<!-- LEFT NAVBAR -->
<div class="col-xs-12 col-md-4 col-lg-4">
    <div class="settings__navbar">

	    <a href="<?= $this->url->get('settings/profile') ?>">
	        <button class="button black">Profile settings</button>
	    </a>

	    <a href="<?= $this->url->get('settings/security') ?>">
	        <button class="button black">Security settings</button>
	    </a>

        <a href="<?= $this->url->get('profile/') ?><?= $user->username ?>">
            <button class="button white">Back to Profile</button>
        </a>

    </div>
</div>
<!-- LEFT NAVBAR -->

<!-- BODY -->
<div class="col-xs-12 col-md-8 col-lg-8">
    <p class="settings__title">Profile Settings</p>
    
    <form id="profileSettings" class="settings__form" method="POST" action="<?= $this->url->get('api/v1/settings/profile-settings') ?>" enctype="multipart/form-data">

        <div class="settings__form__input">
            <input type="text" id="username" name="username" value="<?= $user->username ?>"  maxlength="25" required />
            <label for="username">Username</label>
        </div>

        <div class="settings__form__input">
            <input type="text" id="first_name" name="first_name" value="<?= $user->first_name ?>"  maxlength="25" required />
            <label for="first_name">First Name</label>
        </div>

        <div class="settings__form__input">
            <input type="text" id="last_name" name="last_name" value="<?= $user->last_name ?>"  maxlength="25"  required />
            <label for="last_name">Last Name</label>
        </div>

        <div class="settings__form__input">
            <input type="email" id="email_address" name="email_address" value="<?= $user->email_address ?>"  maxlength="255" placeholder="<?php if (($user->email_address == null)) { ?>Please confirm your email-address <?php } else { ?>Enter a new email-address <?php } ?>" required />
            <label for="email_address">Email Address</label>
        </div>

        <div class="settings__form__input">
            <textarea id="description" name="description" maxlength="255" placeholder="Enter a fitting description"><?= $user->description ?></textarea>
            <label for="description">Description</label>
        </div>

        <div class="settings__form__input__file">
            <input type="file" name="avatar" id="avatar" accept="image/x-png,image/jpeg,image/jpg" />
            <label class="settings__form__input__file__select" for="avatar"><i  style="margin-right: .5rem;" class="fa fa-upload" aria-hidden="true"></i>Choose a file</label>
        </div>

        <input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />

        <input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
        <input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />

        <div class="settings__form__input">
            <input id="settings_submit" type="submit" name="submit" value="Update" />
        </div>

        <div style="color:black;" id="feedback_message"></div>
    </form>

    <!-- Remove avatar -->
    <form style="color:black;" method="POST" id="removeAvatar" action="<?= $this->url->get('api/v1/settings/profile-settings/remove-avatar') ?>">
        <input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />

        <div style="font-style: italic; margin-top: 1rem;">
            If you wish to remove your avatar, click <input id="avatar__remove" style="background-color: white; border: none; font-size: .97rem; text-decoration: underline; font-style: italic; cursor: pointer;" type="submit" name="submit" value="here ">
        </div>
    </form>

</div>
<!-- BODY -->

<?= $this->tag->javascriptInclude('js/auth/profileSettings.js') ?>


            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>