<?php

//download.php

include('class/Appointment.php');

$object = new Appointment;

require_once('class/pdf.php');

if(isset($_GET["id"]))
{
	$html = '<table border="0" cellpadding="5" cellspacing="5" width="100%" >';


	$html .= '<tr><td align="center">';
			// $html .= '<img src="'.substr($hospital_row['hospital_logo'], 3).'" /><br />';
	$html .= '<img src="img/logo.jpg" /><br />';
		
	$html .= '<h2 align="center">Hospital Management System</h2>
		<p align="center"><b>Address - </b>Can Tho Viet Nam</p>
		<p align="center"><b>Contact No. - </b>0123456789</p></td></tr>
	';
	

	$html .= "
	<tr><td><hr /></td></tr>
	<tr><td>
	";

	$object->query = "
	SELECT * FROM prescription
	WHERE prescription_id = '".$_GET["id"]."'
	";

	$prescription_data = $object->get_result();

	foreach($prescription_data as $prescription_row)
	{
		
		$object->query = "
		SELECT * FROM doctor_table 
		WHERE doctor_id = '".$prescription_row["doctor_id"]."'
		";

		$doctor_data = $object->get_result();

		$html .= '
		<h4 align="center">Doctor Details</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%"> ';

		foreach($doctor_data as $doctor_row)
		{
			$html .= '
			<tr><th width="50%" align="right">Doctor Name</th><td>'.$doctor_row["doctor_name"].'</td></tr>
			<tr><th width="50%" align="right">Doctor Spec</th><td>'.$doctor_row["doctor_expert_in"].' '.$doctor_row["doctor_degree"].'</td></tr>';
		}

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$prescription_row["patient_id"]."'
		";

		$patient_data = $object->get_result();
		
		$html .= '</table><br /><hr />
		<h4 align="center">Patient Details</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">';

		foreach($patient_data as $patient_row)
		{
			$html .= '<tr><th width="50%" align="right">Patient Name</th><td>'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td></tr>
			<tr><th width="50%" align="right">Contact No.</th><td>'.$patient_row["patient_phone_no"].'</td></tr>
			<tr><th width="50%" align="right">Address</th><td>'.$patient_row["patient_address"].'</td></tr>';
		}

		
		$html .= "</table><br />
		<tr><td></td></tr>
		<tr><td>
		";
		$html .= '<hr />
		<h4 align="center">Prescription Details</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%" page-break-after="always">
			<tr>
				<th width="50%" align="right">Prescription No.</th>
				<td>'.$prescription_row["prescription_id"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Prescription date</th>
				<td>'.$prescription_row["prescription_date"].'</td>
			</tr>
		';

		
		$object->query = "
		SELECT * FROM medicine
		WHERE prescription_id = '".$prescription_row["prescription_id"]."'
		";

		$med_data = $object->get_result();
		
		$html .= '</table><br />
		<h4 align="center">Medicine List</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">';

		foreach($med_data as $med_row)
		{
			$html .= '<tr><th width="50%" align="right">Med Name</th><td>'.$med_row["medicine_name"].'</td></tr>
			<tr><th width="50%" align="right">Unit</th><td>'.$med_row["unit"].'</td></tr>
			<tr><th width="50%" align="right">Dosage</th><td>'.$med_row["dosage"].'</td></tr>';
		}

		$html .= '
		</table>
		';
	}

	$html .= '
			</td>
		</tr>
	</table>';

	echo $html;

	$pdf = new Pdf();

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>