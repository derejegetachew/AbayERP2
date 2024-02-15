
		
<?php $ibdOdbp_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name Of Exporter', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['name_of_exporter'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ref No', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency Code', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['currency_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Fct', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['fct'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lcy', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['lcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Fcy', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['sett_fcy'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Amount', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['sett_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sett Date', true) . ":</th><td><b>" . $ibdOdbp['IbdOdbp']['sett_date'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ibdOdbp_view_panel_1 = {
			html : '<?php echo $ibdOdbp_html; ?>',
			frame : true,
			height: 80
		}
		var ibdOdbp_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var IbdOdbpViewWindow = new Ext.Window({
			title: '<?php __('View IbdOdbp'); ?>: <?php echo $ibdOdbp['IbdOdbp']['id']; ?>',
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
				ibdOdbp_view_panel_1,
				ibdOdbp_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdOdbpViewWindow.close();
				}
			}]
		});
