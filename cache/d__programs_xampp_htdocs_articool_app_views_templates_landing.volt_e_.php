a:7:{i:0;s:130:"<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>";s:5:"title";N;i:1;s:1132:"</title>
        
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

        ";s:4:"meta";N;i:2;s:82:"
    </head>

    <body>
        <!-- Content for website / body -->
        ";s:7:"content";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:10:"
        ";s:4:"file";s:66:"D:\Programs\xampp\htdocs\articool/app/views/templates/landing.volt";s:4:"line";i:27;}}i:3;s:381:"

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js') ?>
        <?= $this->tag->javascriptInclude('js/libraries/smoothscroll.js') ?>
    </body>
</html>";}