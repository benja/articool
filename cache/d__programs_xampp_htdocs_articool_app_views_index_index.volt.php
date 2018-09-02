<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Articool </title>
        
        <link rel="apple-touch-icon" sizes="76x76" href="<?= $this->url->get('img/favicon/apple-touch-icon.png?v=OmyYv82BBp') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= $this->url->get('img/favicon/favicon-32x32.png?v=OmyYv82BBp') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= $this->url->get('img/favicon/favicon-16x16.png?v=OmyYv82BBp') ?>">
        <link rel="manifest" href="<?= $this->url->get('img/favicon/manifest.json?v=OmyYv82BBp') ?>">
        <link rel="mask-icon" href="<?= $this->url->get('img/favicon/safari-pinned-tab.svg?v=OmyYv82BBp') ?>" color="#5bbad5">
        <link rel="shortcut icon" href="<?= $this->url->get('img/favicon/favicon.ico?v=OmyYv82BBp') ?>">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:image" content="https://articool.benjaminakar.com/img/logo/facebook-logo.png" />
	    <meta property="og:image" content="https://articool.benjaminakar.com/img/logo/facebook-logo.png" />

        <!-- Output CSS from controllerbase -->
        <?= $this->assets->outputCss() ?>

        
<meta name="description" content="A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind.">
<meta name="keywords" content="articool, article">
<meta name="author" content="Articool">

<!-- Twitter Tags -->
<meta name="twitter:title" content="Articool - article platform!" />
<meta name="twitter:site" content="https://articool.benjaminakar.com/" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind." />

<!-- Facebook Tags -->
<meta property="og:url" content="https://articool.benjaminakar.com/" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Articool - article platform!" />
<meta property="og:description" content="A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind." />
<meta property="fb:app_id"	content="181778325703258" />

    </head>

    <body>
        <!-- Content for website / body -->
        
<!-- Welcome Section  -->
<section class="welcome">
	<div class="welcome__background--overlay">
		<div class="welcome__background"></div>
	</div>

	<nav class="welcome__navbar">
		<ul class="welcome__navbar--links">
			<li class="welcome__navbar--entry"><a href="<?= $this->url->get('login') ?>">Login</a></li>
		</ul>
	</nav>

	<div class="welcome__body">
		<div class="welcome__text">
			<div class="welcome__text--big">articool</div>
			<div class="welcome__text--small">/* A platform where you are given the opportunity to express your feelings, thoughts, and interests – free of charge. You can write about politics, social issues, literature, or anything on your mind. */</div>
		</div>
	</div>

	<div class="welcome__footer">
		<div class="welcome__text nomax">
			<div class="welcome__text--smaller">Learn More</div>
		</div>
		<a class="welcome__footer--arrow" href="#information"></a>
	</div>
</section>

<!-- Statistics Section -->
<section class="stats">
	<div class="stats__boxes">
		
		<div class="stats__boxes--entry">
			<div class="stats__boxes--number">230</div>
			<div class="stats__boxes--description">Articools Written</div>
			<div class="stats__boxes--hr"></div>
		</div>

		<div class="stats__boxes--entry">
			<div class="stats__boxes--number">102,304</div>
			<div class="stats__boxes--description">Articools Read</div>
			<div class="stats__boxes--hr"></div>
		</div>

		<div class="stats__boxes--entry">
			<div class="stats__boxes--number">24</div>
			<div class="stats__boxes--description">Authors</div>
			<div class="stats__boxes--hr"></div>
		</div>

	</div>
</section>

<!-- Information Section -->
<section id="information" class="information">

	<div class="information__left">
		<div class="information__left--items">
			<img class="information__left--logo" src="<?= $this->url->get('img/logo/logo-small.png') ?>" alt="Articool Small Logo">
			<div class="information__left--text">Articool is an article platform designed to improve communication between authors and readers. It’s simplistic design makes sure the reader stays motivated and focused throughout the whole text.
				<br><br>
				You can be assured there will be no interruptions while reading articles, this including no advertisements.
			</div>
		</div>
	</div>

	<div class="information__right">
		<img class="information__right--image" src="<?= $this->url->get('img/articool_image.jpg') ?>" alt="Articool Image">
	</div>
</section>

<!-- Register Section -->
<section class="join">
	<div class="join__content">

		<div class="join__text">
			<div class="join__text--big">
				Give us a try, and maybe you'll find the inner author in you!
			</div>
		</div>

		<a class="join__button" href="<?= $this->url->get('register') ?>">Become an Author</a>

		<div class="join__text">
			<div class="join__text--small">
				<a href="<?= $this->url->get('login') ?>">Already an author?</a>
			</div>
		</div>

	</div>
</section>

<!-- Footer -->
<section class="footer">
	<div class="footer__content">

		<div class="footer__text">
			<div class="footer__text--title">articool</div>
		</div>

		<div class="footer__list">
			<div class="footer__text">
				<div class="footer__text--small">Social Media</div>
			</div>
			<ul class="footer__list--items">
				<li class="footer__list--entry"><a target="_blank" href="//twitter.com/articool_pf">Twitter</a></li>
				<li class="footer__list--entry"><a target="_blank" href="//facebook.com/articoolplatform">Facebook</a></li>
			</ul>
		</div>

		<div class="footer__credits">
			Made with <span class="footer__credits--red">♥</span> by <a href="//benjaminakar.com">Benjamin Akar</a>
			<div class="footer__credits--hr"></div>
		</div>

	</div>
</section>


        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js') ?>
        <?= $this->tag->javascriptInclude('js/libraries/smoothscroll.js') ?>
    </body>
</html>