
var store_cmsCases = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','case','status','user','user_id','assignedTo','level','branch','ticket','created']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'list_data')); ?>'
	})
});

var store_cmsCasesDetail = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','content'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'list_data')); ?>/'+id
	})
});


function AddCmsCase() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsCaseAddWindow.show();
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase add form. Error code'); ?>: ' + response.status);
		}
	});
}

cmsr = function AddCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'CmsReplies', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsReplyAddWindow.show();
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase add form. Error code'); ?>: ' + response.status);
		}
	});
}

cmsr1 = function AddCmsReply1(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'CmsReplies', 'action' => 'add_1')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsReplyAddWindow1.show();
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase add form. Error code'); ?>: ' + response.status);
		}
	});
}

cmsc = function AddCmsClose(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'close')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Issue successfully closed!'); ?>');
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the issue close form. Error code'); ?>: ' + response.status);
		}
	});
}

cmst = function AddCmsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'transfer')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsTransferAddWindow.show();
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the issue transfer form. Error code'); ?>: ' + response.status);
		}
	});
}

cmsa = function AssignCase(id) {
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

function EditCmsCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cmsCase_data = response.responseText;
			
			eval(cmsCase_data);
			
			CmsCaseEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsCase(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cmsCase_data = response.responseText;

            eval(cmsCase_data);

            CmsCaseViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase view form. Error code'); ?>: ' + response.status);
        }
    });
}

cmsd = function DeleteCmsCase(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsCase successfully deleted!'); ?>');
			RefreshCmsCaseData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsCase add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCmsCase(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cmsCase_data = response.responseText;

			eval(cmsCase_data);

			cmsCaseSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cmsCase search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function ViewParentAttachments(id,posted) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'CmsAttachments', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_attachments_data = response.responseText;

                eval(parent_attachments_data);

                parentCmsAttachmentsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Attachment view form. Error code'); ?>: ' + response.status);
            }
        });
    }

function SearchByCmsCaseName(value){
	var conditions = '\'CmsCase.ticket_number LIKE\' => \'%' + value + '%\'';
	store_cmsCases.reload({
		 params: {
			start: 0,
			limit: list_size,
			search_id: Ext.getCmp('criteriacombo').value,
			search_status: Ext.getCmp('statuscombo').value,
			conditions: conditions
	    }
	});
}

function viewgroups(){
	 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'CmsGroups', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_group = response.responseText;

			eval(parent_group);

			parentCmsGroupsViewWindow.show();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Group view form. Error code'); ?>: ' + response.status);
		}
	});
}

function RefreshCmsCaseData() {
	store_cmsCases.reload({
	   params:{'search_id': Ext.getCmp('criteriacombo').value,'search_status': Ext.getCmp('statuscombo').value}
	});
	
	var el = document.getElementById('case_detail');
	el.src="about:blank";	
	el.src = '/AbayERP/cms/cms_replies/list_data/'+Ext.getCmp('main').getSelectionModel().getSelected().data.id+'/'+Ext.getCmp('criteriacombo').getValue()+'/'+'<?php echo $user_id;?>'+'/'+supervisorbtn;
		
}

function RefreshCmsReplyData() {
	store_cmsCasesDetail.reload();
}
var selectedCase=0;


var groupbtn = true;
var supervisorbtn = false;
<?php foreach($groups as $group){
				if ($group['name'] == 'Administrators'){
			?>
					groupbtn = false;
			<?php
				}
				if ($group['name'] == 'Supervisor'){
			?>
					supervisorbtn = true;
			<?php
				}
			}
			?>

var g = new Ext.Panel({
		items : [{
        xtype : "component",
        autoEl : {
            tag : "iframe",
            src : "",
			style: "border:none;height: inherit;width: -moz-available;",
			id:"case_detail"
        }
    }],
		id : 'g'	
});

var main = new Ext.grid.GridPanel({
	height : 275,
	id:'main',
	style:{
            display:'inline-block'
        },
	store: store_cmsCases,
	cls: 'custom-grid',
	columns: [
		{header: "<?php __('Issues'); ?>", dataIndex: 'case',width: 550, autoSizeColumn: true,sortable: false},
		{header: "<?php __('Ticket No'); ?>", dataIndex: 'ticket',sortable: true},
		{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		//{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: false},
		{header: "<?php __('Assigned To'); ?>", dataIndex: 'assignedTo', sortable: true},
		{header: "<?php __('Severity'); ?>", dataIndex: 'level', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
	],
	
	view: new Ext.grid.GroupingView({
		forceFit:true
	}),
	listeners: {
		cellclick: function(){
			var el = document.getElementById('case_detail');
			el.src="about:blank";
			el.contentWindow.document.write("Loading...");
			el.src = '/AbayERP/cms/cms_replies/list_data/'+this.getSelectionModel().getSelected().data.id+'/'+Ext.getCmp('criteriacombo').getValue()+'/'+'<?php echo $user_id;?>'+'/'+supervisorbtn;
		
		}
	},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: true
	}),
	
	tbar: new Ext.Panel({
			
			items: [
			
			{
			xtype: 'toolbar',
				items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('New Issue'); ?>',
					tooltip:'<?php __('<b>Add CmsCases</b><br />Click here to create a new Case'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCmsCase();
					}
				}, ' ', '-',  '<?php __('Search By: Assignment'); ?> ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],['1' ,'New Cases'],['2','Cases Assigned To Me'],['3','Cases I Created'],['4','Cases Assigned To Others']]
					}),
					displayField : 'name',
					valueField : 'id',
					id:'criteriacombo',
					mode : 'local',
					value : '3',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsCases.reload({
								params: {
									start: 0,
									limit: list_size,
									search_id : combo.getValue(),
									search_status : Ext.getCmp('statuscombo').getValue()
								}
							});
							store_cmsCasesDetail.reload({
								params: {
									id:0				
								}
							});							
						}
					}
				}, ' ', '',  '<?php __('Status'); ?> ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],['created' ,'created'],['Work On Progress','Work On Progress'],['Review Update','Review Update'],['Solution Offered','Solution Offered'],['Closed','Closed']]
					}),
					displayField : 'name',
					valueField : 'id',
					id:'statuscombo',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsCases.reload({
								params: {
									start: 0,
									limit: list_size,
									search_status : combo.getValue(),
									search_id : Ext.getCmp('criteriacombo').getValue()
								}
							});
							store_cmsCasesDetail.reload({
								params: {
									id:0				
								}
							});							
						}
					}
				}
		]},
		{
			xtype: 'toolbar',
				items: [
				{
					xtype: 'textfield',
					emptyText: '<?php __('Search By Ticket Number'); ?>',
					width:200,
					id: 'cmsCase_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCmsCaseName(Ext.getCmp('cmsCase_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cmsCase_go_button',
					handler: function(){
						SearchByCmsCaseName(Ext.getCmp('cmsCase_search_field').getValue());
					}
				}
				
		
		]}		
		]}),
		bbar:[ new Ext.PagingToolbar({
			pageSize: 40,
			store: store_cmsCases,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			listeners: {
				beforechange: function() { 
					store_cmsCases.setBaseParam('search_id', Ext.getCmp('criteriacombo').value);
					store_cmsCases.setBaseParam('search_status', Ext.getCmp('statuscombo').value);
					store_cmsCases.setBaseParam('limit', list_size);
				}
			},
		
		items:['->',{
				xtype: 'tbbutton',
					text: '<?php __('Manage Groups'); ?>',
					id:'btngroup',
					hidden:groupbtn,
					handler: function(btn) {
						viewgroups();
					}
			}]})]
});

if(center_panel.find('id', 'cmsCase-tab') != "") {
	var p = center_panel.findById('cmsCase-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cases'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cmsCase-tab',
		layout: "border",
		items:[{
				region: "west",
				xtype: 'panel',
				id: 'leftmessage',
				layout: 'fit',
				width: 650,
				items:[main]
			},{
				region: "center",
				xtype: 'panel',
				id: 'rightmessage',
				layout: 'fit',
				items:[g]
			}]
	});	
	
	center_panel.setActiveTab(p);
	
	store_cmsCases.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
	store_cmsCasesDetail.load({
		params: {
			start: 0,          
			limit: 10
		}
	});
}
