	
<div id="main_div">
	<h2>Nastavitve</h2>
	<?= form_open(base_url() . 'nastavitve/update'); ?>
	<table>
		<tr>
			<td>Naziv</td>
			<td><?= form_input('naziv', $naziv); ?></td>
		</tr>
		<tr>
			<td>Naslov</td>
			<td><?= form_input('naslov', $naslov); ?></td>
		</tr>
		<tr>
			<td>Pošta</td>
			<td><?= form_input('posta', $posta); ?></td>
		</tr>
		<tr>
			<td>Telefon</td>
			<td><?= form_input('telefon', $telefon); ?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?= form_input('email', $email); ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<?= form_submit('submit', 'Shrani') ?>
			</td>
		</tr>
	</table>
	
		

	<?=	form_close(); ?>

</div>
