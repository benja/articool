<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Login </title>
        
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

    <body id="body" class=" login ">
    
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
                
<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>

<div class="col-xs-12 col-md-6 col-lg-6">

	<form class="login__form" id="loginForm" method="POST" action="<?= $this->url->get('api/v1/auth/login') ?>">
		<div class="login__form__input">
			<input type="text" id="usernameoremail_address" name="usernameoremail_address" maxlength="255" required>
			<label for="usernameoremail_address">Username or Email</label>
		</div>

		<div class="login__form__input">
			<input type="password" id="password" name="password" maxlength="255" required>
			<label for="password">••••• •••• ••••••••</label>
		</div>

		<input type="checkbox" name="remember_me" id="remember_me" />
		<label style="margin-bottom: 2rem; margin-top: -1rem;" for="remember_me">
			<span>
				
			</span>
			Remember me
		</label>

		<input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />

		<div class="login__form__input">
			<input id="login_submit" type="submit" value="Log In">
		</div>

		<div id="feedback_message"></div>
	</form>
	<a class="login__form__link" href="<?= $this->url->get('forgot') ?>">Forgot Password?</a>
	<a class="login__form__link" href="<?= $this->url->get('register') ?>">Become an Author</a>
</div>

<div class="col-xs-12 col-md-3 col-lg-3">
<!-- Something -->
</div>


<?= $this->tag->javascriptInclude('js/auth/authLogin.js') ?>

            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>