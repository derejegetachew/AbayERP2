
var store_hoPerformancePlans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','employee','quarter','self_technical_percent', 'spvr_technical_percent' ,'both_technical_percent','semiannual_technical', 'behavioural_percent', 'semiannual_average',
		 'plan_status','result_status','comment'		 
			]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'list_data')); ?>'
	})
 
<!--	,sortInfo:{field: 'name', direction: "ASC"}, -->
	<!-- groupField: 'budget_year_id' -->
});
var branch_type = '<?php echo $branch_type; ?>';

var DialogWindow = new Ext.Window({
			title: '<?php __('Error!'); ?>',
			width: 400,
			minWidth: 400,
			closable: false,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: [{
				xtype: 'label',
				html: 'This is available only for head office employees!'
			}
				],
			
			buttons: [  
				 {
				text: '<?php __('Ok'); ?>',
				handler: function(btn){
					var p = center_panel.findById('hoPerformancePlan-tab');
					center_panel.remove('hoPerformancePlan-tab');
					
					DialogWindow.close();
				}
			}]
		});


var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function AddHoPerformancePlan() {


		myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			myMask.hide();
			HoPerformancePlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
	


}

function EditHoPerformancePlan(id) {
	
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			myMask.hide();
			HoPerformancePlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});

}

function ChangeStatus(id){
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'change_status')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
	
}




function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
		   // eval(hoPerformancePlan_data);
			
		   	myMask.hide();

			store_hoPerformancePlans.reload();
		},
		failure: function(response, opts) {
			
			myMask.hide();

			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}



function ViewHoPerformancePlan(id) {

    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var hoPerformancePlan_data = response.responseText;

            eval(hoPerformancePlan_data);

            HoPerformancePlanViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentHoPerformanceDetails(id) {


    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_hoPerformanceDetails_data = response.responseText;

            eval(parent_hoPerformanceDetails_data);

            parentHoPerformanceDetailsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
	
}


function DeleteHoPerformancePlan(id) {
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('HoPerformancePlan successfully deleted!'); ?>');
			RefreshHoPerformancePlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});

}

function SearchHoPerformancePlan(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'search')); ?>',
		success: function(response, opts){
			var hoPerformancePlan_data = response.responseText;

			eval(hoPerformancePlan_data);

			hoPerformancePlanSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the hoPerformancePlan search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByHoPerformancePlanName(value){
	var conditions = '\'HoPerformancePlan.name LIKE\' => \'%' + value + '%\'';
	store_hoPerformancePlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshHoPerformancePlanData() {
	store_hoPerformancePlans.reload();
}
function showMenu(grid, index, event) {

        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Recalculate / Refresh </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       RecalculateRefresh(record.get('id'));
					   
                    }
                }
				,{
                    text: '<b>Change status </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       ChangeStatus(record.get('id'));
					   
                    }
                }
            ]
        }).showAt(event.xy);
	
}


if(center_panel.find('id', 'hoPerformancePlan-tab') != "") {
	var p = center_panel.findById('hoPerformancePlan-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ho Performance Plans'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'hoPerformancePlan-tab',
		xtype: 'grid',
		store: store_hoPerformancePlans,
		columns: [
			
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Self technical percent'); ?>", dataIndex: 'self_technical_percent', sortable: true},
			{header: "<?php __('Spvr technical percent'); ?>", dataIndex: 'spvr_technical_percent', sortable: true},
			{header: "<?php __('Both technical percent'); ?>", dataIndex: 'both_technical_percent', sortable: true},
			{header: "<?php __('Semiannual technical'); ?>", dataIndex: 'semiannual_technical', sortable: true},
			{header: "<?php __('Behavioural percent'); ?>", dataIndex: 'behavioural_percent', sortable: true},
			{header: "<?php __('Semiannual average'); ?>", dataIndex: 'semiannual_average', sortable: true},
			{header: "<?php __('Plan status'); ?>", dataIndex: 'plan_status', sortable: true},
			{header: "<?php __('Result status'); ?>", dataIndex: 'result_status', sortable: true},
			{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "HoPerformancePlans" : "HoPerformancePlan"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewHoPerformancePlan(Ext.getCmp('hoPerformancePlan-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                        //grid.selectedNode = grid.store.getAt(row); // we need this
                        //if((index) !== false) {
                        this.getSelectionModel().selectRow(index);
                        //}
                }
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',					
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add HoPerformancePlans</b><br />Click here to create a new HoPerformancePlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddHoPerformancePlan();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-hoPerformancePlan',
					tooltip:'<?php __('<b>Edit HoPerformancePlans</b><br />Click here to modify the selected HoPerformancePlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditHoPerformancePlan(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-hoPerformancePlan',
					tooltip:'<?php __('<b>Delete HoPerformancePlans(s)</b><br />Click here to remove the selected HoPerformancePlan(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove HoPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.id+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteHoPerformancePlan(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove HoPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected HoPerformancePlans'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteHoPerformancePlan(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View HoPerformancePlan'); ?>',
					id: 'view-hoPerformancePlan',
					tooltip:'<?php __('<b>View HoPerformancePlan</b><br />Click here to see details of the selected HoPerformancePlan'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewHoPerformancePlan(sel.data.id);
						};
					},
					menu : {
						items: [
								{
							text: '<?php __('View Ho Performance Details'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentHoPerformanceDetails(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;for ($i = 1; $i <= count($budget_years) ; $i++ ){ if($st) echo ",
							";?>['<?php echo $i; ?>' ,'<?php echo $budget_years[$i]; ?>']<?php $st = true;}?>						]
						
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_hoPerformancePlans.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				},
 '->',  '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchHoPerformancePlan();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_hoPerformancePlans,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		
		p.getTopToolbar().findById('edit-hoPerformancePlan').enable();
		p.getTopToolbar().findById('delete-hoPerformancePlan').enable();
		p.getTopToolbar().findById('view-hoPerformancePlan').enable();
		
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-hoPerformancePlan').disable();
			p.getTopToolbar().findById('view-hoPerformancePlan').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-hoPerformancePlan').disable();
			p.getTopToolbar().findById('view-hoPerformancePlan').disable();
			p.getTopToolbar().findById('delete-hoPerformancePlan').enable();
		}
		else if(this.getSelections().length == 1){
		
			p.getTopToolbar().findById('edit-hoPerformancePlan').enable();
			p.getTopToolbar().findById('view-hoPerformancePlan').enable();
			p.getTopToolbar().findById('delete-hoPerformancePlan').enable();
		
			
		}
		else{
			p.getTopToolbar().findById('edit-hoPerformancePlan').disable();
			p.getTopToolbar().findById('view-hoPerformancePlan').disable();
			p.getTopToolbar().findById('delete-hoPerformancePlan').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_hoPerformancePlans.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});

	if(branch_type != "ho"){
		DialogWindow.show();
	}
	
}
