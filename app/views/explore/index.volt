{% extends "templates/base.volt" %}

{% block title %} Articool {% endblock %}

{% block meta %}
<meta name="description" content="{{ appDescription }}">
<meta name="keywords" content="{{ appName }}, article">
<meta name="author" content="{{ appName }}">

<!-- Twitter Tags -->
<meta name="twitter:title" content="Articool - article platform!" />
<meta name="twitter:site" content="{{ appUrl }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{ appDescription }}" />

<!-- Facebook Tags -->
<meta property="og:url" content="{{ appUrl }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Articool - article platform!" />
<meta property="og:description" content="{{ appDescription }}" />
<meta property="fb:app_id"	content="181778325703258" />
{% endblock %}

{% block content %}
{{ partial('templates/navbar') }}
<div class="explorepage">
	
	<div class="left">

		<section class="section">
			<h1 class="section__text--title"><i class="fas fa-list-ul" style="margin-right: 1rem;"></i>Jump to category (click)</h1>

			<div class="section__categorylist">
				<a href="#analysis">
					<p class="section__categorylist--entry analysis">Analysis</p>
				</a>

				<a href="#autobiography">
					<p class="section__categorylist--entry autobiography">Autobiography</p>
				</a>

				<a href="#biography">
					<p class="section__categorylist--entry biography">Biography</p>
				</a>

				<a href="#chronicle">
					<p class="section__categorylist--entry chronicle">Chronicle</p>
				</a>

				<a href="#essay">
					<p class="section__categorylist--entry essay">Essay</p>
				</a>

				<a href="#fiction">
					<p class="section__categorylist--entry fiction">Fiction</p>
				</a>

				<a href="#nonfiction">
					<p class="section__categorylist--entry nonfiction">Non-Fiction</p>
				</a>

				<a href="#poetry">
					<p class="section__categorylist--entry poetry">Poetry</p>
				</a>

				<a href="#popularscience">
					<p class="section__categorylist--entry popularscience">Popular Science</p>
				</a>

				<a href="#shortstory">
					<p class="section__categorylist--entry shortstory">Short Story</p>
				</a>
			</div>
		</section>
		
		<section class="section">
			<h1 class="section__text--title"><i class="fas fa-fire" style="margin-right: 1rem;"></i>Trending articools</h1>

			<div class="articoolboxes">
				{% if getTrendingPosts|length is 0 %}
				<p class="section__text--error">There's no articools trending right now, please check back later!</p>
				{% endif %}

				{% for post in getTrendingPosts %}
					{% if post.posts.is_draft is 0 %}
					<a href="{{ appUrl }}@{{ post.posts.users.username }}/{{ post.posts.post_id }}/{{ createTitleSlug(post.posts.post_title) }}">
						<div {% if post.posts.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.posts.post_background }});"{% endif %} class="articoolboxes__box">
													
							<div class='articoolboxes__box--overlay {% if post.posts.post_genre == "Analysis" %}analysis{% elseif post.posts.post_genre == "Autobiography" %}autobiography{% elseif post.posts.post_genre == "Biography" %}biography{% elseif post.posts.post_genre == "Chronicle" %}chronicle{% elseif post.posts.post_genre == "Essay" %}essay{% elseif post.posts.post_genre == "Fiction" %}fiction{% elseif post.posts.post_genre == "Non-Fiction" %}nonfiction{% elseif post.posts.post_genre == "Poetry" %}poetry{% elseif post.posts.post_genre == "Popular-Science" %}popularscience{% elseif post.posts.post_genre == "Short-Story" %}shortstory{% endif %}'>
								<div class="articoolboxes__content">
									<!-- meta -->
									<h2 class="articoolboxes__content--title">{{ post.posts.post_title }}</h2>
									<p class="articoolboxes__content--description">"{{ short_body(post.posts.post_body) }}..."</p>
									<p class="articoolboxes__content--genre">{{ post.posts.post_language }} {{ post.posts.post_genre }}</p>
									<p class="articoolboxes__content--authors">by {{ post.posts.users.first_name }} {{ post.posts.users.last_name }}</p>

									<!-- stats -->
									<p class="articoolboxes__content--views"><i class="far fa-eye" style="margin-right: .5rem;"></i>{{ niceNumber(post.posts.post_views) }}</p>
								</div>
							</div>
						</div>
					</a>
					{% endif %}
				{% endfor %}
			</div>

		</section>


		{% if getAnalysisPosts|length > 0 %}
		<section id="analysis" class="section">
			<h1 class="section__text--title">Analysis articools</h1>

			<div class="articoolboxes">
				{% for post in getAnalysisPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getAutobiographyPosts|length > 0 %}
		<section id="autobiography" class="section">
			<h1 class="section__text--title">Autobiography articools</h1>

			<div class="articoolboxes">
			{% for post in getAutobiographyPosts %}
			<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
				<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
											
					<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
						<div class="articoolboxes__content">
							<!-- meta -->
							<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
							<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getBiographyPosts|length > 0 %}
		<section id="biography" class="section">
			<h1 class="section__text--title">Biography articools</h1>

			<div class="articoolboxes">
				{% for post in getBiographyPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getChroniclePosts|length > 0 %}
		<section id="chronicle" class="section">
			<h1 class="section__text--title">Chronicle articools</h1>

			<div class="articoolboxes">
				{% for post in getChroniclePosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getEssayPosts|length > 0 %}
		<section id="essay" class="section">
			<h1 class="section__text--title">Essay articools</h1>

			<div class="articoolboxes">
				{% for post in getEssayPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getFictionPosts|length > 0 %}
		<section id="fiction" class="section">
			<h1 class="section__text--title">Fiction articools</h1>

			<div class="articoolboxes">
				{% for post in getFictionPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getNonFictionPosts|length > 0 %}
		<section id="nonfiction" class="section">
			<h1 class="section__text--title">Non-Fiction articools</h1>

			<div class="articoolboxes">
				{% for post in getNonFictionPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getPoetryPosts|length > 0 %}
		<section id="poetry" class="section">
			<h1 class="section__text--title">Poetry articools</h1>

			<div class="articoolboxes">
				{% for post in getPoetryPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getPopularSciencePosts|length > 0 %}
		<section id="popularscience" class="section">
			<h1 class="section__text--title">Popular Science articools</h1>

			<div class="articoolboxes">
				{% for post in getPopularSciencePosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

		{% if getShortStoryPosts|length > 0 %}
		<section id="shortstory" class="section">
			<h1 class="section__text--title">Short Story articools</h1>

			<div class="articoolboxes">
				{% for post in getShortStoryPosts %}
				<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
					<div {% if post.post_background is not null %}style="background-image: url({{ url('img/backgrounds/') }}{{ post.post_background }});"{% endif %} class="articoolboxes__box">
												
						<div class='articoolboxes__box--overlay {% if post.post_genre == "Analysis" %}analysis{% elseif post.post_genre == "Autobiography" %}autobiography{% elseif post.post_genre == "Biography" %}biography{% elseif post.post_genre == "Chronicle" %}chronicle{% elseif post.post_genre == "Essay" %}essay{% elseif post.post_genre == "Fiction" %}fiction{% elseif post.post_genre == "Non-Fiction" %}nonfiction{% elseif post.post_genre == "Poetry" %}poetry{% elseif post.post_genre == "Popular-Science" %}popularscience{% elseif post.post_genre == "Short-Story" %}shortstory{% endif %}'>
							<div class="articoolboxes__content">
								<!-- meta -->
								<h2 class="articoolboxes__content--title">{{ post.post_title }}</h2>
								<p class="articoolboxes__content--description">"{{ short_body(post.post_body) }}..."</p>
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
		</section>
		{% endif %}

	</div>

	<div class="right">
		<section class="section">
			<h1 class="section__text--title nomargin">Authors on the rise</h1>
	
			{% if getApprovedAuthors|length is 0 %}
			<p style="margin: 0;" class="section__text--error">There are no approved authors.</p>
			{% endif %}
	
			{% for user in getApprovedAuthors %}
	
			<a href="{{ url('author/') }}{{ user.username }}">
				<div class="author">
					<div class="author__image" style="background-image: url({{ url('img/avatars/') }}{{ user.avatar }})"></div>
					<div class="author__info">
						<div class="author__info--text">
							<h1 class="author__info--name">{{ user.first_name }} {{ user.last_name }}</h1>
							<h4 class="author__info--username">(@{{ user.username }})</h4>
							{% if user.rank_id >= 2 %}
							<div class="role {% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}">{% if user.rank_id == 2 %}verified{% elseif user.rank_id == 3 %}mod{% elseif user.rank_id == 4 %}admin{% endif %}</div>
							{% endif %}
						</div>
					</div>
				</div>
			</a>
	
			{% endfor %}
	
		</section>
	</div>

</div>
{% endblock %}