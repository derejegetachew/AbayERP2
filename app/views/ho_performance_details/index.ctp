
var store_hoPerformanceDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','perspective','objective','plan_description','plan_in_number','actual_result','measure','weight','accomplishment','total_score','final_score','direction'
			<!-- 'five_pointer_min_included','five_pointer_max','four_pointer_min_included','four_pointer_max','three_pointer_min_included','three_pointer_max','two_pointer_min_included','two_pointer_max','one_pointer_min_included','one_pointer_max','ho_performance_plan'	 -->	
			] 
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'list_data')); ?>'
	})
,	
<!-- sortInfo:{field: 'objective', direction: "ASC"}, -->
	<!-- groupField: 'perspective' -->
});


function AddHoPerformanceDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var hoPerformanceDetail_data = response.responseText;
			
			eval(hoPerformanceDetail_data);
			
			HoPerformanceDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditHoPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformanceDetail_data = response.responseText;
			
			eval(hoPerformanceDetail_data);
			
			HoPerformanceDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoPerformanceDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var hoPerformanceDetail_data = response.responseText;

            eval(hoPerformanceDetail_data);

            HoPerformanceDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteHoPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('HoPerformanceDetail successfully deleted!'); ?>');
			RefreshHoPerformanceDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchHoPerformanceDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var hoPerformanceDetail_data = response.responseText;

			eval(hoPerformanceDetail_data);

			hoPerformanceDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the hoPerformanceDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByHoPerformanceDetailName(value){
	var conditions = '\'HoPerformanceDetail.name LIKE\' => \'%' + value + '%\'';
	store_hoPerformanceDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshHoPerformanceDetailData() {
	store_hoPerformanceDetails.reload();
}


var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			myMask.hide();
			var hoPerformanceDetail_data = response.responseText;
			
		   // eval(hoPerformanceDetail_data);
			
			
			store_hoPerformanceDetails.reload();
		},
		failure: function(response, opts) {
			myMask.hide();
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
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
                    text: '<b>Recalculate / Refresh </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       RecalculateRefresh(record.get('id'));
					   
                    }
                }
            ]
        }).showAt(event.xy);
    }


if(center_panel.find('id', 'hoPerformanceDetail-tab') != "") {
	var p = center_panel.findById('hoPerformanceDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ho Performance Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'hoPerformanceDetail-tab',
		xtype: 'grid',
		store: store_hoPerformanceDetails,
		columns: [
			{header: "<?php __('Perspective'); ?>", dataIndex: 'perspective', sortable: true},
			{header: "<?php __('Objective'); ?>", dataIndex: 'objective', sortable: true},
			{header: "<?php __('Plan Description'); ?>", dataIndex: 'plan_description', sortable: true},
			{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true},
			{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true},
			{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true},
			{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true},
			{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true},
			{header: "<?php __('Total Score'); ?>", dataIndex: 'total_score', sortable: true},
			{header: "<?php __('Final Score'); ?>", dataIndex: 'final_score', sortable: true},
			{header: "<?php __('Direction'); ?>", dataIndex: 'direction', sortable: true},
		
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "HoPerformanceDetails" : "HoPerformanceDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewHoPerformanceDetail(Ext.getCmp('hoPerformanceDetail-tab').getSelectionModel().getSelected().data.id);
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
					tooltip:'<?php __('<b>Add HoPerformanceDetails</b><br />Click here to create a new HoPerformanceDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddHoPerformanceDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-hoPerformanceDetail',
					tooltip:'<?php __('<b>Edit HoPerformanceDetails</b><br />Click here to modify the selected HoPerformanceDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditHoPerformanceDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-hoPerformanceDetail',
					tooltip:'<?php __('<b>Delete HoPerformanceDetails(s)</b><br />Click here to remove the selected HoPerformanceDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove HoPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteHoPerformanceDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove HoPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected HoPerformanceDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteHoPerformanceDetail(sel_ids);
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
					text: '<?php __('View HoPerformanceDetail'); ?>',
					id: 'view-hoPerformanceDetail',
					tooltip:'<?php __('<b>View HoPerformanceDetail</b><br />Click here to see details of the selected HoPerformanceDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewHoPerformanceDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				},  {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'hoPerformanceDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByHoPerformanceDetailName(Ext.getCmp('hoPerformanceDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'hoPerformanceDetail_go_button',
					handler: function(){
						SearchByHoPerformanceDetailName(Ext.getCmp('hoPerformanceDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchHoPerformanceDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_hoPerformanceDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-hoPerformanceDetail').enable();
		p.getTopToolbar().findById('delete-hoPerformanceDetail').enable();
		p.getTopToolbar().findById('view-hoPerformanceDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-hoPerformanceDetail').disable();
			p.getTopToolbar().findById('view-hoPerformanceDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-hoPerformanceDetail').disable();
			p.getTopToolbar().findById('view-hoPerformanceDetail').disable();
			p.getTopToolbar().findById('delete-hoPerformanceDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-hoPerformanceDetail').enable();
			p.getTopToolbar().findById('view-hoPerformanceDetail').enable();
			p.getTopToolbar().findById('delete-hoPerformanceDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-hoPerformanceDetail').disable();
			p.getTopToolbar().findById('view-hoPerformanceDetail').disable();
			p.getTopToolbar().findById('delete-hoPerformanceDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_hoPerformanceDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
