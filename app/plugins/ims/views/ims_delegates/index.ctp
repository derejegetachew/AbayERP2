
var store_imsDelegates = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_requisition','user','name','phone','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_requisition_id', direction: "ASC"},
	groupField: 'user_id'
});


function AddImsDelegate() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsDelegate_data = response.responseText;
			
			eval(imsDelegate_data);
			
			ImsDelegateAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsDelegate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsDelegate_data = response.responseText;
			
			eval(imsDelegate_data);
			
			ImsDelegateEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDelegate(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsDelegate_data = response.responseText;

            eval(imsDelegate_data);

            ImsDelegateViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsDelegate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDelegate successfully deleted!'); ?>');
			RefreshImsDelegateData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDelegate add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsDelegate(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsDelegate_data = response.responseText;

			eval(imsDelegate_data);

			imsDelegateSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsDelegate search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsDelegateName(value){
	var conditions = '\'ImsDelegate.name LIKE\' => \'%' + value + '%\'';
	store_imsDelegates.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsDelegateData() {
	store_imsDelegates.reload();
}


if(center_panel.find('id', 'imsDelegate-tab') != "") {
	var p = center_panel.findById('imsDelegate-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Delegates'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsDelegate-tab',
		xtype: 'grid',
		store: store_imsDelegates,
		columns: [
			{header: "<?php __('ImsRequisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Phone'); ?>", dataIndex: 'phone', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsDelegates" : "ImsDelegate"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsDelegate(Ext.getCmp('imsDelegate-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsDelegates</b><br />Click here to create a new ImsDelegate'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsDelegate();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsDelegate',
					tooltip:'<?php __('<b>Edit ImsDelegates</b><br />Click here to modify the selected ImsDelegate'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsDelegate(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsDelegate',
					tooltip:'<?php __('<b>Delete ImsDelegates(s)</b><br />Click here to remove the selected ImsDelegate(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsDelegate'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsDelegate(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsDelegate'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsDelegates'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsDelegate(sel_ids);
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
					text: '<?php __('View ImsDelegate'); ?>',
					id: 'view-imsDelegate',
					tooltip:'<?php __('<b>View ImsDelegate</b><br />Click here to see details of the selected ImsDelegate'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsDelegate(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsRequisition'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsrequisitions as $item){if($st) echo ",
							";?>['<?php echo $item['ImsRequisition']['id']; ?>' ,'<?php echo $item['ImsRequisition']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsDelegates.reload({
								params: {
									start: 0,
									limit: list_size,
									imsrequisition_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsDelegate_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsDelegateName(Ext.getCmp('imsDelegate_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsDelegate_go_button',
					handler: function(){
						SearchByImsDelegateName(Ext.getCmp('imsDelegate_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsDelegate();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsDelegates,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsDelegate').enable();
		p.getTopToolbar().findById('delete-imsDelegate').enable();
		p.getTopToolbar().findById('view-imsDelegate').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDelegate').disable();
			p.getTopToolbar().findById('view-imsDelegate').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDelegate').disable();
			p.getTopToolbar().findById('view-imsDelegate').disable();
			p.getTopToolbar().findById('delete-imsDelegate').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsDelegate').enable();
			p.getTopToolbar().findById('view-imsDelegate').enable();
			p.getTopToolbar().findById('delete-imsDelegate').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsDelegate').disable();
			p.getTopToolbar().findById('view-imsDelegate').disable();
			p.getTopToolbar().findById('delete-imsDelegate').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsDelegates.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
