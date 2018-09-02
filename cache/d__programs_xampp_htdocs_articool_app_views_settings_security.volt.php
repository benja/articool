<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Settings  </title>
        
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
    <p class="settings__title">Security Settings</p>

    <form id="securitySettings" class="settings__form" method="POST" action="<?= $this->url->get('api/v1/settings/security-settings') ?>" enctype="multipart/form-data">

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

        <input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
        <input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />

        <input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />

        <div class="settings__form__input">
            <input id="settings_submit" type="submit" name="submit" value="Update" />
        </div>

        <div style="color:black;" id="feedback_message"></div>
    </form>
</div>
<!-- BODY -->

<?= $this->tag->javascriptInclude('js/auth/securitySettings.js') ?>

            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>