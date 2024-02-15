
var store_spPlans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'plan_id','id','sp_item','group','march_end','june_end','july','august','september','october','november','december','january','february','march','april','may','june'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'list_data')); ?>'
	}),
	groupField: 'group'

});


function AddSpPlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var spPlan_data = response.responseText;
			
			eval(spPlan_data);
			
			SpPlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var spPlan_data = response.responseText;
			
			eval(spPlan_data);
			
			SpPlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function FinalizeSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'finalize')); ?>/'+id,
		success: function(response, opts) {
		    Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpPlan successfully finalized!'); ?>');
			RefreshSpPlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpPlan(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var spPlan_data = response.responseText;

            eval(spPlan_data);

            SpPlanViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpPlan successfully deleted!'); ?>');
			RefreshSpPlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSpPlan(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'search')); ?>',
		success: function(response, opts){
			var spPlan_data = response.responseText;

			eval(spPlan_data);

			spPlanSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the spPlan search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySpPlanName(value){
	var conditions = '\'SpPlan.name LIKE\' => \'%' + value + '%\'';
	store_spPlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSpPlanData() {
	store_spPlans.reload();
}


if(center_panel.find('id', 'spPlan-tab') != "") {
	var p = center_panel.findById('spPlan-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Plan Entry'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'spPlan-tab',
		xtype: 'grid',
		store: store_spPlans,
		columns: [
			{header: "<?php __('S.N.'); ?>", dataIndex: 'id', sortable: true,width:55},
			{header: "<?php __('Category'); ?>", dataIndex: 'group', sortable: true,hidden:true},
			{header: "<?php __('Checklist'); ?>", dataIndex: 'sp_item', sortable: true},
	        {header: "<?php __('Plan Id'); ?>", dataIndex: 'plan_id', sortable: true,hidden:true},
			//{header: "<?php __('BudgetYears'); ?>", dataIndex: 'budget_years', sortable: true},
			
			{header: "<?php __('March End'); ?>", dataIndex: 'march_end', sortable: true},
			{header: "<?php __('June Estimate'); ?>", dataIndex: 'june_end', sortable: true},
			{header: "<?php __('July'); ?>", dataIndex: 'july', sortable: true},
			{header: "<?php __('August'); ?>", dataIndex: 'august', sortable: true},
			{header: "<?php __('September'); ?>", dataIndex: 'september', sortable: true},
			{header: "<?php __('October'); ?>", dataIndex: 'october', sortable: true},
			{header: "<?php __('November'); ?>", dataIndex: 'november', sortable: true},
			{header: "<?php __('December'); ?>", dataIndex: 'december', sortable: true},
			{header: "<?php __('January'); ?>", dataIndex: 'january', sortable: true},
			{header: "<?php __('February'); ?>", dataIndex: 'february', sortable: true},
			{header: "<?php __('March'); ?>", dataIndex: 'march', sortable: true},
			{header: "<?php __('April'); ?>", dataIndex: 'april', sortable: true},
			{header: "<?php __('May'); ?>", dataIndex: 'may', sortable: true},
			{header: "<?php __('June'); ?>", dataIndex: 'june', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Plans" : "Plan"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewSpPlan(Ext.getCmp('spPlan-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add Budget'); ?>',
					tooltip:'<?php __('<b>Add Plan</b><br />Click here to create a new Plan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
hidden:'<?php echo $active; ?>',
					handler: function(btn) {
						AddSpPlan();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Submit All'); ?>',
					id: 'finalize-spPlan',
					tooltip:'<?php __('<b>Submit Plan</b><br />Click here to modify the selected SpPlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
                                       hidden:'<?php echo $active; ?>',
					handler: function(btn) {
 if(store_spPlans.getCount()>0){
						Ext.Msg.show({
									title: '<?php __('Submit Plan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Confirm Submitting'); ?> ',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											FinalizeSpPlan(-1);
										}
									}
								});
}
}			
	}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-spPlan',
					tooltip:'<?php __('<b>Edit SpPlans</b><br />Click here to modify the selected SpPlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
hidden:'<?php echo $active; ?>',
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSpPlan(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Remove'); ?>',
					id: 'delete-spPlan',
					tooltip:'<?php __('<b>Delete SpPlans(s)</b><br />Click here to remove the selected SpPlan(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
hidden:'<?php echo $active; ?>',
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove SpPlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteSpPlan(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove SpPlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected SpPlans'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteSpPlan(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('Check Errors'); ?>',
hidden:'<?php echo $active; ?>',
					handler: function(btn) {
						window.open("http://10.1.85.11/AbayERP/sp_plans/alert/", "", "width=600,height=600");
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('View Return Comment'); ?>',
hidden:'<?php echo $active; ?>',
					handler: function(btn) {
						window.open("http://10.1.85.11/AbayERP/sp_plans/comment/", "", "width=600,height=600");
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<p style="color:red"><?php __('Plan is not active for any modification'); ?></p> ',
					hidden:'<?php echo  !$active; ?>',
					handler: function(btn) {
						window.open("http://localhost:82/AbayERP/sp_plans/alert/", "", "width=600,height=600");
					}
				}, '->',{
					xtype: 'tbbutton',
					text: '<b><?php __('Budget Year: ');__($by); ?></b>'
				}, '->', {
					xtype: 'tbsplit',
					text: '<?php __('Reports'); ?>',
					id: 'view-shiftRequest',
					tooltip:'<?php __('<b>View reports</b><br />Click here to see list of reports'); ?>',
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
						window.open("http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5CPlan_Detail.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=50&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report&-1447231237&branch="+"<?php echo $b_id; ?>", "_blank");
					}
				}
,{
					
					text: '<b><?php __('Deposite Mobilization'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Cdeposite_aggregate.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176&branch="+"<?php echo $b_id; ?>", "_blank");
					}
				},{
					
					text: '<b><?php __('Customer Attraction'); ?></b>',
					icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
					handler: function(btn) {
						window.open("http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Ccustomer_attraction_aggregate.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=10&__resourceFolder=C%3A%5CUsers%5Cmhenoke%5Cworkspace%5CStrategyPlan&1810435176&branch="+"<?php echo $b_id; ?>", "_blank");
					}
				}
						]
					}
				}		
]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_spPlans,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-spPlan').enable();
		//p.getTopToolbar().findById('finalize-spPlan').enable();
		p.getTopToolbar().findById('delete-spPlan').enable();
		p.getTopToolbar().findById('view-spPlan').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spPlan').disable();
			//p.getTopToolbar().findById('finalize-spPlan').disable();
			p.getTopToolbar().findById('view-spPlan').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('finalize-spPlan').disable();
			p.getTopToolbar().findById('edit-spPlan').disable();
			p.getTopToolbar().findById('view-spPlan').disable();
			p.getTopToolbar().findById('delete-spPlan').enable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('finalize-spPlan').enable();
			p.getTopToolbar().findById('edit-spPlan').enable();
			p.getTopToolbar().findById('view-spPlan').enable();
			p.getTopToolbar().findById('delete-spPlan').enable();
		}
		else{
			//p.getTopToolbar().findById('finalize-spPlan').disable();
			p.getTopToolbar().findById('edit-spPlan').disable();
			p.getTopToolbar().findById('view-spPlan').disable();
			p.getTopToolbar().findById('delete-spPlan').disable();
		}
	});	center_panel.setActiveTab(p);
	
	store_spPlans.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
