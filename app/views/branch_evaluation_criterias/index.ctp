
var store_branchEvaluationCriterias = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','goal','measure','target','weight','direction','status'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'list_data')); ?>'
	})

});


function AddBranchEvaluationCriteria() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchEvaluationCriteria_data = response.responseText;
			
			eval(branchEvaluationCriteria_data);
			
			BranchEvaluationCriteriaAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchEvaluationCriteria add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchEvaluationCriteria(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchEvaluationCriteria_data = response.responseText;
			
			eval(branchEvaluationCriteria_data);
			
			BranchEvaluationCriteriaEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchEvaluationCriteria edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchEvaluationCriteria(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchEvaluationCriteria_data = response.responseText;

            eval(branchEvaluationCriteria_data);

            BranchEvaluationCriteriaViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchEvaluationCriteria view form. Error code'); ?>: ' + response.status);
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


function DeleteBranchEvaluationCriteria(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchEvaluationCriteria successfully deleted!'); ?>');
			RefreshBranchEvaluationCriteriaData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchEvaluationCriteria add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchEvaluationCriteria(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchEvaluationCriteria_data = response.responseText;

			eval(branchEvaluationCriteria_data);

			branchEvaluationCriteriaSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchEvaluationCriteria search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchEvaluationCriteriaName(value){
	var conditions = '\'BranchEvaluationCriteria.name LIKE\' => \'%' + value + '%\'';
	store_branchEvaluationCriterias.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchEvaluationCriteriaData() {
	store_branchEvaluationCriterias.reload();
}


if(center_panel.find('id', 'branchEvaluationCriteria-tab') != "") {
	var p = center_panel.findById('branchEvaluationCriteria-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Evaluation Criterias'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchEvaluationCriteria-tab',
		xtype: 'grid',
		store: store_branchEvaluationCriterias,
		columns: [
			{header: "<?php __('Goal'); ?>", dataIndex: 'goal', sortable: true},
			{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true},
			{header: "<?php __('Target'); ?>", dataIndex: 'target', sortable: true},
			{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true},
			{header: "<?php __('Direction'); ?>", dataIndex: 'direction', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchEvaluationCriterias" : "BranchEvaluationCriteria"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchEvaluationCriteria(Ext.getCmp('branchEvaluationCriteria-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchEvaluationCriterias</b><br />Click here to create a new BranchEvaluationCriteria'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchEvaluationCriteria();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchEvaluationCriteria',
					tooltip:'<?php __('<b>Edit BranchEvaluationCriterias</b><br />Click here to modify the selected BranchEvaluationCriteria'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchEvaluationCriteria(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View BranchEvaluationCriteria'); ?>',
					id: 'view-branchEvaluationCriteria',
					tooltip:'<?php __('<b>View BranchEvaluationCriteria</b><br />Click here to see details of the selected BranchEvaluationCriteria'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchEvaluationCriteria(sel.data.id);
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
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchEvaluationCriteria();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchEvaluationCriterias,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchEvaluationCriteria').enable();
		
		p.getTopToolbar().findById('view-branchEvaluationCriteria').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchEvaluationCriteria').disable();
			p.getTopToolbar().findById('view-branchEvaluationCriteria').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchEvaluationCriteria').disable();
			p.getTopToolbar().findById('view-branchEvaluationCriteria').disable();
			
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchEvaluationCriteria').enable();
			p.getTopToolbar().findById('view-branchEvaluationCriteria').enable();
			
		}
		else{
			p.getTopToolbar().findById('edit-branchEvaluationCriteria').disable();
			p.getTopToolbar().findById('view-branchEvaluationCriteria').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchEvaluationCriterias.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
