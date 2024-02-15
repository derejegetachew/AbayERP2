
var store_bpMonths = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'list_data')); ?>'
	})
});


function AddBpMonth() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpMonth_data = response.responseText;
			
			eval(bpMonth_data);
			
			BpMonthAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpMonth add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpMonth(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpMonth_data = response.responseText;
			
			eval(bpMonth_data);
			
			BpMonthEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpMonth edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpMonth(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpMonth_data = response.responseText;

            eval(bpMonth_data);

            BpMonthViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpMonth view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentBpActuals(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_bpActuals_data = response.responseText;

            eval(parent_bpActuals_data);

            parentBpActualsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentBpPlans(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_bpPlans_data = response.responseText;

            eval(parent_bpPlans_data);

            parentBpPlansViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteBpMonth(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpMonth successfully deleted!'); ?>');
			RefreshBpMonthData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpMonth add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpMonth(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpMonths', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpMonth_data = response.responseText;

			eval(bpMonth_data);

			bpMonthSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpMonth search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpMonthName(value){
	var conditions = '\'BpMonth.name LIKE\' => \'%' + value + '%\'';
	store_bpMonths.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpMonthData() {
	store_bpMonths.reload();
}


if(center_panel.find('id', 'bpMonth-tab') != "") {
	var p = center_panel.findById('bpMonth-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Months'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpMonth-tab',
		xtype: 'grid',
		store: store_bpMonths,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewBpMonth(Ext.getCmp('bpMonth-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpMonths</b><br />Click here to create a new BpMonth'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpMonth();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpMonth',
					tooltip:'<?php __('<b>Edit BpMonths</b><br />Click here to modify the selected BpMonth'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpMonth(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpMonth',
					tooltip:'<?php __('<b>Delete BpMonths(s)</b><br />Click here to remove the selected BpMonth(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpMonth'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpMonth(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpMonth'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpMonths'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpMonth(sel_ids);
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
					text: '<?php __('View BpMonth'); ?>',
					id: 'view-bpMonth',
					tooltip:'<?php __('<b>View BpMonth</b><br />Click here to see details of the selected BpMonth'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpMonth(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Bp Actuals'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBpActuals(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Bp Plans'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBpPlans(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpMonth_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpMonthName(Ext.getCmp('bpMonth_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpMonth_go_button',
					handler: function(){
						SearchByBpMonthName(Ext.getCmp('bpMonth_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpMonth();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpMonths,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpMonth').enable();
		p.getTopToolbar().findById('delete-bpMonth').enable();
		p.getTopToolbar().findById('view-bpMonth').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpMonth').disable();
			p.getTopToolbar().findById('view-bpMonth').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpMonth').disable();
			p.getTopToolbar().findById('view-bpMonth').disable();
			p.getTopToolbar().findById('delete-bpMonth').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpMonth').enable();
			p.getTopToolbar().findById('view-bpMonth').enable();
			p.getTopToolbar().findById('delete-bpMonth').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpMonth').disable();
			p.getTopToolbar().findById('view-bpMonth').disable();
			p.getTopToolbar().findById('delete-bpMonth').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpMonths.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
