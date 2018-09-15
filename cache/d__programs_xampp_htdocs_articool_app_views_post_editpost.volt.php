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

        <meta name="twitter:image" content="https://articool.blog/img/logo/facebook-logo.png" />
	    <meta property="og:image" content="https://articool.blog/img/logo/facebook-logo.png" />

        <!-- Output CSS & JS from controllerbase -->
        <?= $this->assets->outputCss() ?>
        <?= $this->assets->outputJs() ?>

        
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
	<div id="article__modal" style="display: block;" class="modal">
	    <div class="modal__content">
			<a href="javascript:history.go(-1)">
				<span class="modal__content__close">&times;</span>
			</a>

	        <form id="editArticool" method="POST">

	        	<input type="hidden" name="post_id" value="<?= $post->post_id ?>">

				<h1 class="modal__form__title">Edit Articool</h1>
				<div class="modal__form__divide"></div>
				<h1 class="modal__form__title__small">Change your Articool title, and context all in here.</h1>

				<div class="modal__form__input">
					<input type="text" id="post_title" name="post_title" maxlength="255" autocomplete="off" value="<?= $post->post_title ?>" required/>
					<label for="post_title">Articool Title</label>
				</div>

				<div class="modal__form__input">
					<div name="post_body" id="post_body"><?= $post->post_body ?></div><br>
				</div>

				<h1 class="modal__form__title">Additional Information</h1>
				<div class="modal__form__divide"></div>
				<h1 class="modal__form__title__small">You can add contributors to your article by writing their name in the box below, keep in mind that they will need an Articool account. Leave blank if nobody else contributed to the Articool. By selecting the Articool language, and genre, your Articool will appear under the specified categories, and will do better engagement-wise.</h1>

	            <div class="modal__form__input">
	                <select multiple id="post_authors" name="post_authors[]" data-placeholder="Contributors" class="chosen-select">
					
					<?php foreach ($getRegisteredUsers as $author) { ?>
						<?php if ($post->user_id != $author->user_id) { ?>
							<option value="<?= $author->user_id ?>"><?= $author->first_name ?> <?= $author->last_name ?> (<?= $author->username ?>)</option>
						<?php } ?>
					<?php } ?>

					<?php foreach ($printAuthorsId as $authors) { ?>
						<?php if ($user->username != $authors->username) { ?>
							<option selected value="<?= $authors->users->user_id ?>"><?= $authors->users->first_name ?> <?= $authors->users->last_name ?> (<?= $authors->users->username ?>)</option>
						<?php } ?>
					<?php } ?>

					</select>
	            </div>

				<div class="modal__form__input two">
					<select id="post_language" name="post_language" required>
						<?php if ($post->post_language != null) { ?>
							<option value="<?= $post->post_language ?>" hidden selected><?= $post->post_language ?></option>
						<?php } else { ?>
							<option value="" disabled selected>Language</option>
						<?php } ?>
						<option value="Afrikanns">Afrikanns</option>
						<option value="Albanian">Albanian</option>
						<option value="Arabic">Arabic</option>
						<option value="Armenian">Armenian</option>
						<option value="Basque">Basque</option>
						<option value="Bengali">Bengali</option>
						<option value="Bulgarian">Bulgarian</option>
						<option value="Catalan">Catalan</option>
						<option value="Cambodian">Cambodian</option>
						<option value="Chinese">Chinese</option>
						<option value="Croation">Croation</option>
						<option value="Czech">Czech</option>
						<option value="Danish">Danish</option>
						<option value="Dutch">Dutch</option>
						<option value="English">English</option>
						<option value="Estonian">Estonian</option>
						<option value="Fiji">Fiji</option>
						<option value="Finnish">Finnish</option>
						<option value="French">French</option>
						<option value="Georgian">Georgian</option>
						<option value="German">German</option>
						<option value="Greek">Greek</option>
						<option value="Gujarati">Gujarati</option>
						<option value="Hebrew">Hebrew</option>
						<option value="Hindi">Hindi</option>
						<option value="Hungarian">Hungarian</option>
						<option value="Icelandic">Icelandic</option>
						<option value="Indonesian">Indonesian</option>
						<option value="Irish">Irish</option>
						<option value="Italian">Italian</option>
						<option value="Japanese">Japanese</option>
						<option value="Javanese">Javanese</option>
						<option value="Korean">Korean</option>
						<option value="Latin">Latin</option>
						<option value="Latvian">Latvian</option>
						<option value="Lithuanian">Lithuanian</option>
						<option value="Macedonian">Macedonian</option>
						<option value="Malay">Malay</option>
						<option value="Malayalam">Malayalam</option>
						<option value="Maltese">Maltese</option>
						<option value="Maori">Maori</option>
						<option value="Marathi">Marathi</option>
						<option value="Mongolian">Mongolian</option>
						<option value="Nepali">Nepali</option>
						<option value="Norwegian">Norwegian</option>
						<option value="Persian">Persian</option>
						<option value="Polish">Polish</option>
						<option value="Portuguese">Portuguese</option>
						<option value="Punjabi">Punjabi</option>
						<option value="Quechua">Quechua</option>
						<option value="Romanian">Romanian</option>
						<option value="Russian">Russian</option>
						<option value="Samoan">Samoan</option>
						<option value="Serbian">Serbian</option>
						<option value="Slovak">Slovak</option>
						<option value="Slovenian">Slovenian</option>
						<option value="Spanish">Spanish</option>
						<option value="Swahili">Swahili</option>
						<option value="Swedish">Swedish</option>
						<option value="Tamil">Tamil</option>
						<option value="Tatar">Tatar</option>
						<option value="Telugu">Telugu</option>
						<option value="Thai">Thai</option>
						<option value="Tibetan">Tibetan</option>
						<option value="Tonga">Tonga</option>
						<option value="Turkish">Turkish</option>
						<option value="Ukranian">Ukranian</option>
						<option value="Urdu">Urdu</option>
						<option value="Uzbek">Uzbek</option>
						<option value="Vietnamese">Vietnamese</option>
						<option value="Welsh">Welsh</option>
						<option value="Xhosa">Xhosa</option>
					</select>

					<select style="margin: 0;" id="post_genre" name="post_genre" required>
						<?php if ($post->post_language != null) { ?>
							<option value="<?= $post->post_genre ?>" hidden selected><?= $post->post_genre ?></option>
						<?php } else { ?>
							<option value="" disabled selected>Genre</option>
						<?php } ?>
						<optgroup label="Literature">
							<option value="Analysis">Analysis</option>
							<option value="Autobiography">Autobiography</option>
							<option value="Biography">Biography</option>
							<option value="Essay">Essay</option>
							<option value="Fiction">Fiction</option>
							<option value="Non-Fiction">Non-Fiction</option>
							<option value="Poetry">Poetry</option>
							<option value="Short Story">Short Story</option>
						</optgroup>
					</select>
				</div>

				<input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
				<input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />

	            <input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />
	            <div class="modal__form__input">
	                <input type="submit" id="articool_submit" name="submit" value="Update Articool">
				</div>
				<div id="alert_div" class="alert hidden">
					<span>
						<label id="alert_title" class="alert__title">ERROR</label>
					</span>
					<ul>
						<div id="feedback_message"></div>
					</ul>
				</div>
			</form>

			<form method="POST" id="deleteArticool" action="<?= $this->url->get('api/v1/post/delete-articool/{post_id}') ?>">
				<input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>" />
				<input type="hidden" id="username" value="<?= $user->username ?>" />
				
				<input type="hidden" id="session_identifier" value="<?= $tokens->session_identifier ?>" />
				<input type="hidden" id="session_token" value="<?= $tokens->session_token ?>" />

				<div style="font-style: italic; margin-top: 1rem;">
					If you wish to delete this articool, click <input id="articool_delete" style="background-color: white; border: none; font-size: .97rem; text-decoration: underline; font-style: italic; cursor: pointer;" type="submit" name="submit" value="here ">
				</div>
			</form>

	    </div>
	</div>
</div>

<script>
	history.replaceState({}, 'title', '<?= $appUrl ?>@<?= $post->users->username ?>/<?= $post->post_id ?>/<?= str_replace(" ", "-", preg_replace("/\s{2,}/", " ", preg_replace("/[^a-z0-9 ]+/", "", trim(strtolower("$post->post_title"))))) ?>/edit' );
</script>

<script type="text/javascript">
	
	ClassicEditor
		.create( document.querySelector( '#post_body' ), {
			toolbar: [ 'bold', 'italic', 'underline', 'strikethrough', 'code', 'blockQuote', '|', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo' ]
		} )
		.then( editor => {
			console.log( editor );
			post_body = editor;
			
		} )
		.catch( error => {
			console.error( error );
		} );
</script>

<!-- Styling some of the CKEDITOR -->
<style>

	.ck-editor__editable {
		min-height: 10rem;
	}

	.ck-editor__editable p {
		font-family: 'Open Sans', sans-serif;
		color: #222222;
		margin-top: 1rem;
		width: 100%;
		word-spacing: .05rem;
		line-height: 1.8rem;
	}
	.ck-editor__editable blockquote {
		border-left: 0.5rem solid #222222;
		font-style: italic;
		padding-left: 1rem;
		margin: 1rem 0 1rem 1rem;
	}

	.ck-editor__editable em, a, i, u, s, code, ul, li, ol {
		font-family: 'Open Sans', serif;
		color: #222222;
	}

	.ck-editor__editable p {
		margin-top: 1rem;
		color: #222222;
		width: 100%;
		white-space: pre-line;
		color: #222222;
		word-spacing: .05rem;
		line-height: 1.8rem;
		font-family: 'Open Sans', sans-serif;
	}

	.ck-editor__editable img {
		margin-top: 1rem;
		margin-bottom: 1rem;
		width: 100%;
		border: .5rem solid #222222;
		user-drag: none; 
		user-select: none;
		-moz-user-select: none;
		-webkit-user-drag: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}

	.ck-editor__editable a {
		color: #222222;
		border-bottom: .15rem solid #222222;
		text-decoration: none;
	}

	.ck-editor__editable blockquote {
		background-color: #7373731f;
		width: fit-content;
		padding: .5rem 1rem .5rem 1rem;
		margin: 1rem 0 0 1rem;
		border-left: .25rem solid #222222;
		font-style: italic;
	}

	.ck-editor__editable blockquote p {
		margin-top: 0;
	}

	.ck-editor__editable ul, ol {
		margin: 1rem 0 0 2rem;
	}

	.ck-editor__editable li {
		padding-left: .5rem;
	}

	.ck-editor__editable code {
		background-color: #eeeeee;
		font-family: monospace;
		padding: 0.25rem 0.3rem 0.25rem .3rem;
		color: #222222;
		border-radius: .2rem;
		border: 2px solid #dadada;
	}

</style>

<script type="text/javascript">
$(".chosen-select").chosen({
	no_results_text: "We can't find the author ",
	width: "100%"
}); 
</script>

<?= $this->tag->javascriptInclude('js/auth/editArticool.js') ?>
<?= $this->tag->javascriptInclude('js/auth/deleteArticool.js') ?>


            </div>
        </div>

        <!-- Cooikie warning -->
        <?= $this->partial('templates/partials/cookies') ?>

        <!-- Include Javascript files neccessary for landing to work -->
        <?= $this->tag->javascriptInclude('js/partials/navbar.js') ?>
    </body>
</html>