
		
<?php $ibdOutstandingExportLc_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Exporter Name', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['exporter_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Lc Fcy', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['total_lc_fcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Lc Amount', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['total_lc_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Outstanding Lc Fcy', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['outstanding_lc_fcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Outstanding Lc Amount', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['outstanding_lc_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Issuing Bank Ref No', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['issuing_bank_ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Our Ref No', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['our_ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Of Issue', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['date_of_issue'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expire Date', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['expire_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Place Of Expire', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['place_of_expire'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Date', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['sett_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Fcy', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['sett_fcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Amount', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['sett_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Reference No', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['sett_reference_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Outstanding Remaining Lc Fcy', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['outstanding_remaining_lc_fcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Outstanding Remaining Lc Value', true) . ":</th><td><b>" . $ibdOutstandingExportLc['IbdOutstandingExportLc']['outstanding_remaining_lc_value'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdOutstandingExportLc_view_panel_1 = {
			html : '<?php echo $ibdOutstandingExportLc_html; ?>',
			frame : true,
			height: 80
		}
		var ibdOutstandingExportLc_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdOutstandingExportLcViewWindow = new Ext.Window({
			title: '<?php __('View IbdOutstandingExportLc'); ?>: <?php echo $ibdOutstandingExportLc['IbdOutstandingExportLc']['id']; ?>',
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
				ibdOutstandingExportLc_view_panel_1,
				ibdOutstandingExportLc_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdOutstandingExportLcViewWindow.close();
				}
			}]
		});
