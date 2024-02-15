
		
<?php $result = $this->requestAction(
							array(
								'controller' => 'orms_loss_datas', 
								'action' => 'getparent'), 
							array('childid' => $ormsLossData['OrmsLossData']['orms_risk_category_id'])
						);
							$category = explode('~',$result,2);
							
						if($ormsLossData['OrmsLossData']['severity'] == 1){
								$severity= 'Insignificant'; 
							} else if($ormsLossData['OrmsLossData']['severity'] == 2){
								$severity= 'Minor'; 
							} else if($ormsLossData['OrmsLossData']['severity'] == 3){
								$severity= 'Moderate'; 
							} else if($ormsLossData['OrmsLossData']['severity'] == 4){
								$severity= 'Major'; 
							}else if($ormsLossData['OrmsLossData']['severity'] == 5){
								$severity= 'Disastrous'; 
							}	
							
							if($ormsLossData['OrmsLossData']['frequency'] == 1){
								$frequency= 'Rare'; 
							} else if($ormsLossData['OrmsLossData']['frequency'] == 2){
								$frequency= 'Unlikely'; 
							} else if($ormsLossData['OrmsLossData']['frequency'] == 3){
								$frequency= 'Possible'; 
							} else if($ormsLossData['OrmsLossData']['frequency'] == 4){
								$frequency= 'Likely'; 
							}else if($ormsLossData['OrmsLossData']['frequency'] == 5){
								$frequency= 'Almost certain'; 
							}
							
$ormsLossData_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $ormsLossData['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Risk Category', true) . ":</th><td><b>" . $category[1] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Risk sub Category', true) . ":</th><td><b>" . $category[0] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Risk', true) . ":</th><td><b>" . $ormsLossData['OrmsRiskCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['description'] . "</b></td></tr>" . 		 
		"<tr><th align=right>" . __('Occured From', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['occured_from'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Occured To', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['occured_to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Discovered Date', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['discovered_date'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Severity', true) . ":</th><td><b>" . $severity . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Frequency', true) . ":</th><td><b>" . $frequency . "</b></td></tr>" .
		"<tr><th align=right>" . __('Action to be taken', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['action_tobe_taken'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('action taken date', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['action_taken_date'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $ormsLossData['CreatedUser']['Person']['first_name'].' '.$ormsLossData['CreatedUser']['Person']['middle_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved By', true) . ":</th><td><b>" . $ormsLossData['ApprovedUser']['Person']['first_name'].' '.$ormsLossData['ApprovedUser']['Person']['middle_name']. "</b></td></tr>" .	
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $ormsLossData['OrmsLossData']['status'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ormsLossData_view_panel_1 = {
			html : '<?php echo $ormsLossData_html; ?>',
			frame : true,
			height: 350
		}
		var ormsLossData_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:50,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var OrmsLossDataViewWindow = new Ext.Window({
			title: '<?php __('View Loss Data'); ?>',
			width: 500,
			height:450,
			minWidth: 500,
			minHeight: 450,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				ormsLossData_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					OrmsLossDataViewWindow.close();
				}
			}]
		});
