
var store_fmsIncidents = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','occurrence_date','occurrence_time','occurrence_place','details','action_taken','created_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'occurrence_date', direction: "ASC"},
	groupField: 'fms_vehicle'
});


function AddFmsIncident() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsIncident_data = response.responseText;
			
			eval(fmsIncident_data);
			
			FmsIncidentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Incident add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsIncident(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsIncident_data = response.responseText;
			
			eval(fmsIncident_data);
			
			FmsIncidentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Incident edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsIncident(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsIncident_data = response.responseText;

            eval(fmsIncident_data);

            FmsIncidentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Incident view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsIncident(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Incident successfully deleted!'); ?>');
			RefreshFmsIncidentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Incident add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsIncident(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsIncident_data = response.responseText;

			eval(fmsIncident_data);

			fmsIncidentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Incident search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsIncidentName(value){
	var conditions = '\'FmsIncident.name LIKE\' => \'%' + value + '%\'';
	store_fmsIncidents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsIncidentData() {
	store_fmsIncidents.reload();
}


if(center_panel.find('id', 'fmsIncident-tab') != "") {
	var p = center_panel.findById('fmsIncident-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Incidents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsIncident-tab',
		xtype: 'grid',
		store: store_fmsIncidents,
		columns: [
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Occurrence Date'); ?>", dataIndex: 'occurrence_date', sortable: true},
			{header: "<?php __('Occurrence Time'); ?>", dataIndex: 'occurrence_time', sortable: true},
			{header: "<?php __('Occurrence Place'); ?>", dataIndex: 'occurrence_place', sortable: true},
			{header: "<?php __('Details'); ?>", dataIndex: 'details', sortable: true},
			{header: "<?php __('Action Taken'); ?>", dataIndex: 'action_taken', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Incidents" : "Incident"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsIncident(Ext.getCmp('fmsIncident-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Incidents</b><br />Click here to create a new Incident'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsIncident();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsIncident',
					tooltip:'<?php __('<b>Edit Incidents</b><br />Click here to modify the selected Incident'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsIncident(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsIncident',
					tooltip:'<?php __('<b>Delete Incidents(s)</b><br />Click here to remove the selected Incident(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Incident'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.fms_vehicle+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsIncident(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Incident'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Incidents'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsIncident(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Incident'); ?>',
					id: 'view-fmsIncident',
					tooltip:'<?php __('<b>View Incident</b><br />Click here to see details of the selected Incident'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsIncident(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Vehicle'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($fms_vehicles as $item){if($st) echo ",
							";?>['<?php echo $item['FmsVehicle']['id']; ?>' ,'<?php echo $item['FmsVehicle']['plate_no']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_fmsIncidents.reload({
								params: {
									start: 0,
									limit: list_size,
									fmsvehicle_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsIncident_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsIncidentName(Ext.getCmp('fmsIncident_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsIncident_go_button',
					handler: function(){
						SearchByFmsIncidentName(Ext.getCmp('fmsIncident_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsIncident();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsIncidents,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-fmsIncident').enable();
		p.getTopToolbar().findById('delete-fmsIncident').enable();
		p.getTopToolbar().findById('view-fmsIncident').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsIncident').disable();
			p.getTopToolbar().findById('view-fmsIncident').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsIncident').disable();
			p.getTopToolbar().findById('view-fmsIncident').disable();
			p.getTopToolbar().findById('delete-fmsIncident').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-fmsIncident').enable();
			p.getTopToolbar().findById('view-fmsIncident').enable();
			p.getTopToolbar().findById('delete-fmsIncident').enable();
		}
		else{
			p.getTopToolbar().findById('edit-fmsIncident').disable();
			p.getTopToolbar().findById('view-fmsIncident').disable();
			p.getTopToolbar().findById('delete-fmsIncident').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsIncidents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
