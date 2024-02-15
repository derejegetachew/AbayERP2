
		
<?php $spPlan_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $spPlan['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sp Item', true) . ":</th><td><b>" . $spPlan['SpItem']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Years', true) . ":</th><td><b>" . $spPlan['BudgetYears']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $spPlan['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('March End', true) . ":</th><td><b>" . $spPlan['SpPlan']['march_end'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('June End', true) . ":</th><td><b>" . $spPlan['SpPlan']['june_end'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('July', true) . ":</th><td><b>" . $spPlan['SpPlan']['july'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Auguest', true) . ":</th><td><b>" . $spPlan['SpPlan']['auguest'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('September', true) . ":</th><td><b>" . $spPlan['SpPlan']['september'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('October', true) . ":</th><td><b>" . $spPlan['SpPlan']['october'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('November', true) . ":</th><td><b>" . $spPlan['SpPlan']['november'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('December', true) . ":</th><td><b>" . $spPlan['SpPlan']['december'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('January', true) . ":</th><td><b>" . $spPlan['SpPlan']['january'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('February', true) . ":</th><td><b>" . $spPlan['SpPlan']['february'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('March', true) . ":</th><td><b>" . $spPlan['SpPlan']['march'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('April', true) . ":</th><td><b>" . $spPlan['SpPlan']['april'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('May', true) . ":</th><td><b>" . $spPlan['SpPlan']['may'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('June', true) . ":</th><td><b>" . $spPlan['SpPlan']['june'] . "</b></td></tr>" . 
"</table>"; 
?>
		var spPlan_view_panel_1 = {
			html : '<?php echo $spPlan_html; ?>',
			frame : true,
			height: 80
		}
		var spPlan_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var SpPlanViewWindow = new Ext.Window({
			title: '<?php __('View SpPlan'); ?>: <?php echo $spPlan['SpPlan']['id']; ?>',
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
				spPlan_view_panel_1,
				spPlan_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpPlanViewWindow.close();
				}
			}]
		});
