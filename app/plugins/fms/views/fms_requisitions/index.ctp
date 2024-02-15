
var store_fmsRequisitions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','requested_by','approved_by','branch','town','place','departure_date','arrival_date','departure_time','arrival_time','travelers','fms_vehicle','start_odometer','end_odometer','transport_clerk','transport_supervisor','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});


function AssignFmsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'assign')); ?>/'+id,
		success: function(response, opts) {
			var fmsRequisition_data = response.responseText;
			
			eval(fmsRequisition_data);
			
			FmsRequisitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fleet Requisition assign form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsRequisition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsRequisition_data = response.responseText;

            eval(fmsRequisition_data);

            FmsRequisitionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fleet Requisition view form. Error code'); ?>: ' + response.status);
        }
    });
}

function SearchFmsRequisition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsRequisition_data = response.responseText;

			eval(fmsRequisition_data);

			fmsRequisitionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the fleet Requisition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsRequisitionName(value){
	var conditions = '\'FmsRequisition.name LIKE\' => \'%' + value + '%\'';
	store_fmsRequisitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsRequisitionData() {
	store_fmsRequisitions.reload();
}


if(center_panel.find('id', 'fmsRequisition-tab') != "") {
	var p = center_panel.findById('fmsRequisition-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Fleet Requisitions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsRequisition-tab',
		xtype: 'grid',
		store: store_fmsRequisitions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Town'); ?>", dataIndex: 'town', sortable: true},
			{header: "<?php __('Place'); ?>", dataIndex: 'place', sortable: true},
			{header: "<?php __('Departure Date'); ?>", dataIndex: 'departure_date', sortable: true},
			{header: "<?php __('Arrival Date'); ?>", dataIndex: 'arrival_date', sortable: true},
			{header: "<?php __('Departure Time'); ?>", dataIndex: 'departure_time', sortable: true},
			{header: "<?php __('Arrival Time'); ?>", dataIndex: 'arrival_time', sortable: true},
			{header: "<?php __('Travelers'); ?>", dataIndex: 'travelers', sortable: true},
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Start Odometer'); ?>", dataIndex: 'start_odometer', sortable: true},
			{header: "<?php __('End Odometer'); ?>", dataIndex: 'end_odometer', sortable: true},
			{header: "<?php __('Transport Clerk'); ?>", dataIndex: 'transport_clerk', sortable: true},
			{header: "<?php __('Transport Supervisor'); ?>", dataIndex: 'transport_supervisor', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsRequisitions" : "FmsRequisition"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsRequisition(Ext.getCmp('fmsRequisition-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Assign'); ?>',
					id: 'assign-fmsRequisition',
					tooltip:'<?php __('<b>Assign FmsRequisitions</b><br />Click here to modify the selected FmsRequisition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							AssignFmsRequisition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View FmsRequisition'); ?>',
					id: 'view-fmsRequisition',
					tooltip:'<?php __('<b>View FmsRequisition</b><br />Click here to see details of the selected FmsRequisition'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsRequisition(sel.data.id);
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
							store_fmsRequisitions.reload({
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
					id: 'fmsRequisition_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsRequisitionName(Ext.getCmp('fmsRequisition_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsRequisition_go_button',
					handler: function(){
						SearchByFmsRequisitionName(Ext.getCmp('fmsRequisition_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsRequisition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsRequisitions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('assign-fmsRequisition').enable();
		p.getTopToolbar().findById('view-fmsRequisition').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('assign-fmsRequisition').disable();
			p.getTopToolbar().findById('view-fmsRequisition').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('assign-fmsRequisition').disable();
			p.getTopToolbar().findById('view-fmsRequisition').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('assign-fmsRequisition').enable();
			p.getTopToolbar().findById('view-fmsRequisition').enable();
		}
		else{
			p.getTopToolbar().findById('assign-fmsRequisition').disable();
			p.getTopToolbar().findById('view-fmsRequisition').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsRequisitions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
