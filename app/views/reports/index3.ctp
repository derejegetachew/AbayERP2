
var store_reports = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','rows','report_group'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'list_data')); ?>/'+<?php echo $group_id; ?>
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'report_group'
});



function AddReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var report_data = response.responseText;
			
			eval(report_data);
			
			ReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var report_data = response.responseText;
			
			eval(report_data);
			
			ReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPHP(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'editphp')); ?>/'+id,
		success: function(response, opts) {
			var report_data = response.responseText;
			
			eval(report_data);
			
			ReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditSQL(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'editsql')); ?>/'+id,
		success: function(response, opts) {
			var report_data = response.responseText;
			
			eval(report_data);
			
			ReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditCustom(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'editcustom')); ?>/'+id,
		success: function(response, opts) {
			var report_data = response.responseText;
			
			eval(report_data);
			
			ReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function ViewReport(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var report_data = response.responseText;

            eval(report_data);

            ReportViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentReportFields(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_reportFields_data = response.responseText;

            eval(parent_reportFields_data);

            parentReportFieldsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentPayrolls(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_payrolls_data = response.responseText;

            eval(parent_payrolls_data);

            parentPayrollsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Report successfully deleted!'); ?>');
			RefreshReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchReport(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'search')); ?>',
		success: function(response, opts){
			var report_data = response.responseText;

			eval(report_data);

			reportSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the report search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByReportName(value){
	var conditions = '\'Report.name LIKE\' => \'%' + value + '%\'';
	store_reports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshReportData() {
	store_reports.reload();
}


if(center_panel.find('id', 'report-tab') != "") {
	var p = center_panel.findById('report-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'report-tab',
		xtype: 'grid',
		store: store_reports,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('ReportGroup'); ?>", dataIndex: 'report_group', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Reports" : "Report"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewReport(Ext.getCmp('report-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [ '<?php __('ReportGroup'); ?>: ', {
					xtype : 'combo',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php    $st = false;    foreach ($report_groups as $k => $v) {        if ($st)  echo ",";
        ?>['<?php echo $k; ?>' ,'<?php echo $v; ?>']<?php $st = true;}    ?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '<?php echo $group_id;?>',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_reports.reload({
								params: {
									start: 0,
									limit: list_size,
									report_group_id : combo.getValue()
								}
							});
						}
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_reports,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-report').enable();
                p.getTopToolbar().findById('edit-php').enable();
                p.getTopToolbar().findById('edit-sql').enable();
                p.getTopToolbar().findById('edit-custom').enable();
		p.getTopToolbar().findById('delete-report').enable();
		p.getTopToolbar().findById('view-report').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-report').disable();
                         p.getTopToolbar().findById('edit-php').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                        p.getTopToolbar().findById('edit-custom').disable();
			p.getTopToolbar().findById('view-report').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-report').disable();
                          p.getTopToolbar().findById('edit-php').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                        p.getTopToolbar().findById('edit-custom').disable();
			p.getTopToolbar().findById('view-report').disable();
			p.getTopToolbar().findById('delete-report').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-report').enable();
                         p.getTopToolbar().findById('edit-php').enable();
                p.getTopToolbar().findById('edit-sql').enable();
                p.getTopToolbar().findById('edit-custom').enable();
			p.getTopToolbar().findById('view-report').enable();
			p.getTopToolbar().findById('delete-report').enable();
		}
		else{
			p.getTopToolbar().findById('edit-report').disable();
                          p.getTopToolbar().findById('edit-php').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                        p.getTopToolbar().findById('edit-custom').disable();
			p.getTopToolbar().findById('view-report').disable();
			p.getTopToolbar().findById('delete-report').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_reports.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
