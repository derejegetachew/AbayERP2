
var store_reportGroups = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','parent_report_group','name','lft','rght'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'list_data')); ?>'
	})
});


function AddReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var reportGroup_data = response.responseText;
			
			eval(reportGroup_data);
			
			ReportGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var reportGroup_data = response.responseText;
			
			eval(reportGroup_data);
			
			ReportGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportGroup(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var reportGroup_data = response.responseText;

            eval(reportGroup_data);

            ReportGroupViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentReportGroups(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'childReportGroups', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_childReportGroups_data = response.responseText;

            eval(parent_childReportGroups_data);

            parentReportGroupsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentReports(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_reports_data = response.responseText;

            eval(parent_reports_data);

            parentReportsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ReportGroup successfully deleted!'); ?>');
			RefreshReportGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchReportGroup(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'search')); ?>',
		success: function(response, opts){
			var reportGroup_data = response.responseText;

			eval(reportGroup_data);

			reportGroupSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the reportGroup search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByReportGroupName(value){
	var conditions = '\'ReportGroup.name LIKE\' => \'%' + value + '%\'';
	store_reportGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshReportGroupData() {
	store_reportGroups.reload();
	
	var p = center_panel.findById('report_group-tab');
	p.getRootNode().reload();
}

var selected_item_id = 0;
var selected_item_name = '';

if(center_panel.find('id', 'location-tab') != "") {
	var p = center_panel.findById('report_group-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add(
		new Ext.ux.tree.TreeGrid({
			title: '<?php __('ReportGroups'); ?>',
			closable: true,
			id: 'report_group-tab',
			forceFit:true,
			columns:[
				{header: 'ReportGroups', width: 300, dataIndex: 'name'}
			],
			dataUrl: '<?php echo $this->Html->url(array('controller' => 'report_groups', 'action' => 'list_data')); ?>',
			listeners: {
				click: function(n) {
					selected_item_id = n.attributes.id;
					selected_item_name = n.attributes.name;
					p.getTopToolbar().findById('add_reportgroup').enable();
					p.getTopToolbar().findById('edit_reportgroup').enable();
					p.getTopToolbar().findById('delete_reportgroup').enable();
					if(n.attributes.name == 'Root ReportGroup'){
						p.getTopToolbar().findById('edit_reportgroup').disable();
						p.getTopToolbar().findById('delete_reportgroup').disable();
					}
				}
			},
			tbar: new Ext.Toolbar({
				items:[
					{
						xtype: 'tbbutton',
						text: '<?php __('Add'); ?>',
						id: 'add_reportgroup',
						tooltip:'<?php __('Add Child ReportGroup'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								AddReportGroup(selected_item_id);
							}
						}
					},
					{
						xtype: 'tbbutton',
						text: '<?php __('Edit'); ?>',
						id: 'edit_reportgroup',
						tooltip:'<?php __('Edit ReportGroup'); ?>',
						icon: 'img/table_edit.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								EditReportGroup(selected_item_id);
							};
						}
					},' ', '-', ' ',
					{
						xtype: 'tbbutton',
						text: '<?php __('Delete'); ?>',
						id: 'delete_reportgroup',
						tooltip:'<?php __('Delete ReportGroup'); ?>',
						icon: 'img/table_delete.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								Ext.Msg.show({
									title: '<?php __('Remove ReportGroup'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+selected_item_name+' <?php __('with all its child items'); ?>?',
									fn: function(btn){
										if (btn == 'yes'){
											DeleteReportGroup(selected_item_id);
										}
									}
								});
							} else {
								Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
							}
						}
					}
				]
			})
		})
	);
	center_panel.setActiveTab(p);
	
}
