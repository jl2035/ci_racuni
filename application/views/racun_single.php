<?php 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage();
$line = 40;
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$pdf->SetFont('freesans', '', 12);

$hlevo = '<p>'.$racun['narocnik']->naziv."<br>".$racun['narocnik']->naslov."<br>".$racun['narocnik']->posta.'</p>';
$hdesno = '<p style="text-align: left; float: right;">'.$racun['stranka']->naziv."<br>".$racun['stranka']->naslov."<br>".$racun['stranka']->posta.'</p>';
$table1 = '<table style="width: 100%; border-style: solid;"><tr><td>'.$hlevo.'</td><td>'.$hdesno.'</td></tr></table><br><br>';
$html = $table1;
$html.= 'Račun št.: '.$racun['id'].'<br><br>';
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $table1, $border=1, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$table2 = '<table><tr><td>ID</td><td>Storitev</td><td>Cena</td><td>DDV</td><td>Cena z DDV</td><td>Kolicina</td><td>Znesek</td></tr>';
//$table2 = '<table><thead><th>ID</th><th>Storitev</th><th>Cena</th><th>DDV</th><th>Cena z DDV</th><th>Kolicina</th><th>Znesek</th></thead><tbody>';
$skupajZDVV = 0;
$skupajBrezDDV = 0;
foreach($racun['postavke'] as $postavka)
{
	$cenaZDDV = $postavka->cena + ($postavka->cena * ($postavka->ddv / 100));
	$skupajBrezDDV += $postavka->cena * $postavka->kolicina;
	$znesekP = $cenaZDDV * $postavka->kolicina;
	$skupajZDVV += $znesekP;
	$table2 .= '<tr><td>'.$postavka->storitev_id.'</td><td>'.$postavka->naziv.'</td><td>'.$postavka->cena.
	'</td><td>'.$postavka->ddv.'%</td><td>'.$cenaZDDV.'</td><td>'.$postavka->kolicina.'</td><td>'.$znesekP.'</td></tr>';
}
$table2 .= '<tr><td colspan="2">&nbsp;</td><td colspan="3">Skupaj brez DDV: '.$skupajBrezDDV.'€</td><td colspan="2"><strong>Znesek: '.$skupajZDVV.'€</strong></td></tr>';
// postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.ddv, storitev.naziv
//$table2 .= '</tbody></table>';
$table2 .= '</table><br>';
$html .= $table2;
/*TCPDF::writeHTML 	( $html, $ln=true, $fill=false, $reseth=false,	$cell=false, $align='') 	*/
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=$, $table2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMl($html);
$pdf->Output('Račun št. '.$racun_id.'.pdf', 'I');
?>
