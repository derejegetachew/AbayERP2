//<script>
    var store_parent_offsprings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','first_name','last_name','sex','birth_date','employee','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentOffspring() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_offspring_data = response.responseText;
			
			eval(parent_offspring_data);
			
			OffspringAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentOffspring(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_offspring_data = response.responseText;
			
			eval(parent_offspring_data);
			
			OffspringEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOffspring(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var offspring_data = response.responseText;

			eval(offspring_data);

			OffspringViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentOffspring(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Offspring(s) successfully deleted!'); ?>');
			RefreshParentOffspringData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the offspring to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentOffspringName(value){
	var conditions = '\'Offspring.name LIKE\' => \'%' + value + '%\'';
	store_parent_offsprings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentOffspringData() {
	store_parent_offsprings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Offsprings'); ?>',
	store: store_parent_offsprings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'offspringGrid',
	columns: [
		{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
		{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
		{header: "<?php __('Sex'); ?>", dataIndex: 'sex', sortable: true},
		{header: "<?php __('Birth Date'); ?>", dataIndex: 'birth_date', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewOffspring(Ext.getCmp('offspringGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Offspring</b><br />Click here to create a new Offspring'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentOffspring();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-offspring',
				tooltip:'<?php __('<b>Edit Offspring</b><br />Click here to modify the selected Offspring'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentOffspring(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-offspring',
				tooltip:'<?php __('<b>Delete Offspring(s)</b><br />Click here to remove the selected Offspring(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Offspring'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentOffspring(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Offspring'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Offspring'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentOffspring(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_offsprings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-offspring').enable();
	g.getTopToolbar().findById('delete-parent-offspring').enable();
        //g.getTopToolbar().findById('view-offspring2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-offspring').disable();
               // g.getTopToolbar().findById('view-offspring2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-offspring').disable();
		g.getTopToolbar().findById('delete-parent-offspring').enable();
            //    g.getTopToolbar().findById('view-offspring2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-offspring').enable();
		g.getTopToolbar().findById('delete-parent-offspring').enable();
             //   g.getTopToolbar().findById('view-offspring2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-offspring').disable();
		g.getTopToolbar().findById('delete-parent-offspring').disable();
              //  g.getTopToolbar().findById('view-offspring2').disable();
	}
});



var parentOffspringsViewWindow = new Ext.Window({
	title: 'Offspring Under the selected Item',
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
			parentOffspringsViewWindow.close();
		}
	}]
});

store_parent_offsprings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});