<hr>
<strong>Kommentare:</strong><br>
{if count($commentsUser) > 0 or count($commentsNonuser) > 0}
	{foreach $commentsUser as $comment}<div class="usercomment" data-cid="{$comment["cid"]}"><strong>Du hast geschrieben:</strong><button id="btn-editUsercomment">bearbeiten</button><button id="btn-deleteUsercomment">löschen</button><br><div>{$comment["text"]}</div></div>{/foreach}
	{foreach $commentsNonuser as $comment}<div class="usercomment"><strong>{$comment[1]} schrieb:</strong><br><div>{$comment[0]}</div></div>{/foreach}
{else}
	Zu diesem Film hat noch niemand seinen Quark hinzugefügt?!<br>Schnell du musst das ändern!
{/if}
{if $logedin eq true}
<hr>
<div class="commentForm">
	<form>
	<label for="writeComment"><strong>Neuen Kommentar verfassen</strong></label>
	<textarea id="writeComment" data-cid="none" maxlength="500" required name="comment" placeholder="Das ist ein Film und ich hab folgendes dazu zu sagen: ..."></textarea>
	<button id="btn-sendNewUsercomment">Kommentar einsenden.</button>
	</form>
</div>
{/if}