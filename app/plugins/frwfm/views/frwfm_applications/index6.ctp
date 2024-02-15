
var store_frwfmApplications = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','user','status','order','date','location','mobile_phone','email','amount','currency','expiry_date','license','created','modified','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'list_data6')); ?>'
	})
});


function ApproveFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationApproveWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmApplication(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var frwfmApplication_data = response.responseText;

            eval(frwfmApplication_data);

            FrwfmApplicationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentFrwfmDocuments(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_frwfmDocuments_data = response.responseText;

            eval(parent_frwfmDocuments_data);

            parentFrwfmDocumentsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentFrwfmEvents(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_frwfmEvents_data = response.responseText;

            eval(parent_frwfmEvents_data);

            parentFrwfmEventsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application successfully deleted!'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function ReportFrwfmApplication(){
Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'report')); ?>',
		success: function(response, opts) {
			  var parent_frwfmEvents_data = response.responseText;

            eval(parent_frwfmEvents_data);

            ReportWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function post(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'post')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application successfully sent!'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function Update(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'updatebalance')); ?>',
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication form. Error code'); ?>: ' + response.status);
		}
	});
}
function approve(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function accept(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'accept')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function reject(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'reject')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function SearchFrwfmApplication(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'search')); ?>',
		success: function(response, opts){
			var frwfmApplication_data = response.responseText;

			eval(frwfmApplication_data);

			frwfmApplicationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the frwfmApplication search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFrwfmApplicationName(value){
	var conditions = '\'FrwfmApplication.name LIKE\' => \'%' + value + '%\'';
	store_frwfmApplications.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFrwfmApplicationData() {
	store_frwfmApplications.reload();
}


if(center_panel.find('id', 'frwfmApplication-tab6') != "") {
	var p = center_panel.findById('frwfmApplication-tab6');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Canceled Applications'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmApplication-tab6',
		xtype: 'grid',
		store: store_frwfmApplications,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Order'); ?>", dataIndex: 'order', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmApplications" : "FrwfmApplication"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFrwfmApplication(Ext.getCmp('frwfmApplication-tab6').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [ 

		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_frwfmApplications,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-frwfmApplication').enable();
		
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
		}
		else if(this.getSelections().length == 1){
		p.getTopToolbar().findById('edit-frwfmApplication').enable();
		}
		else{
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_frwfmApplications.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
