{% extends "templates/base.volt" %}

{% block title %} Articool {% endblock %}
{% block body_id %}index{% endblock %}
{% block containerclass %}fluid-{% endblock %}

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
<div class="col-xs-12 col-md-12 col-lg-12">
	<div class="index__logo__center">
		<img class="index__logo" src="{{ appUrl }}img/logo/logo-big.png" />
	</div>
</div>

<!--

	TRENDING ARTICLES

-->

<div class="col-xs-12 col-md-12 col-lg-4">
	<h1 class="index__title">Trending Articools</h1>

	{% for post in getTrendingPosts %}
	<div class="postbox">
		<a href="{{ appUrl }}@{{ post.posts.users.username }}/{{ post.posts.post_id }}/{{ createTitleSlug(post.posts.post_title) }}"><p style="margin-bottom: 0;" class="postbox__title">{{ post.posts.post_title }}</p></a>
		By <a style="text-decoration: none; color: #FFFFFF;" href="{{ url('profile/') }}{{ post.posts.users.username }}"><img style="width: 1.5rem; height: 1.5rem;" class="postbox__avatar" src="{{ url('img/avatars/') }}{{ post.posts.users.avatar }}"> {{ post.posts.users.first_name }} {{ post.posts.users.last_name }}</a>

		<p class="postbox__description">"{{ short_body(post.posts.post_body) }}..."</p>
		<div class="postbox__readmore">
			<a href="{{ appUrl }}@{{ post.posts.users.username }}/{{ post.posts.post_id }}/{{ createTitleSlug(post.posts.post_title) }}">
				<i style="margin-right: .5rem;" class="fa fa-arrow-right" aria-hidden="true"></i> Read More
			</a>
		</div>
	</div>
	{% endfor %}

	{% if getTrendingPosts|length is 0 %}
	<h1 class="index__empty">There's nothing trending yet, check back later!</h1>
	{% endif %}
</div>


<!--

	NEW ARTICLES

-->

<div class="col-xs-12 col-md-12 col-lg-4">
	<h1 class="index__title">New Articools</h1>

	{% for post in getPosts %}
	<div class="postbox">
		<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}"><p style="margin-bottom: 0;" class="postbox__title">{{ post.post_title }}</p></a>
		By <a style="text-decoration: none; color: #FFFFFF;" href="{{ url('profile/') }}{{ post.users.username }}"><img style="width: 1.5rem; height: 1.5rem;" class="postbox__avatar" src="{{ url('img/avatars/') }}{{ post.users.avatar }}"> {{ post.users.first_name }} {{ post.users.last_name }}</a>

		<p class="postbox__description">«{{ short_body(post.post_body)|left_trim }}...»</p>
		<div class="postbox__readmore">
			<a href="{{ appUrl }}@{{ post.users.username }}/{{ post.post_id }}/{{ createTitleSlug(post.post_title) }}">
				<i style="margin-right: .5rem;" class="fa fa-arrow-right" aria-hidden="true"></i> Read More
			</a>
		</div>
	</div>
	{% endfor %}

	{% if getPosts|length is 0 %}
	<h1 class="index__empty">There are no articools published yet, check back later!</h1>
	{% endif %}
</div>


<!--

	APPROVED AUTHORS

-->

<div class="col-xs-12 col-md-12 col-lg-4">
	<h1 class="index__title">Approved Authors</h1>

	{% for user in getApprovedAuthors %}
		<a href="{{ url('profile/') }}{{ user.username }}">
			<div class="index__user__box">
				<h1 class="index__user__box__name">{{ user.first_name }} {{ user.last_name }}</h1>
				<h1 class="index__user__box__description">«{{ user.description }}»</h1>
				{% if user.rank_id >= 2 %}
					<div class="rank {% if user.rank_id == 2 %}approved{% elseif user.rank_id == 3 %}moderator{% elseif user.rank_id == 4 %}administrator{% endif %}"></div>
				{% endif %}
				<!--<hr>
				<h1 class="index__user__box__description__small">Written <strong>26</strong> articles - Followed by <strong>245</strong> people--></h1>
			</div>
		</a>
	{% endfor %}

	{% if getApprovedAuthors|length is 0 %}
		<h1 class="index__empty">There are no approved authors.</h1>
	{% endif %}

</div>
{% endblock %}