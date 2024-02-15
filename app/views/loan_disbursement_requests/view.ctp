
		
<?php $loanDisbursementRequest_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name Of Applicants', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['name_of_applicants'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Purpose Of Loan', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['purpose_of_loan'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approval Committee', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['approval_committee'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Of Approval', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['date_of_approval'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sector', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['sector'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount Approved', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['amount_approved'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Disbursement Amount Requested', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['disbursement_amount_requested'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount Disbursed', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['amount_disbursed'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Undisbursed Amount', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['undisbursed_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fcy Generated', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['fcy_generated'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Dsb Requested', true) . ":</th><td><b>" . $loanDisbursementRequest['LoanDisbursementRequest']['date_dsb_requested'] . "</b></td></tr>" . 
"</table>"; 
?>
		var loanDisbursementRequest_view_panel_1 = {
			html : '<?php echo $loanDisbursementRequest_html; ?>',
			frame : true,
			height: 80
		}
		var loanDisbursementRequest_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var LoanDisbursementRequestViewWindow = new Ext.Window({
			title: '<?php __('View LoanDisbursementRequest'); ?>: <?php echo $loanDisbursementRequest['LoanDisbursementRequest']['id']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				loanDisbursementRequest_view_panel_1,
				loanDisbursementRequest_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LoanDisbursementRequestViewWindow.close();
				}
			}]
		});
