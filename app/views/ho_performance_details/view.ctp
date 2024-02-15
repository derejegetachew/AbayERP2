
		
<?php $hoPerformanceDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Objective', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['objective'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Perspective', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['perspective'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plan Description', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['plan_description'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Plan In Number', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['plan_in_number'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Actual Result', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['actual_result'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Measure', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['measure'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Weight', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['weight'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Accomplishment', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['accomplishment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Score', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['total_score'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Final Score', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['final_score'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Five Pointer Min Included', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['five_pointer_min_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Five Pointer Max', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['five_pointer_max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Four Pointer Min Included', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['four_pointer_min_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Four Pointer Max', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['four_pointer_max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Three Pointer Min Included', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['three_pointer_min_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Three Pointer Max', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['three_pointer_max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Two Pointer Min Included', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['two_pointer_min_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Two Pointer Max', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['two_pointer_max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('One Pointer Min Included', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['one_pointer_min_included'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('One Pointer Max', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformanceDetail']['one_pointer_max'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ho Performance Plan', true) . ":</th><td><b>" . $hoPerformanceDetail['HoPerformancePlan']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var hoPerformanceDetail_view_panel_1 = {
			html : '<?php echo $hoPerformanceDetail_html; ?>',
			frame : true,
			height: 80
		}
		var hoPerformanceDetail_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var HoPerformanceDetailViewWindow = new Ext.Window({
			title: '<?php __('View HoPerformanceDetail'); ?>: <?php echo $hoPerformanceDetail['HoPerformanceDetail']['id']; ?>',
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
				hoPerformanceDetail_view_panel_1,
				hoPerformanceDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					HoPerformanceDetailViewWindow.close();
				}
			}]
		});
