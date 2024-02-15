
		
<?php $bpPlanAttachment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Plan', true) . ":</th><td><b>" . $bpPlanAttachment['Plan']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File Name', true) . ":</th><td><b>" . $bpPlanAttachment['BpPlanAttachment']['file_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Path', true) . ":</th><td><b>" . $bpPlanAttachment['BpPlanAttachment']['path'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $bpPlanAttachment['BpPlanAttachment']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $bpPlanAttachment['BpPlanAttachment']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var bpPlanAttachment_view_panel_1 = {
			html : '<?php echo $bpPlanAttachment_html; ?>',
			frame : true,
			height: 80
		}
		var bpPlanAttachment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var BpPlanAttachmentViewWindow = new Ext.Window({
			title: '<?php __('View BpPlanAttachment'); ?>: <?php echo $bpPlanAttachment['BpPlanAttachment']['id']; ?>',
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
				bpPlanAttachment_view_panel_1,
				bpPlanAttachment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpPlanAttachmentViewWindow.close();
				}
			}]
		});
