
var store_cmsGroups = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'user_id'
});


function AddCmsGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cmsGroup_data = response.responseText;
			
			eval(cmsGroup_data);
			
			CmsGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cmsGroup_data = response.responseText;
			
			eval(cmsGroup_data);
			
			CmsGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsGroup(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cmsGroup_data = response.responseText;

            eval(cmsGroup_data);

            CmsGroupViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsGroup successfully deleted!'); ?>');
			RefreshCmsGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCmsGroup(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cmsGroup_data = response.responseText;

			eval(cmsGroup_data);

			cmsGroupSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cmsGroup search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCmsGroupName(value){
	var conditions = '\'CmsGroup.name LIKE\' => \'%' + value + '%\'';
	store_cmsGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCmsGroupData() {
	store_cmsGroups.reload();
}


if(center_panel.find('id', 'cmsGroup-tab') != "") {
	var p = center_panel.findById('cmsGroup-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cms Groups'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cmsGroup-tab',
		xtype: 'grid',
		store: store_cmsGroups,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CmsGroups" : "CmsGroup"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCmsGroup(Ext.getCmp('cmsGroup-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CmsGroups</b><br />Click here to create a new CmsGroup'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCmsGroup();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-cmsGroup',
					tooltip:'<?php __('<b>Edit CmsGroups</b><br />Click here to modify the selected CmsGroup'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCmsGroup(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-cmsGroup',
					tooltip:'<?php __('<b>Delete CmsGroups(s)</b><br />Click here to remove the selected CmsGroup(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CmsGroup'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCmsGroup(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CmsGroup'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CmsGroups'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCmsGroup(sel_ids);
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
					text: '<?php __('View CmsGroup'); ?>',
					id: 'view-cmsGroup',
					tooltip:'<?php __('<b>View CmsGroup</b><br />Click here to see details of the selected CmsGroup'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCmsGroup(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('User'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($users as $item){if($st) echo ",
							";?>['<?php echo $item['User']['id']; ?>' ,'<?php echo $item['User']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsGroups.reload({
								params: {
									start: 0,
									limit: list_size,
									user_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'cmsGroup_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCmsGroupName(Ext.getCmp('cmsGroup_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cmsGroup_go_button',
					handler: function(){
						SearchByCmsGroupName(Ext.getCmp('cmsGroup_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCmsGroup();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cmsGroups,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-cmsGroup').enable();
		p.getTopToolbar().findById('delete-cmsGroup').enable();
		p.getTopToolbar().findById('view-cmsGroup').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsGroup').disable();
			p.getTopToolbar().findById('view-cmsGroup').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsGroup').disable();
			p.getTopToolbar().findById('view-cmsGroup').disable();
			p.getTopToolbar().findById('delete-cmsGroup').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-cmsGroup').enable();
			p.getTopToolbar().findById('view-cmsGroup').enable();
			p.getTopToolbar().findById('delete-cmsGroup').enable();
		}
		else{
			p.getTopToolbar().findById('edit-cmsGroup').disable();
			p.getTopToolbar().findById('view-cmsGroup').disable();
			p.getTopToolbar().findById('delete-cmsGroup').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cmsGroups.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
