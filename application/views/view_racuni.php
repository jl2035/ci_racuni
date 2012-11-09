
<div id="main_div">
<table width="700px">
	<tr>
		<td><h2 style="margin-left: 10px;">Racuni</h2></td>
		<td style="vertical-align: middle"><h3 style="margin-right: 5px; float: right;"><?= anchor('racuni/dodaj', '<img src="'.base_url().'assets/images/dodaj.png">Vnesi nov račun'); ?></h3></td>
	</tr>
</table>
<?php
	if(count($racuni) > 0)
	{
		?>
		<table id="table-2">
			<thead>
				<th>ID</th><th>Datum</th><th>Stranka</th><th>Znesek</th><th style="width: 115px;"></th>
			</thead>
			<tbody>
		<?php
		foreach($racuni as $racun)
		{
			/*$znesek = 0;
			foreach($racun['postavke'] as $postavka)
			{
				$znesek += ($postavka->cena + ($postavka->cena * ($postavka->ddv / 100)) * $postavka->kolicina);
			}*/
			echo '<tr><td>'.$racun['st_racuna'].'</td><td>'.date('j.n.Y', $racun['datum']).'</td><td>'.$racun['stranka'].'</td><td>'.$racun['znesek'].'€</td><td>'.
			anchor('racuni/editing/'.$racun['id'], '<img title="Poglej" src="'.base_url().'assets/images/poglej.png">').'&nbsp;&nbsp;'.
			anchor('racuni/show_single/'.$racun['id'], '<img title="Dobi PDF" src="'.base_url().'assets/images/pdf.png">').'&nbsp;&nbsp;'.
			anchor('racuni/remove?rac_id='.$racun['id'], '<img title="Odstrani" src="'.base_url().'assets/images/odstrani.png">').'</td></tr>';
		}
		echo '</tbody></table>';
	}
	else
		echo "Ni vnosov";
?>
</div>
