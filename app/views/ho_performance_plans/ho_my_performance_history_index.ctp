
var store_hoPerformancePlans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter', 'employee',
		 'plan_status','result_status','comment'		 
			]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'ho_my_performance_history_list')); ?>'
	})
 
<!--	,sortInfo:{field: 'name', direction: "ASC"}, -->
	<!-- groupField: 'budget_year_id' -->
});

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});
function my_technical_report(id){
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'ho_my_objectives_report')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			myMask.hide();	
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}	

function my_behavioural_report(id){
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'ho_my_behavioural_report')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			myMask.hide();
			
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



var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

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
                    text: '<b>My Technical Report </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
						my_technical_report(record.get('id'));
					   
                    }
                }
				,{
                    text: '<b>My Behavioural Report </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       my_behavioural_report(record.get('id'));
					   
                    }
                }
            ]
        }).showAt(event.xy);
}


if(center_panel.find('id', 'myPerformanceHistory-tab') != "") {
	var p = center_panel.findById('myPerformanceHistory-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('My HO performance history'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'myPerformanceHistory-tab',
		xtype: 'grid',
		store: store_hoPerformancePlans,
		columns: [
			
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			
			
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
			
			items: ['<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
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
 '->',  {
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
		
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		
	});
	center_panel.setActiveTab(p);
	
	store_hoPerformancePlans.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
