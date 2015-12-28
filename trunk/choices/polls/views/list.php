<table>
		<tr>
			<th>Title</th><th>Notes</th><th>Type</th><th>Actions</th>
		</tr>
		
		<?
		foreach($records as $rec)
		{
			$css_class = ($css_class == 'rowa') ? 'rowb' : 'rowa';
			?>
			<tr class="<?=$css_class?> <?=($rec->data['id']==$insertedId) ? 'insertedRow' : '' ?>">
				<td class="titleField">
					<a href="?action=show&id=<?=$rec->data['id']?>">
						<?=$rec->data['title']?>
					</a>
				</td>
				<td class="notesField">
						<?=$rec->data['notes']?>
				</td>
				<td class="typeField">
						<?=$rec->data['type']?>
				</td>
				<td class="actionsField">
					<? if($is_owner){ ?>
						<a href='?action=edit&id=<?=$rec->data['id']?>' >Edit</a> |
						<a href='?action=delete&id=<?=$rec->data['id']?>'>Delete</a>
					<? } ?>
				</td>
			</tr>
			<?
		}
		?>
</table>