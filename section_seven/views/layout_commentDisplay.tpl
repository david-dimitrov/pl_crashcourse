<strong>Kommentare:</strong><br>
{if count($commentsUser) > 0 or count($commentsNonuser) > 0}
	{foreach $commentsUser as $comment}<div id="usercomment" data-cid="{$comment["cid"]}"><strong>Du hast geschrieben:</strong><button id="btn-editUsercomment">bearbeiten</button><button id="btn-deleteUsercomment">löschen</button><br><div>{$comment["text"]}</div><br></div>{/foreach}
	{foreach $commentsNonuser as $comment}<div><strong>{$comment[1]} schrieb:</strong><br><div>{$comment[0]}</div><br></div>{/foreach}
{else}
	Zu diesem Film hat noch niemand seinen Quark hinzugefügt?!<br>Schnell du musst das ändern!
{/if}
{if $logedin eq true}
<div>
	<form>
	<textarea id="writeComment" data-cid="none" maxlength="500" required name="comment" placeholder="Das ist ein Film. Mehr brauch ich dazu nicht sagen."></textarea>
	<button id="btn-sendNewUsercomment">Kommentar einsenden.</button>
	</form>
</div>
{/if}