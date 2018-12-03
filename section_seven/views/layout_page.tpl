<html>
<head>
	<meta charset="UTF-8">
	<title>Film-Datenbank | Alle Filme auf einen Blick</title>
	<link type="text/css" rel = "stylesheet" href= "lib/style.css">
	<link type="text/css" rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="script.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
	<div class="row margin-top">
		<div class="col-xl-20 col-md-20 col-sm-30 col-xs-60">
			<h1>
				Film-Datenbank
			</h1>
		</div>
		<div class="col-xl-20 col-md-20 col-sm-0 col-xs-60">
		</div>
		<div class="col-xl-20 col-md-20 col-sm-30 col-xs-60">
			{$__login}
			{$__warning}
		</div>
	</div>
	<hr class="obsolete">
	<div class="row align-items-center margin-top">
		<div class="col-xl-60 col-md-60 col-sm-60 col-xs-60">
			<div class="row contentDivButtons">
				<div class="col-xl-30 col-md-30 col-sm-60 col-xs-60">
					<button class="obsolete " id="btn-loadFilmList">Details ausblenden</button>
				</div>
				<div class="col-xl-30 col-md-30 col-sm-60 col-xs-60">
					<button class="obsolete " id="btn-reloadFilmList">Details erneutladen</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row contentDiv">
		<div class="col-xl-30 col-md-30 col-sm-30 col-xs-60 contentDivDetail obsolete" id="contentDivDetail">
		</div>
		<div class="col-xl-30 col-md-30 col-sm-30 col-xs-60 filmCommentSection" id="filmCommentSection">
		</div>
	</div>
	<hr>
	<div class="contentDivTable">
		{$__content}
	</div>
	<footer>
	</footer>
</div>
</body>
</html>
<!--

--!>