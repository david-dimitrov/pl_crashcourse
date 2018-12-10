<div class="row">
	<div class="col-xl-30 col-md-30 col-sm-30 col-xs-60">
		<label for = "username">
			<input id = "username" name = "username" placeholder = "MaxM" tabindex="1">
		</label>
		<button id="btn-login" type="submit" tabindex="3">login</button>
	</div>
	<div class="col-xl-30 col-md-30 col-sm-30 col-xs-60">
		<label for = "password">
			<input type = "password" id = "password" name = "password" placeholder = "********" tabindex="2">
		</label>
		<button id="btn-register" tabindex="4">registrieren</button>
	</div>
</div>
<div {$loginMsgStyle}>
{$loginMsg}
</div>