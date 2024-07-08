<?php

include('../config.php');
require('invoice.php');

$moneyiddb = $_GET['id'];
$leadgen_ids = $_GET['leadgenid'];

$moneyid = unserialize(base64_decode($moneyiddb));
$leadgen_id = unserialize(base64_decode($leadgen_ids));

 
$sql = select("","id='$moneyid'");
$fetchid = fetch($sql);

$nohack = "select * from av_addmoney where id='$moneyid' and leadgen_id ='$leadgen_id'";
$nohackval 	=	mysqli_query($con,$nohack);	

$idval = 0;
while($rowval = fetch($nohackval)){  
			
	$idval =  $rowval['id'];		
			
			
}

if($idval == '0')
{


header("Location: https://avazai.com");


}
else
{
	
	/////////////GET Total Amount//////////			
			$sql = "select * from av_addmoney where id='$moneyid'";
			$valsql 	=	mysqli_query($con,$sql);	

			while($row = fetch($valsql)){  


				$amount_getall =  $row['amount'];	
				$vat_tax_number_add =  $row['vat_tax_number'];
				$datedb =  $row['date'];  //dd/mm/yyyy 2019-06-14 //y m d
				
				$uktime = strtotime($datedb);
				$mysqldateuk = date('d-m-Y', $uktime);

				
				$Grossval =   ($amount_getall) - ($vat_tax_number_add);
				
			}

$Compnay_name = get_option_meta('Compnay_name');
$Address_name = get_option_meta('Address_name');
$Post_code = get_option_meta('Post_code');
$vat_tax_number = get_option_meta('vat_tax_number');

//// GET to INFO
$first_name = get_user_info($leadgen_id,'first_name',true);
$last_name = get_user_info($leadgen_id,'last_name',true);
$av_company = get_user_info($leadgen_id,'av_company',true);
$av_address = get_user_info($leadgen_id,'av_address',true);
$av_post_code = get_user_info($leadgen_id,'av_post_code',true);
$av_fax = get_user_info($leadgen_id,'av_fax',true);
$av_phone = get_user_info($leadgen_id,'av_phone',true);
$av_category = get_user_info($leadgen_id,'av_category',true);


$todaydate = date($mysqldateuk,"F j, Y"); 



$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete("$Compnay_name\n",	
                  "$Address_name\n" .                 
                  "$Post_code\n" .
                  "TAX/VAT Number: $vat_tax_number\n\n".
				  "To\n\n" .
				  "$av_company\n" .
				  "$av_address\n" .
				  "$av_post_code\n" .
				  "Phone : $av_phone\n" .
				  "TAX/VAT Number: $av_fax\n");
$pdf->fact_dev( "INVOICE", "0000$moneyid" );
$pdf->addNumTVA($mysqldateuk);
$cols=array( "DESCRIPTION"    => 40,
             "CATEGORY"  => 55,
             "QTY"     => 22,
             "NET"      => 26,			 
			 "TAX/VAT"      => 20,
             "GROSS"          =>40);
$pdf->addCols( $cols);
$cols=array( "DESCRIPTION "    => "C",
             "CATEGORY"  => "C",
             "QTY"     => "C",
			 "NET"     => "C",              
             "TAX/VAT"      => "C",			 
             "GROSS"          => "C");
$pdf->addLineFormat($cols);
$pdf->addLineFormat($cols);

$y    = 110;
$line = array( "DESCRIPTION"    => "Amount Credited",
               "CATEGORY"  => "$av_category",
               "QTY"     => "1",
			    "NET"     => "$amount_getall",				
               "TAX/VAT"      => "$vat_tax_number_add", 
				"GROSS"      => "$Grossval");
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;
$pdf->addCadreTVAs();        

$params  = array( "RemiseGlobale" => 1,
                      "remise_tva"     => 1,      
                      "remise"         => 0,      
                      "remise_percent" => 10,     
                  "FraisPort"     => 1,
                      "portTTC"        => 10,     
                                                   
                      "portHT"         => 0,       
                      "portTVA"        => 19.6,    
                  "AccompteExige" => 1,
                      "accompte"         => 0,    
                      "accompte_percent" => 15,    
                  "Notes" => "Make all checks payable to Company Name Payment is due within 30 days\n" );

$pdf->addTVAs($params,$amount_getall ,$Compnay_name);
$pdf->addCadreEurosFrancs();
$pdf->Output();

	
}	





//$posts = base64_encode(serialize($leadgen_id));

 
 //echo $_POSTss = unserialize(base64_decode($posts));


 //echo "-------------".$mcrypt_decrypt  = mcrypt_decrypt('$cryptID');


?>
