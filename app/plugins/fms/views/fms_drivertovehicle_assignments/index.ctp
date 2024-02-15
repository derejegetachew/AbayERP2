
var store_fmsDrivertovehicleAssignments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_driver','fms_vehicle','start_date','end_date','created_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'fms_driver', direction: "ASC"},
	groupField: 'fms_vehicle'
});


function AddFmsDrivertovehicleAssignment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsDrivertovehicleAssignment_data = response.responseText;
			
			eval(fmsDrivertovehicleAssignment_data);
			
			FmsDrivertovehicleAssignmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver to vehicle Assignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsDrivertovehicleAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsDrivertovehicleAssignment_data = response.responseText;
			
			eval(fmsDrivertovehicleAssignment_data);
			
			FmsDrivertovehicleAssignmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver to vehicle Assignment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsDrivertovehicleAssignment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsDrivertovehicleAssignment_data = response.responseText;

            eval(fmsDrivertovehicleAssignment_data);

            FmsDrivertovehicleAssignmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver to vehicle Assignment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsDrivertovehicleAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsDrivertovehicleAssignment successfully deleted!'); ?>');
			RefreshFmsDrivertovehicleAssignmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver to vehicle Assignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsDrivertovehicleAssignment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsDrivertovehicleAssignment_data = response.responseText;

			eval(fmsDrivertovehicleAssignment_data);

			fmsDrivertovehicleAssignmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Driver to vehicle Assignment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsDrivertovehicleAssignmentName(value){
	var conditions = '\'FmsDrivertovehicleAssignment.name LIKE\' => \'%' + value + '%\'';
	store_fmsDrivertovehicleAssignments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsDrivertovehicleAssignmentData() {
	store_fmsDrivertovehicleAssignments.reload();
}


if(center_panel.find('id', 'fmsDrivertovehicleAssignment-tab') != "") {
	var p = center_panel.findById('fmsDrivertovehicleAssignment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Driver to vehicle Assignments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsDrivertovehicleAssignment-tab',
		xtype: 'grid',
		store: store_fmsDrivertovehicleAssignments,
		columns: [
			{header: "<?php __('Driver'); ?>", dataIndex: 'fms_driver', sortable: true},
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
			{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsDrivertovehicleAssignments" : "FmsDrivertovehicleAssignment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsDrivertovehicleAssignment(Ext.getCmp('fmsDrivertovehicleAssignment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Driver to vehicle Assignments</b><br />Click here to create a new Driver to vehicle Assignment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsDrivertovehicleAssignment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsDrivertovehicleAssignment',
					tooltip:'<?php __('<b>Edit Driver to vehicle Assignments</b><br />Click here to modify the selected Driver to vehicle Assignment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsDrivertovehicleAssignment(sel.data.id);
						};
					}
				}/*, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsDrivertovehicleAssignment',
					tooltip:'<?php __('<b>Delete Driver to vehicle Assignments(s)</b><br />Click here to remove the selected Driver to vehicle Assignment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Driver to vehicle Assignment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsDrivertovehicleAssignment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Driver to vehicle Assignment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Driver to vehicle Assignments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsDrivertovehicleAssignment(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}*/, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Driver to vehicle Assignment'); ?>',
					id: 'view-fmsDrivertovehicleAssignment',
					tooltip:'<?php __('<b>View Driver to vehicle Assignment</b><br />Click here to see details of the selected Driver to vehicle Assignment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsDrivertovehicleAssignment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Driver'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($fms_drivers as $item){if($st) echo ",
							";?>['<?php echo $item['FmsDriver']['id']; ?>' ,'<?php echo $item['Person']['first_name'].' '.$item['Person']['middle_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_fmsDrivertovehicleAssignments.reload({
								params: {
									start: 0,
									limit: list_size,
									fmsdriver_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsDrivertovehicleAssignment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsDrivertovehicleAssignmentName(Ext.getCmp('fmsDrivertovehicleAssignment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsDrivertovehicleAssignment_go_button',
					handler: function(){
						SearchByFmsDrivertovehicleAssignmentName(Ext.getCmp('fmsDrivertovehicleAssignment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsDrivertovehicleAssignment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsDrivertovehicleAssignments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-fmsDrivertovehicleAssignment').enable();
		p.getTopToolbar().findById('delete-fmsDrivertovehicleAssignment').enable();
		p.getTopToolbar().findById('view-fmsDrivertovehicleAssignment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsDrivertovehicleAssignment').disable();
			p.getTopToolbar().findById('view-fmsDrivertovehicleAssignment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsDrivertovehicleAssignment').disable();
			p.getTopToolbar().findById('view-fmsDrivertovehicleAssignment').disable();
			p.getTopToolbar().findById('delete-fmsDrivertovehicleAssignment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-fmsDrivertovehicleAssignment').enable();
			p.getTopToolbar().findById('view-fmsDrivertovehicleAssignment').enable();
			p.getTopToolbar().findById('delete-fmsDrivertovehicleAssignment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-fmsDrivertovehicleAssignment').disable();
			p.getTopToolbar().findById('view-fmsDrivertovehicleAssignment').disable();
			p.getTopToolbar().findById('delete-fmsDrivertovehicleAssignment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsDrivertovehicleAssignments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
