
var store_cmsAssignments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','cms_case','assigned_by','assigned_to','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'cms_case_id', direction: "ASC"},
	groupField: 'assigned_by'
});


function AddCmsAssignment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cmsAssignment_data = response.responseText;
			
			eval(cmsAssignment_data);
			
			CmsAssignmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCmsAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cmsAssignment_data = response.responseText;
			
			eval(cmsAssignment_data);
			
			CmsAssignmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsAssignment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cmsAssignment_data = response.responseText;

            eval(cmsAssignment_data);

            CmsAssignmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCmsAssignment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsAssignment successfully deleted!'); ?>');
			RefreshCmsAssignmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAssignment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCmsAssignment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cmsAssignment_data = response.responseText;

			eval(cmsAssignment_data);

			cmsAssignmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cmsAssignment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCmsAssignmentName(value){
	var conditions = '\'CmsAssignment.name LIKE\' => \'%' + value + '%\'';
	store_cmsAssignments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCmsAssignmentData() {
	store_cmsAssignments.reload();
}


if(center_panel.find('id', 'cmsAssignment-tab') != "") {
	var p = center_panel.findById('cmsAssignment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cms Assignments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cmsAssignment-tab',
		xtype: 'grid',
		store: store_cmsAssignments,
		columns: [
			{header: "<?php __('CmsCase'); ?>", dataIndex: 'cms_case', sortable: true},
			{header: "<?php __('Assigned By'); ?>", dataIndex: 'assigned_by', sortable: true},
			{header: "<?php __('Assigned To'); ?>", dataIndex: 'assigned_to', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CmsAssignments" : "CmsAssignment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCmsAssignment(Ext.getCmp('cmsAssignment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CmsAssignments</b><br />Click here to create a new CmsAssignment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCmsAssignment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-cmsAssignment',
					tooltip:'<?php __('<b>Edit CmsAssignments</b><br />Click here to modify the selected CmsAssignment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCmsAssignment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-cmsAssignment',
					tooltip:'<?php __('<b>Delete CmsAssignments(s)</b><br />Click here to remove the selected CmsAssignment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CmsAssignment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCmsAssignment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CmsAssignment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CmsAssignments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCmsAssignment(sel_ids);
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
					text: '<?php __('View CmsAssignment'); ?>',
					id: 'view-cmsAssignment',
					tooltip:'<?php __('<b>View CmsAssignment</b><br />Click here to see details of the selected CmsAssignment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCmsAssignment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('CmsCase'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($cmscases as $item){if($st) echo ",
							";?>['<?php echo $item['CmsCase']['id']; ?>' ,'<?php echo $item['CmsCase']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsAssignments.reload({
								params: {
									start: 0,
									limit: list_size,
									cmscase_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'cmsAssignment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCmsAssignmentName(Ext.getCmp('cmsAssignment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cmsAssignment_go_button',
					handler: function(){
						SearchByCmsAssignmentName(Ext.getCmp('cmsAssignment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCmsAssignment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cmsAssignments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-cmsAssignment').enable();
		p.getTopToolbar().findById('delete-cmsAssignment').enable();
		p.getTopToolbar().findById('view-cmsAssignment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsAssignment').disable();
			p.getTopToolbar().findById('view-cmsAssignment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsAssignment').disable();
			p.getTopToolbar().findById('view-cmsAssignment').disable();
			p.getTopToolbar().findById('delete-cmsAssignment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-cmsAssignment').enable();
			p.getTopToolbar().findById('view-cmsAssignment').enable();
			p.getTopToolbar().findById('delete-cmsAssignment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-cmsAssignment').disable();
			p.getTopToolbar().findById('view-cmsAssignment').disable();
			p.getTopToolbar().findById('delete-cmsAssignment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cmsAssignments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
