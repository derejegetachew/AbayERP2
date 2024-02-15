//<script>


var store_dmsMessagesDetail = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','message'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'list_data3')); ?>/'+id
	})
});

function AssignCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsAssignmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the assignment form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDmsMessage(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'search')); ?>',
		success: function(response, opts){
			var dmsMessage_data = response.responseText;

			eval(dmsMessage_data);

			dmsMessageSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the dmsMessage search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDmsMessageName(value){
	var conditions = '\'DmsMessage.name LIKE\' => \'%' + value + '%\'';
	store_dmsMessages.reload({
		 params: {
			start: 0,
			limit: 30,
			conditions: conditions
	    }
	});
}

function RefreshDmsMessageData() {
	store_dmsMessages.reload();
}

function RefreshDmsMessageDetailData() {
	store_dmsMessagesDetail.reload();
}

var g = new Ext.Panel({
		items : [{
        xtype : "component",
        autoEl : {
            tag : "iframe",
            src : "",
			style: "border:none;height: inherit;width:100%", //-moz-available;
			id:"message_detail"
        }
    }],
		id : 'g'	
});
/*
var main = new Ext.grid.GridPanel({
	height : 518,
	width  : 390,
	 style:{
            display:'inline-block'
        },
	id:'main',
	loadMask: true,
	store: store_dmsMessages,
	cls: 'custom-grid',
	columns: [
		{header: "<?php __('Messages'); ?>", dataIndex: 'name'}
	],
		
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsMessages" : "DmsMessage"]})'
	}),
	listeners: {
		cellclick: function(){
		var el = document.getElementById('message_detail');
		el.src="about:blank";
		el.contentWindow.document.write("Loading...");
		el.src = '/AbayERP/dms/dms_messages/view_detail/'+Ext.getCmp('main').getSelectionModel().getSelected().data.id+'/inbox';
		
		}
	},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),	
	bbar: new Ext.PagingToolbar({
		pageSize: 30,
		id: 'bbar_store_dmsMessages',
		store: store_dmsMessages,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});*/
var main = new Ext.grid.GridPanel({
	layout:'fit',
	width: 390,
	id:'main',
	loadMask: true,
	store: store_dmsMessages,
	cls: 'custom-grid',
	columns: [
		{header: "<?php __('Messages'); ?>", dataIndex: 'name'}
	],
		
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsMessages" : "DmsMessage"]})'
	}),
	listeners: {
		cellclick: function(){
		var el = document.getElementById('message_detail');
		el.src="about:blank";
		el.contentWindow.document.write("Loading...");
		el.src = '/AbayERP/dms/dms_messages/view_detail/'+Ext.getCmp('main').getSelectionModel().getSelected().data.id+'/inbox';
		
		}
	},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),	
	bbar: new Ext.PagingToolbar({
		pageSize: 30,
		id: 'bbar_store_dmsMessages',
		store: store_dmsMessages,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});

var main2 = new Ext.grid.GridPanel({
	layout:'fit',
	width: 390,
	id:'main2',
	loadMask: true,
	store: store_dmsMessages1,
	cls: 'custom-grid',
	columns: [
		{header: "<?php __('Messages'); ?>", dataIndex: 'name'}
	],
		
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsMessages" : "DmsMessage"]})'
	}),
	listeners: {
		cellclick: function(){
		var el = document.getElementById('message_detail');
		el.src="about:blank";
		el.contentWindow.document.write("Loading...");
		el.src = '/AbayERP/dms/dms_messages/view_detail/'+Ext.getCmp('main2').getSelectionModel().getSelected().data.id+'/sent';
		
		}
	},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),	
	bbar: new Ext.PagingToolbar({
		pageSize: 30,
		id: 'bbar_store_dmsMessages1',
		store: store_dmsMessages1,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
var main3 = new Ext.grid.GridPanel({
	layout:'fit',
	width: 390,
	id:'main3',
	loadMask: true,
	store: store_dmsMessages2,
	cls: 'custom-grid',
	columns: [
		{header: "<?php __('Messages'); ?>", dataIndex: 'name'}
	],
		
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsMessages" : "DmsMessage"]})'
	}),
	listeners: {
		cellclick: function(){
		var el = document.getElementById('message_detail');
		el.src="about:blank";
		el.contentWindow.document.write("Loading...");
		el.src = '/AbayERP/dms/dms_messages/view_detail/'+Ext.getCmp('main3').getSelectionModel().getSelected().data.id+'/inbox';
		
		}
	},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),	
	bbar: new Ext.PagingToolbar({
		pageSize: 30,
		id: 'bbar_store_dmsMessages2',
		store: store_dmsMessages2,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
/*if(center_panel.find('id', 'dmsMessage-tab') != "") {
	var p = center_panel.findById('dmsMessage-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Messages'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsMessage-tab',
		items:[main,g]
		
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-dmsMessage').enable();
		p.getTopToolbar().findById('delete-dmsMessage').enable();
		p.getTopToolbar().findById('view-dmsMessage').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsMessage').disable();
			p.getTopToolbar().findById('view-dmsMessage').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsMessage').disable();
			p.getTopToolbar().findById('view-dmsMessage').disable();
			p.getTopToolbar().findById('delete-dmsMessage').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-dmsMessage').enable();
			p.getTopToolbar().findById('view-dmsMessage').enable();
			p.getTopToolbar().findById('delete-dmsMessage').enable();
		}
		else{
			p.getTopToolbar().findById('edit-dmsMessage').disable();
			p.getTopToolbar().findById('view-dmsMessage').disable();
			p.getTopToolbar().findById('delete-dmsMessage').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dmsMessages.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}*/
