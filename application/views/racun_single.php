<?php 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$line = 40;#848484ow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$pdf->SetFont('freesans', '', 12);
$hlevo = '<div style="float: left;">'.$racun['narocnik']->naziv."<br>".$racun['narocnik']->naslov."<br>".$racun['narocnik']->posta."<br>Tel.: ".$racun['narocnik']->telefon."<br>Email: ".$racun['narocnik']->email."<br>TRR: ".$racun['narocnik']->trr."<br>Banka: ".$racun['narocnik']->banka.'</div>';
$hdesno = '<div style="text-align: left; float: right;">'.$racun['stranka']->naziv."<br>".$racun['stranka']->naslov."<br>".$racun['stranka']->posta;
if(strlen($racun['stranka']->telefon) > 0)
	$hdesno .= "<br>Tel.: ".$racun['stranka']->telefon;
if(strlen($racun['stranka']->email) > 0)
	$hdesno .= "<br>Email: ".$racun['stranka']->email;
$hdesno .= '</div>';
//$table1 = '<table><tr><td>'.$hlevo.'</td><td>'.$hdesno.'</td></tr></table><br><br>';
$html = $hlevo.$hdesno; //$table1;
$racun_beseda = $racun['predracun'] == 1 ? 'Predračun' : 'Račun';
$html.= '<br><strong>'.$racun_beseda.' št.: '.$racun['st_racuna'].'</strong><br><br><br>';
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $table1, $border=1, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$table2 = '<table cellpadding="2px"><tr style="background-color: #DCDCFF;"><td style="width: 20px;">ID</td><td style="width: 170px;">Storitev</td><td style="width: 60px;">Cena</td><td>DDV</td><td>Cena z DDV</td><td style="width: 60px;">Kolicina</td><td>Znesek</td></tr>';
//$table2 = '<table><thead><th>ID</th><th>Storitev</th><th>Cena</th><th>DDV</th><th>Cena z DDV</th><th>Kolicina</th><th>Znesek</th></thead><tbody>';
$skupajZDVV = 0;
$skupajBrezDDV = 0;
$barva = '#FFFFF0';
foreach($racun['postavke'] as $postavka)
{
	if($barva == '#FFFFF0')
		$barva = '#FFFFF2';
	else
		$barva = '#FFFFF0';
	$cenaZDDV = $postavka->cena + ($postavka->cena * ($postavka->ddv / 100));
	$skupajBrezDDV += $postavka->cena * $postavka->kolicina;
	$znesekP = $cenaZDDV * $postavka->kolicina;
	$skupajZDVV += $znesekP;
	$table2 .= '<tr style="background-color: '.$barva.';"><td>'.$postavka->storitev_id.'</td><td>'.$postavka->naziv.'</td><td>'.$postavka->cena.
	'</td><td>'.$postavka->ddv.'%</td><td>'.$cenaZDDV.'</td><td>'.$postavka->kolicina.'</td><td>'.$znesekP.'</td></tr>';
}
$table2 .= '<tr style="background-color: #DCDCFF;"><td colspan="2">&nbsp;</td><td colspan="3">Skupaj brez DDV: '.$skupajBrezDDV.'€</td><td colspan="2"><strong>Znesek: '.$skupajZDVV.'€</strong></td></tr>';
// postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.ddv, storitev.naziv
//$table2 .= '</tbody></table>';
$table2 .= '</table><br>';
$html .= $table2;
if(!$racun['predracun'])
	$html .= '<p>Plačilo lahko izvršite z univerzalnim plačilnim nalogom UPN na transakcijski račun:<br>'.$racun['narocnik']->trr.'.<br>Pri plačilu navedite naslednjo referenco: SI00 '.date('Y').$racun['st_racuna'].'</p>';
/*TCPDF::writeHTML 	( $html, $ln=true, $fill=false, $reseth=false,	$cell=false, $align='') 	*/
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=$, $table2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMl($html);
$racun_beseda2 = $racun['predracun'] == 1 ? 'Predracun_st._' : 'Racun_st._';
$pdf->Output( $racun_beseda2.$racun_id.'.pdf', 'I');
?>
