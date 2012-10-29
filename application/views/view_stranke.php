
<div id="main_div">
	<table width="600px">
	<tr>
		<td><h2 style="margin-left: 10px;">Stranke</h2></td>
		<td><h3 style="margin-right: 10px; float: right;"><?= anchor('stranke/dodaj', 'Dodaj stranko'); ?></h3></td>
	</tr>
	</table>
	<table id="table-2">
		<thead>
			<th>Stranka</th>
			<th>Naslov</th>
			<th>Pošta</th>
			<th></th>
		</thead>
		<tbody>
	<?php 
	
		foreach($stranke->result() as $st_item)
		{
			echo "<tr><td>".$st_item->naziv."</td><td>".$st_item->naslov."€ </td><td>".$st_item->posta."</td><td>".anchor('stranke/remove?st_id='.$st_item->id, 'Odstrani')."</td></tr>";
		}
	?>		
		</tbody>
	</table>
</div>

