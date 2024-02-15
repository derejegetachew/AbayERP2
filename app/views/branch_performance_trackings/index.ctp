
var store_branchPerformanceTrackings = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','goal','date','value'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'list_data')); ?>'
	})

});

var is_district_branch_manager = '<?php echo $is_district_branch_mgr; ?>';

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
				html: 'This is available only for district and branch managers!'
			}
				],
			
			buttons: [  
				 {
				text: '<?php __('Ok'); ?>',
				handler: function(btn){
					var p = center_panel.findById('branchPerformanceTracking-tab');
					center_panel.remove('branchPerformanceTracking-tab');
					
					DialogWindow.close();
				}
			}]
		});


function AddBranchPerformanceTracking() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchPerformanceTracking_data = response.responseText;
			
			eval(branchPerformanceTracking_data);
			
			BranchPerformanceTrackingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchPerformanceTracking(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceTracking_data = response.responseText;
			
			eval(branchPerformanceTracking_data);
			
			BranchPerformanceTrackingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceTracking(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchPerformanceTracking_data = response.responseText;

            eval(branchPerformanceTracking_data);

            BranchPerformanceTrackingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBranchPerformanceTracking(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceTracking successfully deleted!'); ?>');
			RefreshBranchPerformanceTrackingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTracking add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchPerformanceTracking(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchPerformanceTracking_data = response.responseText;

			eval(branchPerformanceTracking_data);

			branchPerformanceTrackingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchPerformanceTracking search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchPerformanceTrackingName(value){
	var conditions = '\'BranchPerformanceTracking.name LIKE\' => \'%' + value + '%\'';
	store_branchPerformanceTrackings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchPerformanceTrackingData() {
	store_branchPerformanceTrackings.reload();
}


if(center_panel.find('id', 'branchPerformanceTracking-tab') != "") {
	var p = center_panel.findById('branchPerformanceTracking-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Performance Trackings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchPerformanceTracking-tab',
		xtype: 'grid',
		store: store_branchPerformanceTrackings,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Goal'); ?>", dataIndex: 'goal', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchPerformanceTrackings" : "BranchPerformanceTracking"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchPerformanceTracking(Ext.getCmp('branchPerformanceTracking-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchPerformanceTrackings</b><br />Click here to create a new BranchPerformanceTracking'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchPerformanceTracking();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchPerformanceTracking',
					tooltip:'<?php __('<b>Edit BranchPerformanceTrackings</b><br />Click here to modify the selected BranchPerformanceTracking'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchPerformanceTracking(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View BranchPerformanceTracking'); ?>',
					id: 'view-branchPerformanceTracking',
					tooltip:'<?php __('<b>View BranchPerformanceTracking</b><br />Click here to see details of the selected BranchPerformanceTracking'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchPerformanceTracking(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchPerformanceTracking();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchPerformanceTrackings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchPerformanceTracking').enable();
		
		p.getTopToolbar().findById('view-branchPerformanceTracking').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceTracking').disable();
			p.getTopToolbar().findById('view-branchPerformanceTracking').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceTracking').disable();
			p.getTopToolbar().findById('view-branchPerformanceTracking').disable();
			p
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchPerformanceTracking').enable();
			p.getTopToolbar().findById('view-branchPerformanceTracking').enable();
			
		}
		else{
			p.getTopToolbar().findById('edit-branchPerformanceTracking').disable();
			p.getTopToolbar().findById('view-branchPerformanceTracking').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchPerformanceTrackings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});


	if(is_district_branch_manager != 1 ){
		DialogWindow.show();
	}
	
}
