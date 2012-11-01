<?php 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage();
$line = 40;#848484ow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$pdf->SetFont('freesans', '', 12);

$hlevo = '<div style="float: left;">'.$racun['narocnik']->naziv."<br>".$racun['narocnik']->naslov."<br>".$racun['narocnik']->posta.'</div>';
$hdesno = '<div style="text-align: left; float: right;">'.$racun['stranka']->naziv."<br>".$racun['stranka']->naslov."<br>".$racun['stranka']->posta.'</div>';
//$table1 = '<table><tr><td>'.$hlevo.'</td><td>'.$hdesno.'</td></tr></table><br><br>';
$html = $hlevo.$hdesno; //$table1;
$html.= '<br><strong>Račun št.: '.$racun['id'].'</strong><br><br><br>';
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $table1, $border=1, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$table2 = '<table cellpadding="2px"><tr style="background-color: #8686FF;"><td style="width: 20px;">ID</td><td style="width: 170px;">Storitev</td><td style="width: 60px;">Cena</td><td>DDV</td><td>Cena z DDV</td><td style="width: 60px;">Kolicina</td><td>Znesek</td></tr>';
//$table2 = '<table><thead><th>ID</th><th>Storitev</th><th>Cena</th><th>DDV</th><th>Cena z DDV</th><th>Kolicina</th><th>Znesek</th></thead><tbody>';
$skupajZDVV = 0;
$skupajBrezDDV = 0;
$barva = '#BBBBFF';
foreach($racun['postavke'] as $postavka)
{
	if($barva == '#CECEFF')
		$barva = '#BBBBFF';
	else
		$barva = '#CECEFF';
	$cenaZDDV = $postavka->cena + ($postavka->cena * ($postavka->ddv / 100));
	$skupajBrezDDV += $postavka->cena * $postavka->kolicina;
	$znesekP = $cenaZDDV * $postavka->kolicina;
	$skupajZDVV += $znesekP;
	$table2 .= '<tr style="background-color: '.$barva.';"><td>'.$postavka->storitev_id.'</td><td>'.$postavka->naziv.'</td><td>'.$postavka->cena.
	'</td><td>'.$postavka->ddv.'%</td><td>'.$cenaZDDV.'</td><td>'.$postavka->kolicina.'</td><td>'.$znesekP.'</td></tr>';
}
$table2 .= '<tr style="background-color: #8686FF;"><td colspan="2">&nbsp;</td><td colspan="3">Skupaj brez DDV: '.$skupajBrezDDV.'€</td><td colspan="2"><strong>Znesek: '.$skupajZDVV.'€</strong></td></tr>';
// postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.ddv, storitev.naziv
//$table2 .= '</tbody></table>';
$table2 .= '</table><br>';
$html .= $table2;
$html .= '<p>Plačilo izvršite z univerzalnim plačilnim nalogom UPN na transakcijski račun: '.$racun['narocnik']->trr.'.<br>Pri plačilu obvezno navedite naslednjo referenco: SI00 '.date('Y').$racun['id'].'</p>';
/*TCPDF::writeHTML 	( $html, $ln=true, $fill=false, $reseth=false,	$cell=false, $align='') 	*/
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=$, $table2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMl($html);
$pdf->Output('Račun št. '.$racun_id.'.pdf', 'I');
?>
