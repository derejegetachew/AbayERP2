
		
<?php $faAssetLog_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Fa Asset', true) . ":</th><td><b>" . $faAssetLog['FaAsset']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Name', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['branch_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Code', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['branch_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Rate', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['tax_rate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Cat', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['tax_cat'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Class', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['class'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Cat', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['ifrs_cat'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Useful Age', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['useful_age'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Residual Value', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['residual_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created At', true) . ":</th><td><b>" . $faAssetLog['FaAssetLog']['created_at'] . "</b></td></tr>" . 
"</table>"; 
?>
		var faAssetLog_view_panel_1 = {
			html : '<?php echo $faAssetLog_html; ?>',
			frame : true,
			height: 80
		}
		var faAssetLog_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FaAssetLogViewWindow = new Ext.Window({
			title: '<?php __('View FaAssetLog'); ?>: <?php echo $faAssetLog['FaAssetLog']['id']; ?>',
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
				faAssetLog_view_panel_1,
				faAssetLog_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FaAssetLogViewWindow.close();
				}
			}]
		});
