
var store_steps = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'list_data')); ?>'
	})
});


function AddStep() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var step_data = response.responseText;
			
			eval(step_data);
			
			StepAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the step add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditStep(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var step_data = response.responseText;
			
			eval(step_data);
			
			StepEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the step edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewStep(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var step_data = response.responseText;

            eval(step_data);

            StepViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the step view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentScales(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_scales_data = response.responseText;

            eval(parent_scales_data);

            parentScalesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteStep(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Step successfully deleted!'); ?>');
			RefreshStepData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the step add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchStep(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'steps', 'action' => 'search')); ?>',
		success: function(response, opts){
			var step_data = response.responseText;

			eval(step_data);

			stepSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the step search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByStepName(value){
	var conditions = '\'Step.name LIKE\' => \'%' + value + '%\'';
	store_steps.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshStepData() {
	store_steps.reload();
}


if(center_panel.find('id', 'step-tab') != "") {
	var p = center_panel.findById('step-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Steps'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'step-tab',
		xtype: 'grid',
		store: store_steps,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewStep(Ext.getCmp('step-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Steps</b><br />Click here to create a new Step'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddStep();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-step',
					tooltip:'<?php __('<b>Edit Steps</b><br />Click here to modify the selected Step'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditStep(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-step',
					tooltip:'<?php __('<b>Delete Steps(s)</b><br />Click here to remove the selected Step(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Step'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteStep(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Step'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Steps'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteStep(sel_ids);
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
					text: '<?php __('View Step'); ?>',
					id: 'view-step',
					tooltip:'<?php __('<b>View Step</b><br />Click here to see details of the selected Step'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewStep(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Scales'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentScales(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'step_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByStepName(Ext.getCmp('step_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'step_go_button',
					handler: function(){
						SearchByStepName(Ext.getCmp('step_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchStep();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_steps,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-step').enable();
		p.getTopToolbar().findById('delete-step').enable();
		p.getTopToolbar().findById('view-step').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-step').disable();
			p.getTopToolbar().findById('view-step').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-step').disable();
			p.getTopToolbar().findById('view-step').disable();
			p.getTopToolbar().findById('delete-step').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-step').enable();
			p.getTopToolbar().findById('view-step').enable();
			p.getTopToolbar().findById('delete-step').enable();
		}
		else{
			p.getTopToolbar().findById('edit-step').disable();
			p.getTopToolbar().findById('view-step').disable();
			p.getTopToolbar().findById('delete-step').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_steps.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
