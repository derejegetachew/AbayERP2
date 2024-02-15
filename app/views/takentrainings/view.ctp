
var store_takentraining_stafftooktrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','takentraining','employee','position','branch','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'list_data', $takentraining['Takentraining']['id'])); ?>'	})
});
		
<?php $takentraining_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Training', true) . ":</th><td><b>" . $takentraining['Training']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('From', true) . ":</th><td><b>" . $takentraining['Takentraining']['from'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To', true) . ":</th><td><b>" . $takentraining['Takentraining']['to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Half Day', true) . ":</th><td><b>" . $takentraining['Takentraining']['half_day'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Trainingvenue', true) . ":</th><td><b>" . $takentraining['Trainingvenue']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Cost Per Person', true) . ":</th><td><b>" . $takentraining['Takentraining']['cost_per_person'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Trainer', true) . ":</th><td><b>" . $takentraining['Trainer']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Trainingtarget', true) . ":</th><td><b>" . $takentraining['Trainingtarget']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Certification', true) . ":</th><td><b>" . $takentraining['Takentraining']['certification'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $takentraining['Takentraining']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $takentraining['Takentraining']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var takentraining_view_panel_1 = {
			html : '<?php echo $takentraining_html; ?>',
			frame : true,
			height: 80
		}
		var takentraining_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_takentraining_stafftooktrainings,
				title: '<?php __('Stafftooktrainings'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_takentraining_stafftooktrainings.getCount() == '')
							store_takentraining_stafftooktrainings.reload();
					}
				},
				columns: [
					{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true}
,					{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_takentraining_stafftooktrainings,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var TakentrainingViewWindow = new Ext.Window({
			title: '<?php __('View Takentraining'); ?>: <?php echo $takentraining['Takentraining']['id']; ?>',
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
				takentraining_view_panel_1,
				takentraining_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TakentrainingViewWindow.close();
				}
			}]
		});
