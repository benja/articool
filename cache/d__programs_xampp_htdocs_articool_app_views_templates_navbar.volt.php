<?php if (isset($user)) { ?>
<div id="navbar" class="navbar hidden">
    <div class="navbar__elements">

        <a href="<?= $this->url->get('explore') ?>">
            <div class="navbar__elements__element">
                <li>Explore</li>
            </div>
        </a>

        <a href="<?= $this->url->get('settings/profile') ?>">
            <div class="navbar__elements__element">
                <li>Settings</li>
            </div>
        </a>

        <form id="authLogout" method="POST" action="<?= $this->url->get('api/v1/auth/logout') ?>">
            <a href="<?= $this->url->get('api/v1/auth/logout') ?>">
                <input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
                <input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />
                
                <input id="logout_submit" class="navbar__elements__element" type="submit" value="Logout">
            </a>
        </form>

        <a href="<?= $this->url->get('profile/') ?><?= $user->username ?>">
            <div class="navbar__elements__element">
                <li><img class="navbar__elements__image" src="<?= $this->url->get('img/avatars/') ?><?= $user->avatar ?>" alt="<?= $user->first_name ?> <?= $user->last_name ?>" /><?= $user->first_name ?> <?= $user->last_name ?></li>
            </div>
        </a>

    </div>
</div>
<?= $this->tag->javascriptInclude('js/auth/authLogout.js') ?>

<?php } else { ?>

<div id="navbar" class="navbar hidden">
    <div class="navbar__elements">

        <a href="<?= $this->url->get('') ?>">
            <div class="navbar__elements__element">
                <li>Home</li>
            </div>
        </a>

        <a href="<?= $this->url->get('explore') ?>">
            <div class="navbar__elements__element">
                <li>Explore</li>
            </div>
        </a>

        <a href="<?= $this->url->get('login') ?>">
            <div class="navbar__elements__element">
                <li>Login</li>
            </div>
        </a>

        <a href="<?= $this->url->get('register') ?>">
            <div class="navbar__elements__element">
                <li>Register</li>
            </div>
        </a>

    </div>
</div>
<?php } ?>