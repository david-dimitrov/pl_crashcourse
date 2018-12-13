<div class="row justify-content-center">
	<div class="col-30 loginNameDisplay">Sie sind angemeldet <strong>{$username}</strong></div>
	<div class="col-30">
			<button id="btn-logout" type="submit" tabindex="1">logout</button>
		<form class="loginNameDisplay" action="lib/logout.php">
		</form>
	</div>
</div>
<div {$loginMsgStyle}>
{$loginMsg}
</div>