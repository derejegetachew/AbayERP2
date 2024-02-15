var store_parent_reportFields = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','report','field','Renamed','getas'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentReportField() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_reportField_data = response.responseText;
			
			eval(parent_reportField_data);
			
			ReportFieldAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentReportField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_reportField_data = response.responseText;
			
			eval(parent_reportField_data);
			
			ReportFieldEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var reportField_data = response.responseText;

			eval(reportField_data);

			ReportFieldViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentReportField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ReportField(s) successfully deleted!'); ?>');
			RefreshParentReportFieldData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentReportFieldName(value){
	var conditions = '\'ReportField.name LIKE\' => \'%' + value + '%\'';
	store_parent_reportFields.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentReportFieldData() {
	store_parent_reportFields.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ReportFields'); ?>',
	store: store_parent_reportFields,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'reportFieldGrid',
	columns: [
		{header:"<?php __('report'); ?>", dataIndex: 'report', sortable: true},
		{header:"<?php __('field'); ?>", dataIndex: 'field', sortable: true},
		{header: "<?php __('Renamed'); ?>", dataIndex: 'Renamed', sortable: true},
		{header: "<?php __('Getas'); ?>", dataIndex: 'getas', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewReportField(Ext.getCmp('reportFieldGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ReportField</b><br />Click here to create a new ReportField'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentReportField();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-reportField',
				tooltip:'<?php __('<b>Edit ReportField</b><br />Click here to modify the selected ReportField'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentReportField(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-reportField',
				tooltip:'<?php __('<b>Delete ReportField(s)</b><br />Click here to remove the selected ReportField(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ReportField'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentReportField(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ReportField'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ReportField'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentReportField(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View ReportField'); ?>',
				id: 'view-reportField2',
				tooltip:'<?php __('<b>View ReportField</b><br />Click here to see details of the selected ReportField'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewReportField(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_reportField_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentReportFieldName(Ext.getCmp('parent_reportField_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_reportField_go_button',
				handler: function(){
					SearchByParentReportFieldName(Ext.getCmp('parent_reportField_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_reportFields,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-reportField').enable();
	g.getTopToolbar().findById('delete-parent-reportField').enable();
        g.getTopToolbar().findById('view-reportField2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-reportField').disable();
                g.getTopToolbar().findById('view-reportField2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-reportField').disable();
		g.getTopToolbar().findById('delete-parent-reportField').enable();
                g.getTopToolbar().findById('view-reportField2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-reportField').enable();
		g.getTopToolbar().findById('delete-parent-reportField').enable();
                g.getTopToolbar().findById('view-reportField2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-reportField').disable();
		g.getTopToolbar().findById('delete-parent-reportField').disable();
                g.getTopToolbar().findById('view-reportField2').disable();
	}
});



var parentReportFieldsViewWindow = new Ext.Window({
	title: 'ReportField Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentReportFieldsViewWindow.close();
		}
	}]
});

store_parent_reportFields.load({
    params: {
        start: 0,    
        limit: list_size
    }
});