var store_parent_performanceListChoices = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','performance_list'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerformanceListChoice() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_performanceListChoice_data = response.responseText;
			
			eval(parent_performanceListChoice_data);
			
			PerformanceListChoiceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerformanceListChoice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_performanceListChoice_data = response.responseText;
			
			eval(parent_performanceListChoice_data);
			
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

function ViewPerformanceListChoiceEmployeePerformanceResults(id) {
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


function DeleteParentPerformanceListChoice(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceListChoice(s) successfully deleted!'); ?>');
			RefreshParentPerformanceListChoiceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceListChoice to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerformanceListChoiceName(value){
	var conditions = '\'PerformanceListChoice.name LIKE\' => \'%' + value + '%\'';
	store_parent_performanceListChoices.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerformanceListChoiceData() {
	store_parent_performanceListChoices.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PerformanceListChoices'); ?>',
	store: store_parent_performanceListChoices,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'performanceListChoiceGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('performance_list'); ?>", dataIndex: 'performance_list', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            //ViewPerformanceListChoice(Ext.getCmp('performanceListChoiceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PerformanceListChoice</b><br />Click here to create a new PerformanceListChoice'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerformanceListChoice();
				}
			}, ' ', ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_performanceListChoices,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-performanceListChoice').enable();
	g.getTopToolbar().findById('delete-parent-performanceListChoice').enable();
        g.getTopToolbar().findById('view-performanceListChoice2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceListChoice').disable();
                g.getTopToolbar().findById('view-performanceListChoice2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceListChoice').disable();
		g.getTopToolbar().findById('delete-parent-performanceListChoice').enable();
                g.getTopToolbar().findById('view-performanceListChoice2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-performanceListChoice').enable();
		g.getTopToolbar().findById('delete-parent-performanceListChoice').enable();
                g.getTopToolbar().findById('view-performanceListChoice2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-performanceListChoice').disable();
		g.getTopToolbar().findById('delete-parent-performanceListChoice').disable();
                g.getTopToolbar().findById('view-performanceListChoice2').disable();
	}
});



var parentPerformanceListChoicesViewWindow = new Ext.Window({
	title: 'PerformanceListChoice Under the selected Item',
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
			parentPerformanceListChoicesViewWindow.close();
		}
	}]
});

store_parent_performanceListChoices.load({
    params: {
        start: 0,    
        limit: list_size
    }
});