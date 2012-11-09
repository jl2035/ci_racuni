

	
	
<div id="main_div">
	<table width="600px">
	<tr>
		<td><h2 style="margin-left: 10px;">Storitve</h2></td>
		<td><h3 style="margin-right: 10px; float: right;"><?= anchor('storitve/addnew', 'Dodaj storitev'); ?></h3></td>
	</tr>
	</table>
	<table id="table-2">
		<thead>
			<th>ID</th>
			<th>Storitev</th>
			<th>Cena</th>
			<th>DDV</th>
			<th>Cena z DDV</th>
			<th></th>
		</thead>
		<tbody>
	<?php 
	
		foreach($query->result() as $st_item)
		{
			echo "<tr><td>".$st_item->id."</td><td>".$st_item->naziv."</td><td>".$st_item->cena."€ </td><td>".$st_item->ddv."%</td><td>".(($st_item->cena) + ($st_item->cena * ($st_item->ddv / 100)))."€</td><td>".anchor('storitve/remove?stor_id='.$st_item->id, '<img title="Odstrani" src="'.base_url().'assets/images/odstrani.png">')."</td></tr>";
		}
	?>		
		</tbody>
	</table>
</div>

