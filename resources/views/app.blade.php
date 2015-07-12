<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ isset($document) ? $document->title . " - " : "" }}LaraDoc</title>

	<link href="{{ asset('/css/vendor/laravel.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/css/vendor/selectize.bootstrap3.css') }}"/>

	<link rel="shortcut icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="docs language-php">
	<span class="overlay"></span>

	@include('partials._nav')

	@include('partials._slide-menu')

	{{-- Main side menu on the page --}}
	<div class="docs-wrapper container">
		<section class="sidebar">
			<ul>
				@foreach ($categories as $category)

					<li>
						{{ $category->category_name }}

						@unless ($category->documents->isEmpty())
							<ul>
								@foreach ($category->documents->sortBy('order_index') as $document)
									<li>
										<a href="{{ url( 'documents', str_slug($category->category_name.' '.$document->title) ) }}">{{ $document->title }}</a>
									</li>
								@endforeach
							</ul>
						@endunless
					</li>

				@endforeach
			</ul>
		</section>

		<article>
			<form action="search.php">
				<select name="q" id="searchbox" placeholder="Search&hellip;" class="form-control"></select>
			</form>

			@yield('content')
		</article>
	</div>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
	<script src="{{ asset('/js/vendor/selectize.js') }}"></script>
	<script>
		var root = '{{url("/")}}';
		$(document).ready(function() {
			$('#searchbox').selectize({
				valueField: 'url',
				labelField: 'title',
				searchConjunction: 'or',
				maxOptions: 20,
				options: [],
				create: false,
				render: {
					option: function(item, escape) {
						var html = '<div><h1>' + item.title + '</h1>';
						html += item.content;
						html += '</div>';
						return html;
					}
				},
//				optgroups: [
//					{ value: 'title', label: 'Titles' },
//					{ value: 'content', label: 'Content' }
//				],
//				optgroupField: 'title',
//				optgroupOrder: ['product', 'category'],
				load: function(query, callback) {
					if (!query.length) return callback();
					$.ajax({
						url: root + '/documents/search',
						type: 'GET',
						dataType: 'json',
						data: {
							q: query
						},
						error: function() {
							callback();
						},
						success: function(res) {
							callback(res.data);
						}
					});
				},
				onChange: function() {
					if(this.items.length > 0) {
						window.location = this.items[0];
						this.clear();
					}
				}
			});
		});
	</script>

	<script src="{{ asset('/js/vendor/laravel.js') }}"></script>
	<script src="{{ asset('/js/vendor/viewport-units-buggyfill.js') }}"></script>
</body>
</html>
