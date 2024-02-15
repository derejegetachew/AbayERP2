
var store_performanceStatuses = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'list_data')); ?>'
	})

});


function AddPerformanceStatus() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var performanceStatus_data = response.responseText;
			
			eval(performanceStatus_data);
			
			PerformanceStatusAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerformanceStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var performanceStatus_data = response.responseText;
			
			eval(performanceStatus_data);
			
			PerformanceStatusEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceStatus(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var performanceStatus_data = response.responseText;

            eval(performanceStatus_data);

            PerformanceStatusViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePerformanceStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceStatus successfully deleted!'); ?>');
			RefreshPerformanceStatusData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerformanceStatus(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'search')); ?>',
		success: function(response, opts){
			var performanceStatus_data = response.responseText;

			eval(performanceStatus_data);

			performanceStatusSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the performanceStatus search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerformanceStatusName(value){
	var conditions = '\'PerformanceStatus.name LIKE\' => \'%' + value + '%\'';
	store_performanceStatuses.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerformanceStatusData() {
	store_performanceStatuses.reload();
}


if(center_panel.find('id', 'performanceStatus-tab') != "") {
	var p = center_panel.findById('performanceStatus-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Performance Statuses'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'performanceStatus-tab',
		xtype: 'grid',
		store: store_performanceStatuses,
		columns: [
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "PerformanceStatuses" : "PerformanceStatus"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPerformanceStatus(Ext.getCmp('performanceStatus-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add PerformanceStatuses</b><br />Click here to create a new PerformanceStatus'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerformanceStatus();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-performanceStatus',
					tooltip:'<?php __('<b>Edit PerformanceStatuses</b><br />Click here to modify the selected PerformanceStatus'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerformanceStatus(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View PerformanceStatus'); ?>',
					id: 'view-performanceStatus',
					tooltip:'<?php __('<b>View PerformanceStatus</b><br />Click here to see details of the selected PerformanceStatus'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerformanceStatus(sel.data.id);
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
							store_performanceStatuses.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerformanceStatus();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_performanceStatuses,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-performanceStatus').enable();
		
		p.getTopToolbar().findById('view-performanceStatus').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceStatus').disable();
			p.getTopToolbar().findById('view-performanceStatus').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-performanceStatus').disable();
			p.getTopToolbar().findById('view-performanceStatus').disable();
			
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-performanceStatus').enable();
			p.getTopToolbar().findById('view-performanceStatus').enable();
		
		}
		else{
			p.getTopToolbar().findById('edit-performanceStatus').disable();
			p.getTopToolbar().findById('view-performanceStatus').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_performanceStatuses.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
