
var store_celebrationDays = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','day','name','budget_year'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'day', direction: "ASC"},
	groupField: 'name'
});


function AddCelebrationDay() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var celebrationDay_data = response.responseText;
			
			eval(celebrationDay_data);
			
			CelebrationDayAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the celebrationDay add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCelebrationDay(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var celebrationDay_data = response.responseText;
			
			eval(celebrationDay_data);
			
			CelebrationDayEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the celebrationDay edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCelebrationDay(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var celebrationDay_data = response.responseText;

            eval(celebrationDay_data);

            CelebrationDayViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the celebrationDay view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCelebrationDay(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CelebrationDay successfully deleted!'); ?>');
			RefreshCelebrationDayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the celebrationDay add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCelebrationDay(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'search')); ?>',
		success: function(response, opts){
			var celebrationDay_data = response.responseText;

			eval(celebrationDay_data);

			celebrationDaySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the celebrationDay search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCelebrationDayName(value){
	var conditions = '\'CelebrationDay.name LIKE\' => \'%' + value + '%\'';
	store_celebrationDays.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCelebrationDayData() {
	store_celebrationDays.reload();
}


if(center_panel.find('id', 'celebrationDay-tab') != "") {
	var p = center_panel.findById('celebrationDay-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Celebration Days'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'celebrationDay-tab',
		xtype: 'grid',
		store: store_celebrationDays,
		columns: [
			{header: "<?php __('Day'); ?>", dataIndex: 'day', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CelebrationDays" : "CelebrationDay"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCelebrationDay(Ext.getCmp('celebrationDay-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CelebrationDays</b><br />Click here to create a new CelebrationDay'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCelebrationDay();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-celebrationDay',
					tooltip:'<?php __('<b>Edit CelebrationDays</b><br />Click here to modify the selected CelebrationDay'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCelebrationDay(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-celebrationDay',
					tooltip:'<?php __('<b>Delete CelebrationDays(s)</b><br />Click here to remove the selected CelebrationDay(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CelebrationDay'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCelebrationDay(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CelebrationDay'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CelebrationDays'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCelebrationDay(sel_ids);
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
					text: '<?php __('View CelebrationDay'); ?>',
					id: 'view-celebrationDay',
					tooltip:'<?php __('<b>View CelebrationDay</b><br />Click here to see details of the selected CelebrationDay'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCelebrationDay(sel.data.id);
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
							<?php $st = false;foreach ($budgetyears as $item){if($st) echo ",
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
							store_celebrationDays.reload({
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
					id: 'celebrationDay_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCelebrationDayName(Ext.getCmp('celebrationDay_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'celebrationDay_go_button',
					handler: function(){
						SearchByCelebrationDayName(Ext.getCmp('celebrationDay_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCelebrationDay();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_celebrationDays,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-celebrationDay').enable();
		p.getTopToolbar().findById('delete-celebrationDay').enable();
		p.getTopToolbar().findById('view-celebrationDay').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-celebrationDay').disable();
			p.getTopToolbar().findById('view-celebrationDay').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-celebrationDay').disable();
			p.getTopToolbar().findById('view-celebrationDay').disable();
			p.getTopToolbar().findById('delete-celebrationDay').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-celebrationDay').enable();
			p.getTopToolbar().findById('view-celebrationDay').enable();
			p.getTopToolbar().findById('delete-celebrationDay').enable();
		}
		else{
			p.getTopToolbar().findById('edit-celebrationDay').disable();
			p.getTopToolbar().findById('view-celebrationDay').disable();
			p.getTopToolbar().findById('delete-celebrationDay').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_celebrationDays.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
