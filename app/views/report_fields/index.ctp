
var store_reportFields = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','report','field','Renamed','getas'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'report_id', direction: "ASC"},
	groupField: 'field_id'
});


function AddReportField() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var reportField_data = response.responseText;
			
			eval(reportField_data);
			
			ReportFieldAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditReportField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var reportField_data = response.responseText;
			
			eval(reportField_data);
			
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

function DeleteReportField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ReportField successfully deleted!'); ?>');
			RefreshReportFieldData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportField add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchReportField(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'search')); ?>',
		success: function(response, opts){
			var reportField_data = response.responseText;

			eval(reportField_data);

			reportFieldSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the reportField search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByReportFieldName(value){
	var conditions = '\'ReportField.name LIKE\' => \'%' + value + '%\'';
	store_reportFields.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshReportFieldData() {
	store_reportFields.reload();
}


if(center_panel.find('id', 'reportField-tab') != "") {
	var p = center_panel.findById('reportField-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Report Fields'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'reportField-tab',
		xtype: 'grid',
		store: store_reportFields,
		columns: [
			{header: "<?php __('Report'); ?>", dataIndex: 'report', sortable: true},
			{header: "<?php __('Field'); ?>", dataIndex: 'field', sortable: true},
			{header: "<?php __('Renamed'); ?>", dataIndex: 'Renamed', sortable: true},
			{header: "<?php __('Getas'); ?>", dataIndex: 'getas', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ReportFields" : "ReportField"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewReportField(Ext.getCmp('reportField-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ReportFields</b><br />Click here to create a new ReportField'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddReportField();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-reportField',
					tooltip:'<?php __('<b>Edit ReportFields</b><br />Click here to modify the selected ReportField'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditReportField(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-reportField',
					tooltip:'<?php __('<b>Delete ReportFields(s)</b><br />Click here to remove the selected ReportField(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ReportField'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteReportField(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ReportField'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ReportFields'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteReportField(sel_ids);
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
					text: '<?php __('View ReportField'); ?>',
					id: 'view-reportField',
					tooltip:'<?php __('<b>View ReportField</b><br />Click here to see details of the selected ReportField'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewReportField(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Report'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($reports as $item){if($st) echo ",
							";?>['<?php echo $item['Report']['id']; ?>' ,'<?php echo $item['Report']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_reportFields.reload({
								params: {
									start: 0,
									limit: list_size,
									report_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'reportField_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByReportFieldName(Ext.getCmp('reportField_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'reportField_go_button',
					handler: function(){
						SearchByReportFieldName(Ext.getCmp('reportField_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchReportField();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_reportFields,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-reportField').enable();
		p.getTopToolbar().findById('delete-reportField').enable();
		p.getTopToolbar().findById('view-reportField').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-reportField').disable();
			p.getTopToolbar().findById('view-reportField').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-reportField').disable();
			p.getTopToolbar().findById('view-reportField').disable();
			p.getTopToolbar().findById('delete-reportField').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-reportField').enable();
			p.getTopToolbar().findById('view-reportField').enable();
			p.getTopToolbar().findById('delete-reportField').enable();
		}
		else{
			p.getTopToolbar().findById('edit-reportField').disable();
			p.getTopToolbar().findById('view-reportField').disable();
			p.getTopToolbar().findById('delete-reportField').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_reportFields.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
