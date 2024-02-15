
var store_claimonjobtrainings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','position','date_of_employment','placement_date','date_responded','no_of_days','payment_month','placement_branch','basic_salary','transport','hardship','pension','total'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});


function AddClaimonjobtraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var claimonjobtraining_data = response.responseText;
			
			eval(claimonjobtraining_data);
			
			ClaimonjobtrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimonjobtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditClaimonjobtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var claimonjobtraining_data = response.responseText;
			
			eval(claimonjobtraining_data);
			
			ClaimonjobtrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimonjobtraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewClaimonjobtraining(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var claimonjobtraining_data = response.responseText;

            eval(claimonjobtraining_data);

            ClaimonjobtrainingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimonjobtraining view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteClaimonjobtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Claimonjobtraining successfully deleted!'); ?>');
			RefreshClaimonjobtrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimonjobtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchClaimonjobtraining(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var claimonjobtraining_data = response.responseText;

			eval(claimonjobtraining_data);

			claimonjobtrainingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the claimonjobtraining search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByClaimonjobtrainingName(value){
	var conditions = '\'Claimonjobtraining.name LIKE\' => \'%' + value + '%\'';
	store_claimonjobtrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshClaimonjobtrainingData() {
	store_claimonjobtrainings.reload();
}


if(center_panel.find('id', 'claimonjobtraining-tab') != "") {
	var p = center_panel.findById('claimonjobtraining-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Claimonjobtrainings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'claimonjobtraining-tab',
		xtype: 'grid',
		store: store_claimonjobtrainings,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
			{header: "<?php __('Date Of Employment'); ?>", dataIndex: 'date_of_employment', sortable: true},
			{header: "<?php __('Placement Date'); ?>", dataIndex: 'placement_date', sortable: true},
			{header: "<?php __('Date Responded'); ?>", dataIndex: 'date_responded', sortable: true},
			{header: "<?php __('No Of Days'); ?>", dataIndex: 'no_of_days', sortable: true},
			{header: "<?php __('Payment Month'); ?>", dataIndex: 'payment_month', sortable: true},
			{header: "<?php __('Placement Branch'); ?>", dataIndex: 'placement_branch', sortable: true},
			{header: "<?php __('Basic Salary'); ?>", dataIndex: 'basic_salary', sortable: true},
			{header: "<?php __('Transport'); ?>", dataIndex: 'transport', sortable: true},
			{header: "<?php __('Hardship'); ?>", dataIndex: 'hardship', sortable: true},
			{header: "<?php __('Pension'); ?>", dataIndex: 'pension', sortable: true},
			{header: "<?php __('Total'); ?>", dataIndex: 'total', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Claimonjobtrainings" : "Claimonjobtraining"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewClaimonjobtraining(Ext.getCmp('claimonjobtraining-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Claimonjobtrainings</b><br />Click here to create a new Claimonjobtraining'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddClaimonjobtraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-claimonjobtraining',
					tooltip:'<?php __('<b>Edit Claimonjobtrainings</b><br />Click here to modify the selected Claimonjobtraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditClaimonjobtraining(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-claimonjobtraining',
					tooltip:'<?php __('<b>Delete Claimonjobtrainings(s)</b><br />Click here to remove the selected Claimonjobtraining(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Claimonjobtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteClaimonjobtraining(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Claimonjobtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Claimonjobtrainings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteClaimonjobtraining(sel_ids);
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
					text: '<?php __('View Claimonjobtraining'); ?>',
					id: 'view-claimonjobtraining',
					tooltip:'<?php __('<b>View Claimonjobtraining</b><br />Click here to see details of the selected Claimonjobtraining'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewClaimonjobtraining(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'claimonjobtraining_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByClaimonjobtrainingName(Ext.getCmp('claimonjobtraining_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'claimonjobtraining_go_button',
					handler: function(){
						SearchByClaimonjobtrainingName(Ext.getCmp('claimonjobtraining_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchClaimonjobtraining();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_claimonjobtrainings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-claimonjobtraining').enable();
		p.getTopToolbar().findById('delete-claimonjobtraining').enable();
		p.getTopToolbar().findById('view-claimonjobtraining').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-claimonjobtraining').disable();
			p.getTopToolbar().findById('view-claimonjobtraining').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-claimonjobtraining').disable();
			p.getTopToolbar().findById('view-claimonjobtraining').disable();
			p.getTopToolbar().findById('delete-claimonjobtraining').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-claimonjobtraining').enable();
			p.getTopToolbar().findById('view-claimonjobtraining').enable();
			p.getTopToolbar().findById('delete-claimonjobtraining').enable();
		}
		else{
			p.getTopToolbar().findById('edit-claimonjobtraining').disable();
			p.getTopToolbar().findById('view-claimonjobtraining').disable();
			p.getTopToolbar().findById('delete-claimonjobtraining').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_claimonjobtrainings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
