
var store_performanceLists = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','performance'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'type'
});


function AddPerformanceList() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var performanceList_data = response.responseText;
			
			eval(performanceList_data);
			
			PerformanceListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerformanceList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var performanceList_data = response.responseText;
			
			eval(performanceList_data);
			
			PerformanceListEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceList(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var performanceList_data = response.responseText;

            eval(performanceList_data);

            PerformanceListViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList view form. Error code'); ?>: ' + response.status);
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

function ViewParentPerformanceListChoices(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_performanceListChoices_data = response.responseText;

            eval(parent_performanceListChoices_data);

            parentPerformanceListChoicesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeletePerformanceList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceList successfully deleted!'); ?>');
			RefreshPerformanceListData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerformanceList(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'search')); ?>',
		success: function(response, opts){
			var performanceList_data = response.responseText;

			eval(performanceList_data);

			performanceListSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the performanceList search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerformanceListName(value){
	var conditions = '\'PerformanceList.name LIKE\' => \'%' + value + '%\'';
	store_performanceLists.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerformanceListData() {
	store_performanceLists.reload();
}


if(center_panel.find('id', 'performanceList-tab') != "") {
	var p = center_panel.findById('performanceList-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performance Lists'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'performanceList-tab',
		xtype: 'grid',
		store: store_performanceLists,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Performance'); ?>", dataIndex: 'performance', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PerformanceLists" : "PerformanceList"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPerformanceList(Ext.getCmp('performanceList-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PerformanceLists</b><br />Click here to create a new PerformanceList'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerformanceList();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-performanceList',
					tooltip:'<?php __('<b>Edit PerformanceLists</b><br />Click here to modify the selected PerformanceList'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerformanceList(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-performanceList',
					tooltip:'<?php __('<b>Delete PerformanceLists(s)</b><br />Click here to remove the selected PerformanceList(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceList'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePerformanceList(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove PerformanceList'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected PerformanceLists'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePerformanceList(sel_ids);
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
					text: '<?php __('View PerformanceList'); ?>',
					id: 'view-performanceList',
					tooltip:'<?php __('<b>View PerformanceList</b><br />Click here to see details of the selected PerformanceList'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerformanceList(sel.data.id);
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
,{
							text: '<?php __('View Performance List Choices'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPerformanceListChoices(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Performance'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($performances as $item){if($st) echo ",
							";?>['<?php echo $item['Performance']['id']; ?>' ,'<?php echo $item['Performance']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_performanceLists.reload({
								params: {
									start: 0,
									limit: list_size,
									performance_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'performanceList_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPerformanceListName(Ext.getCmp('performanceList_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'performanceList_go_button',
					handler: function(){
						SearchByPerformanceListName(Ext.getCmp('performanceList_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerformanceList();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_performanceLists,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-performanceList').enable();
		p.getTopToolbar().findById('delete-performanceList').enable();
		p.getTopToolbar().findById('view-performanceList').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceList').disable();
			p.getTopToolbar().findById('view-performanceList').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceList').disable();
			p.getTopToolbar().findById('view-performanceList').disable();
			p.getTopToolbar().findById('delete-performanceList').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-performanceList').enable();
			p.getTopToolbar().findById('view-performanceList').enable();
			p.getTopToolbar().findById('delete-performanceList').enable();
		}
		else{
			p.getTopToolbar().findById('edit-performanceList').disable();
			p.getTopToolbar().findById('view-performanceList').disable();
			p.getTopToolbar().findById('delete-performanceList').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_performanceLists.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
