$( document ).ready(function() {
	//Hier jQuery-Code eintragen
	$("button#btn-flower").click(function() {

	    $.ajax({
	        type: "POST",
	        url: "index.php",
	        data: {
	            method: "flowers"
	        },
	        success: function(content) {
	            $("#data-list").html(content);
	        }
	    });

	    return false;
	});
	
	$("button#btn-dog").click(function() {

	    $.ajax({
	        type: "POST",
	        url: "index.php",
	        data: {
	            method: "dogs"
	        },
	        success: function(content) {
	            $("#data-list").html(content);
	        }
	    });

	    return false;
	});

	$("button#btn-team").click(function() {

	    $.ajax({
	        type: "POST",
	        url: "index.php",
	        data: {
	            method: "teams"
	        },
	        success: function(content) {
	            $("#data-list").html(content);
	        }
	    });

	    return false;
	});
});

function onSuccess(content)
{
    var response = $.parseJSON(content);

    $("#content").html(response.template);
    
    if(!response.result)
    {
        $(".control-group").addClass("error");
    }
    else
    {
        $(".control-group").removeClass("error");
    }
}