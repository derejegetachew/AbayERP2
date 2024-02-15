
		
<?php $delinquent_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $delinquent['Delinquent']['Name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Soundex Name', true) . ":</th><td><b>" . $delinquent['Delinquent']['Soundex_Name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Closing Bank', true) . ":</th><td><b>" . $delinquent['Delinquent']['Closing_Bank'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $delinquent['Delinquent']['Branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Account Closed', true) . ":</th><td><b>" . $delinquent['Delinquent']['Date_Account_Closed'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tin', true) . ":</th><td><b>" . $delinquent['Delinquent']['Tin'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Reason_For_Closing', true) . ":</th><td><b>" . $delinquent['Delinquent']['Reason_For_Closing'] . "</b></td></tr>" .
"</table>"; 
?>
		var delinquent_view_panel_1 = {
			html : '<?php echo $delinquent_html; ?>',
			frame : true,
			height: 80
		}
		var delinquent_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var DelinquentViewWindow = new Ext.Window({
			title: '<?php __('View Delinquent'); ?>: <?php echo $delinquent['Delinquent']['id']; ?>',
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
				delinquent_view_panel_1,
				delinquent_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DelinquentViewWindow.close();
				}
			}]
		});
