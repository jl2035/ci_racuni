
	<h1>Dodaj račun</h1>
	
	<?php $atts = array('id' => 'form1');
		echo form_open(base_url() . 'racuni/insert', $atts); ?>
	<table class="formtable">
		<tr>
			<td>Predračun (DA / NE)</td>
			<td>
				<input type="checkbox" name="predracun">
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Storitev</td>
			<td>Kolicina</td>
			<td></td>
		</tr>
		<tr>
	<?php 
		foreach($storitve_q->result() as $storitev)
			$options[$storitev->id] = $storitev->naziv;
		echo '<td>'.form_dropdown('storitev', $options, '', 'id="storitev"').'</td>'; // 'large', $js);
		echo '<td>'.form_input('kolicina', '1', 'style="width: 50px;" id="kolicina"').'<span id="kol_span" style="visibility: hidden; color: red;"> !!</span></td>';
	?>
	<td><div style="border-style: solid; cursor: pointer; padding-left: 2px; padding-right: 2px;" onclick="dodajStor()">Dodaj</div></td>
	</tr>
	<tr>
		<td colspan="3">
			<div id="postavke"></div>
		</td>
	</tr>
	</table>
	<br>
	<input type="hidden" name="stors" id="stors">

	
	<?php 
		$stranke_opt = array();
		$stranke_opt['-1'] = 'Nova stranka';
		foreach($stranke_q->result() as $stranka)
		{
			$stranke_opt[$stranka->id] = $stranka->naziv;
		}
	?>

	<h1>Podatki o stranki</h1>
	<?php
	//$stranke_sel =  $this->input->post('stranka');
	echo form_dropdown('stranka', $stranke_opt, $this->input->post('stranka'), 'id="stranka" onChange="this.form.submit();"');
	 if ($this->input->post('stranka')) { ?>
	<table>
		<tr>
			<td>Naziv</td>
			<td><?= form_input('str_naziv', '', 'style="width: 100px;" id="kolicina"'); // array('id' => 'str_naziv', 'name' => 'str_naziv')); ?></td>
		</tr>
		<tr>
			<td>Naslov</td>
			<td><?= form_input('str_naslov', '', 'style="width: 150px;" id="kolicina"');  //array('id' => 'str_naslov', 'name' => 'str_naslov')); ?></td>
		</tr>
		<tr>
			<td>Pošta</td>
			<td><?= form_input('str_posta', '', 'style="width: 100px;" id="kolicina"');       //array('id' => 'str_posta', 'name' => 'str_posta')); ?></td>
		</tr>
	</table>
	
	<?php } ?>
	
	
	<div style="border-bottom: 1px solid #D0D0D0;"><br></div>
	<br>
	<?php 
	 echo form_hidden(array('sid' => $sid)); 
	 //echo form_hidden(array('stors' => ''), 'id="stors"'); 
	 echo form_submit(array('name' => 'submit', 'value' => 'Shrani')); 
	 echo form_close(); 
	?>
	
	
	
<script type="text/javascript">
	function dodajStor()
	{
		var kolicina = document.getElementById('kolicina').value;
		if(isNumeric(kolicina))
		{
			document.getElementById('kol_span').style.visibility = 'hidden';
			elt = document.getElementById('storitev');
			dodajPostavko(elt.value, kolicina);
		}
		else
			document.getElementById('kol_span').style.visibility = 'visible';
	}
	
	function isNumeric(input)
	{
		var RE = /^-{0,1}\d*\.{0,1}\d+$/;
		return (RE.test(input));
	}

	function dodajPostavko(val, kol)
	{
		var vse = document.getElementById('stors').value;
		var arr = vse.split('|');
		var found = false;
		if(arr.length > 0 && arr[0].length > 0){
			for(i=0; i<arr.length; i++)
			{
				var item = arr[i].split(';');
				if(item[0] == val){
					item[1] = (parseInt(item[1], 10) + parseInt(kol, 10)).toString();
					found = true;
					var st_item = item[0] + ";" + item[1];
					arr[i] = st_item;
				}
			}
		}
		if(!found){
			var ln = arr.length;
			if(arr.length == 1 && arr[0] == "")
				ln = 0;
			arr[ln] = val + ";" + kol;
		}
		var str_all = "";
		str_all += arr[0];
		for(i=1; i<arr.length; i++)
			str_all += "|"+arr[i];		
		document.getElementById('stors').value = str_all;
		updateGUI();
		//alert(str_all);
	}
	
	function updateGUI()
	{
		var select = document.getElementById('storitev');
		var stors = document.getElementById('stors').value;
		//alert(stors);
		var stors_arr = stors.split('|');
		var out_str = "";
		for(i=0; (i<stors_arr.length); i++)
		{	
			var postavka = stors_arr[i].split(';');
			out_str += "<br>"+getOptionText(select, postavka[0])+" - "+postavka[1]+"x";
		}
		document.getElementById('postavke').innerHTML = out_str;
	}

	function getOptionText(selem, id)
	{
		for(i=0; i<selem.options.length; i++)
		{
			if(selem.options[i].value == id)
				return selem.options[i].text;
		}
		return null;
	}

</script>


