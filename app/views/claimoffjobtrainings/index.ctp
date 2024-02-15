
var store_claimoffjobtrainings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','training_title','position','venue','date_responded','starting_date','ending_date','perdiem','transport','accomadation','refreshment','total'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});


function AddClaimoffjobtraining() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var claimoffjobtraining_data = response.responseText;
			
			eval(claimoffjobtraining_data);
			
			ClaimoffjobtrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimoffjobtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditClaimoffjobtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var claimoffjobtraining_data = response.responseText;
			
			eval(claimoffjobtraining_data);
			
			ClaimoffjobtrainingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimoffjobtraining edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewClaimoffjobtraining(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var claimoffjobtraining_data = response.responseText;

            eval(claimoffjobtraining_data);

            ClaimoffjobtrainingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimoffjobtraining view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteClaimoffjobtraining(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Claimoffjobtraining successfully deleted!'); ?>');
			RefreshClaimoffjobtrainingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the claimoffjobtraining add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchClaimoffjobtraining(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var claimoffjobtraining_data = response.responseText;

			eval(claimoffjobtraining_data);

			claimoffjobtrainingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the claimoffjobtraining search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByClaimoffjobtrainingName(value){
	var conditions = '\'Claimoffjobtraining.name LIKE\' => \'%' + value + '%\'';
	store_claimoffjobtrainings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshClaimoffjobtrainingData() {
	store_claimoffjobtrainings.reload();
}


if(center_panel.find('id', 'claimoffjobtraining-tab') != "") {
	var p = center_panel.findById('claimoffjobtraining-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Claimoffjobtrainings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'claimoffjobtraining-tab',
		xtype: 'grid',
		store: store_claimoffjobtrainings,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Training Title'); ?>", dataIndex: 'training_title', sortable: true},
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
			{header: "<?php __('Venue'); ?>", dataIndex: 'venue', sortable: true},
			{header: "<?php __('Date Responded'); ?>", dataIndex: 'date_responded', sortable: true},
			{header: "<?php __('Starting Date'); ?>", dataIndex: 'starting_date', sortable: true},
			{header: "<?php __('Ending Date'); ?>", dataIndex: 'ending_date', sortable: true},
			{header: "<?php __('Perdiem'); ?>", dataIndex: 'perdiem', sortable: true},
			{header: "<?php __('Transport'); ?>", dataIndex: 'transport', sortable: true},
			{header: "<?php __('Accomadation'); ?>", dataIndex: 'accomadation', sortable: true},
			{header: "<?php __('Refreshment'); ?>", dataIndex: 'refreshment', sortable: true},
			{header: "<?php __('Total'); ?>", dataIndex: 'total', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Claimoffjobtrainings" : "Claimoffjobtraining"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewClaimoffjobtraining(Ext.getCmp('claimoffjobtraining-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Claimoffjobtrainings</b><br />Click here to create a new Claimoffjobtraining'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddClaimoffjobtraining();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-claimoffjobtraining',
					tooltip:'<?php __('<b>Edit Claimoffjobtrainings</b><br />Click here to modify the selected Claimoffjobtraining'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditClaimoffjobtraining(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-claimoffjobtraining',
					tooltip:'<?php __('<b>Delete Claimoffjobtrainings(s)</b><br />Click here to remove the selected Claimoffjobtraining(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Claimoffjobtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteClaimoffjobtraining(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Claimoffjobtraining'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Claimoffjobtrainings'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteClaimoffjobtraining(sel_ids);
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
					text: '<?php __('View Claimoffjobtraining'); ?>',
					id: 'view-claimoffjobtraining',
					tooltip:'<?php __('<b>View Claimoffjobtraining</b><br />Click here to see details of the selected Claimoffjobtraining'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewClaimoffjobtraining(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'claimoffjobtraining_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByClaimoffjobtrainingName(Ext.getCmp('claimoffjobtraining_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'claimoffjobtraining_go_button',
					handler: function(){
						SearchByClaimoffjobtrainingName(Ext.getCmp('claimoffjobtraining_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchClaimoffjobtraining();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_claimoffjobtrainings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-claimoffjobtraining').enable();
		p.getTopToolbar().findById('delete-claimoffjobtraining').enable();
		p.getTopToolbar().findById('view-claimoffjobtraining').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-claimoffjobtraining').disable();
			p.getTopToolbar().findById('view-claimoffjobtraining').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-claimoffjobtraining').disable();
			p.getTopToolbar().findById('view-claimoffjobtraining').disable();
			p.getTopToolbar().findById('delete-claimoffjobtraining').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-claimoffjobtraining').enable();
			p.getTopToolbar().findById('view-claimoffjobtraining').enable();
			p.getTopToolbar().findById('delete-claimoffjobtraining').enable();
		}
		else{
			p.getTopToolbar().findById('edit-claimoffjobtraining').disable();
			p.getTopToolbar().findById('view-claimoffjobtraining').disable();
			p.getTopToolbar().findById('delete-claimoffjobtraining').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_claimoffjobtrainings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
