{% extends "templates/base.volt" %}

{% block title %} {{ profile.first_name }} {{ profile.last_name }}'s profile  {% endblock %}

{% block content %}
{{ partial('templates/navbar') }}

{% if user.username is defined %}
{% if profile.username == user.username %}
<div id="modal" class="postmodal">
    <div id="modalbackground" class="postmodal__background"></div>
    <div id="modalcontent" class="postmodal__content">
        <div class="postmodal__info">
            <div class="postmodal__title">New Articool</div>
            <div id="modalfullscreen" class="postmodal__close" style="margin-right: 1rem;"><i class="fas fa-arrows-alt"></i></div>
            <div id="modalclose" class="postmodal__close"><i style="color: #ff7474;" class="fas fa-times"></i></div>
        </div>
        <form id="postArticool" method="POST" enctype="multipart/form-data">
            <div class="input__div">

                <div class="three">

                    <div class="input__box">
                        <h1 class="input__box--title">Title</h1>
                        <input class="input__box--field" type="text" id="post_title" name="post_title" maxlength="255" autocomplete="off" placeholder="Title your articool" required>
                    </div>

                    <div class="input__box">
                        <h1 class="input__box--title">Language</h1>
                        <select class="input__box--field" id="post_language" name="post_language" required>
                            <option value="" disabled selected>Select language</option>
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
                            <option value="" disabled selected>Select genre</option>
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
                    <div class="input__box--field" name="post_body" id="post_body"></div><br>
                </div>

                <details>
                    <summary>Additional Info</summary>
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
                            {% if user.username != author.username %}
                                <option value="{{ author.user_id }}">{{ author.first_name }} {{ author.last_name }} ({{ author.username }})</option>
                            {% endif %}
                        {% endfor %}

                        </select>
                    </div>

                    <div class="input__box">
                        <div class="inline">
                            <h1 class="input__box--title">Is this text canonical?</h1>
        
                            <!-- Help button -->
                            <div class="input__box--helpcircle">?
                                <div class="input__box--helpbox">
                                    <span>Is the text you have written, with some fine adjuments, to be found anywhere else on the internet? If so, you must check it as canonical and link to the URL where it is to be found.</span>
                                </div>
                            </div>
                            <!-- Help button -->
                        </div>

                        <input type="checkbox" id="is_canonical" name="is_canonical" value="is_canonical" />
                        <label for="is_canonical" style="font-size: 1.2rem;">Yes</label>
                        <input class="input__box--field" type="text" id="canonical_url" name="canonical_url" placeholder="Link to the post" style="display: none; margin-top: 1rem;">
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
                </details>

                <input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
                <input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

                <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />

                <div class="input__box end">
                    <input class="button normal" id="articool_draft" type="submit" value="Save Draft">
                    <input class="button success" id="articool_submit" type="submit" name="submit" value="Publish">
                </div>

                <div class="input__box">
                    <div id="alert_div" class="feedback">
                        <h1 id="alert_title" class="feedback--title">TITLE</h1>
                        <div id="feedback_message" class="feedback__messages">message</div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
{% endif %}
{% endif %}

{% if profile %}
<div class="profilepage">
    <div class="profilepage__content">

        <div class="profilepage__left {% if profile.background is 2 %}bg1{% elseif profile.background is 3 %}bg2{% endif %}">
            <div class="profile">

                <div class="profile__info">
                    {% if profile.rank_id >= 2 %}
                    <div style="position: relative; top: 10.5rem;" class="role {% if profile.rank_id == 2 %}verified{% elseif profile.rank_id == 3 %}mod{% elseif profile.rank_id == 4 %}admin{% endif %}">{% if profile.rank_id == 2 %}verified{% elseif profile.rank_id == 3 %}mod{% elseif profile.rank_id == 4 %}admin{% endif %}</div>
                    {% endif %}
                    <div class="profile__info--image" style="background-image: url({{ url('img/avatars/') }}{{ profile.avatar }});"></div>
                    <h1 class="profile__info--name">{{ profile.first_name }} {{ profile.last_name }}</h1>
                    {% if profile.email_address is not null %}
                    <img class="profile__info--checkmark" src="{{ url('img/checkmark.svg') }}" alt="Confirmed email-address">
                    {% endif %}
                    <p class="profile__info--username">(@{{ profile.username }})</p>
                    

                    <p class="profile__info--description">«{{ profile.description }}»</p>
                    <!--
                    <form action="">
                        <input class="profile__info--subscribe" type="submit" value="Subscribe to Benjamin">
                    </form>
                    -->
                </div>

                <div class="profile__stats">
                    <div class="profile__stats--entry">
                        <p class="profile__stats--value">{{ getPostCount }}</p>
                        <p class="profile__stats--description">articools written</p>
                    </div>
                    <div class="profile__stats--entry">
                        <p class="profile__stats--value">{{ niceNumber(getPeopleReached) }}</p>
                        <p class="profile__stats--description">people reached</p>
                    </div>
                    <div class="profile__stats--entry">
                        <p class="profile__stats--value">{{ niceNumber(getAppreciationCount) }}</p>
                        <p class="profile__stats--description">appreciations received</p>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="profilepage__right">

            <div class="articools">
                <div class="articools__latest">
                    <h1 class="articools--title">Latest articools</h1>
                    {% if user.username is defined %}
                        {% if profile.username == user.username %}
                            <div id="modalbutton" class="articools--new">+</div>
                        {% endif %}
                    {% endif %}
                    {% if getUserPosts|length is 0 and profile.username != user.username %}
                        <p class="articools--none">{{ profile.first_name }} has not posted any articools.</p>
                    {% endif %}

                    <!-- articool boxes -->
                    <div class="articoolboxes">

                        {% for post in getUserPosts %}
                            {% if post.is_draft is 0 %}
                            <a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
                                <div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
                                                            
                                    <div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
                                        <div class="articoolboxes__content">
                                            <!-- meta -->
                                            <h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
                                            <p class="articoolboxes__content--description">«{{ short_body(post.post_body) }}...»</p>
                                            <p class="articoolboxes__content--genre">{{ post.post_language }} {{ post.post_genre }}</p>
                                            <p class="articoolboxes__content--authors">by {{ post.users.first_name }} {{ post.users.last_name }}</p>

                                            <!-- stats -->
                                            <p class="articoolboxes__content--views"><i class="far fa-eye" style="margin-right: .5rem;"></i>{{ niceNumber(post.post_views) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            {% elseif post.is_draft is 1 and user.username is defined and profile.username == user.username %}
                            <a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
                                <div style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});" class="articoolboxes__box">
                                                            
                                    <div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
                                        <div class="articoolboxes__content">
                                            <!-- meta -->
                                            <h2 class="articoolboxes__content--title">
                                                <div class="articoolboxes__content--draft">draft</div>{{ post.post_title }}
                                            </h2>
                                            <p class="articoolboxes__content--description">«{{ short_body(post.post_body) }}...»</p>
                                            <p class="articoolboxes__content--genre">{{ post.post_language }} {{ post.post_genre }}</p>
                                            <p class="articoolboxes__content--authors">by {{ post.users.first_name }} {{ post.users.last_name }}</p>

                                            <!-- stats -->
                                            <p class="articoolboxes__content--views"><i class="far fa-eye" style="margin-right: .5rem;"></i>{{ niceNumber(post.post_views) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            {% endif %}
                        {% endfor %}
                    </div>
                    <!-- articool boxes -->

                </div>

                <div class="articools__popular">
                    {% if getUserPosts|length >= 1 %}
                    <h1 class="articools--title">Popular articools</h1>

                    <!-- articool boxes -->
                    <div class="articoolboxes">

                        {% for post in getUserPopularPosts %}
                        <a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
                            <div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">       

                                <div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
                                    <div class="articoolboxes__content">
                                        <!-- meta -->
                                        <h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
                                        <p class="articoolboxes__content--description">«{{ short_body(post.post_body) }}...»</p>
                                        <p class="articoolboxes__content--genre">{{ post.post_language }} {{ post.post_genre }}</p>
                                        <p class="articoolboxes__content--authors">by {{ post.users.first_name }} {{ post.users.last_name }}</p>

                                        <!-- stats -->
                                        <p class="articoolboxes__content--views"><i class="far fa-eye" style="margin-right: .5rem;"></i>{{ niceNumber(post.post_views) }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        {% endfor %}

                    </div>
                    <!-- articool boxes -->
                    {% endif %}

                </div>
            </div>

            {{ partial('templates/footer') }}
        </div>

    </div>
</div>
{% endif %}

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
	margin: 2rem 0 1rem 1rem;
	padding-left: 1rem;
	width: fit-content;
	display: inline-flex;
	color: #131313e3;
	border-left: .15rem solid #959595;
	font-style: italic;
}

.ck-editor__editable blockquote p {
	margin: 0;
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

.ck-editor__editable ul, ol {
	margin: 1rem 0 .5rem 3rem;
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
</script>

{{ javascript_include("js/auth/postArticool.js") }}
{{ javascript_include("js/auth/postDraft.js") }}
{{ javascript_include("js/partials/modal.js") }}
{% endblock %}