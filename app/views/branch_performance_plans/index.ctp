
var store_branchPerformancePlans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','budget_year','quarter','result','plan_status','result_status','comment'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'list_data')); ?>'
	})

});

var is_district_manager = '<?php echo $is_district_mgr; ?>';

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
				html: 'This is available only for district managers!'
			}
				],
			
			buttons: [  
				 {
				text: '<?php __('Ok'); ?>',
				handler: function(btn){
					var p = center_panel.findById('branchPerformancePlan-tab');
					center_panel.remove('branchPerformancePlan-tab');
					
					DialogWindow.close();
				}
			}]
		});

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function AddBranchPerformancePlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchPerformancePlan_data = response.responseText;
			
			eval(branchPerformancePlan_data);
			
			BranchPerformancePlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformancePlan_data = response.responseText;
			
			eval(branchPerformancePlan_data);
			
			BranchPerformancePlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ChangeStatus(id){
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'change_status')); ?>/'+id,
		success: function(response, opts) {
			var brPerformancePlan_data = response.responseText;
			
			eval(brPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the brPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
	
}



function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			var brPerformancePlan_data = response.responseText;
			
		   // eval(brPerformancePlan_data);
			
		   	myMask.hide();

			store_branchPerformancePlans.reload();
		},
		failure: function(response, opts) {
			
			myMask.hide();

			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the brPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
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

function ViewBranchPerformancePlan(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchPerformancePlan_data = response.responseText;

            eval(branchPerformancePlan_data);

            BranchPerformancePlanViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentBranchPerformanceDetails(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_branchPerformanceDetails_data = response.responseText;

            eval(parent_branchPerformanceDetails_data);

            parentBranchPerformanceDetailsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteBranchPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformancePlan successfully deleted!'); ?>');
			RefreshBranchPerformancePlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchPerformancePlan(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchPerformancePlan_data = response.responseText;

			eval(branchPerformancePlan_data);

			branchPerformancePlanSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchPerformancePlan search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchPerformancePlanName(value){
	var conditions = '\'BranchPerformancePlan.name LIKE\' => \'%' + value + '%\'';
	store_branchPerformancePlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchPerformancePlanData() {
	store_branchPerformancePlans.reload();
}


if(center_panel.find('id', 'branchPerformancePlan-tab') != "") {
	var p = center_panel.findById('branchPerformancePlan-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Performance Plans'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchPerformancePlan-tab',
		xtype: 'grid',
		store: store_branchPerformancePlans,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Result'); ?>", dataIndex: 'result', sortable: true},
			{header: "<?php __('Plan Status'); ?>", dataIndex: 'plan_status', sortable: true},
			{header: "<?php __('Result Status'); ?>", dataIndex: 'result_status', sortable: true},
			{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchPerformancePlans" : "BranchPerformancePlan"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchPerformancePlan(Ext.getCmp('branchPerformancePlan-tab').getSelectionModel().getSelected().data.id);
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
					tooltip:'<?php __('<b>Add BranchPerformancePlans</b><br />Click here to create a new BranchPerformancePlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchPerformancePlan();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchPerformancePlan',
					tooltip:'<?php __('<b>Edit BranchPerformancePlans</b><br />Click here to modify the selected BranchPerformancePlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchPerformancePlan(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-branchPerformancePlan',
					tooltip:'<?php __('<b>Delete BranchPerformancePlans(s)</b><br />Click here to remove the selected BranchPerformancePlan(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBranchPerformancePlan(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BranchPerformancePlans'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBranchPerformancePlan(sel_ids);
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
					text: '<?php __('View BranchPerformancePlan'); ?>',
					id: 'view-branchPerformancePlan',
					tooltip:'<?php __('<b>View BranchPerformancePlan</b><br />Click here to see details of the selected BranchPerformancePlan'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchPerformancePlan(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Branch Performance Details'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBranchPerformanceDetails(sel.data.id);
								};
							}
						}
						]
					}
				},  ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
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
							store_branchPerformancePlans.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchPerformancePlan();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchPerformancePlans,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchPerformancePlan').enable();
		p.getTopToolbar().findById('delete-branchPerformancePlan').enable();
		p.getTopToolbar().findById('view-branchPerformancePlan').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformancePlan').disable();
			p.getTopToolbar().findById('view-branchPerformancePlan').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformancePlan').disable();
			p.getTopToolbar().findById('view-branchPerformancePlan').disable();
			p.getTopToolbar().findById('delete-branchPerformancePlan').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchPerformancePlan').enable();
			p.getTopToolbar().findById('view-branchPerformancePlan').enable();
			p.getTopToolbar().findById('delete-branchPerformancePlan').enable();
		}
		else{
			p.getTopToolbar().findById('edit-branchPerformancePlan').disable();
			p.getTopToolbar().findById('view-branchPerformancePlan').disable();
			p.getTopToolbar().findById('delete-branchPerformancePlan').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchPerformancePlans.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});

	if(is_district_manager != "1" ){
		DialogWindow.show();
	}
	
}
