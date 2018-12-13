$( document ).ready(function() {
	$("div#filmCommentSection").on('click','button#btn-deleteUsercomment', deleteComment);
	$("div#filmCommentSection").on('click','button#btn-editUsercomment', editComment);
	$("div#filmCommentSection").on('click','button#btn-sendNewUsercomment', sendComment);
	$("div#loginForm").on('click','button#btn-login',{action:"login"},loginActions);
	$("div#loginForm").on('click','button#btn-register',{action:"register"},loginActions);
	$("div#loginForm").on('click','button#btn-logout',{action:"logout"},loginActions);
	
	function loginActions(event){
		var datalast = $("tbody.filmlistBody").attr("data-last");
		console.log(datalast);
		var action = event.data.action;
		if (action != "logout"){
			var username = $("input#username").val();
			var password = $("input#password").val();
		}else{
			//var username = null;
			//var password = null;
		}
		
		$.ajax({
			type: "POST",
			url: "index.php",
			data: {
				action: action,
				username: username,
				password: password
			},
			success: function(content) {
				$("div#loginForm").html(content);
			}
		});
		/*
		if (action != "register"){
			reloadComments({value:datalast});
		}/**/
	}
	
	$("button#btn-loadFilmDetails").click(function() {
		var container = $(this).parent().parent();//<tr> der den Button der gedrückt wurde beinhaltet.
		var value = container.attr("data-value"); //die mid des Films, der dem Button zugeordnet ist.
		var oldValue = container.parent().attr("data-last"); //der letzte Film, dessen Details angezeigt wurden.

		if (oldValue != value)
		{
			//ersetze vorherige Details-Seite
			$.ajax({
				type: "POST",
				url: "index.php",
				data: {
					action: "reload",
					method: "loadFilmDetail",
					value: value
				},
				success: function(content) {
					$("#contentDivDetail").html(content);
				}
			});

			reloadComments({value:value});
		}

		//blende aktuelles Listenelement aus und das alte wieder ein
		container.parent().attr("data-last",value);
		if (oldValue == 0){
			container.attr("class","obsolete");
		}else{
			container.siblings(".obsolete").attr("class","filmRow");
			container.attr("class","obsolete");
		}			
    	
		//button offenlegen, der die Details wieder verschwinden lässt.
		$("button#btn-loadFilmList").removeClass("obsolete");
		$("button#btn-reloadFilmList").removeClass("obsolete");
		$("div#contentDivDetail").removeClass("obsolete");
		$("div#filmCommentSection").removeClass("obsolete");
		$("div#contentDivDetail").parent("div.contentDiv").prev().prev("hr").removeClass("obsolete");
		
		window.scrollTo(0,0);
		
		return false;
	});
	
	function reloadComments(event){		
		//ersetze vorherige Kommentar-Section
		$.ajax({
			type: "POST",
			url: "index.php",
			data: {
				action: "reload",
				method: "loadFilmComments",
				value: event.value
			},
			success: function(content) {
				$("#filmCommentSection").html(content);
			}
		});
	}
	
	$("button#btn-reloadFilmList").click(function() {
		//Welcher Film ist gerade geladen?
		var value = $("tbody#filmlistBody").attr("data-last");
		//neu Laden der Inhalte
		$.ajax({
			type: "POST",
			url: "index.php",
			data: {
				action: "reload",
				method: "loadFilmDetail",
				value: value
			},
			success: function(content) {
				$("#contentDivDetail").html(content);
			}
		});

		//ersetze vorherige Kommentar-Section
		$.ajax({
			type: "POST",
			url: "index.php",
			data: {
				action: "reload",
				method: "loadFilmComments",
				value: value
			},
			success: function(content) {
				$("#filmCommentSection").html(content);
			}
		});
		
		return false;
	});

	function deleteComment(){
		if (confirm("Sollen wir den Kommentar wirklich löschen?"))
		{
			var datalast = $("tbody.filmlistBody").attr("data-last");
			//Kommentar Arbeitsfläche
			var myComment = $(this).parent();
			//die zu löschende cid
			var cid = myComment.attr("data-cid");
			//placeholder
			var plaintext = "";
			var mid = null;
			
			//serveranfrage
			$.ajax({
				type: "POST",
				url: "index.php",
				data: {
					action: "comment",
					plaintext: plaintext,
					cid: cid,
					mid: mid,
					del: true
				},
				success: function(content) {
					$("textarea#writeComment").parent().parent().html(content);
					//Alterrierung des abgebildeten Kommentars
					myComment.remove();
				}
			});
			reloadComments({value:datalast});

		}
	}
	
	function editComment(){
		//Kommentar aus derzeitigen Position entfernen und an "workspace" schreiben
		var plaintext = $(this).siblings("div").text();
		var myComment = $(this).parent();
		var cid = myComment.attr("data-cid")
		
		myComment.siblings(".obsolete").removeClass("obsolete");
		myComment.addClass("obsolete");
		
		$("button#btn-sendNewUsercomment").prev().val(plaintext);
		$("button#btn-sendNewUsercomment").prev().attr("data-cid",cid);
		$("button#btn-sendNewUsercomment").text("Änderungen senden");
	}
	
	function sendComment(){
		var datalast = $("tbody.filmlistBody").attr("data-last");
		//entgegennahme
		var plaintext = $("textarea#writeComment").val();
		var cid = $("textarea#writeComment").attr("data-cid");
		var mid = $("tbody#filmlistBody").attr("data-last");
		
		if (plaintext){
			$.ajax({
				type: "POST",
				url: "index.php",
				data: {
					action: "comment",
					plaintext: plaintext,
					cid: cid,
					mid: mid,
					del: false
				},
				success: function(content) {
					$("textarea#writeComment").parent().parent().html(content);
				}
			});
		}
		reloadComments({value:datalast});
		
		return false;
	}
	
	$("button#btn-loadFilmList").click(function() {//details ausblenden
		$("div#contentDivDetail").addClass("obsolete");
		$("div#filmCommentSection").addClass("obsolete");
		$("button#btn-loadFilmList").addClass("obsolete");
		$("button#btn-reloadFilmList").addClass("obsolete");
		$("div#contentDivDetail").parent("div.contentDiv").prev().prev("hr").addClass("obsolete");

		$("tbody#filmlistBody").children(".obsolete").attr("class","filmRow");
	    return false;
	});
});