<table class="filmList">
	<thead>
		<tr>
			<th>Titel</th>
			<th>Erscheinungsjahr</th>
			<th>Mitwirkende Schauspieler</th>
			<th>Regisseur</th>
			<th>Genre</th>
		</tr>
	</thead>
	<tbody id="filmlistBody" data-last="0">
		{foreach $contentData as $set}
		<tr class="filmRow" data-value="{$set["mid"]}">
			<td><button id="btn-loadFilmDetails" >{$set["title"]}</button></td>
			<td>{$set["year"]}</td>
			<td>{foreach $set["actors"] as $actor}{$actor["firstname"]} {$actor["name"]},{/foreach}</td>
			<td>{$set["regisseur"]["firstname"]} {$set["regisseur"]["name"]}</td>
			<td>{$set["genre"]}</td>
		</tr>
		{/foreach}
	</tbody>
</table>