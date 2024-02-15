
		
<?php  $misLetterDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Applicant', true) . ":</th><td><b>" . $misLetterDetail['MisLetter']['applicant'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Of', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['account_of'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Number', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['account_number'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $misLetterDetail['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $misLetterDetail['CreatedUser']['Person']['first_name']." ".$misLetterDetail['CreatedUser']['Person']['middle_name']." ".$misLetterDetail['CreatedUser']['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Replied By', true) . ":</th><td><b>" . $misLetterDetail['RepliedUser']['Person']['first_name']." ".$misLetterDetail['RepliedUser']['Person']['middle_name']." ".$misLetterDetail['RepliedUser']['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Completed By', true) . ":</th><td><b>" . $misLetterDetail['CompletedUser']['Person']['first_name']." ".$misLetterDetail['CompletedUser']['Person']['middle_name']." ".$misLetterDetail['CompletedUser']['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Letter Prepared By', true) . ":</th><td><b>" . $misLetterDetail['LetterPreparedUser']['Person']['first_name']." ".$misLetterDetail['LetterPreparedUser']['Person']['middle_name']." ".$misLetterDetail['LetterPreparedUser']['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['file'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $misLetterDetail['MisLetterDetail']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var misLetterDetail_view_panel_1 = {
			html : '<?php echo $misLetterDetail_html; ?>',
			frame : true,
			height: 190
		}
		var misLetterDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:80,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var MisLetterDetailViewWindow = new Ext.Window({
			title: '<?php __('View Letter Detail'); ?>',
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
				misLetterDetail_view_panel_1,
				misLetterDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					MisLetterDetailViewWindow.close();
				}
			}]
		});
