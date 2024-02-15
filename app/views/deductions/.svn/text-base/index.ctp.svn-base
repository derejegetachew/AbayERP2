
var store_deductions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Measurement','amount','grade','start_date','end_date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'Measurement'
});


function AddDeduction() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var deduction_data = response.responseText;
			
			eval(deduction_data);
			
			DeductionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDeduction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var deduction_data = response.responseText;
			
			eval(deduction_data);
			
			DeductionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDeduction(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var deduction_data = response.responseText;

            eval(deduction_data);

            DeductionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDeduction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Deduction successfully deleted!'); ?>');
			RefreshDeductionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDeduction(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var deduction_data = response.responseText;

			eval(deduction_data);

			deductionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the deduction search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDeductionName(value){
	var conditions = '\'Deduction.name LIKE\' => \'%' + value + '%\'';
	store_deductions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDeductionData() {
	store_deductions.reload();
}


if(center_panel.find('id', 'deduction-tab') != "") {
	var p = center_panel.findById('deduction-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Deductions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'deduction-tab',
		xtype: 'grid',
		store: store_deductions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'Measurement', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
			{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Deductions" : "Deduction"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDeduction(Ext.getCmp('deduction-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Deductions</b><br />Click here to create a new Deduction'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDeduction();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-deduction',
					tooltip:'<?php __('<b>Edit Deductions</b><br />Click here to modify the selected Deduction'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDeduction(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-deduction',
					tooltip:'<?php __('<b>Delete Deductions(s)</b><br />Click here to remove the selected Deduction(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Deduction'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDeduction(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Deduction'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Deductions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDeduction(sel_ids);
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
					text: '<?php __('View Deduction'); ?>',
					id: 'view-deduction',
					tooltip:'<?php __('<b>View Deduction</b><br />Click here to see details of the selected Deduction'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDeduction(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Grade'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($grades as $item){if($st) echo ",
							";?>['<?php echo $item['Grade']['id']; ?>' ,'<?php echo $item['Grade']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_deductions.reload({
								params: {
									start: 0,
									limit: list_size,
									grade_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'deduction_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDeductionName(Ext.getCmp('deduction_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'deduction_go_button',
					handler: function(){
						SearchByDeductionName(Ext.getCmp('deduction_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDeduction();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_deductions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-deduction').enable();
		p.getTopToolbar().findById('delete-deduction').enable();
		p.getTopToolbar().findById('view-deduction').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-deduction').disable();
			p.getTopToolbar().findById('view-deduction').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-deduction').disable();
			p.getTopToolbar().findById('view-deduction').disable();
			p.getTopToolbar().findById('delete-deduction').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-deduction').enable();
			p.getTopToolbar().findById('view-deduction').enable();
			p.getTopToolbar().findById('delete-deduction').enable();
		}
		else{
			p.getTopToolbar().findById('edit-deduction').disable();
			p.getTopToolbar().findById('view-deduction').disable();
			p.getTopToolbar().findById('delete-deduction').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_deductions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
