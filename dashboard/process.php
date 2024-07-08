<?php
	switch ($Act){
		
		case 'transactions':
			include  "transactions.php" ;
			break;
		case 'reportfraud':
			include  "reportfraud.php" ;
			break;
		case 'alertsettings':
			include  "alertsettings.php" ;
			break;
		case 'reportissue':
			include  "reportissue.php" ;
			break;
		case 'saleuser':
			include  "saleuser.php" ;
			break;
		case 'trackingcode':
			include  "getcode.php" ;
			break;
		case 'alerts':
			include  "alerts.php" ;
		break;
		case 'home':
			include  "home.php" ;
		break;
		case 'homenew':
			include  "homenew.php" ;
		break;
		
		case 'campaign': 
			include  "campaign.php" ;
		break;
		case 'campaign_type': 
			include  "campaign_type.php" ;
		break;
		case 'add_compaign': 
			include  "add_compaign.php" ;
		break;
		
		case 'standard': 
			include  "standard.php" ;
		break;
		
		case 'custom': 
			include  "custom.php" ;
		break;
		
		case 'slide_up': 
			include  "slide_up.php" ;
		break;
			
		case 'paymentlist':
		//   include  'payment_link.php';
			include  "payment_list.php" ;
		break;
		
		case 'transaction_merchant':
			include 'report_links.php';
			include "transaction_menu.php";
			// include "transaction_help.php";
			include 'transaction_mercahnt.php';
		break;
		
		case 'all_submissions':
			include 'all_submissions.php';
		break;
		
		case 'submission_view':
			include 'submission_view.php';
		break;
		
		case 'submission_list':
			include 'submission_list.php';
		break;
		
		case 'revenues':
			include 'report_links.php';
			include "transaction_menu.php";
			include 'revenues.php';
		break;
		
		case 'manual_payments':
			include  'payment_link.php';
			include  "manual_payments.php" ;
		break;
	
		case 'paid_mails':
			include  'payment_link.php';
			include  "paid_mails.php" ;
		break;
		
		case 'accounts':
			include 'accounts.php';
		break;
		
		case 'upgrade':
			include 'upgrade.php';
		break;
		
		case 'GetCode':
			// include 'GetCode.php';
			include 'setVariables.php';
		break;
		
		case 'getTrackingCode': 
			include 'GetCode.php';
		break;
		
		case 'listaffiliate':
			include 'total_affiliates.php';
		break;
		
		case 'waitingaff':
			include 'waiting_affiliates.php';
		break;
	
		case 'waitingpgm':
			include 'waiting_pgms.php';
		break;
		
		case 'waitrotator':
			include 'waitrotator.php';
		break;
		
		case 'programs1':
			include 'programs.php';
		break;
		
		case 'programs':
			include 'programs.php';
		break;
		
		case 'newprogram':
			include 'newprogram.php';
		break;
		
		case 'programedit':
			include 'programedit.php';
		break;
	
		case  'emails':
			include 'mer_mail.php';
		break;
		
		case 'reports':
			include 'reports.php';

		case 'forperiod':
			include 'report_links.php';
			include 'forperiod.php';
		break;
		
		case 'ProgramReport':
			include 'report_links.php';
			include 'report_programs.php';
		break;
	 
		case 'affiliates':
			include 'search_affiliate.php';
			include 'affiliates_help.php';
			include 'affiliates.php';
		break;
		
		case 'coupons':
			include 'coupons.php';
		break;
		
		case 'add_coupon':
			include 'add_coupon.php';
		break;
		
		case  'AffiliateReport':
			include 'report_links.php';
			include 'report_affiliates.php';
		break;
		
		case  'LinkReport':
			include 'report_links.php';
			include 'link_report3.php';
		break;
	
		case  'ProductReport':
			include 'report_links.php';
			include 'product_report.php';
		break;
		
		case  'reversesale':
			include 'reverse_sale.php';
		break;
		
		case  'addlinks':
			include 'add_links.php';
		break;
		
		case  'add_banner':
			include 'add_banner.php';
		break;
		
		case  'add_text':
			include 'add_text.php';
		break;
		
		case 'add_textnew':
			include 'add_text_new.php';
		break;
		
		case  'add_flash':
			include 'add_flash.php';
		break;
		
		case  'add_html':
			include 'add_html.php';
		break;
		
		case  'add_popup':
			include 'add_popup.php';
		break;
		
		case  'edit_banner':
			include 'edit_banner.php';
		break;
		
		case  'group':
			include 'group.php';
		break;
		
		case  'add_group':
			include 'add_group.php';
		break;
		
		case  'edit_group':
			include 'edit_group.php';
		break;
		
		case  'paidmail':
			include 'paidmail.php';
		break;
		
		case  'affiliate_page':
			include 'affiliate_page.php';
		break;
		
		case  'add_money':
			include 'add_money.php';
		break;
		
		case  'uploadProducts':
			include 'upload_product.php';
		break;
		
		case  'recurring':
			include 'report_links.php';
			include 'recurring.php';
		break;
		
		case  'ViewRecurringDetails':
			include 'report_links.php';
			include 'view_recur_details.php';
		break;
		
		case  'ViewTransactionDetails':
			include 'report_links.php';
			include 'view_trans_details.php';
		break;
		
		case  'graph_return':
			include 'report_links.php';
			include 'graph_menu.php';
			include 'graph_returndays.php';
		break;
		
		case  'graph_affiliate':
			include 'report_links.php';
			include 'graph_menu.php';
			include 'graph_affiliate.php';
		break;
		
		case  'graph_distribution':
			include 'report_links.php';
			include 'graph_menu.php';
			include 'graph_distribution.php';
		break;
		
		case  'graph_bubble':
			include 'report_links.php';
			include 'graph_menu.php';
			include 'graph_bubble.php';
		break;
		case  'statistics':
			include 'statistics.php';
		break;

	}
?>