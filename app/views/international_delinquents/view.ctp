
		
<?php $internationalDelinquent_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $internationalDelinquent['InternationalDelinquent']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Nationality', true) . ":</th><td><b>" . $internationalDelinquent['InternationalDelinquent']['Nationality'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('BOD', true) . ":</th><td><b>" . $internationalDelinquent['InternationalDelinquent']['BOD'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $internationalDelinquent['InternationalDelinquent']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $internationalDelinquent['InternationalDelinquent']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var internationalDelinquent_view_panel_1 = {
			html : '<?php echo $internationalDelinquent_html; ?>',
			frame : true,
			height: 80
		}
		var internationalDelinquent_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var InternationalDelinquentViewWindow = new Ext.Window({
			title: '<?php __('View InternationalDelinquent'); ?>: <?php echo $internationalDelinquent['InternationalDelinquent']['name']; ?>',
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
				internationalDelinquent_view_panel_1,
				internationalDelinquent_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					InternationalDelinquentViewWindow.close();
				}
			}]
		});
