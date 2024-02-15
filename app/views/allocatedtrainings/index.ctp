
var store_allocatedtrainings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','employee','training1','training2','training3'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'list_data')); ?>'
	})
<!-- ,	sortInfo:{field: 'budget_year_id', direction: "ASC"} -->
<!-- , groupField: 'quarter' -->
});

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});
function AddAllocatedtraining() {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var allocatedtraining_data = response.responseText;
			
			eval(allocatedtraining_data);
			myMask.hide();
			AllocatedtrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditAllocatedtraining(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var allocatedtraining_data = response.responseText;
			
			eval(allocatedtraining_data);
			myMask.hide();
			AllocatedtrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function ReportAllocatedtraining() {
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'index_report')); ?>',
		success: function(response, opts) {
			var allocatedtraining_data = response.responseText;
			
			eval(allocatedtraining_data);
			
			AllocatedtrainingReportWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Allocatedtraining add form. Error code'); ?>: ' + response.status);
		}
	});
} 

function ViewAllocatedtraining(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var allocatedtraining_data = response.responseText;

            eval(allocatedtraining_data);

            AllocatedtrainingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteAllocatedtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Allocatedtraining successfully deleted!'); ?>');
			RefreshAllocatedtrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the allocatedtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchAllocatedtraining(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var allocatedtraining_data = response.responseText;

			eval(allocatedtraining_data);

			allocatedtrainingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the allocatedtraining search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByAllocatedtrainingName(value){
	var conditions = '\'Allocatedtraining.name LIKE\' => \'%' + value + '%\'';
	store_allocatedtrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshAllocatedtrainingData() {
	store_allocatedtrainings.reload();
}


if(center_panel.find('id', 'allocatedtraining-tab') != "") {
	var p = center_panel.findById('allocatedtraining-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Allocatedtrainings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'allocatedtraining-tab',
		xtype: 'grid',
		store: store_allocatedtrainings,
		columns: [
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Training1'); ?>", dataIndex: 'training1', sortable: true},
			{header: "<?php __('Training2'); ?>", dataIndex: 'training2', sortable: true},
			{header: "<?php __('Training3'); ?>", dataIndex: 'training3', sortable: true},
			
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Allocatedtrainings" : "Allocatedtraining"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewAllocatedtraining(Ext.getCmp('allocatedtraining-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Allocatedtrainings</b><br />Click here to create a new Allocatedtraining'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddAllocatedtraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-allocatedtraining',
					tooltip:'<?php __('<b>Edit Allocatedtrainings</b><br />Click here to modify the selected Allocatedtraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditAllocatedtraining(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-allocatedtraining',
					tooltip:'<?php __('<b>Delete Allocatedtrainings(s)</b><br />Click here to remove the selected Allocatedtraining(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Allocatedtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteAllocatedtraining(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Allocatedtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Allocatedtrainings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteAllocatedtraining(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},  ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Report'); ?>',
					id: 'report-allocatedtraining',
					tooltip:'<?php __('<b>Report Allocatedtrainings</b><br />Click here to modify the selected Allocatedtraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					
					handler: function(btn) {
							ReportAllocatedtraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Allocatedtraining'); ?>',
					id: 'view-allocatedtraining',
					tooltip:'<?php __('<b>View Allocatedtraining</b><br />Click here to see details of the selected Allocatedtraining'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewAllocatedtraining(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_allocatedtrainings.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'allocatedtraining_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByAllocatedtrainingName(Ext.getCmp('allocatedtraining_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'allocatedtraining_go_button',
					handler: function(){
						SearchByAllocatedtrainingName(Ext.getCmp('allocatedtraining_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchAllocatedtraining();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_allocatedtrainings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-allocatedtraining').enable();
		p.getTopToolbar().findById('delete-allocatedtraining').enable();
		p.getTopToolbar().findById('view-allocatedtraining').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-allocatedtraining').disable();
			p.getTopToolbar().findById('view-allocatedtraining').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-allocatedtraining').disable();
			p.getTopToolbar().findById('view-allocatedtraining').disable();
			p.getTopToolbar().findById('delete-allocatedtraining').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-allocatedtraining').enable();
			p.getTopToolbar().findById('view-allocatedtraining').enable();
			p.getTopToolbar().findById('delete-allocatedtraining').enable();
		}
		else{
			p.getTopToolbar().findById('edit-allocatedtraining').disable();
			p.getTopToolbar().findById('view-allocatedtraining').disable();
			p.getTopToolbar().findById('delete-allocatedtraining').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_allocatedtrainings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
