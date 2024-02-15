
var store_training_plannedtrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','training','cost','Q1','Q2','Q3','Q4','training_target','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'plannedtrainings', 'action' => 'list_data', $training['Training']['id'])); ?>'	})
});
var store_training_takentrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','training','from','to','half_day','venue','cost_per_person','trainer','internal_trainer_name','training_target','certification','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'list_data', $training['Training']['id'])); ?>'	})
});
		
<?php $training_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $training['Training']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $training['Training']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $training['Training']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $training['Training']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var training_view_panel_1 = {
			html : '<?php echo $training_html; ?>',
			frame : true,
			height: 80
		}
		var training_view_panel_2 = new Ext.TabPanel({
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
				store: store_training_plannedtrainings,
				title: '<?php __('Plannedtrainings'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_training_plannedtrainings.getCount() == '')
							store_training_plannedtrainings.reload();
					}
				},
				columns: [
					{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true}
,					{header: "<?php __('Cost'); ?>", dataIndex: 'cost', sortable: true}
,					{header: "<?php __('Q1'); ?>", dataIndex: 'Q1', sortable: true}
,					{header: "<?php __('Q2'); ?>", dataIndex: 'Q2', sortable: true}
,					{header: "<?php __('Q3'); ?>", dataIndex: 'Q3', sortable: true}
,					{header: "<?php __('Q4'); ?>", dataIndex: 'Q4', sortable: true}
,					{header: "<?php __('Training Target'); ?>", dataIndex: 'training_target', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_training_plannedtrainings,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_training_takentrainings,
				title: '<?php __('Takentrainings'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_training_takentrainings.getCount() == '')
							store_training_takentrainings.reload();
					}
				},
				columns: [
					{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true}
,					{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true}
,					{header: "<?php __('Half Day'); ?>", dataIndex: 'half_day', sortable: true}
,					{header: "<?php __('Venue'); ?>", dataIndex: 'venue', sortable: true}
,					{header: "<?php __('Cost Per Person'); ?>", dataIndex: 'cost_per_person', sortable: true}
,					{header: "<?php __('Trainer'); ?>", dataIndex: 'trainer', sortable: true}
,					{header: "<?php __('Internal Trainer Name'); ?>", dataIndex: 'internal_trainer_name', sortable: true}
,					{header: "<?php __('Training Target'); ?>", dataIndex: 'training_target', sortable: true}
,					{header: "<?php __('Certification'); ?>", dataIndex: 'certification', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_training_takentrainings,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var TrainingViewWindow = new Ext.Window({
			title: '<?php __('View Training'); ?>: <?php echo $training['Training']['name']; ?>',
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
				training_view_panel_1,
				training_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TrainingViewWindow.close();
				}
			}]
		});
