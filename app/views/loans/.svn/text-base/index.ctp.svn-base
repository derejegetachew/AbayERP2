
var store_loans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','Type','Per_month','start','no_months','skipped_months'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'Type'
});


function AddLoan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var loan_data = response.responseText;
			
			eval(loan_data);
			
			LoanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var loan_data = response.responseText;
			
			eval(loan_data);
			
			LoanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLoan(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var loan_data = response.responseText;

            eval(loan_data);

            LoanViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Loan successfully deleted!'); ?>');
			RefreshLoanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLoan(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'search')); ?>',
		success: function(response, opts){
			var loan_data = response.responseText;

			eval(loan_data);

			loanSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the loan search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLoanName(value){
	var conditions = '\'Loan.name LIKE\' => \'%' + value + '%\'';
	store_loans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLoanData() {
	store_loans.reload();
}


if(center_panel.find('id', 'loan-tab') != "") {
	var p = center_panel.findById('loan-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Loans'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'loan-tab',
		xtype: 'grid',
		store: store_loans,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'Type', sortable: true},
			{header: "<?php __('Per Month'); ?>", dataIndex: 'Per_month', sortable: true},
			{header: "<?php __('Start'); ?>", dataIndex: 'start', sortable: true},
			{header: "<?php __('No Months'); ?>", dataIndex: 'no_months', sortable: true},
			{header: "<?php __('Skipped Months'); ?>", dataIndex: 'skipped_months', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Loans" : "Loan"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewLoan(Ext.getCmp('loan-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Loans</b><br />Click here to create a new Loan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLoan();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-loan',
					tooltip:'<?php __('<b>Edit Loans</b><br />Click here to modify the selected Loan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLoan(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-loan',
					tooltip:'<?php __('<b>Delete Loans(s)</b><br />Click here to remove the selected Loan(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Loan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLoan(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Loan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Loans'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteLoan(sel_ids);
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
					text: '<?php __('View Loan'); ?>',
					id: 'view-loan',
					tooltip:'<?php __('<b>View Loan</b><br />Click here to see details of the selected Loan'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLoan(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_loans.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'loan_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLoanName(Ext.getCmp('loan_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'loan_go_button',
					handler: function(){
						SearchByLoanName(Ext.getCmp('loan_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLoan();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_loans,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-loan').enable();
		p.getTopToolbar().findById('delete-loan').enable();
		p.getTopToolbar().findById('view-loan').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-loan').disable();
			p.getTopToolbar().findById('view-loan').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-loan').disable();
			p.getTopToolbar().findById('view-loan').disable();
			p.getTopToolbar().findById('delete-loan').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-loan').enable();
			p.getTopToolbar().findById('view-loan').enable();
			p.getTopToolbar().findById('delete-loan').enable();
		}
		else{
			p.getTopToolbar().findById('edit-loan').disable();
			p.getTopToolbar().findById('view-loan').disable();
			p.getTopToolbar().findById('delete-loan').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_loans.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
