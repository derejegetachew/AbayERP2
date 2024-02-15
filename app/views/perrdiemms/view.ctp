
		
<?php $perrdiemm_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Employee', true) . ":</th><td><b>" . $perrdiemm['Employee']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payroll', true) . ":</th><td><b>" . $perrdiemm['Payroll']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Days', true) . ":</th><td><b>" . $perrdiemm['Perrdiemm']['days'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rate', true) . ":</th><td><b>" . $perrdiemm['Perrdiemm']['rate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Taxable', true) . ":</th><td><b>" . $perrdiemm['Perrdiemm']['taxable'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $perrdiemm['Perrdiemm']['date'] . "</b></td></tr>" . 
"</table>"; 
?>
		var perrdiemm_view_panel_1 = {
			html : '<?php echo $perrdiemm_html; ?>',
			frame : true,
			height: 80
		}
		var perrdiemm_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PerrdiemmViewWindow = new Ext.Window({
			title: '<?php __('View Perrdiemm'); ?>: <?php echo $perrdiemm['Perrdiemm']['id']; ?>',
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
				perrdiemm_view_panel_1,
				perrdiemm_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PerrdiemmViewWindow.close();
				}
			}]
		});
