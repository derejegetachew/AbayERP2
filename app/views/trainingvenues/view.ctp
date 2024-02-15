
var store_trainingvenue_takentrainings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','training','from','to','half_day','trainingvenue','cost_per_person','trainer','trainingtarget','certification','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'list_data', $trainingvenue['Trainingvenue']['id'])); ?>'	})
});
		
<?php $trainingvenue_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $trainingvenue['Trainingvenue']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Address', true) . ":</th><td><b>" . $trainingvenue['Trainingvenue']['address'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $trainingvenue['Trainingvenue']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $trainingvenue['Trainingvenue']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var trainingvenue_view_panel_1 = {
			html : '<?php echo $trainingvenue_html; ?>',
			frame : true,
			height: 80
		}
		var trainingvenue_view_panel_2 = new Ext.TabPanel({
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
				store: store_trainingvenue_takentrainings,
				title: '<?php __('Takentrainings'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_trainingvenue_takentrainings.getCount() == '')
							store_trainingvenue_takentrainings.reload();
					}
				},
				columns: [
					{header: "<?php __('Training'); ?>", dataIndex: 'training', sortable: true}
,					{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true}
,					{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true}
,					{header: "<?php __('Half Day'); ?>", dataIndex: 'half_day', sortable: true}
,					{header: "<?php __('Cost Per Person'); ?>", dataIndex: 'cost_per_person', sortable: true}
,					{header: "<?php __('Trainer'); ?>", dataIndex: 'trainer', sortable: true}
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
					store: store_trainingvenue_takentrainings,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var TrainingvenueViewWindow = new Ext.Window({
			title: '<?php __('View Trainingvenue'); ?>: <?php echo $trainingvenue['Trainingvenue']['name']; ?>',
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
				trainingvenue_view_panel_1,
				trainingvenue_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					TrainingvenueViewWindow.close();
				}
			}]
		});
