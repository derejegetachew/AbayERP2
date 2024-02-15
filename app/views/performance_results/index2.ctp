var store_parent_performanceResults = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','budget_year','first','second','third','fourth','average','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerformanceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_performanceResult_data = response.responseText;
			
			eval(parent_performanceResult_data);
			
			PerformanceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_performanceResult_data = response.responseText;
			
			eval(parent_performanceResult_data);
			
			PerformanceResultEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var performanceResult_data = response.responseText;

			eval(performanceResult_data);

			PerformanceResultViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceResultEmployees(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_employees_data = response.responseText;

			eval(parent_employees_data);

			parentEmployeesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerformanceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceResult(s) successfully deleted!'); ?>');
			RefreshParentPerformanceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceResult to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerformanceResultName(value){
	var conditions = '\'PerformanceResult.name LIKE\' => \'%' + value + '%\'';
	store_parent_performanceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerformanceResultData() {
	store_parent_performanceResults.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PerformanceResults'); ?>',
	store: store_parent_performanceResults,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'performanceResultGrid',
	columns: [
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('1st Quarter'); ?>", dataIndex: 'first', sortable: true},
		{header: "<?php __('2nd Quarter'); ?>", dataIndex: 'second', sortable: true},
		{header: "<?php __('3rd Quarter'); ?>", dataIndex: 'third', sortable: true},
		{header: "<?php __('4th Quarter'); ?>", dataIndex: 'fourth', sortable: true},
		{header: "<?php __('Average'); ?>", dataIndex: 'average', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPerformanceResult(Ext.getCmp('performanceResultGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [ ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-performanceResult',
				tooltip:'<?php __('<b>Edit PerformanceResult</b><br />Click here to modify the selected PerformanceResult'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPerformanceResult(sel.data.id);
					};
				}
			}, ' ',' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_performanceResults,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-performanceResult').enable();
	g.getTopToolbar().findById('delete-parent-performanceResult').enable();
        g.getTopToolbar().findById('view-performanceResult2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceResult').disable();
                g.getTopToolbar().findById('view-performanceResult2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceResult').disable();
		g.getTopToolbar().findById('delete-parent-performanceResult').enable();
                g.getTopToolbar().findById('view-performanceResult2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-performanceResult').enable();
		g.getTopToolbar().findById('delete-parent-performanceResult').enable();
                g.getTopToolbar().findById('view-performanceResult2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-performanceResult').disable();
		g.getTopToolbar().findById('delete-parent-performanceResult').disable();
                g.getTopToolbar().findById('view-performanceResult2').disable();
	}
});



var parentPerformanceResultsViewWindow = new Ext.Window({
	title: 'PerformanceResult Under the selected Item',
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
			parentPerformanceResultsViewWindow.close();
		}
	}]
});

store_parent_performanceResults.load({
    params: {
        start: 0,    
        limit: list_size
    }
});