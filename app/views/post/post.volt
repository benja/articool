{% extends "templates/base.volt" %}

{% block title %}
		
	{% for post in getArticoolData %}
		{% if post.post_active is 1 %}
		«{{ post.post_title }}» by {{ printAuthorsText }}
		{% else %}
			This articool has been deleted
		{% endif %}
	{% endfor %}
	
{% endblock %}

{% block meta %}
	<meta name="description" content="{{ short_body(post.post_body)|left_trim }}">
	<meta name="keywords" content="{{ appName }}, article, post, {{ post.users.first_name }} {{ post.users.last_name }}">
	<meta name="author" content="{{ post.users.first_name }} {{ post.users.last_name }}">

	<!-- Twitter Tags -->
	<meta name="twitter:title" content="{{ post.post_title }}" />
	<meta name="twitter:site" content="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}" />
	<meta name="twitter:image" content="{{ appUrl }}img/logo/facebook-logo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="{{ short_body(post.post_body)|left_trim }}" />

	<!-- Facebook Tags -->
	<meta property="og:url" content="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}/" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ post.post_title }}" />
	<meta property="og:description" content="{{ short_body(post.post_body)|left_trim }}" />
	<meta property="og:image" content="{{ appUrl }}img/logo/facebook-logo.png" />
	<meta property="fb:app_id"	content="181778325703258" />
{% endblock %}

{% block content %}
{{ partial('templates/navbar') }}

{% if user.username is defined %}
{% if post.users.username == user.username or user.rank_id >= 3 %}
{% if post.is_draft is 0 %}
<div id="modal" class="postmodal">
    <div id="modalbackground" class="postmodal__background"></div>
    <div id="modalcontent" class="postmodal__content">
        <div class="postmodal__info">
            <div class="postmodal__title">Edit Articool</div>
            <div id="modalfullscreen" class="postmodal__close" style="margin-right: 1rem;"><i class="fas fa-arrows-alt"></i></div>
            <div id="modalclose" class="postmodal__close"><i style="color: #ff7474;" class="fas fa-times"></i></div>
        </div>
		<form id="editArticool" method="POST" action="{{ url('api/v1/post/edit-articool') }}" enctype="multipart/form-data">
			<input type="hidden" name="post_id" value="{{ post.post_id }}">
            <div class="input__div">

				<div class="input__box">
					<div id="alert_div" class="feedback">
						<h1 id="alert_title" class="feedback--title">TITLE</h1>
						<div id="feedback_message" class="feedback__messages">message</div>
					</div>
				</div>

                <div class="three">

                    <div class="input__box">
                        <h1 class="input__box--title">Title</h1>
                        <input class="input__box--field" type="text" id="post_title" name="post_title" maxlength="255" autocomplete="off" placeholder="Title your articool" value="{{ post.post_title }}" required>
                    </div>

                    <div class="input__box">
                        <h1 class="input__box--title">Language</h1>
                        <select class="input__box--field" id="post_language" name="post_language" required>
							{% if post.post_language is not null %}
							<option value="{{ post.post_language }}" hidden selected>{{ post.post_language }}</option>
							{% else %}
							<option value="" disabled selected>Language</option>
							{% endif %}
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
                    </div>

                    <div class="input__box">
                        <h1 class="input__box--title">Genre</h1>
                        <select class="input__box--field" id="post_genre" name="post_genre" required>
							{% if post.post_language is not null %}
							<option value="{{ post.post_genre }}" hidden selected>{{ post.post_genre }}</option>
							{% else %}
							<option value="" disabled selected>Genre</option>
							{% endif %}
                            <optgroup label="Literature">
                                <option value="Analysis">Analysis</option>
                                <option value="Autobiography">Autobiography</option>
                                <option value="Biography">Biography</option>
                                <option value="Chronicle">Chronicle</option>
                                <option value="Essay">Essay</option>
                                <option value="Fiction">Fiction</option>
                                <option value="Non-Fiction">Non-Fiction</option>
                                <option value="Poetry">Poetry</option>
                                <option value="Popular-Science">Popular Science</option>
                                <option value="Short-Story">Short Story</option>
                            </optgroup>
                        </select>
                    </div>

                </div>

                <div class="input__box">
                    <h1 class="input__box--title">Write away</h1>
                    <div class="input__box--field" name="post_body" id="post_body">{{ post.post_body }}</div><br>
                </div>

                <div class="input__box">
                    <div class="inline">
                        <h1 class="input__box--title">Contributors</h1>

                        <!-- Help button -->
                        <div class="input__box--helpcircle">?
                            <div class="input__box--helpbox">
                                <span>You can add contributors to your article by writing their name in the box below, keep in mind that they will need an Articool account. Leave blank if nobody else contributed to the Articool. By selecting the Articool language, and genre, your Articool will appear under the specified categories, and will do better engagement-wise.</span>
                            </div>
                        </div>
                        <!-- Help button -->
                    </div>

                    <select multiple id="post_authors" name="post_authors[]" data-placeholder="Add contributors" class="chosen-select">

						{% for author in getRegisteredUsers %}
							{% if post.user_id != author.user_id %}
								<option value="{{ author.user_id }}">{{ author.first_name }} {{ author.last_name }} ({{ author.username }})</option>
							{% endif %}
						{% endfor %}

						{% for authors in printAuthorsId %}
							{% if user.username != authors.username %}
								<option selected value="{{ authors.users.user_id }}">{{ authors.users.first_name }} {{ authors.users.last_name }} ({{ authors.users.username }})</option>
							{% endif %}
						{% endfor %}

                    </select>
                </div>

                <div class="input__box">
                    <h1 class="input__box--title">Upload background image (optional)</h1>
                    <input type="file" id="post_background" value="Click to upload"> <!-- Hidden -->

                    <div class="inline">
                        <label id="post_backgroundlabel" class="input__box--filebutton" for="post_background">Click to upload</label>
                        <p>or</p>
                        <input class="input__box--field" id="post_backgroundlink" type="text" placeholder="Link to an image">
                    </div>
				</div>
				
                <input type="hidden" id="user_username" value="{{ post.users.username }}" />
                <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
                <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

                <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

                <div class="input__box end">
					<input class="button danger" type="submit" id="articool_delete" name="submit" value="Delete">
                    <input class="button success" id="articool_submit" type="submit" name="submit" value="Update">
                </div>

            </div>
		</form>
    </div>
</div>
{% else %}
<div id="modal" class="postmodal">
		<div id="modalbackground" class="postmodal__background"></div>
		<div id="modalcontent" class="postmodal__content">
			<div class="postmodal__info">
				<div class="postmodal__title">Edit Articool</div>
				<div id="modalfullscreen" class="postmodal__close" style="margin-right: 1rem;"><i class="fas fa-arrows-alt"></i></div>
				<div id="modalclose" class="postmodal__close"><i style="color: #ff7474;" class="fas fa-times"></i></div>
			</div>
			<form id="editArticool" method="POST" action="{{ url('api/v1/post/edit-articool') }}" enctype="multipart/form-data">
				<input type="hidden" name="post_id" value="{{ post.post_id }}">
				<div class="input__div">
	
					<div class="input__box">
						<div id="alert_div" class="feedback">
							<h1 id="alert_title" class="feedback--title">TITLE</h1>
							<div id="feedback_message" class="feedback__messages">message</div>
						</div>
					</div>
	
					<div class="three">
	
						<div class="input__box">
							<h1 class="input__box--title">Title</h1>
							<input class="input__box--field" type="text" id="post_title" name="post_title" maxlength="255" autocomplete="off" placeholder="Title your articool" value="{{ post.post_title }}" required>
						</div>
	
						<div class="input__box">
							<h1 class="input__box--title">Language</h1>
							<select class="input__box--field" id="post_language" name="post_language" required>
								{% if post.post_language is not null %}
								<option value="{{ post.post_language }}" hidden selected>{{ post.post_language }}</option>
								{% else %}
								<option value="" disabled selected>Language</option>
								{% endif %}
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
						</div>
	
						<div class="input__box">
							<h1 class="input__box--title">Genre</h1>
							<select class="input__box--field" id="post_genre" name="post_genre" required>
								{% if post.post_language is not null %}
								<option value="{{ post.post_genre }}" hidden selected>{{ post.post_genre }}</option>
								{% else %}
								<option value="" disabled selected>Genre</option>
								{% endif %}
								<optgroup label="Literature">
									<option value="Analysis">Analysis</option>
									<option value="Autobiography">Autobiography</option>
									<option value="Biography">Biography</option>
									<option value="Chronicle">Chronicle</option>
									<option value="Essay">Essay</option>
									<option value="Fiction">Fiction</option>
									<option value="Non-Fiction">Non-Fiction</option>
									<option value="Poetry">Poetry</option>
									<option value="Popular-Science">Popular Science</option>
									<option value="Short-Story">Short Story</option>
								</optgroup>
							</select>
						</div>
	
					</div>
	
					<div class="input__box">
						<h1 class="input__box--title">Write away</h1>
						<div class="input__box--field" name="post_body" id="post_body">{{ post.post_body }}</div><br>
					</div>
	
					<div class="input__box">
						<div class="inline">
							<h1 class="input__box--title">Contributors</h1>
	
							<!-- Help button -->
							<div class="input__box--helpcircle">?
								<div class="input__box--helpbox">
									<span>You can add contributors to your article by writing their name in the box below, keep in mind that they will need an Articool account. Leave blank if nobody else contributed to the Articool. By selecting the Articool language, and genre, your Articool will appear under the specified categories, and will do better engagement-wise.</span>
								</div>
							</div>
							<!-- Help button -->
						</div>
	
						<select multiple id="post_authors" name="post_authors[]" data-placeholder="Add contributors" class="chosen-select">
	
							{% for author in getRegisteredUsers %}
								{% if post.user_id != author.user_id %}
									<option value="{{ author.user_id }}">{{ author.first_name }} {{ author.last_name }} ({{ author.username }})</option>
								{% endif %}
							{% endfor %}
	
							{% for authors in printAuthorsId %}
								{% if user.username != authors.username %}
									<option selected value="{{ authors.users.user_id }}">{{ authors.users.first_name }} {{ authors.users.last_name }} ({{ authors.users.username }})</option>
								{% endif %}
							{% endfor %}
	
						</select>
					</div>
	
					<div class="input__box">
						<h1 class="input__box--title">Upload background image (optional)</h1>
						<input type="file" id="post_background" value="Click to upload"> <!-- Hidden -->
	
						<div class="inline">
							<label id="post_backgroundlabel" class="input__box--filebutton" for="post_background">Click to upload</label>
							<p>or</p>
							<input class="input__box--field" id="post_backgroundlink" type="text" placeholder="Link to an image">
						</div>
					</div>
					
					<input type="hidden" id="user_username" value="{{ post.users.username }}" />
					<input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
					<input type="hidden" id="session_token" value="{{ tokens.session_token }}" />
	
					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />
	
					<div class="input__box end">
						<input class="button danger" type="submit" id="articool_delete" name="submit" value="Delete">
						<input class="button normal" type="submit" id="articool_update" name="submit" value="Save Changes">
						<input class="button success" id="articool_submit" type="submit" name="submit" value="Publish">
					</div>
	
				</div>
			</form>
		</div>
	</div>
{% endif %}
{% endif %}
{% endif %}


<div class="postpage">

	<div class="postpage__menu">
		<div class="postpage__menu--left">
			<a href="javascript:history.go(-1)">
				<i class="fas fa-arrow-left"></i>
				<p>Go Back</p>
			</a>
		</div>

		{% if user.username is defined and post.post_active != 0 %}
		{% if user.rank_id >= 3 %}
		<div class="postpage__menu--right">
			<a style="margin-right: 1rem;">
				<form id="trendArticool" method="POST" action="{{ url('api/v1/post/trend-articool') }}">
					<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

					<input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
					<input type="hidden" id="session_token" value="{{ tokens.session_token }}" />    
				
					{% if isTrending is 0 %}
					<i id="trendingStatus" class="far fa-star"></i>
					{% else %}
					<i id="trendingStatus" class="fas fa-star"></i>
					{% endif %}
					<input id="articool_trend" type="submit" value="Trend">
				</form>
			</a>
			<a id="modalbutton">
				<i class="fas fa-pencil-alt"></i>
				<p>Edit</p>
			</a>
		</div>
		{% elseif post.users.username == user.username %}
		<a id="modalbutton">
			<i class="fas fa-pencil-alt"></i>
			<p>Edit</p>
		</a>
		{% endif %}
		{% endif %}
	</div>

	<div class="postpage__sharediv">
		<div class="postpage__share">
			<div class="postpage__share--list">
				<div class="postpage__share--entry facebook">
					<a href="//www.facebook.com/sharer/sharer.php?u={{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}&src=sdkpreparse" target="_blank">
						<i class="fab fa-facebook"></i>
					</a>
				</div>

				<div class="postpage__share--entry twitter">
					<a href="//twitter.com/intent/tweet?text=Take+a+look+at+this+articool+by+{{ printAuthorsText }}!+«{{ post.post_title }}»&via=articool_pf&url={{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}" target="_blank">
						<i class="fab fa-twitter-square"></i>
					</a>
				</div>

				<div class="postpage__share--entry linkedin">
					<a href="//www.linkedin.com/shareArticle?url={{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}&title=«{{ post.post_title }}»&summary=Take a look at this articool by {{ printAuthorsText }}!" target="_blank">
						<i class="fab fa-linkedin"></i>
					</a>
				</div>

				<div class="postpage__share--entry googleplus">
					<a href="//plus.google.com/share?url={{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}" target="_blank">
						<i class="fab fa-google-plus-square"></i>
					</a>
				</div>

			</div>
			<p>Share</p>
		</div>
		{% if post is defined and post.post_active != 0 %}
		{% for post in getArticoolData %}
		<div class="postpage__post">
			{% if post.is_draft is 1 %}<div class="postpage__post--draft">This draft is only visible to you, unless you publish it from the "edit" menu.</div> {% endif %}
			<h1 id="postpage_title" class="postpage__post--title">{{ post.post_title }} </h1>
			<div class="postpage__post--authors">{{ printAuthorsHtml }}</div>
			<div class="postpage__post--extra">
				<p>~ {{ readTime }} min read, {% if post.is_draft is 0 %}published{% else %}drafted{% endif %} <time class="timeago" datetime="{{post.created_at}}">July 17, 2008</time></p>
				<span class="postpage__post--extratext">{% if post.is_draft is 0 %}Published{% else %}Drafted{% endif %} {{ format_date(post.created_at) }}{% if post.created_at != post.updated_at %} - Updated {{ format_date(post.updated_at) }} {% endif %} ({{ niceNumber(post.post_views) }} {% if post.post_views is 1 %} view{% else %} views{% endif %})</span>
			</div>
			
			<span class='postpage__post--category {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>{{ post.post_language }} {{ post.post_genre }}</span>
			{% if post.post_background is not null %}
			<div id="postpage_" class="postpage__post--backgroundimage" style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"></div>
			{% endif %}

			<div id="postpage_body" class="postpage__post--body">{{ post.post_body }}</div>
		</div>
		{% endfor %}
		{% else %}
		<p class="postpage__nopost">This articool has been deleted.</p>
		{% endif %}
	</div>

</div>

<script>
	/* animate navbar to remove on scroll down */
	var nav = document.getElementById("nav");

	/* scroll direction function */
	window.addEventListener("scroll", function(e) {
		scrolldir = window.scrollY;

		if(scrolldir < 50) {
			nav.classList.remove("slideup");
			nav.classList.add("slidedown");
		} else if(scrolldir > 50) {
			nav.classList.remove("slidedown");
			nav.classList.add("slideup");
		}
	});

	history.replaceState({}, 'title', '{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}' );
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
	font-size: 1.2rem;
	line-height: 2rem;
	white-space: pre-line;
	font-family: 'Open Sans', sans-serif;
	font-weight: 400;
	margin-top: 1rem;
}
.ck-editor__editable blockquote {
	margin: 1rem 0;
	padding: .5rem 0;
	width: fit-content;
	display: inline-flex;
	color: #131313e3;
	font-style: italic;
	border: none;
}

.ck-editor__editable blockquote:before {
	content: '"';
	font-size: 2rem;
	font-style: normal;
	font-weight: bold;
}

.ck-editor__editable em, .ck-editor__editable a, .ck-editor__editable i, .ck-editor__editable u, .ck-editor__editable s, .ck-editor__editable code, .ck-editor__editable ul, .ck-editor__editable li, .ck-editor__editable ol {
	font-family: 'Open Sans', sans-serif;
}

.ck-editor__editable a {
	text-decoration: none;
	color: #1e1e1e;
	border-bottom: .15rem solid #7D7D7D;
	transition: .1s;
}

.ck-editor__editable a:hover {
	border-color: #131313;
	transition: .1s;
}

.ck-editor__editable blockquote p {
	margin-top: 1rem;
}

.ck-editor__editable ul, ol {
	margin-left: 1.3rem;
	font-size: 1.2rem;
	line-height: 2rem;
	white-space: pre-line;
	font-family: 'Open Sans', sans-serif;
	font-weight: 400;
}

.ck-editor__editable li {
	padding-left: .5rem;
}

.ck-editor__editable code {
	font-size: 1.2rem;
	color: #1a1a1a;
	padding: .2rem .5rem;
	border-radius: .2rem;
	background: #e6e6e6;
}

</style>

<script type="text/javascript">
$(".chosen-select").chosen({
	no_results_text: "We can't find the author ",
	width: "100%"
}); 

/* enable timeago when document is ready */
jQuery(document).ready(function() {
  jQuery("time.timeago").timeago();
});

</script>

{{ javascript_include("js/auth/trendArticool.js") }}
{{ javascript_include("js/auth/editArticool.js") }}
{{ javascript_include("js/auth/editDraft.js") }}
{{ javascript_include("js/auth/deleteArticool.js") }}
{{ javascript_include("js/partials/modal.js") }}
{{ javascript_include("js/jquery.timeago.js") }}

{% endblock %}