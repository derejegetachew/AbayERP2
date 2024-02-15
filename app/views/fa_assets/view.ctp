
		
<?php $faAsset_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Reference', true) . ":</th><td><b>" . $faAsset['FaAsset']['reference'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $faAsset['FaAsset']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Book Value', true) . ":</th><td><b>" . $faAsset['FaAsset']['book_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Book Date', true) . ":</th><td><b>" . $faAsset['FaAsset']['book_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sold', true) . ":</th><td><b>" . $faAsset['FaAsset']['sold'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sold Date', true) . ":</th><td><b>" . $faAsset['FaAsset']['sold_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Rate', true) . ":</th><td><b>" . $faAsset['FaAsset']['tax_rate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Tax Cat', true) . ":</th><td><b>" . $faAsset['FaAsset']['tax_cat'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Class', true) . ":</th><td><b>" . $faAsset['FaAsset']['ifrs_class'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Cat', true) . ":</th><td><b>" . $faAsset['FaAsset']['ifrs_cat'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ifrs Useful Age', true) . ":</th><td><b>" . $faAsset['FaAsset']['ifrs_useful_age'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Residual Value Rate', true) . ":</th><td><b>" . $faAsset['FaAsset']['residual_value_rate'] . "</b></td></tr>" . 
"</table>"; 
?>
		var faAsset_view_panel_1 = {
			html : '<?php echo $faAsset_html; ?>',
			frame : true,
			height: 80
		}
		var faAsset_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FaAssetViewWindow = new Ext.Window({
			title: '<?php __('View FaAsset'); ?>: <?php echo $faAsset['FaAsset']['name']; ?>',
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
				faAsset_view_panel_1,
				faAsset_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FaAssetViewWindow.close();
				}
			}]
		});
