
var store_competenceResults = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','budget_year','quarter','employee'	,'result_status',	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'list_data')); ?>'
	})
<!-- ,	sortInfo:{field: 'budget_year_id', direction: "ASC"} -->
<!-- , groupField: 'quarter' -->
});


function AddCompetenceResult() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var competenceResult_data = response.responseText;
			
			eval(competenceResult_data);
			
			CompetenceResultAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCompetenceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var competenceResult_data = response.responseText;
			
			eval(competenceResult_data);
			
			CompetenceResultEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ChangeStatus(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'change_status')); ?>/'+id,
		success: function(response, opts) {
			var competenceResult_data = response.responseText;
			
			eval(competenceResult_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult form. Error code'); ?>: ' + response.status);
		}
	});
}

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			var competenceResult_data = response.responseText;
			
			//eval(competenceResult_data);

			myMask.hide();

			store_competenceResults.reload();
			
			//CompetenceResultEditWindow.show();
		},
		failure: function(response, opts) {
			myMask.hide();
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult edit form. Error code'); ?>: ' + response.status);
			
		}
	});
}

function ViewCompetenceResult(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var competenceResult_data = response.responseText;

            eval(competenceResult_data);

            CompetenceResultViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCompetenceResult(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CompetenceResult successfully deleted!'); ?>');
			RefreshCompetenceResultData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceResult add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCompetenceResult(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'search')); ?>',
		success: function(response, opts){
			var competenceResult_data = response.responseText;

			eval(competenceResult_data);

			competenceResultSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the competenceResult search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompetenceResultName(value){
	var conditions = '\'CompetenceResult.name LIKE\' => \'%' + value + '%\'';
	store_competenceResults.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompetenceResultData() {
	store_competenceResults.reload();
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
                     //  RecalculateRefresh(record.get('id'));
                    }
                }
				
            ]
        }).showAt(event.xy);
    }


if(center_panel.find('id', 'competenceResult-tab') != "") {
	var p = center_panel.findById('competenceResult-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Results'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'competenceResult-tab',
		xtype: 'grid',
		store: store_competenceResults,
		columns: [
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Result Status'); ?>", dataIndex: 'result_status', sortable: true},
			
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CompetenceResults" : "CompetenceResult"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCompetenceResult(Ext.getCmp('competenceResult-tab').getSelectionModel().getSelected().data.id);
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
					tooltip:'<?php __('<b>Add CompetenceResults</b><br />Click here to create a new CompetenceResult'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCompetenceResult();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-competenceResult',
					tooltip:'<?php __('<b>Edit CompetenceResults</b><br />Click here to modify the selected CompetenceResult'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCompetenceResult(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-competenceResult',
					tooltip:'<?php __('<b>Delete CompetenceResults(s)</b><br />Click here to remove the selected CompetenceResult(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCompetenceResult(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CompetenceResult'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CompetenceResults'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCompetenceResult(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View CompetenceResult'); ?>',
					id: 'view-competenceResult',
					tooltip:'<?php __('<b>View CompetenceResult</b><br />Click here to see details of the selected CompetenceResult'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCompetenceResult(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
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
							store_competenceResults.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
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
						SearchCompetenceResult();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_competenceResults,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-competenceResult').enable();
		p.getTopToolbar().findById('delete-competenceResult').enable();
		p.getTopToolbar().findById('view-competenceResult').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceResult').disable();
			p.getTopToolbar().findById('view-competenceResult').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-competenceResult').disable();
			p.getTopToolbar().findById('view-competenceResult').disable();
			p.getTopToolbar().findById('delete-competenceResult').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-competenceResult').enable();
			p.getTopToolbar().findById('view-competenceResult').enable();
			p.getTopToolbar().findById('delete-competenceResult').enable();
		}
		else{
			p.getTopToolbar().findById('edit-competenceResult').disable();
			p.getTopToolbar().findById('view-competenceResult').disable();
			p.getTopToolbar().findById('delete-competenceResult').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_competenceResults.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
