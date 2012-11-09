<style>
div#pop-up {
  display: none;
  position: absolute;
  width: 200px;
  padding: 10px;
  background: #eeeeee;
  color: #000000;
  border: 1px solid #1a1a1a;
  font-size: 90%;
  left: 40%;
  top: 200px;
}
p
{
   padding: 10px;
}
</style>
<div id="main_div">
<h2 style="margin-left: 10px;">Racun št.: <?= $racun['st_racuna']; ?></h2>		
<?php
	echo '<table id="table-2" style="width: 100%;"><thead>
	          <td>ID</td>
	          <td>Storitev</td>
	          <td>Količina</td>
	          <td>Cena</td>
	          <td>DDV</td>
	          <td>Cena DDV</td>
	          <td>Popusti</td>
	          <td>Znesek</td>
	          <td>S popustom</td>
	      </thead><tbody>';
	foreach($racun['postavke'] as $postavka)
	{
		$cenaZDDV = $postavka['cena'] + ($postavka['cena'] * ($postavka['ddv'] / 100));
		$znesekP = $cenaZDDV * $postavka['kolicina'];
		echo '<tr>
		<td>'.$postavka['storitev_id'].'</td>
		<td>'.$postavka['naziv'].'</td>
		<td>'.$postavka['kolicina'].'</td>
		<td>'.$postavka['cena'].'€</td>
		<td>'.$postavka['ddv'].'%</td>
		<td>'.$cenaZDDV.'€</td>';
		echo '<td>';
		$skupajPopust = 0;
		foreach($postavka['popusti'] as $popust)
		{
			$skupajPopust += $popust['vrednost'];
			echo $popust['vrednost'].'% &nbsp; '.anchor('racuni/odstrani_popust/'.$popust['id'].'/'.$racun['id'],  '<img width="15" height="15" title="Odstrani popust" src="'.base_url().'assets/images/odstrani.png">').'<br>';
		}
		echo '<img onclick="pokazi_popup('.$postavka['id'].')" width="15" style="cursor: pointer;" height="15" title="Dodaj popust" src="'.base_url().'assets/images/dodaj.png">';
		echo '</td>';
		echo '<td>'.$znesekP.'€</td>';
		$znesekP = $znesekP - ($znesekP * ($skupajPopust / 100));
		echo '<td>'.$znesekP.'€</td>
		</tr>';
	}
	echo '</tbody></table>';
	
	echo '<p>Znesek brez DDV: '.$racun['znesekBrezDDV'].'€</p><p><strong>Znesek: '.$racun['znesek'].'€</strong></p>';
	
?>
</div>
<div id="pop-up">
	<?php echo form_open(base_url() . 'racuni/dodaj_popust'); ?>
	<label for="vrednost">Vnesi popust: </label>
	<input type="text" name="vrednost" id="vrednost" style="width: 20px;"> % <span id="span_klicaj" style="color: red; visibility: hidden;">!!!</span><br>
	<input type="hidden" name="racun_id" value="<?= $racun['id']; ?>">
	<input type="hidden" id="postavka_id" name="postavka_id">
	<span id="span_preklici" style="cursor: pointer;">Preklici</span>
	<input type="submit" id="submit" name="submit" value="Dodaj">
	<?php echo form_close(); ?>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript">
	$('#span_preklici').click(function(){
		$('#pop-up').css('display', 'none');
	});
	$('#submit').click(function()
	{
		if(!isNumeric($('#vrednost').val())){
			$('#span_klicaj').css('visibility', 'visible');
			return false;
		}
		else
			return true;
	});
	
	function isNumeric(input)
	{
		var RE = /^-{0,1}\d*\.{0,1}\d+$/;
		return (RE.test(input));
	}
	
	function pokazi_popup(pos_id)
	{
		$('#pop-up').css('display', 'block');
		$('#postavka_id').val(pos_id);
	}
</script>
