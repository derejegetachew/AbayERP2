
var store_performanceListChoices = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','performance_list'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'performance_list_id'
});


function AddPerformanceListChoice() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var performanceListChoice_data = response.responseText;
			
			eval(performanceListChoice_data);
			
			PerformanceListChoiceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerformanceListChoice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var performanceListChoice_data = response.responseText;
			
			eval(performanceListChoice_data);
			
			PerformanceListChoiceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceListChoice(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var performanceListChoice_data = response.responseText;

            eval(performanceListChoice_data);

            PerformanceListChoiceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentEmployeePerformanceResults(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_employeePerformanceResults_data = response.responseText;

            eval(parent_employeePerformanceResults_data);

            parentEmployeePerformanceResultsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeletePerformanceListChoice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceListChoice successfully deleted!'); ?>');
			RefreshPerformanceListChoiceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerformanceListChoice(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'search')); ?>',
		success: function(response, opts){
			var performanceListChoice_data = response.responseText;

			eval(performanceListChoice_data);

			performanceListChoiceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the performanceListChoice search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerformanceListChoiceName(value){
	var conditions = '\'PerformanceListChoice.name LIKE\' => \'%' + value + '%\'';
	store_performanceListChoices.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerformanceListChoiceData() {
	store_performanceListChoices.reload();
}


if(center_panel.find('id', 'performanceListChoice-tab') != "") {
	var p = center_panel.findById('performanceListChoice-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performance List Choices'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'performanceListChoice-tab',
		xtype: 'grid',
		store: store_performanceListChoices,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('PerformanceList'); ?>", dataIndex: 'performance_list', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PerformanceListChoices" : "PerformanceListChoice"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPerformanceListChoice(Ext.getCmp('performanceListChoice-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PerformanceListChoices</b><br />Click here to create a new PerformanceListChoice'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerformanceListChoice();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-performanceListChoice',
					tooltip:'<?php __('<b>Edit PerformanceListChoices</b><br />Click here to modify the selected PerformanceListChoice'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerformanceListChoice(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-performanceListChoice',
					tooltip:'<?php __('<b>Delete PerformanceListChoices(s)</b><br />Click here to remove the selected PerformanceListChoice(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceListChoice'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePerformanceListChoice(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceListChoice'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PerformanceListChoices'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePerformanceListChoice(sel_ids);
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
					text: '<?php __('View PerformanceListChoice'); ?>',
					id: 'view-performanceListChoice',
					tooltip:'<?php __('<b>View PerformanceListChoice</b><br />Click here to see details of the selected PerformanceListChoice'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerformanceListChoice(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Employee Performance Results'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentEmployeePerformanceResults(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('PerformanceList'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($performancelists as $item){if($st) echo ",
							";?>['<?php echo $item['PerformanceList']['id']; ?>' ,'<?php echo $item['PerformanceList']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_performanceListChoices.reload({
								params: {
									start: 0,
									limit: list_size,
									performancelist_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'performanceListChoice_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPerformanceListChoiceName(Ext.getCmp('performanceListChoice_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'performanceListChoice_go_button',
					handler: function(){
						SearchByPerformanceListChoiceName(Ext.getCmp('performanceListChoice_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerformanceListChoice();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_performanceListChoices,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-performanceListChoice').enable();
		p.getTopToolbar().findById('delete-performanceListChoice').enable();
		p.getTopToolbar().findById('view-performanceListChoice').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceListChoice').disable();
			p.getTopToolbar().findById('view-performanceListChoice').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceListChoice').disable();
			p.getTopToolbar().findById('view-performanceListChoice').disable();
			p.getTopToolbar().findById('delete-performanceListChoice').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-performanceListChoice').enable();
			p.getTopToolbar().findById('view-performanceListChoice').enable();
			p.getTopToolbar().findById('delete-performanceListChoice').enable();
		}
		else{
			p.getTopToolbar().findById('edit-performanceListChoice').disable();
			p.getTopToolbar().findById('view-performanceListChoice').disable();
			p.getTopToolbar().findById('delete-performanceListChoice').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_performanceListChoices.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
