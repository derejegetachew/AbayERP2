
var store_grades = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'list_data')); ?>'
	})
});


function AddGrade() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var grade_data = response.responseText;
			
			eval(grade_data);
			
			GradeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grade add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditGrade(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var grade_data = response.responseText;
			
			eval(grade_data);
			
			GradeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grade edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGrade(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var grade_data = response.responseText;

            eval(grade_data);

            GradeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grade view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentPositions(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_positions_data = response.responseText;

            eval(parent_positions_data);

            parentPositionsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentScales(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_scales_data = response.responseText;

            eval(parent_scales_data);

            parentScalesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteGrade(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Grade successfully deleted!'); ?>');
			RefreshGradeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the grade add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchGrade(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'search')); ?>',
		success: function(response, opts){
			var grade_data = response.responseText;

			eval(grade_data);

			gradeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the grade search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByGradeName(value){
	var conditions = '\'Grade.name LIKE\' => \'%' + value + '%\'';
	store_grades.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshGradeData() {
	store_grades.reload();
}

    function ViewDeduction(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_deductions_data = response.responseText;

                eval(parent_deductions_data);

                parentDeductionsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });  
    }
   
        function ViewBenefit(id){
              Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_benefits_data = response.responseText;

                eval(parent_benefits_data);

                parentBenefitsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
        });  
    }
function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Benefits</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        ViewBenefit(record.get('id'));
                    }},
                     {
                    text: '<b>Deductions</b>',
                    icon: 'img/table_delete.png',
                    handler: function() {
                        ViewDeduction(record.get('id'));
                    }
                } ]
        }).showAt(event.xy);
    }

if(center_panel.find('id', 'grade-tab') != "") {
	var p = center_panel.findById('grade-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Grades'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'grade-tab',
		xtype: 'grid',
		store: store_grades,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewGrade(Ext.getCmp('grade-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Grades</b><br />Click here to create a new Grade'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddGrade();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-grade',
					tooltip:'<?php __('<b>Edit Grades</b><br />Click here to modify the selected Grade'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditGrade(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-grade',
					tooltip:'<?php __('<b>Delete Grades(s)</b><br />Click here to remove the selected Grade(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Grade'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteGrade(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Grade'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Grades'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteGrade(sel_ids);
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
					text: '<?php __('View Grade'); ?>',
					id: 'view-grade',
					tooltip:'<?php __('<b>View Grade</b><br />Click here to see details of the selected Grade'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewGrade(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Positions'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPositions(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Scales'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentScales(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'grade_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByGradeName(Ext.getCmp('grade_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'grade_go_button',
					handler: function(){
						SearchByGradeName(Ext.getCmp('grade_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchGrade();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_grades,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-grade').enable();
		p.getTopToolbar().findById('delete-grade').enable();
		p.getTopToolbar().findById('view-grade').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-grade').disable();
			p.getTopToolbar().findById('view-grade').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-grade').disable();
			p.getTopToolbar().findById('view-grade').disable();
			p.getTopToolbar().findById('delete-grade').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-grade').enable();
			p.getTopToolbar().findById('view-grade').enable();
			p.getTopToolbar().findById('delete-grade').enable();
		}
		else{
			p.getTopToolbar().findById('edit-grade').disable();
			p.getTopToolbar().findById('view-grade').disable();
			p.getTopToolbar().findById('delete-grade').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_grades.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
