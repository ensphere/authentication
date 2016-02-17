<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Application</title>
		<meta name="description" content="" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		@include('css-loader')
		<link rel="stylesheet" href="/css/packages.all.css">
		@include('js-loader')
		<script src="/js/packages.all.js"></script>
	</head>
	<body class="authentication signedup">
		<div class="ui middle aligned center aligned grid">
			<div class="column">
				<div class="ui message success">
					<p><strong>Thank you for registering.</strong> You account is awaiting approval and you will receive confirmation when your account has been activated.</p>
				</div>
			</div>
		</div>
	</body>
</html>
