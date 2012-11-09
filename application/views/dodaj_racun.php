
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
			<td>Številka računa</td>
			<td><?= form_input('st_racuna', 0, 'style="width: 50px;" id="st_racuna"'); ?></td>
			<td></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		</table>
		<table style="background-color: #CACACA;">
		<tr>
			<td>Storitev</td>
			<td>Šifra</td>
			<td>Kolicina</td>
			<td></td>
		</tr>
		<tr>
			<?php 
				foreach($storitve_q->result() as $storitev)
					$options[$storitev->id] = $storitev->naziv;
				echo '<td>'.form_dropdown('storitev', $options, '', 'id="storitev"').'</td>'; // 'large', $js);
				echo '<td><input type="text" id="sifra" name="sifra" style="width: 25px"></td>';
				echo '<td>'.form_input('kolicina', '1', 'style="width: 50px;" id="kolicina"').'<span id="kol_span" style="visibility: hidden; color: red;"> !!</span></td>';
			?>
			<td><div id="gumbDodaj" style="border-style: solid; cursor: pointer; padding-left: 2px; padding-right: 2px;">Dodaj</div></td>
		</tr>
		<tr>	
			<td colspan="4">
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
	echo form_dropdown('stranka', $stranke_opt, $this->input->post('stranka'), 'id="stranka"');
	 if (!$this->input->post('stranka') || $this->input->post('stranka') == '-1') { ?>
	<table id="stranka_tbl">
		<tr>
			<td>Naziv</td>
			<td><?= form_input('str_naziv', '', 'style="width: 100px;" id="str_naziv"'); // array('id' => 'str_naziv', 'name' => 'str_naziv')); ?></td>
		</tr>
		<tr>
			<td>Naslov</td>
			<td><?= form_input('str_naslov', '', 'style="width: 150px;" id="str_naslov"');  //array('id' => 'str_naslov', 'name' => 'str_naslov')); ?></td>
		</tr>
		<tr>
			<td>Pošta</td>
			<td><?= form_input('str_posta', '', 'style="width: 100px;" id="str_posta"');       //array('id' => 'str_posta', 'name' => 'str_posta')); ?></td>
		</tr>
		<tr>
			<td>Telefon</td>
			<td><?= form_input('str_telefon', '', 'style="width: 100px;" id="str_telefon"');       //array('id' => 'str_posta', 'name' => 'str_posta')); ?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?= form_input('str_email', '', 'style="width: 100px;" id="str_email"');       //array('id' => 'str_posta', 'name' => 'str_posta')); ?></td>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<!--script type="text/javascript" src="http://localhost/jquery.js"></script-->	
<script type="text/javascript">
	
	$("#gumbDodaj").click(function()
	{
		var kolicina = $("#kolicina").val();
		if(isNumeric(kolicina))
		{
			$("#kol_span").css('visibility', 'hidden');
			dodajPostavko($("#storitev").val(), kolicina);
		}
		else
			$("#kol_span").css('visibility', 'visible');
	});
	
	$('#storitev').change(function()
	{
		$('#sifra').val($('#storitev').val());
	});
		
	$('#sifra').keyup(function()
	{
		var sfr = $('#sifra').val();
		$('#storitev option[value="'+sfr+'"]').prop('selected', true);
	});
		
		
	function isNumeric(input)
	{
		var RE = /^-{0,1}\d*\.{0,1}\d+$/;
		return (RE.test(input));
	}

	function dodajPostavko(val, kol)
	{
		var vse = $("#stors").val(); 
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
		$("#stors").val(str_all);	
		updateGUI();
	}
	
	function updateGUI()
	{
		var stors = $("#stors").val(); 
		var stors_arr = stors.split('|');
		var out_str = "";
		for(i=0; (i<stors_arr.length); i++)
		{	
			var postavka = stors_arr[i].split(';');
			var o_text = $("#storitev option[value='"+postavka[0]+"']").text();
			out_str += "<br>"+o_text+" - "+postavka[1]+"x"; //
		}
		document.getElementById('postavke').innerHTML = out_str;
	}

	$('#stranka').change(function()
	{ 
		if($('#stranka').val() == '-1')
			$('#stranka_tbl').css('visibility', 'visible');
		else
			$('#stranka_tbl').css('visibility', 'hidden');
	});

</script>


