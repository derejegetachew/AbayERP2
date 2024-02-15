
var store_spPlanHds = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','budget_year'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'list_data2')); ?>'
	})
});


function AddSpPlanHd() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var spPlanHd_data = response.responseText;
			
			eval(spPlanHd_data);
			
			SpPlanHdAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'edit2')); ?>/'+id,
		success: function(response, opts) {
			var spPlanHd_data = response.responseText;
			
			eval(spPlanHd_data);
			
			SpPlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ApproveSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'boapprove')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Plan Approved!'); ?>');
			RefreshSpPlanHdData();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ReturnSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'boret')); ?>/'+id,
		success: function(response, opts) {
			var spPlanHd_data = response.responseText;
			
			eval(spPlanHd_data);
			
			SpPlanHdReturnWindow.show();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd edit form. Error code'); ?>: ' + response.status);
		}
	});
}



function ViewSpPlanHd(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var spPlanHd_data = response.responseText;

            eval(spPlanHd_data);

            SpPlanHdViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentSpPlans(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_spPlans_data = response.responseText;

            eval(parent_spPlans_data);

            parentSpPlansViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpPlanHd successfully deleted!'); ?>');
			RefreshSpPlanHdData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSpPlanHd(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'search')); ?>',
		success: function(response, opts){
			var spPlanHd_data = response.responseText;

			eval(spPlanHd_data);

			spPlanHdSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the spPlanHd search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySpPlanHdName(value){
	var conditions = '\'SpPlanHd.name LIKE\' => \'%' + value + '%\'';
	store_spPlanHds.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSpPlanHdData() {
	store_spPlanHds.reload();
}


if(center_panel.find('id', 'spPlanHd-tab4') != "") {
	var p = center_panel.findById('spPlanHd-tab4');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Plan Approval'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'spPlanHd-tab4',
		xtype: 'grid',
		store: store_spPlanHds,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Plan Id'); ?>", dataIndex: 'id', sortable: true,hidden:true},
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
		
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Plans" : "Plan"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewParentSpPlans(Ext.getCmp('spPlanHd-tab4').getSelectionModel().getSelected().data.id);
				
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [ {
					xtype: 'tbbutton',
					text: '<?php __('Submit'); ?>',
					id: 'submit-spPlanHd',
					tooltip:'<?php __('<b>Edit SpPlanHds</b><br />Click here to modify the selected SpPlanHd'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Ext.Msg.show({
									title: '<?php __('Approve SpPlanHd'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Approve'); ?> '+sel.data.branch+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											ApproveSpPlanHd(sel.data.id);
										}
									}
								});
							
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Return'); ?>',
					id: 'delete-spPlanHd',
					tooltip:'<?php __('<b>Return SpPlanHds(s)</b><br />Click here to return the selected SpPlanHd(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Ext.Msg.show({
									title: '<?php __('Return SpPlanHd'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Return'); ?> '+sel.data.branch+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											ReturnSpPlanHd(sel.data.id);
										}
									}
								});
							
						};
					}
				}, {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-spPlanHd',
					tooltip:'<?php __('<b>Edit SpPlans</b><br />Click here to modify the selected SpPlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					hidden:true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
								ViewParentSpPlans(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View SpPlanHd'); ?>',
					id: 'view-spPlanHd',
					tooltip:'<?php __('<b>View SpPlanHd</b><br />Click here to see details of the selected SpPlanHd'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
								ViewParentSpPlans(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Sp Plans'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentSpPlans(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Budget Center'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_spPlanHds.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				}, ' ', '-',  '<?php __('Districts'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['All', 'All'],
							<?php $st = false;foreach ($regions as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'name',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_spPlanHds.reload({
								params: {
									start: 0,
									limit: list_size,
									region_id : combo.getValue()
								}
							});
						}
					}
				}, '->',{
					xtype: 'tbbutton',
					text: '<?php __('Budget Year: ');__($by); ?>'
				}, '->', {
					xtype: 'tbsplit',
					text: '<?php __('Reports'); ?>',
					id: 'view-shiftRequest',
					tooltip:'<?php __('<b>View Reports</b><br />Click here to see ist of reports'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewShiftRequest(sel.data.id);
						};
					},
					menu : {
						items: [
{
					
					text: '<b><?php __('Plan Detail '); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5CPlan_Detail_by_branch.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1142502393", "_blank");
					}
				},{
					
					text: '<b><?php __('Plan Summary'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Csummary_BO.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176&region="+"<?php echo $region_name; ?>", "_blank");
					}
				},{
					
					text: '<b><?php __('Deposite Mobilization'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Cdeposite_aggregate_region.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Customer Attraction'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Ccustomer_attraction_aggregate_region.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Total By Item'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Citem_total_abay.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Total By Item and budget Center'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Citem_total_abay_all_bo.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Item By Region'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Ctotal_item_by_region.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Item By Region(Total)'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Ctotal_by_region_summary.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},{
					
					text: '<b><?php __('Aggregated Plan'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5CAggregated.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},
				{
					
					text: '<b><?php __('Total Item by Budget Center'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Citem_by_budget_center_bo.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				},
				{
					
					text: '<b><?php __('Branch Plan Status'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Csp_plan_branch_status.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176", "_blank");
					}
				}



						]
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_spPlanHds,
			displayInfo: true,
      listeners: {
        beforechange: function(pagingToolbar, pageData) {
           
            if (pageData.currentPage < pageData.pageCount) {
               	Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd add form. Error code'); ?>: ');
               // console.log('Next page button clicked');
                
            }
        }
    },
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('submit-spPlanHd').enable();
		p.getTopToolbar().findById('edit-spPlanHd').enable();
		p.getTopToolbar().findById('delete-spPlanHd').enable();
		p.getTopToolbar().findById('view-spPlanHd').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('submit-spPlanHd').disable();
			p.getTopToolbar().findById('edit-spPlanHd').disable();
			p.getTopToolbar().findById('view-spPlanHd').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('submit-spPlanHd').disable();
			p.getTopToolbar().findById('edit-spPlanHd').disable();
			p.getTopToolbar().findById('view-spPlanHd').disable();
			p.getTopToolbar().findById('delete-spPlanHd').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('submit-spPlanHd').enable();
			p.getTopToolbar().findById('edit-spPlanHd').enable();
			p.getTopToolbar().findById('view-spPlanHd').enable();
			p.getTopToolbar().findById('delete-spPlanHd').enable();
		}
		else{
			p.getTopToolbar().findById('submit-spPlanHd').disable();
			p.getTopToolbar().findById('edit-spPlanHd').disable();
			p.getTopToolbar().findById('view-spPlanHd').disable();
			p.getTopToolbar().findById('delete-spPlanHd').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_spPlanHds.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
