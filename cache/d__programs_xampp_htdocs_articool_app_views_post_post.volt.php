<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
		
	<?php foreach ($getArticoolData as $post) { ?>
		<?php if ($post->post_active == 1) { ?>
		«<?= $post->post_title ?>» by <?= $printAuthorsText ?>
		<?php } else { ?>
			This articool has been deleted
		<?php } ?>
	<?php } ?>
	
</title>
        
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

        
	<meta name="description" content="<?= ltrim(
                strip_tags(
                    trim(
                        preg_replace("/<p>/", " ", substr($post->post_body, 0, 350))
                    )
                )) ?>">
	<meta name="keywords" content="<?= $appName ?>, article, post, <?= $post->users->first_name ?> <?= $post->users->last_name ?>">
	<meta name="author" content="<?= $post->users->first_name ?> <?= $post->users->last_name ?>">

	<!-- Twitter Tags -->
	<meta name="twitter:title" content="<?= $post->post_title ?>" />
	<meta name="twitter:site" content="<?= $appUrl ?>posts/<?= $post->post_id ?>/" />
	<meta name="twitter:image" content="<?= $appUrl ?>img/logo/facebook-logo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="<?= ltrim(
                strip_tags(
                    trim(
                        preg_replace("/<p>/", " ", substr($post->post_body, 0, 350))
                    )
                )) ?>" />

	<!-- Facebook Tags -->
	<meta property="og:url" content="<?= $appUrl ?>posts/<?= $post->post_id ?>/" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= $post->post_title ?>" />
	<meta property="og:description" content="<?= ltrim(
                strip_tags(
                    trim(
                        preg_replace("/<p>/", " ", substr($post->post_body, 0, 350))
                    )
                )) ?>" />
	<meta property="og:image" content="<?= $appUrl ?>img/logo/facebook-logo.png" />
	<meta property="fb:app_id"	content="181778325703258" />

    </head>

    <body id="body" class=" post ">
    
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
                
	<div class="col-xs-12 col-md-12 col-lg-12">

		<div class="post__header">
			<div class="post__header__back">
					<a href="javascript:history.go(-1)">
						<i style="margin-right: .5rem;" class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
					</a>
				</div>
	
			<?php if (isset($user->username) && $post->post_active != 0) { ?>
				<div class="post__header__edit">

				<!-- Show moderator menu to staff -->
				<?php if ($user->rank_id >= 3) { ?>

					<form id="trendArticool" method="POST" action="<?= $this->url->get('api/v1/post/trend-articool') ?>" style="display: inline; padding-right: 1rem;">
						<input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />
						
						<input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
						<input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />

						<button id="articool_trend" type="submit" class="post__header__edit__trending">
							<?php if ($isTrending == 0) { ?>
							<i id="trendingStatus" class="fa fa-star-o" aria-hidden="true"></i> Trending
							<?php } else { ?>
							<i id="trendingStatus" class="fa fa-star" aria-hidden="true"></i> Trending
							<?php } ?>
						</button>
					</form>

					<a style="display: inline;" href="<?= $this->url->get('posts/') ?><?= $post->post_id ?>/edit">
						<i style="padding-right: .3rem;" class="fa fa-pencil" aria-hidden="true"></i> Edit Articool
					</a>
				
				<?php } elseif ($post->users->username == $user->username) { ?>
					<!-- Always show edit articool option to author -->
					<a style="display: inline;" href="<?= $this->url->get('posts/') ?><?= $post->post_id ?>/edit">
						<i style="padding-right: .3rem;" class="fa fa-pencil" aria-hidden="true"></i> Edit Articool
					</a>
				<?php } ?>

				</div>
			<?php } ?>
		</div>

		<?php if (isset($post) && $post->post_active != 0) { ?>
			<?php foreach ($getArticoolData as $post) { ?>
				<div class="post__post">
					<p class="post__post__title"><?= $post->post_title ?></p>
					<div class="post__post__information">
						<p class="post__post__information__text">
							<?= date('j F Y H:i', strtotime($post->created_at)) ?> <?php if ($post->created_at != $post->updated_at) { ?> - Updated <?= date('j F Y H:i', strtotime($post->updated_at)) ?> <?php } ?>
							<?php if (isset($user->username)) { ?>
								<?php if ($post->users->username == $user->username || $user->rank_id >= 3) { ?>
									| <i class="fa fa-eye" aria-hidden="true"></i> <?= $post->post_views ?> <?php if ($post->post_views == 1) { ?> view <?php } else { ?> views <?php } ?>
								<?php } ?>
							<?php } ?>
						</p>
						<p class="post__post__information__text">Approximately a <?= $readTime ?> minute read</p>
						<p class="post__post__information__text"><?= $printAuthorsHtml ?></p>
					</div>
					<div class="post__post__body"><?= $post->post_body ?></div>
				</div>
				<div class="post__share">
					<div class="post__share__text">
						<i style="margin-right: .5rem;" class="fa fa-share" aria-hidden="true"></i>Share Articool
					</div>

					<div class="post__share__buttons">
						<div class="post__share facebook">
							<a href="//www.facebook.com/sharer/sharer.php?u=<?= $appUrl ?>@<?= $post->users->username ?>/<?= $post->post_id ?>/<?= str_replace(" ", "-", preg_replace("/\s{2,}/", " ", preg_replace("/[^a-z0-9 ]+/", "", trim(strtolower("$post->post_title"))))) ?>&src=sdkpreparse" target="_blank">
								<i class="fa fa-facebook-official" aria-hidden="true"></i>
							</a>
						</div>

						<div class="post__share twitter">
							<a href="//twitter.com/intent/tweet?text=Take+a+look+at+this+articool+by+<?= $printAuthorsText ?>!+«<?= $post->post_title ?>»&via=articool_pf&url=<?= $appUrl ?>@<?= $post->users->username ?>/<?= $post->post_id ?>/<?= str_replace(" ", "-", preg_replace("/\s{2,}/", " ", preg_replace("/[^a-z0-9 ]+/", "", trim(strtolower("$post->post_title"))))) ?>" target="_blank">
								<i class="fa fa-twitter-square" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
		<p style="color: #222222">This articool has been deleted.</p>
	<?php } ?>
	</div>

	<script>
		history.replaceState({}, 'title', '<?= $appUrl ?>@<?= $post->users->username ?>/<?= $post->post_id ?>/<?= str_replace(" ", "-", preg_replace("/\s{2,}/", " ", preg_replace("/[^a-z0-9 ]+/", "", trim(strtolower("$post->post_title"))))) ?>' );
 	</script>

    <?= $this->tag->javascriptInclude('js/auth/trendArticool.js') ?>


            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>