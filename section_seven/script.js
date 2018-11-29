$( document ).ready(function() {
	$("button#btn-loadFilmDetails").click(function() {
		var container = $(this).parent().parent();//<tr> der den Button der gedrückt wurde beinhaltet.
		var value = container.attr("data-value"); //die mid des Films, der dem Button zugeordnet ist.
		var oldValue = container.parent().attr("data-last"); //der letzte Film, dessen Details angezeigt wurden.

		if (oldValue != value)
		{
			//ersetze vorherige Details-Seite
			$.ajax({
				type: "POST",
				url: "reload.php",
				data: {
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
				url: "reload.php",
				data: {
					method: "loadFilmComments",
					value: value
				},
				success: function(content) {
					$("#filmCommentSection").html(content);
				}
			});
			
			//blende aktuelles Listenelement aus und das alte wieder ein
			container.parent().attr("data-last",value);
			if (oldValue == 0){
				container.attr("class","obsolete");
			}else{
				container.siblings(".obsolete").attr("class","filmRow");
				container.attr("class","obsolete");
			}			
		}
    	
		//button offenlegen, der die Details wieder verschwinden lässt.
		$("button#btn-loadFilmList").removeClass("obsolete");
		$("button#btn-reloadFilmList").removeClass("obsolete");
		$("div#contentDivDetail").removeClass("obsolete");
		$("div#filmCommentSection").removeClass("obsolete");
		
		
		$("div#filmCommentSection").off('click','button#btn-deleteUsercomment');
		$("div#filmCommentSection").on('click','button#btn-deleteUsercomment', deleteComment);
		$("div#filmCommentSection").off('click','button#btn-editUsercomment');
		$("div#filmCommentSection").on('click','button#btn-editUsercomment', editComment);
		$("div#filmCommentSection").off('click','button#btn-sendNewUsercomment');
		$("div#filmCommentSection").on('click','button#btn-sendNewUsercomment', sendComment);
		
		window.scrollTo(0,0);
		
		return false;
	});
	
	$("button#btn-reloadFilmList").click(function() {
		//Welcher Film ist gerade geladen?
		var value = $("tbody#filmlistBody").attr("data-last");
		//neu Laden der Inhalte
		$.ajax({
			type: "POST",
			url: "reload.php",
			data: {
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
			url: "reload.php",
			data: {
				method: "loadFilmComments",
				value: value
			},
			success: function(content) {
				$("#filmCommentSection").html(content);
			}
		});
		
		//den entsprechenden Knöpfen wieder funktionen zuweisen
		$("div#filmCommentSection").off('click','button#btn-deleteUsercomment');
		$("div#filmCommentSection").on('click','button#btn-deleteUsercomment', deleteComment);
		$("div#filmCommentSection").off('click','button#btn-editUsercomment');
		$("div#filmCommentSection").on('click','button#btn-editUsercomment', editComment);
		$("div#filmCommentSection").off('click','button#btn-sendNewUsercomment');
		$("div#filmCommentSection").on('click','button#btn-sendNewUsercomment', sendComment);
		
		return false;
	});

	function deleteComment(){
		if (confirm("Sollen wir den Kommentar wirklich löschen?"))
		{
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
				url: "comment.php",
				data: {
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
		//entgegennahme
		var plaintext = $("textarea#writeComment").val();
		var cid = $("textarea#writeComment").attr("data-cid");
		var mid = $("tbody#filmlistBody").attr("data-last");
		
		if (plaintext){
			$.ajax({
				type: "POST",
				url: "comment.php",
				data: {
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
		
		return false;
	}
	
	$("button#btn-loadFilmList").click(function() {
		$("div#contentDivDetail").addClass("obsolete");
		$("div#filmCommentSection").addClass("obsolete");
		$("button#btn-loadFilmList").addClass("obsolete");
		$("button#btn-reloadFilmList").addClass("obsolete");

		$("tbody#filmlistBody").children(".obsolete").attr("class","filmRow");
	    return false;
	});
});