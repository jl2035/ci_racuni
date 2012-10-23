
	<h1>Storitve</h1>


	<table>
		<tr>
			<td>Storitev</td>
			<td>Cena</td>
		</tr>
	<?php 
	
		foreach($query->result() as $st_item)
		{
			echo "<tr><td>".$st_item->naziv."</td><td>".$st_item->cena."€ </td><td>".anchor('storitve/remove?stor_id='.$st_item->id, 'Odstrani')."</td></tr>";
		}
	?>		
	</table>

	<?= anchor('storitve/addnew', 'Dodaj novo storitev'); ?>
	

