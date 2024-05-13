<?php
	function generateRows(){
		$contents = '';
		include_once('conn.php');
		
		// استرجاع البيانات من جدول clients
		$sql_clients = "SELECT id,name,subs_DT,EXP_DT,age,plan,amount,phone FROM clients";
		$query_clients = $conn->query($sql_clients);
		while($row = $query_clients->fetch_assoc()){
			$contents .= "
			<tr>
				<td>".$row['id']."</td>
				<td>".$row['name']."</td>
				<td>".$row['subs_DT']."</td>
                <td>".$row['EXP_DT']."</td>
                <td>".$row['age']."</td>
                <td>".$row['plan']."</td>
                <td>".$row['amount']."</td>
                <td>".$row['phone']."</td>
                <td>'EXP'</td> <!-- تاريخ انتهاء الاشتراك لا يوجد في هذا الجدول -->
                <td>'EXP'</td> <!-- المبلغ لا يوجد في هذا الجدول -->
			</tr>
			";
		}

		// استرجاع البيانات من جدول expired_clients
		$sql_expired_clients = "SELECT id,name,EXP_DT,amount,phone FROM expired_clients";
		$query_expired_clients = $conn->query($sql_expired_clients);
		while($row = $query_expired_clients->fetch_assoc()){
			$contents .= "
			<tr>
				<td>".$row['id']."</td>
				<td>".$row['name']."</td>
				<td>'EXP'</td> <!-- تاريخ الاشتراك لا يوجد في هذا الجدول -->
                <td>".$row['EXP_DT']."</td>
                <td>'EXP'</td> <!-- العمر لا يوجد في هذا الجدول -->
                <td>'EXP'</td> <!-- الخطة لا يوجد في هذا الجدول -->
                <td>".$row['amount']."</td>
                <td>".$row['phone']."</td>
                <td></td> <!-- تاريخ انتهاء الاشتراك مكرر لذلك يمكن تركه فارغًا -->
                <td></td> <!-- المبلغ مكرر لذلك يمكن تركه فارغًا -->
			</tr>
			";
		}

		return $contents;
	}

	require_once('tcpdf/tcpdf.php');
   
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $lg = Array();
    $lg['a_meta_charset'] = 'UTF-8';
    $lg['a_meta_dir'] = 'rtl';
    $lg['a_meta_language'] = 'ar';
    $pdf->setLanguageArray($lg);
    $pdf->setRTL(true);
    $pdf->SetFont('aealarabiya', '', 11);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle("clients");
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('aealarabiya');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '11', PDF_MARGIN_RIGHT + 20); // زيادة 20 وحدة للهامش اليمين
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 11);

    $pdf->AddPage();
    $content = '';
    $content .= '
      	<h2 align="center">All Clients</h2>
      	
      	<table border="1" cellspacing="0" cellpadding="3" width="100%">
           <tr>
               <th width="5%">id</th>
               <th width="15%">name</th>
               <th width="15%">subs_DT</th>
               <th width="15%">EXP_DT</th>
               <th width="10%">age</th>
               <th width="15%">plan</th>
               <th width="10%">amount</th>
               <th width="15%">phone</th>
           </tr>
      ';
			 
    $content .= generateRows();
    $content .= '</table>';

    // طباعة تاريخ اليوم والوقت
    $datetime = date('Y-m-d H:i:s');
    $content .= "<br/><br/><p align='right'>Date of this file: $datetime</p>";

    // فتح الملف في نافذة جديدة
    $pdf->writeHTML($content);
    $pdf->Output('clients.pdf', 'D');
?>