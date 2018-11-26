<html>
<head>
	<meta charset="UTF-8">
	<title>Film-Datenbank | Alle Filme auf einen Blick</title>
	<link type="text/css" rel = "stylesheet" href= "style.css">
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="script.js" type="text/javascript"></script>
</head>
<body>
	<header>
		<h1>
			Film-Datenbank
		</h1>
		
		{$__login}
		
		{$__warning}

	</header>
	<div class="contentDiv">
		<button class="obsolete " id="btn-loadFilmList">Details ausblenden</button>
		<button class="obsolete " id="btn-reloadFilmList">Details erneutladen</button>
		<div class="contentDivDetail" id="contentDivDetail">
		</div>
		<div class="contentDivTable">
		
			{$__content}
		
		</div>
	</div>
	<footer>
	</footer>
</body>
</html>