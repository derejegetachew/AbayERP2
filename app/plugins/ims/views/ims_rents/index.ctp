
var store_imsRents = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','width','monthly_rent','contract_signed_date','contract_age','contract_functional_date','contract_end_date','prepayed_amount','prepayed_end_date','created_by','renter','address','created','modified','rem_amount_term','region'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'list_data')); ?>'
	}),
  	sortInfo:{field: 'contract_signed_date', direction: "ASC"},
    groupField: 'region'
});


function AddImsRent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsRent_data = response.responseText;
			
			eval(imsRent_data);
			
			ImsRentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Rent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsRent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsRent_data = response.responseText;
			
			eval(imsRent_data);
			
			ImsRentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Rent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRent(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsRent_data = response.responseText;

            eval(imsRent_data);

            ImsRentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Rent view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsRent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Rent successfully deleted!'); ?>');
			RefreshImsRentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Rent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsRent(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsRent_data = response.responseText;

			eval(imsRent_data);

			imsRentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Rent search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsRentName(value){
	var conditions = '\'ImsRent.name LIKE\' => \'%' + value + '%\'';
	store_imsRents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsRentData() {
	store_imsRents.reload();
}


if(center_panel.find('id', 'imsRent-tab') != "") {
	var p = center_panel.findById('imsRent-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Rents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsRent-tab',
		xtype: 'grid',
		store: store_imsRents,
		columns: [
      {header: "<?php __('Region'); ?>", dataIndex: 'region', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Area /m<sup>2</sup>'); ?>", dataIndex: 'width', sortable: true},
			{header: "<?php __('Monthly Rent Amount(with tax)'); ?>", dataIndex: 'monthly_rent', sortable: true},
			{header: "<?php __('Contract Signed Date'); ?>", dataIndex: 'contract_signed_date', sortable: true},
			{header: "<?php __('Year of Rent Period'); ?>", dataIndex: 'contract_age', sortable: true},
			{header: "<?php __('Contract Start Date'); ?>", dataIndex: 'contract_functional_date', sortable: true},
			{header: "<?php __('Contract End Date'); ?>", dataIndex: 'contract_end_date', sortable: true},
			{header: "<?php __('Prepaid Rent Amount'); ?>", dataIndex: 'prepayed_amount', sortable: true},
			{header: "<?php __('Prepaid Rent End Date'); ?>", dataIndex: 'prepayed_end_date', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Renter Name'); ?>", dataIndex: 'renter', sortable: true},
			{header: "<?php __('Renter Address'); ?>", dataIndex: 'address', sortable: true},
      {header: "<?php __('Rem Amount Term'); ?>", dataIndex: 'rem_amount_term', sortable: true}
      ,
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsRents" : "ImsRent"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsRent(Ext.getCmp('imsRent-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Rents</b><br />Click here to create a new Rent'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsRent();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsRent',
					tooltip:'<?php __('<b>Edit Rents</b><br />Click here to modify the selected Rent'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsRent(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsRent',
					tooltip:'<?php __('<b>Delete Rents(s)</b><br />Click here to remove the selected Rent(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Rent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.branch+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsRent(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Rent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Rents'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsRent(sel_ids);
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
					text: '<?php __('View Rent'); ?>',
					id: 'view-imsRent',
					tooltip:'<?php __('<b>View Rent</b><br />Click here to see details of the selected Rent'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsRent(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}
							echo ',["Ambassel ATM" ,"Ambassel ATM"],["DH Geda ATM" ,"DH Geda ATM"]'?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsRents.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsRent_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsRentName(Ext.getCmp('imsRent_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsRent_go_button',
					handler: function(){
						SearchByImsRentName(Ext.getCmp('imsRent_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsRent();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsRents,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsRent').enable();
		p.getTopToolbar().findById('delete-imsRent').enable();
		p.getTopToolbar().findById('view-imsRent').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsRent').disable();
			p.getTopToolbar().findById('view-imsRent').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsRent').disable();
			p.getTopToolbar().findById('view-imsRent').disable();
			p.getTopToolbar().findById('delete-imsRent').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsRent').enable();
			p.getTopToolbar().findById('view-imsRent').enable();
			p.getTopToolbar().findById('delete-imsRent').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsRent').disable();
			p.getTopToolbar().findById('view-imsRent').disable();
			p.getTopToolbar().findById('delete-imsRent').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsRents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
