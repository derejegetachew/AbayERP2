
var store_branchPerformanceSettings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','position','goal','measure','target','weight','five_pointer_min','five_pointer_max_included','four_pointer_min','four_pointer_max_included','three_pointer_min','three_pointer_max_included','two_pointer_min','two_pointer_max_included','one_pointer_min','one_pointer_max_included'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'list_data')); ?>'
	})

});


function AddBranchPerformanceSetting() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchPerformanceSetting_data = response.responseText;
			
			eval(branchPerformanceSetting_data);
			
			BranchPerformanceSettingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchPerformanceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceSetting_data = response.responseText;
			
			eval(branchPerformanceSetting_data);
			
			BranchPerformanceSettingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceSetting(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchPerformanceSetting_data = response.responseText;

            eval(branchPerformanceSetting_data);

            BranchPerformanceSettingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBranchPerformanceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceSetting successfully deleted!'); ?>');
			RefreshBranchPerformanceSettingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchPerformanceSetting(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchPerformanceSetting_data = response.responseText;

			eval(branchPerformanceSetting_data);

			branchPerformanceSettingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchPerformanceSetting search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchPerformanceSettingName(value){
	var conditions = '\'BranchPerformanceSetting.name LIKE\' => \'%' + value + '%\'';
	store_branchPerformanceSettings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchPerformanceSettingData() {
	store_branchPerformanceSettings.reload();
}


if(center_panel.find('id', 'branchPerformanceSetting-tab') != "") {
	var p = center_panel.findById('branchPerformanceSetting-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Performance Settings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchPerformanceSetting-tab',
		xtype: 'grid',
		store: store_branchPerformanceSettings,
		columns: [
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
			{header: "<?php __('Goal'); ?>", dataIndex: 'goal', sortable: true},
			{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true},
			{header: "<?php __('Target'); ?>", dataIndex: 'target', sortable: true},
			{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true},
			{header: "<?php __('Five Pointer Min'); ?>", dataIndex: 'five_pointer_min', sortable: true},
			{header: "<?php __('Five Pointer Max Included'); ?>", dataIndex: 'five_pointer_max_included', sortable: true},
			{header: "<?php __('Four Pointer Min'); ?>", dataIndex: 'four_pointer_min', sortable: true},
			{header: "<?php __('Four Pointer Max Included'); ?>", dataIndex: 'four_pointer_max_included', sortable: true},
			{header: "<?php __('Three Pointer Min'); ?>", dataIndex: 'three_pointer_min', sortable: true},
			{header: "<?php __('Three Pointer Max Included'); ?>", dataIndex: 'three_pointer_max_included', sortable: true},
			{header: "<?php __('Two Pointer Min'); ?>", dataIndex: 'two_pointer_min', sortable: true},
			{header: "<?php __('Two Pointer Max Included'); ?>", dataIndex: 'two_pointer_max_included', sortable: true},
			{header: "<?php __('One Pointer Min'); ?>", dataIndex: 'one_pointer_min', sortable: true},
			{header: "<?php __('One Pointer Max Included'); ?>", dataIndex: 'one_pointer_max_included', sortable: true},
			
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchPerformanceSettings" : "BranchPerformanceSetting"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchPerformanceSetting(Ext.getCmp('branchPerformanceSetting-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchPerformanceSettings</b><br />Click here to create a new BranchPerformanceSetting'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchPerformanceSetting();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchPerformanceSetting',
					tooltip:'<?php __('<b>Edit BranchPerformanceSettings</b><br />Click here to modify the selected BranchPerformanceSetting'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchPerformanceSetting(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View BranchPerformanceSetting'); ?>',
					id: 'view-branchPerformanceSetting',
					tooltip:'<?php __('<b>View BranchPerformanceSetting</b><br />Click here to see details of the selected BranchPerformanceSetting'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchPerformanceSetting(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Position'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($positions as $item){if($st) echo ",
							";?>['<?php echo $item['Position']['id']; ?>' ,'<?php echo $item['Position']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_branchPerformanceSettings.reload({
								params: {
									start: 0,
									limit: list_size,
									position_id : combo.getValue()
								}
							});
						}
					}
				},
 '->',   '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchPerformanceSetting();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchPerformanceSettings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchPerformanceSetting').enable();
	
		p.getTopToolbar().findById('view-branchPerformanceSetting').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceSetting').disable();
			p.getTopToolbar().findById('view-branchPerformanceSetting').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceSetting').disable();
			p.getTopToolbar().findById('view-branchPerformanceSetting').disable();
			
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchPerformanceSetting').enable();
			p.getTopToolbar().findById('view-branchPerformanceSetting').enable();
			
		}
		else{
			p.getTopToolbar().findById('edit-branchPerformanceSetting').disable();
			p.getTopToolbar().findById('view-branchPerformanceSetting').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchPerformanceSettings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
