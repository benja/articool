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

        <!-- Output CSS & JS from controllerbase -->
        <?= $this->assets->outputCss() ?>
        <?= $this->assets->outputJs() ?>

        
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

    <body id="body" class="index">
    
        <!-- Navbar button -->
        <div class="navbar__button">
            <button id="navbar__button">menu</button>
        </div>

        <!-- Navbar -->
        <?= $this->partial('templates/navbar') ?>

        <?= $this->tag->javascriptInclude('js/config.js') ?>
        <div class="fluid-container">
            <div class="row">
                <!-- Content for website / body -->
                
<div class="col-xs-12 col-md-12 col-lg-12">
	<div class="index__logo__center">
		<img class="index__logo" src="https://articool.benjaminakar.com/img/logo/logo-big.png" />
	</div>
</div>

<!--

	TRENDING ARTICLES

-->

<div class="col-xs-12 col-md-4 col-lg-4">
	<h1 class="index__title">Trending Articools</h1>

	<?php foreach ($getTrendingPosts as $post) { ?>
	<div class="postbox">
		<p style="margin-bottom: 0;" class="postbox__title"><?= $post->posts->post_title ?></p>
		By <a style="text-decoration: none; color: #FFFFFF;" href="<?= $this->url->get('profile/') ?><?= $post->posts->users->username ?>"><img style="width: 1.5rem; height: 1.5rem;" class="postbox__avatar" src="<?= $this->url->get('img/avatars/') ?><?= $post->posts->users->avatar ?>"> <?= $post->posts->users->first_name ?> <?= $post->posts->users->last_name ?></a>

		<p class="postbox__description">"<?= 
                strip_tags(
                    trim(
                        preg_replace("/\s+/", " ", substr($post->posts->post_body, 0, 350))
                    )
                ) ?>..."</p>
		<div class="postbox__readmore">
			<a href="<?= $this->url->get('posts/') ?><?= $post->posts->post_id ?>">
				<i style="margin-right: .5rem;" class="fa fa-arrow-right" aria-hidden="true"></i> Read More
			</a>
		</div>
	</div>
	<?php } ?>

	<?php if ($this->length($getTrendingPosts) == 0) { ?>
	<h1 class="index__empty">There's nothing trending yet, check back later!</h1>
	<?php } ?>
</div>


<!--

	NEW ARTICLES

-->

<div class="col-xs-12 col-md-4 col-lg-4">
	<h1 class="index__title">New Articools</h1>

	<?php foreach ($getPosts as $post) { ?>
	<div class="postbox">
		<p style="margin-bottom: 0;" class="postbox__title"><?= $post->post_title ?></p>
		By <a style="text-decoration: none; color: #FFFFFF;" href="<?= $this->url->get('profile/') ?><?= $post->users->username ?>"><img style="width: 1.5rem; height: 1.5rem;" class="postbox__avatar" src="<?= $this->url->get('img/avatars/') ?><?= $post->users->avatar ?>"> <?= $post->users->first_name ?> <?= $post->users->last_name ?></a>

		<p class="postbox__description">"<?= 
                strip_tags(
                    trim(
                        preg_replace("/\s+/", " ", substr($post->post_body, 0, 350))
                    )
                ) ?>..."</p>
		<div class="postbox__readmore">
			<a href="<?= $this->url->get('posts/') ?><?= $post->post_id ?>">
				<i style="margin-right: .5rem;" class="fa fa-arrow-right" aria-hidden="true"></i> Read More
			</a>
		</div>
	</div>
	<?php } ?>

	<?php if ($this->length($getPosts) == 0) { ?>
	<h1 class="index__empty">There are no articools published yet, check back later!</h1>
	<?php } ?>
</div>


<!--

	APPROVED AUTHORS

-->

<div class="col-xs-12 col-md-4 col-lg-4">
	<h1 class="index__title">Approved Authors</h1>

	<?php foreach ($getApprovedAuthors as $user) { ?>
		<a href="<?= $this->url->get('profile/') ?><?= $user->username ?>">
			<div class="index__user__box">
				<h1 class="index__user__box__name"><?= $user->first_name ?> <?= $user->last_name ?></h1>
				<h1 class="index__user__box__description">"<?= $user->description ?>"</h1>
				<?php if ($user->rank_id >= 2) { ?>
					<div class="rank <?php if ($user->rank_id == 2) { ?>approved<?php } elseif ($user->rank_id == 3) { ?>moderator<?php } elseif ($user->rank_id == 4) { ?>administrator<?php } ?>"></div>
				<?php } ?>
				<!--<hr>
				<h1 class="index__user__box__description__small">Written <strong>26</strong> articles - Followed by <strong>245</strong> people--></h1>
			</div>
		</a>
	<?php } ?>

	<?php if ($this->length($getApprovedAuthors) == 0) { ?>
		<h1 class="index__empty">There are no approved authors.</h1>
	<?php } ?>

</div>

            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>