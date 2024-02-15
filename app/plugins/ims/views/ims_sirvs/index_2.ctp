//<script>
var store_imsSirvs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_requisition','ims_branch','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'list_data2')); ?>'
	})
,	sortInfo:{field: 'name', direction: "DESC"},
	groupField: 'ims_branch'
});

var store_requisition = new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($requisitions as $item){if($st) echo ",
							";?>['<?php echo $item['ImsRequisition']['id']; ?>' ,'<?php echo $item['ImsRequisition']['name']; ?>']<?php $st = true;}?>						]
					});

var filter_conditions = '';

function ViewImsSirv(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsSirv_data = response.responseText;

            eval(imsSirv_data);

            ImsSirvViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirv view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsSirvItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsSirvItems_data = response.responseText;

            eval(parent_imsSirvItems_data);

            parentImsSirvItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function SearchImsSirv(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsSirv_data = response.responseText;

			eval(imsSirv_data);

			imsSirvSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsSirv search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsSirvName(value){
	var conditions = '\'ImsSirv.name LIKE\' => \'%' + value + '%\'';
	filter_conditions = conditions;
	store_imsSirvs.setBaseParam('query', filter_conditions);
	store_imsSirvs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsSirvData() {
	store_imsSirvs.reload();
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

function PrintSIRV(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'imsSirvs', 'action' => 'print_sirv1')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = (record.get('status') == 'completed')? false: true;
		var btnStatus1 = true;
		<?php foreach($groups as $group){
			if($group['name'] == 'Stock Supervisor'){
			?>
				btnStatus1 = (record.get('status') == 'completed')? false: true;
			<?php
			}			
			else if ($group['name'] == 'Administrators'){
			?>
				btnStatus1 = (record.get('status') == 'completed')? false: true;				
		<?php
		}		
		}
		?>	
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Print SIRV</b>',
                    icon: 'img/table_print.png',
                    handler: function() {
                        PrintSIRV(record.get('id'));
                    },
                    disabled: btnStatus
                }
            ]
        }).showAt(event.xy);
    }

if(center_panel.find('id', 'imsSirv-tab2') != "") {
	var p = center_panel.findById('imsSirv-tab2');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('All Branch Claims'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsSirv-tab2',
		xtype: 'grid',		
		store: store_imsSirvs,
		columns: [
			{header: "<?php __('SIRV'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Requisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'ims_branch', sortable: true, hidden:true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Sirvs" : "Sirv"]})'
        })
,
		listeners: {
			celldblclick: function(){
				PrintSIRV(Ext.getCmp('imsSirv-tab2').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid, index, event) {
				showMenu(grid, index, event);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbsplit',
					text: '<?php __('View Sirv'); ?>',
					id: 'view-imsSirv',
					tooltip:'<?php __('<b>View ImsSirv</b><br />Click here to see details of the selected ImsSirv'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsSirv(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View SIRV Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsSirvItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Requisition'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : store_requisition,
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
						
							filter_conditions = combo.getValue();
							store_imsSirvs.setBaseParam('query', filter_conditions);
								
							store_imsSirvs.reload({
								params: {
									start: 0,
									limit: list_size,
									imsrequisition_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsSirv_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsSirvName(Ext.getCmp('imsSirv_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsSirv_go_button',
					handler: function(){					
						SearchByImsSirvName(Ext.getCmp('imsSirv_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsSirv();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsSirvs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		
		p.getTopToolbar().findById('view-imsSirv').enable();
		if(this.getSelections().length > 1){
			
			p.getTopToolbar().findById('view-imsSirv').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			
			p.getTopToolbar().findById('view-imsSirv').disable();
			
		}
		else if(this.getSelections().length == 1){
			
			p.getTopToolbar().findById('view-imsSirv').enable();
			
		}
		else{
			
			p.getTopToolbar().findById('view-imsSirv').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsSirvs.setBaseParam('query', filter_conditions);
	
	store_imsSirvs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
