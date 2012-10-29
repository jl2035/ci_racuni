
<div id="main_div">
<table width="600px">
	<tr>
		<td><h2 style="margin-left: 10px;">Racuni</h2></td>
		<td><h3 style="margin-right: 10px; float: right;"><?= anchor('racuni/dodaj', 'Vnesi nov račun'); ?></h3></td>
	</tr>
</table>
<?php
	if(count($racuni) > 0)
	{
		?>
		<table id="table-2">
			<thead>
				<th>ID</th><th>Datum</th><th>Znesek</th><th></th>
			</thead>
			<tbody>
		<?php
		foreach($racuni as $racun)
		{
			$znesek = 0;
			foreach($racun['postavke'] as $postavka)
			{
				$znesek += ($postavka->cena * $postavka->kolicina);
			}
			echo '<tr><td>'.$racun['id'].'</td><td>'.date('j.n.Y', $racun['datum']).'</td><td>'.$znesek.'€</td><td>'.anchor('racuni/show_single?rac_id'.$racun['id'], 'Poglej').'&nbsp;|&nbsp;Uredi&nbsp;|&nbsp;'.anchor('racuni/remove?rac_id='.$racun['id'], 'Odstrani').'</td></tr>';
		}
		echo '</tbody></table>';
	}
	else
		echo "Ni vnosov";
?>
</div>
