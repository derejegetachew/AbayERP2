
var store_pensions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','pf_staff','pf_company','pen_staff','pen_company','payroll'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddPension() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var pension_data = response.responseText;
			
			eval(pension_data);
			
			PensionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPension(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var pension_data = response.responseText;
			
			eval(pension_data);
			
			PensionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPension(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var pension_data = response.responseText;

            eval(pension_data);

            PensionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePension(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'remove')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Pension successfully deleted!'); ?>');
			RefreshPensionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPension(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var pension_data = response.responseText;

			eval(pension_data);

			pensionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the pension search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPensionName(value){
	var conditions = '\'Pension.name LIKE\' => \'%' + value + '%\'';
	store_pensions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPensionData() {
	store_pensions.reload();
}


if(center_panel.find('id', 'pension-tab') != "") {
	var p = center_panel.findById('pension-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('PF/Pensions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'pension-tab',
		xtype: 'grid',
		store: store_pensions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('PF: Staff %'); ?>", dataIndex: 'pf_staff', sortable: true},
			{header: "<?php __('PF: Company %'); ?>", dataIndex: 'pf_company', sortable: true},
			{header: "<?php __('Pension: Staff %'); ?>", dataIndex: 'pen_staff', sortable: true},
			{header: "<?php __('Pension: Company %'); ?>", dataIndex: 'pen_company', sortable: true},
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Pensions" : "Pension"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPension(Ext.getCmp('pension-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Pensions</b><br />Click here to create a new Pension'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPension();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-pension',
					tooltip:'<?php __('<b>Edit Pensions</b><br />Click here to modify the selected Pension'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPension(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-pension',
					tooltip:'<?php __('<b>Delete Pensions(s)</b><br />Click here to remove the selected Pension(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Pension'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePension(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Pension'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Pensions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePension(sel_ids);
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
					text: '<?php __('View Pension'); ?>',
					id: 'view-pension',
					tooltip:'<?php __('<b>View Pension</b><br />Click here to see details of the selected Pension'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPension(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'pension_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPensionName(Ext.getCmp('pension_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'pension_go_button',
					handler: function(){
						SearchByPensionName(Ext.getCmp('pension_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPension();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_pensions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-pension').enable();
		p.getTopToolbar().findById('delete-pension').enable();
		p.getTopToolbar().findById('view-pension').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-pension').disable();
			p.getTopToolbar().findById('view-pension').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-pension').disable();
			p.getTopToolbar().findById('view-pension').disable();
			p.getTopToolbar().findById('delete-pension').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-pension').enable();
			p.getTopToolbar().findById('view-pension').enable();
			p.getTopToolbar().findById('delete-pension').enable();
		}
		else{
			p.getTopToolbar().findById('edit-pension').disable();
			p.getTopToolbar().findById('view-pension').disable();
			p.getTopToolbar().findById('delete-pension').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_pensions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
