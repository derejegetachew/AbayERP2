
var store_bpActuals = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields:['id','branch','month','amount','bp_item','budget_year']
	}),
	proxy: new Ext.data.HttpProxy({
	url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'amount', direction: "ASC"},
	groupField: 'branch'
});


function AddBpActual() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpActual_data = response.responseText;
			
			eval(bpActual_data);
			
			BpActualAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpActual_data = response.responseText;
			
			eval(bpActual_data);
			
			BpActualEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpActual(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpActual_data = response.responseText;

            eval(bpActual_data);
			
            BpActualViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual view form. Error code'); ?>: ' + response.status);
        }
    });
}

function fetch(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'fetch')); ?>/'+id,
        success: function(response, opts) {
            var bpActual_data = response.responseText;

            eval(bpActual_data);

            BpActualViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual view form. Error code'); ?>: ' + response.status);
        }
    });
}
function DeleteBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActual successfully deleted!'); ?>');
			RefreshBpActualData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpActual(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			bpActualSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpActual search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpActualName(value){
	var conditions = '\'BpActual.name LIKE\' => \'%' + value + '%\'';
	store_bpActuals.reload({
		 params: {
			start: 0,
			limit: 10000,
			conditions: conditions
	    }
	});
}

function RefreshBpActualData() {
	store_bpActuals.reload();
}


if(center_panel.find('id', 'bpActual-tab') != "") {
	var p = center_panel.findById('bpActual-tab');
	center_panel.setActiveTab(p);
} else {
	 var win=new Ext.Window({
        title: 'Bottom Header, plain: true',
        width: 400,
        height: 200,
        plain: true,
        x:100,y:100,
        headerPosition: 'bottom',
        layout: 'fit',
        items: {
            border: false
        }
    });
	
	var p = center_panel.add({
		title: '<?php __('Bp Actuals'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpActual-tab',
		xtype: 'grid',
		store: store_bpActuals,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Month'); ?>",  dataIndex: 'month', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,hidden:true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('Item'); ?>",   dataIndex: 'bp_item', sortable: true,hidden:true},
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
			//{header: "<?php __('Created'); ?>",     dataIndex: 'created', sortable: true},
			//{header: "<?php __('Modified'); ?>",    dataIndex: 'modified', sortable: true,hidden:true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ',
			listeners:{
				refresh:function(){
					this.toggleAllGroups();
				}
			}
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpActual(Ext.getCmp('bpActual-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true
		}),
		tbar: new Ext.Toolbar({
			
			items: [' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Add Actual Plan'); ?>',
					id: 'view-bpActual',
					tooltip:'<?php __('<b>View BpActual</b><br />Click here to see details of the selected BpActual'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled:true,
					handler: function(btn) {
							var s = p.getSelectionModel();
							fetch(s.getSelected().data.id);					 
					},
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
							data : [
							['-1', 'All'],
     <?php $st = false;
     foreach ($branches as $item){
     	if($st) echo ",";?>
     ['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']
     <?php $st = true; }
     ?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_bpActuals.reload({
								params: {
									start: 0,
									limit: 10000,
									branch_id : combo.getValue()
								}
							});
						}
					}
				}, '->' , { 
	            xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpActual_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpActualName(Ext.getCmp('bpActual_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpActual_go_button',
					handler: function(){
						SearchByBpActualName(Ext.getCmp('bpActual_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpActual();
					}
				}
	]
		}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpActuals,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	
	
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		//p.getTopToolbar().findById('edit-bpActual').enable();
		//p.getTopToolbar().findById('delete-bpActual').enable();
		p.getTopToolbar().findById('view-bpActual').enable();
		if(this.getSelections().length > 1){
		//	p.getTopToolbar().findById('edit-bpActual').disable();
			//p.getTopToolbar().findById('view-bpActual').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpActual').disable();
			p.getTopToolbar().findById('view-bpActual').disable();
			p.getTopToolbar().findById('delete-bpActual').enable();
		}
		else if(this.getSelections().length == 1){
		//	p.getTopToolbar().findById('edit-bpActual').enable();
			p.getTopToolbar().findById('view-bpActual').enable();
			//p.getTopToolbar().findById('delete-bpActual').enable();
		}
		else{
		//	p.getTopToolbar().findById('edit-bpActual').disable();
			p.getTopToolbar().findById('view-bpActual').disable();
			//p.getTopToolbar().findById('delete-bpActual').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpActuals.load({
		params: {
			start: 0,          
			limit: 10000
		}
	});
	
}
