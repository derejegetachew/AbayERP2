
var store_frwfmEvents = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','user','action','remark','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'frwfm_application_id', direction: "ASC"},
	groupField: 'user_id'
});


function AddFrwfmEvent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var frwfmEvent_data = response.responseText;
			
			eval(frwfmEvent_data);
			
			FrwfmEventAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFrwfmEvent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var frwfmEvent_data = response.responseText;
			
			eval(frwfmEvent_data);
			
			FrwfmEventEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmEvent(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var frwfmEvent_data = response.responseText;

            eval(frwfmEvent_data);

            FrwfmEventViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFrwfmEvent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmEvent successfully deleted!'); ?>');
			RefreshFrwfmEventData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFrwfmEvent(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'search')); ?>',
		success: function(response, opts){
			var frwfmEvent_data = response.responseText;

			eval(frwfmEvent_data);

			frwfmEventSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the frwfmEvent search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFrwfmEventName(value){
	var conditions = '\'FrwfmEvent.name LIKE\' => \'%' + value + '%\'';
	store_frwfmEvents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFrwfmEventData() {
	store_frwfmEvents.reload();
}


if(center_panel.find('id', 'frwfmEvent-tab') != "") {
	var p = center_panel.findById('frwfmEvent-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Frwfm Events'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmEvent-tab',
		xtype: 'grid',
		store: store_frwfmEvents,
		columns: [
			{header: "<?php __('FrwfmApplication'); ?>", dataIndex: 'frwfm_application', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmEvents" : "FrwfmEvent"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFrwfmEvent(Ext.getCmp('frwfmEvent-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add FrwfmEvents</b><br />Click here to create a new FrwfmEvent'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFrwfmEvent();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-frwfmEvent',
					tooltip:'<?php __('<b>Edit FrwfmEvents</b><br />Click here to modify the selected FrwfmEvent'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFrwfmEvent(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-frwfmEvent',
					tooltip:'<?php __('<b>Delete FrwfmEvents(s)</b><br />Click here to remove the selected FrwfmEvent(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmEvent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFrwfmEvent(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmEvent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected FrwfmEvents'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFrwfmEvent(sel_ids);
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
					text: '<?php __('View FrwfmEvent'); ?>',
					id: 'view-frwfmEvent',
					tooltip:'<?php __('<b>View FrwfmEvent</b><br />Click here to see details of the selected FrwfmEvent'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFrwfmEvent(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('FrwfmApplication'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($frwfmapplications as $item){if($st) echo ",
							";?>['<?php echo $item['FrwfmApplication']['id']; ?>' ,'<?php echo $item['FrwfmApplication']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_frwfmEvents.reload({
								params: {
									start: 0,
									limit: list_size,
									frwfmapplication_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'frwfmEvent_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFrwfmEventName(Ext.getCmp('frwfmEvent_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'frwfmEvent_go_button',
					handler: function(){
						SearchByFrwfmEventName(Ext.getCmp('frwfmEvent_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFrwfmEvent();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_frwfmEvents,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-frwfmEvent').enable();
		p.getTopToolbar().findById('delete-frwfmEvent').enable();
		p.getTopToolbar().findById('view-frwfmEvent').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmEvent').disable();
			p.getTopToolbar().findById('view-frwfmEvent').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmEvent').disable();
			p.getTopToolbar().findById('view-frwfmEvent').disable();
			p.getTopToolbar().findById('delete-frwfmEvent').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-frwfmEvent').enable();
			p.getTopToolbar().findById('view-frwfmEvent').enable();
			p.getTopToolbar().findById('delete-frwfmEvent').enable();
		}
		else{
			p.getTopToolbar().findById('edit-frwfmEvent').disable();
			p.getTopToolbar().findById('view-frwfmEvent').disable();
			p.getTopToolbar().findById('delete-frwfmEvent').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_frwfmEvents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
