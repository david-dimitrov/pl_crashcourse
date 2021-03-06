<table class="filmList table table-striped table-sm table-hover">
	<thead>
		<tr>
			<th scope="col">Titel</th>
			<th scope="col">Erscheinungsjahr</th>
			<th class="hidden-xs" scope="col">Mitwirkende Schauspieler</th>
			<th class="hidden-xs" scope="col">Regisseur</th>
			<th scope="col">Genre</th>
		</tr>
	</thead>
	<tbody id="filmlistBody" data-last="0">
		{foreach $contentData as $set}
		<tr class="filmRow" scope="row" data-value="{$set["mid"]}">
			<td><button id="btn-loadFilmDetails" >{$set["title"]}</button></td>
			<td>{$set["year"]}</td>
			<td class="hidden-xs">{foreach $set["actors"] as $actor name=actor}
					{if $smarty.foreach.actor.last}
						{$actor["firstname"]} {$actor["name"]}
					{else}
						{$actor["firstname"]} {$actor["name"]},
					{/if}
				{/foreach}
			</td>
			<td class="hidden-xs">{$set["regisseur"]["firstname"]} {$set["regisseur"]["name"]}</td>
			<td>{$set["genre"]}</td>
		</tr>
		{/foreach}
	</tbody>
</table>