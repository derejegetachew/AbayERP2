
var store_bpPlanLogs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_plan','user','type','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'bp_plan_id', direction: "ASC"},
	groupField: 'user_id'
});


function AddBpPlanLog() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpPlanLog_data = response.responseText;
			
			eval(bpPlanLog_data);
			
			BpPlanLogAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpPlanLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpPlanLog_data = response.responseText;
			
			eval(bpPlanLog_data);
			
			BpPlanLogEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlanLog(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpPlanLog_data = response.responseText;

            eval(bpPlanLog_data);

            BpPlanLogViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBpPlanLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanLog successfully deleted!'); ?>');
			RefreshBpPlanLogData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpPlanLog(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanLogs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpPlanLog_data = response.responseText;

			eval(bpPlanLog_data);

			bpPlanLogSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpPlanLog search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpPlanLogName(value){
	var conditions = '\'BpPlanLog.name LIKE\' => \'%' + value + '%\'';
	store_bpPlanLogs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpPlanLogData() {
	store_bpPlanLogs.reload();
}


if(center_panel.find('id', 'bpPlanLog-tab') != "") {
	var p = center_panel.findById('bpPlanLog-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Plan Logs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpPlanLog-tab',
		xtype: 'grid',
		store: store_bpPlanLogs,
		columns: [
			{header: "<?php __('BpPlan'); ?>", dataIndex: 'bp_plan', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpPlanLogs" : "BpPlanLog"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpPlanLog(Ext.getCmp('bpPlanLog-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpPlanLogs</b><br />Click here to create a new BpPlanLog'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpPlanLog();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpPlanLog',
					tooltip:'<?php __('<b>Edit BpPlanLogs</b><br />Click here to modify the selected BpPlanLog'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpPlanLog(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpPlanLog',
					tooltip:'<?php __('<b>Delete BpPlanLogs(s)</b><br />Click here to remove the selected BpPlanLog(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanLog'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpPlanLog(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanLog'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpPlanLogs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpPlanLog(sel_ids);
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
					text: '<?php __('View BpPlanLog'); ?>',
					id: 'view-bpPlanLog',
					tooltip:'<?php __('<b>View BpPlanLog</b><br />Click here to see details of the selected BpPlanLog'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpPlanLog(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('BpPlan'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($bpplans as $item){if($st) echo ",
							";?>['<?php echo $item['BpPlan']['id']; ?>' ,'<?php echo $item['BpPlan']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_bpPlanLogs.reload({
								params: {
									start: 0,
									limit: list_size,
									bpplan_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpPlanLog_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpPlanLogName(Ext.getCmp('bpPlanLog_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpPlanLog_go_button',
					handler: function(){
						SearchByBpPlanLogName(Ext.getCmp('bpPlanLog_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpPlanLog();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpPlanLogs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpPlanLog').enable();
		p.getTopToolbar().findById('delete-bpPlanLog').enable();
		p.getTopToolbar().findById('view-bpPlanLog').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanLog').disable();
			p.getTopToolbar().findById('view-bpPlanLog').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanLog').disable();
			p.getTopToolbar().findById('view-bpPlanLog').disable();
			p.getTopToolbar().findById('delete-bpPlanLog').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpPlanLog').enable();
			p.getTopToolbar().findById('view-bpPlanLog').enable();
			p.getTopToolbar().findById('delete-bpPlanLog').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpPlanLog').disable();
			p.getTopToolbar().findById('view-bpPlanLog').disable();
			p.getTopToolbar().findById('delete-bpPlanLog').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpPlanLogs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
