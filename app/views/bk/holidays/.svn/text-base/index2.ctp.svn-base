var store_parent_holidays = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','type','from_date','to_date','filled_date','status'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentHoliday() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_holiday_data = response.responseText;
			
			eval(parent_holiday_data);
			
			HolidayAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_holiday_data = response.responseText;
			
			eval(parent_holiday_data);
			
			HolidayEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var holiday_data = response.responseText;

			eval(holiday_data);

			HolidayViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Holiday(s) successfully deleted!'); ?>');
			RefreshParentHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentHolidayName(value){
	var conditions = '\'Holiday.name LIKE\' => \'%' + value + '%\'';
	store_parent_holidays.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentHolidayData() {
	store_parent_holidays.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Holidays'); ?>',
	store: store_parent_holidays,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'holidayGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
		{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
		{header: "<?php __('Filled Date'); ?>", dataIndex: 'filled_date', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewHoliday(Ext.getCmp('holidayGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Holiday</b><br />Click here to create a new Holiday'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentHoliday();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-holiday',
				tooltip:'<?php __('<b>Edit Holiday</b><br />Click here to modify the selected Holiday'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentHoliday(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-holiday',
				tooltip:'<?php __('<b>Delete Holiday(s)</b><br />Click here to remove the selected Holiday(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Holiday'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentHoliday(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Holiday'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Holiday'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentHoliday(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View Holiday'); ?>',
				id: 'view-holiday2',
				tooltip:'<?php __('<b>View Holiday</b><br />Click here to see details of the selected Holiday'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewHoliday(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_holiday_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentHolidayName(Ext.getCmp('parent_holiday_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_holiday_go_button',
				handler: function(){
					SearchByParentHolidayName(Ext.getCmp('parent_holiday_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_holidays,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-holiday').enable();
	g.getTopToolbar().findById('delete-parent-holiday').enable();
        g.getTopToolbar().findById('view-holiday2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-holiday').disable();
                g.getTopToolbar().findById('view-holiday2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-holiday').disable();
		g.getTopToolbar().findById('delete-parent-holiday').enable();
                g.getTopToolbar().findById('view-holiday2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-holiday').enable();
		g.getTopToolbar().findById('delete-parent-holiday').enable();
                g.getTopToolbar().findById('view-holiday2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-holiday').disable();
		g.getTopToolbar().findById('delete-parent-holiday').disable();
                g.getTopToolbar().findById('view-holiday2').disable();
	}
});



var parentHolidaysViewWindow = new Ext.Window({
	title: 'Holiday Under the selected Item',
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
			parentHolidaysViewWindow.close();
		}
	}]
});

store_parent_holidays.load({
    params: {
        start: 0,    
        limit: list_size
    }
});