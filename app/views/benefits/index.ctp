
var store_benefits = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Measurement','amount','grade','start_date','end_date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'Measurement'
});


function AddBenefit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var benefit_data = response.responseText;
			
			eval(benefit_data);
			
			BenefitAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the benefit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBenefit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var benefit_data = response.responseText;
			
			eval(benefit_data);
			
			BenefitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the benefit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBenefit(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var benefit_data = response.responseText;

            eval(benefit_data);

            BenefitViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the benefit view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBenefit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Benefit successfully deleted!'); ?>');
			RefreshBenefitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the benefit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBenefit(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'search')); ?>',
		success: function(response, opts){
			var benefit_data = response.responseText;

			eval(benefit_data);

			benefitSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the benefit search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBenefitName(value){
	var conditions = '\'Benefit.name LIKE\' => \'%' + value + '%\'';
	store_benefits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBenefitData() {
	store_benefits.reload();
}


if(center_panel.find('id', 'benefit-tab') != "") {
	var p = center_panel.findById('benefit-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Benefits'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'benefit-tab',
		xtype: 'grid',
		store: store_benefits,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'Measurement', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
			{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Benefits" : "Benefit"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBenefit(Ext.getCmp('benefit-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Benefits</b><br />Click here to create a new Benefit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBenefit();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-benefit',
					tooltip:'<?php __('<b>Edit Benefits</b><br />Click here to modify the selected Benefit'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBenefit(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-benefit',
					tooltip:'<?php __('<b>Delete Benefits(s)</b><br />Click here to remove the selected Benefit(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Benefit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBenefit(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Benefit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Benefits'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBenefit(sel_ids);
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
					text: '<?php __('View Benefit'); ?>',
					id: 'view-benefit',
					tooltip:'<?php __('<b>View Benefit</b><br />Click here to see details of the selected Benefit'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBenefit(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Grade'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($grades as $item){if($st) echo ",
							";?>['<?php echo $item['Grade']['id']; ?>' ,'<?php echo $item['Grade']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_benefits.reload({
								params: {
									start: 0,
									limit: list_size,
									grade_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'benefit_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBenefitName(Ext.getCmp('benefit_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'benefit_go_button',
					handler: function(){
						SearchByBenefitName(Ext.getCmp('benefit_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBenefit();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_benefits,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-benefit').enable();
		p.getTopToolbar().findById('delete-benefit').enable();
		p.getTopToolbar().findById('view-benefit').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-benefit').disable();
			p.getTopToolbar().findById('view-benefit').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-benefit').disable();
			p.getTopToolbar().findById('view-benefit').disable();
			p.getTopToolbar().findById('delete-benefit').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-benefit').enable();
			p.getTopToolbar().findById('view-benefit').enable();
			p.getTopToolbar().findById('delete-benefit').enable();
		}
		else{
			p.getTopToolbar().findById('edit-benefit').disable();
			p.getTopToolbar().findById('view-benefit').disable();
			p.getTopToolbar().findById('delete-benefit').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_benefits.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
