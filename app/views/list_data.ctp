{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($loanDisbursementRequests as $loan_disbursement_request){ if($st) echo ","; ?>			{
				"id":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['id']; ?>",
				"name_of_applicants":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['name_of_applicants']; ?>",
				"purpose_of_loan":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['purpose_of_loan']; ?>",
				"branch":"<?php echo $get_all_branches[$loan_disbursement_request['LoanDisbursementRequest']['branch']]; ?>",
				"approval_committee":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['approval_committee']; ?>",
				"date_of_approval":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['date_of_approval']; ?>",
				"sector":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['sector']; ?>",
				"company_size":"<?php 
				if($loan_disbursement_request['LoanDisbursementRequest']['company_size'] == 1){
						echo "Coorporate customer";
				}
				if($loan_disbursement_request['LoanDisbursementRequest']['company_size'] == 2){
					echo "Small & Medium enterprise";
				}
				
				?>",
				"amount_approved":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['amount_approved']; ?>",
				"disbursement_amount_requested":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['disbursement_amount_requested']; ?>",
				"amount_disbursed":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['amount_disbursed']; ?>",
				"undisbursed_amount":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['undisbursed_amount']; ?>",
				"fcy_generated":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['fcy_generated']; ?>",
				"date_dsb_requested":"<?php echo $loan_disbursement_request['LoanDisbursementRequest']['date_dsb_requested']; ?>",
				"approval_status":"<?php 
				if($loan_disbursement_request['LoanDisbursementRequest']['approval_status'] == 1){
						echo "Pending";
				}
				if($loan_disbursement_request['LoanDisbursementRequest']['approval_status'] == 2){
					echo "Approved";
				}
				if($loan_disbursement_request['LoanDisbursementRequest']['approval_status'] == 3){
					echo "Rejected";
				}
				
				?>"
			}
<?php $st = true; } ?>		]
}