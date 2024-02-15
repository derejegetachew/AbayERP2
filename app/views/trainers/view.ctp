
var store_trainer_takentrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','training','from','to','half_day','trainingvenue','cost_per_person','trainer','trainingtarget','certification','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'list_data', $trainer['Trainer']['id'])); ?>'	})
});
		
<?php $trainer_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $trainer['Trainer']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $trainer['Trainer']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $trainer['Trainer']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $trainer['Trainer']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var trainer_view_panel_1 = {
			html : '<?php echo $trainer_html; ?>',
			frame : true,
			height: 80
		}
		var trainer_view_panel_2 = new Ext.TabPanel({
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
				store: store_trainer_takentrainings,
				title: '<?php __('Takentrainings'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_trainer_takentrainings.getCount() == '')
							store_trainer_takentrainings.reload();
					}
				},
				columns: [
					{header: "<?php __('Training'); ?>", dataIndex: 'training', sortable: true}
,					{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true}
,					{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true}
,					{header: "<?php __('Half Day'); ?>", dataIndex: 'half_day', sortable: true}
,					{header: "<?php __('Trainingvenue'); ?>", dataIndex: 'trainingvenue', sortable: true}
,					{header: "<?php __('Cost Per Person'); ?>", dataIndex: 'cost_per_person', sortable: true}
,					{header: "<?php __('Trainingtarget'); ?>", dataIndex: 'trainingtarget', sortable: true}
,					{header: "<?php __('Certification'); ?>", dataIndex: 'certification', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_trainer_takentrainings,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var TrainerViewWindow = new Ext.Window({
			title: '<?php __('View Trainer'); ?>: <?php echo $trainer['Trainer']['name']; ?>',
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
				trainer_view_panel_1,
				trainer_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TrainerViewWindow.close();
				}
			}]
		});
