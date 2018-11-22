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
		$("div#contentDivDetail").removeClass("obsolete");
		
		
		$("div#contentDivDetail").on('click','button#btn-sendNewUsercomment', sendComment);
		$("div#contentDivDetail").on('click','button#btn-editUsercomment', editComment);
		
		return false;
	});
	
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
					mid: mid
				},
				success: function(content) {
					$("textarea#writeComment").parent().parent().html(content);
					//display @writeComments*/
				}
			});
		}
		
		return false;
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
		
		console.log(plaintext);
	}
	
	$("button#btn-loadFilmList").click(function() {
		$("#contentDivDetail").addClass("obsolete");
		$("button#btn-loadFilmList").addClass("obsolete");
		$("tbody#filmlistBody").children(".obsolete").attr("class","filmRow");
	    return false;
	});
	
	//test Fkt.
	function invisibleButton () {
		$("button#btn-sendNewUsercomment").attr("class","obsolete");
	}
});