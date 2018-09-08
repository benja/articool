{% extends "templates/base.volt" %}

{% block title %}
		
	{% for post in getArticoolData %}
		{% if post.post_active is 1 %}
		«{{ post.post_title }}» by {{ getPostContributors }}
		{% else %}
			This articool has been deleted
		{% endif %}
	{% endfor %}
	
{% endblock %}

{% block meta %}
	<meta name="description" content="{{ short_body(post.post_body) }}">
	<meta name="keywords" content="articool, article, post, {{ post.users.first_name }} {{ post.users.last_name }}">
	<meta name="author" content="{{ post.users.first_name }} {{ post.users.last_name }}">

	<!-- Twitter Tags -->
	<meta name="twitter:title" content="{{ post.post_title }}" />
	<meta name="twitter:site" content="{{ appUrl }}posts/{{ post.post_id }}/" />
	<meta name="twitter:image" content="{{ appUrl }}img/logo/facebook-logo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="{{ short_body(post.post_body) }}" />

	<!-- Facebook Tags -->
	<meta property="og:url" content="{{ appUrl }}posts/{{ post.post_id }}/" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ post.post_title }}" />
	<meta property="og:description" content="{{ short_body(post.post_body) }}" />
	<meta property="og:image" content="{{ appUrl }}img/logo/facebook-logo.png" />
	<meta property="fb:app_id"	content="181778325703258" />
{% endblock %}

{% block body_id %} post {% endblock %}

{% block content %}
	<div class="col-xs-12 col-md-12 col-lg-12">

		<div class="post__header">
			<div class="post__header__back">
					<a href="javascript:history.go(-1)">
						<i style="margin-right: .5rem;" class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
					</a>
				</div>
	
			{% if user.username is defined and post.post_active != 0 %}
				<div class="post__header__edit">

				<!-- Show moderator menu to staff -->
				{% if user.rank_id >= 3 %}

					<form id="trendArticool" method="POST" action="{{ url('api/v1/post/trend-articool') }}" style="display: inline; padding-right: 1rem;">
						<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}" />
						
						<input type="hidden" id="session_identifier" value="{{ tokens.session_identifier }}" />
						<input type="hidden" id="session_token" value="{{ tokens.session_token }}" />

						<button id="articool_trend" type="submit" class="post__header__edit__trending">
							{% if isTrending is 0 %}
							<i id="trendingStatus" class="fa fa-star-o" aria-hidden="true"></i> Trending
							{% else %}
							<i id="trendingStatus" class="fa fa-star" aria-hidden="true"></i> Trending
							{% endif %}
						</button>
					</form>

					<a style="display: inline;" href="{{ url('posts/') }}{{ post.post_id }}/edit">
						<i style="padding-right: .3rem;" class="fa fa-pencil" aria-hidden="true"></i> Edit Articool
					</a>
				
				{% elseif post.users.username == user.username %}
					<!-- Always show edit articool option to author -->
					<a style="display: inline;" href="{{ url('posts/') }}{{ post.post_id }}/edit">
						<i style="padding-right: .3rem;" class="fa fa-pencil" aria-hidden="true"></i> Edit Articool
					</a>
				{% endif %}

				</div>
			{% endif %}
		</div>

		{% if post is defined and post.post_active != 0 %}
			{% for post in getArticoolData %}
				<div class="post__post">
					<p class="post__post__title">{{ post.post_title }}</p>
					<div class="post__post__information">
						<p class="post__post__information__text">
							{{ format_date(post.created_at) }} {% if post.created_at != post.updated_at %} - Updated {{ format_date(post.updated_at) }} {% endif %}
							{% if user.username is defined %}
								{% if post.users.username == user.username or user.rank_id >= 3 %}
									| <i class="fa fa-eye" aria-hidden="true"></i> {{ post.post_views }} {% if post.post_views is 1 %} view {% else %} views {% endif %}
								{% endif %}
							{% endif %}
						</p>
						<p class="post__post__information__text">Approximately a {{ readTime }} minute read</p>
						<p class="post__post__information__text">{{ getArticoolAuthors }}</p>
					</div>
					<div class="post__post__body">{{ post.post_body }}</div>
				</div>
				<div class="post__share">
					<div class="post__share__text">
						<i style="margin-right: .5rem;" class="fa fa-share" aria-hidden="true"></i>Share Articool
					</div>

					<div class="post__share__buttons">
						<div class="post__share facebook">
							<a href="//www.facebook.com/sharer/sharer.php?u={{ appUrl }}posts/{{ post.post_id }}&src=sdkpreparse" target="_blank">
								<i class="fa fa-facebook-official" aria-hidden="true"></i>
							</a>
						</div>

						<div class="post__share twitter">
							<a href="//twitter.com/intent/tweet?text=Take+a+look+at+this+articool!&via=articool_pf&url={{ appUrl }}posts/{{ post.post_id }}" target="_blank">
								<i class="fa fa-twitter-square" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			{% endfor %}
		{% else %}
		<p style="color: #222222">This articool has been deleted.</p>
	{% endif %}
	</div>

    {{ javascript_include("js/auth/trendArticool.js") }}

{% endblock %}