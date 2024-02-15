
if(center_panel.find('id', 'dmsDocument-tab') != "") {
	var p = center_panel.findById('dmsDocument-tab');
	center_panel.setActiveTab(p);
} else {

//<script>
var store_dmsDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'images',
		totalProperty: 'results',
		fields: [
			'id','name','url','type','tag','size','file_type','created','shared','countch']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'list_data')); ?>'
	})
});

var store_dmsMessages = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','created','message','status','old_record','size','number'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'list_data')); ?>'
	})
});

var store_dmsMessages1 = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','created','message','status','old_record','size','number'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'list_data1')); ?>'
	})
});

var store_dmsMessages2 = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','created','message','status','old_record','size','number'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'list_data2')); ?>'
	})
});

	var store_employee_names = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'user_id', 'full_name','position','photo'		
				]
		}),
		proxy: new Ext.data.HttpProxy({
				url: '<?php echo $this->Html->url(array('controller' => '../employees', 'action' => 'search_emp2')); ?>'
		}),	
			sortInfo:{field: 'full_name', direction: "ASC"}
		});
      store_employee_names.load({
            params: {
                start: 0
            }
        });
		
			var store_employee_names_all = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'user_id', 'full_name','position','photo'		
				]
		}),
		proxy: new Ext.data.HttpProxy({
				url: '<?php echo $this->Html->url(array('controller' => '../employees', 'action' => 'search_emp_all')); ?>'
		}),	
			sortInfo:{field: 'full_name', direction: "ASC"}
		});
      store_employee_names_all.load({
            params: {
                start: 0
            }
        });
Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'DmsMessages', 'action' => 'index')); ?>',
		success: function(response, opts) {
			var dmsMessage_data = response.responseText;
			
			eval(dmsMessage_data);			
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});

function Inbox() {
	/*thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	Ext.getCmp('child_panles').insert(0,Ext.getCmp('main'));
	Ext.getCmp('child_panles').insert(1,Ext.getCmp('g'));
	Ext.getCmp('child_panles').doLayout();
	Ext.getCmp('main2').setVisible(false);
	Ext.getCmp('main').setVisible(true);
	Ext.getCmp('g').setVisible(true);*/
	
	thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	messagecontainer.setVisible(true);
	Ext.getCmp('leftmessage').insert(0,Ext.getCmp('main'));
	Ext.getCmp('rightmessage').insert(0,Ext.getCmp('g'));
	Ext.getCmp('leftmessage').doLayout();
	Ext.getCmp('rightmessage').doLayout();
	Ext.getCmp('main2').setVisible(false);
	Ext.getCmp('main').setVisible(true);
	Ext.getCmp('main3').setVisible(false)
	
	Ext.getCmp('uplbtn').disable();
	Ext.getCmp('refreshbtn').disable();
	Ext.getCmp('newbtn').disable();
	Ext.getCmp('upbtn').disable();
	Ext.getCmp('delmessbtn').enable();
	
	var el = document.getElementById('message_detail');
	el.src="about:blank";
	//Ext.getCmp('main').store=store_dmsMessages;
	//Ext.getCmp('bbar_store_dmsMessages').store=store_dmsMessages;
	store_dmsMessages.load({ params: { start: 0, limit: 30} });	
	//Ext.getCmp('main').getView().ds.load();
	//Ext.getCmp('main').store.reload();
}

function Sent() {

	//alert(Ext.getCmp('child_panles').getHeight());
	thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	messagecontainer.setVisible(true);
	Ext.getCmp('leftmessage').insert(0,Ext.getCmp('main2'));
	Ext.getCmp('rightmessage').insert(0,Ext.getCmp('g'));
	Ext.getCmp('leftmessage').doLayout();
	Ext.getCmp('rightmessage').doLayout();
	Ext.getCmp('main').setVisible(false);
	Ext.getCmp('main2').setVisible(true);
	Ext.getCmp('main3').setVisible(false)
	//Ext.getCmp('messagecontainer').doLayout();
	Ext.getCmp('uplbtn').disable();
	Ext.getCmp('refreshbtn').disable();
	Ext.getCmp('newbtn').disable();
	Ext.getCmp('upbtn').disable();
	Ext.getCmp('delmessbtn').disable();
	
	store_dmsMessages1.load({ params: { start: 0, limit: 30} });
	var el = document.getElementById('message_detail');
	el.src="about:blank";	
	//Ext.getCmp('rightmessage').insert(0,Ext.getCmp('g'));
	/*Ext.getCmp('child_panles').remove(thumb_browser);
	Ext.getCmp('child_panles').remove(detail_browser);
	var myBoxCmp = Ext.getCmp('messagecontainer');
	if(!myBoxCmp){
		Ext.getCmp('child_panles').add({
                        layout: 'border',
						id: 'messagecontainer',
                        items: [{
				region: "west",
				xtype: 'panel',
				id: 'leftmessage',
				layout: 'fit',
				width: 390,
				items:[Ext.getCmp('main2')]
			},{
				region: "center",
				xtype: 'panel',
				id: 'rightmessage',
				layout: 'fit',
				items:[Ext.getCmp('g')]
			}] 
                  });
	store_dmsMessages1.load({ params: { start: 0, limit: 30} });					  
	Ext.getCmp('child_panles').doLayout();
	}else{
	thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	Ext.getCmp('messagecontainer').setVisible(true);
	store_dmsMessages1.load({ params: { start: 0, limit: 30} });
	}
	
	


	
	
	var el = document.getElementById('message_detail');
	el.src="about:blank"; */

}
function Broadcast() {

	//alert(Ext.getCmp('child_panles').getHeight());
	thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	messagecontainer.setVisible(true);
	Ext.getCmp('leftmessage').insert(0,Ext.getCmp('main3'));
	Ext.getCmp('rightmessage').insert(0,Ext.getCmp('g'));
	Ext.getCmp('leftmessage').doLayout();
	Ext.getCmp('rightmessage').doLayout();
	Ext.getCmp('main').setVisible(false);
	Ext.getCmp('main2').setVisible(false);
	Ext.getCmp('main3').setVisible(true);
	//Ext.getCmp('messagecontainer').doLayout();
	Ext.getCmp('uplbtn').disable();
	Ext.getCmp('refreshbtn').disable();
	Ext.getCmp('newbtn').disable();
	Ext.getCmp('upbtn').disable();
	Ext.getCmp('delmessbtn').disable();
	
	store_dmsMessages2.load({ params: { start: 0, limit: 30} });
	var el = document.getElementById('message_detail');
	el.src="about:blank";	
}
function DeleteMessages(){
var cboxes = document.getElementsByName('checkmsg[]');
request='';
    var len = cboxes.length;

	v=0;
    for (var i=0; i<len; i++) {
		if(cboxes[i].checked){
        request=request+'-'+cboxes[i].value;
		v++;
		}
    }
	
	if(v==0)
	alert('No Message Selected');
	else{
	Ext.Msg.show({
				title: '<?php __('Remove Message'); ?>',
				buttons: Ext.MessageBox.YESNOCANCEL,
				msg: '<?php __('Remove'); ?> Selected Messages?',
				icon: Ext.MessageBox.QUESTION,
				fn: function(btn){
						if (btn == 'yes'){
								Ext.Ajax.request({
									url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'removeinbox')); ?>/'+request,
									success: function(response, opts) {
											Ext.Msg.show({
												title: '<?php __('Message'); ?>',
												buttons: Ext.MessageBox.OK,
												msg: response.responseText,
												icon: Ext.MessageBox.INFO
											});
											store_dmsMessages.reload();
									},
									failure: function(response, opts) {
										Ext.Msg.alert('<?php __('Error'); ?>', '<?php __(' Network Error'); ?> ');
									}
							});
						}
				}
		});
		
	var el = document.getElementById('message_detail');
	el.src="about:blank";

	}
	
}
function openuploads(parentid) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'upload')); ?>/'+parentid,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentUploadWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function sendfiles(parentid) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'sendfiles')); ?>/'+parentid,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function sendmessage() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}

myApp.dlms = function sendmessage2(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add2')); ?>/'+id+'/reply',
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}
myApp.dlmf = function sendmessage3(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add2')); ?>/'+id+'/forward',
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentSendWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function ViewParentAttachments(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'DmsAttachments', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_attachments_data = response.responseText;

                eval(parent_attachments_data);

                parentDmsAttachmentsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Attachment view form. Error code'); ?>: ' + response.status);
            }
        });
    }
function newfolder(parentid) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'add')); ?>/'+parentid,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function share(folderid) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'share')); ?>/'+folderid,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsDocumentShareWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function unshare(folderid){
Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'unshare')); ?>/'+folderid,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('This folder is not visible to other users anymore'); ?>');
                RefreshDmsDocumentData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Error'); ?>: ' + response.status);
            }
	});
	}
function remove(id){
Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'remove')); ?>/'+id,
            success: function(response, opts) {
					Ext.Msg.show({
						title: '<?php __('Message'); ?>',
						buttons: Ext.MessageBox.OK,
						msg: response.responseText,
						icon: Ext.MessageBox.INFO
					});
					RefreshDmsDocumentData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __(' Network Error'); ?> ');
            }
	});
	}
	
	function removecontent(id){
		Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'removecontent')); ?>/'+id,
            success: function(response, opts) {
					Ext.Msg.show({
						title: '<?php __('Message'); ?>',
						buttons: Ext.MessageBox.OK,
						msg: response.responseText,
						icon: Ext.MessageBox.INFO
					});
					//RefreshDmsDocumentData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __(' Network Error'); ?> ');
            }
		});
	}
	
function RefreshDmsDocumentData() {
	store_dmsDocuments.reload();
}


    function showMenu(dview, index, event) {
        event.stopEvent();
        var record = dview.getStore().getAt(index);
        var btnStatus = 1; 
		var btnStatus2 = 1;
		var btnStatus3 = 1;
		var btnStatus4 = 1;
		var btnStatus5 = 1;
		if(record.get('shared') == 0 && record.get('shared') != '' && record.get('type')=='folder') btnStatus2=0;
		var btnStatus3 = (record.get('shared') == 1)? false: true;
		if(record.get('type')=='folder' && record.get('id')!=-3 && record.get('id')!=-4) btnStatus4=0;
		if(record.get('type')=='folder' && record.get('id')!=-3 && record.get('id')!=-4) btnStatus5=0;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Open</b>',
					handler: function() {
						if(record.get('type')=='folder'){
							   store_dmsDocuments.load({
								params: {
									parent_id: record.get('id')
								}
							});
						}
						if(record.get('type')=='file'){
						window.open('<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'download')); ?>/'+record.get('id'));
						}
                    }
                }, '-', {
                    text: 'Send',
                    disabled: btnStatus,
					
                }, '-', {
                    text: 'Share',
					disabled: btnStatus2,
					handler: function() {
						if(record.get('type')=='folder'){
								 share(record.get('id'),'individuals');
							}
						}
                },{
                    text: 'Stop Sharing',
					disabled: btnStatus3,
					handler: function() {
						if(record.get('type')=='folder'){
								 unshare(record.get('id'));
							}
						}
                }, '-',
				{
                    text: 'Cut',
                    disabled: btnStatus
                },
				{
                    text: 'Copy',
                    disabled: btnStatus
                },
				{
                    text: 'Paste',
                    disabled: btnStatus
                },
				{
                    text: 'Delete',
					handler: function() {
						Ext.Msg.show({
									title: '<?php __('Remove Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: 'Are you sure you want to remove this item?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													remove(record.get('id'));
											}
									}
							});
								 
							
						}
                },
				{
                    text: 'Clear Folder Content',
					disabled: btnStatus5,
					handler: function() {
						Ext.Msg.show({
									title: '<?php __('Remove Item'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: 'This will remove all files in this folder and its subfolders.<br>Only files will be deleted, Folders structure will remain untouched.<br>Do you want to continue?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													removecontent(record.get('id'));
											}
									}
							});
								 
							
						}
                },{
                    text: 'Rename',
                    disabled: btnStatus
                }, '-',
				{
                    text: 'Zip and download folder',
                    disabled: btnStatus4,
					handler: function() {
						window.open('<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'zip')); ?>/'+record.get('id'));
					}
                }
            ]
        }).showAt(event.xy);
    }
	

	var detail_browser = new Ext.grid.GridPanel({
	store: store_dmsDocuments,
	loadMask: true,
	height:450,
	stripeRows: true,
	hidden:true,
    id: 'dmsDocumentGrid',
	columns: [
		{dataIndex: 'url', sortable: false,width:40,fixed:true,menuDisabled:true, 
		renderer: function(value, metaData, record, rowIndex, colIndex, store) {
			return '<img height="15"  src="'+value+'"/>';
		}},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: false},
		{header: "<?php __('Size'); ?>", dataIndex: 'size', sortable: false},
		{header: "<?php __('File Type'); ?>", dataIndex: 'file_type', sortable: false},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true} ],
		sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
		}),
		viewConfig: {
			forceFit: true
		},
		listeners: {
        celldblclick: function(){
            
					if(Ext.getCmp('dmsDocumentGrid').getSelectionModel().getSelected().data.type=='folder'){
					store_dmsDocuments.load({
						params: {
							parent_id: Ext.getCmp('dmsDocumentGrid').getSelectionModel().getSelected().data.id
						}
					});
					}
					if(Ext.getCmp('dmsDocumentGrid').getSelectionModel().getSelected().data.type=='file'){
						window.open('<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'download')); ?>/'+Ext.getCmp('dmsDocumentGrid').getSelectionModel().getSelected().data.id);
					}
			},
			'rowcontextmenu': function(grid, index, event) {
						showMenu(grid, index, event);
                }
		}
		});
	
var tpl = new Ext.XTemplate(
		'<tpl for=".">',
            '<div class="thumb-wrap" id="{name}" title="{name}">',
		    '<div class="thumb"><img src="{url}" title="{name}"></div>',
		    '<span class="x-editable">{shortName}{tag}</span>',
			'<div style="position:relative;top: -88px;left: 69px;"><div style="position:absolute;background-color: white;color: #cb8b10;width: 11px;padding-left: 3px;">{countch}</div></div></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
	);
	
	  var thumb_browser = new Ext.Panel({
        id:'images-view',
        layout:'fit',
		items: new Ext.DataView({
            store: store_dmsDocuments,
            tpl: tpl,
			autoScroll: true,
			loadingText: 'Loading, Please wait...',
            height:450,
            multiSelect: true,
            overClass:'x-view-over',
            itemSelector:'div.thumb-wrap',
            emptyText: 'No Files to display',

            plugins: [
                new Ext.DataView.DragSelector()
            ],

            prepareData: function(data){
                data.shortName = Ext.util.Format.ellipsis(data.name, 15);
                return data;
            },
			listeners: {
				dblclick: function(dview,index){
					var record = dview.getStore().getAt(index);
					if(record.get('type')=='folder'){
					store_dmsDocuments.load({
						params: {
							parent_id: record.get('id')
						}
					});
					}
					if(record.get('type')=='file'){
					window.open('<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'download')); ?>/'+record.get('id'));
					}
					
				},
				'contextmenu': function(dview, index,html, e) {
						showMenu(dview, index, e);
                }
			}
        })
		});
	
	var messagecontainer = new Ext.Panel({
                        layout: 'border',
						id: 'messagecontainer',
						hidden:true,
                        items: [{
				region: "west",
				xtype: 'panel',
				id: 'leftmessage',
				layout: 'fit',
				width: 390,
				items:[thumb_browser]
			},{
				region: "center",
				xtype: 'panel',
				id: 'rightmessage',
				layout: 'fit',
				items:[detail_browser]
			}]
			});
		var tree = new Ext.tree.TreePanel({
        useArrows: true,
        autoScroll: true,
        animate: true,
        enableDD: true,
        containerScroll: true,
        border: false,
		rootVisible : false,
		height:450,
		width:200,
        // auto create TreeLoader
       //dataUrl:'http://localhost/AbayERP/files/tree.php',

        root: {
            nodeType: 'async',
            text: 'Document',
            draggable: false,
            id: 'src',
			collapsible: true,
			children: [
				{ text:'<?php echo 'Inbox <i style="color:black;font-size:11px;font-weight: bold;">'.$count_unread ?></i>',
					leaf:true,
					listeners:{
						click: function(n) {
					Inbox();
					}
					}
				},
				{ text:'Sent',
					leaf:true,
					listeners:{
						click: function(n) {
					Sent();
					}
					}
				},
				{ 
					text:'<?php echo 'Broadcast Messages <i style="color:gray;font-size:11px;font-family:Comic Sans MS;">'. $count_brodcast ?></i>',
					leaf:true,
					listeners:{
						click: function(n) {
					Broadcast();
					}
					}
				}
				,
				
				<?php 
				function getchild($results){
					foreach($results as $result){	
				?>
				{ text: "<?php echo $result['DmsDocument']['name'];?>", 
				  expanded: false,
				  children: [
					<?php if(!empty($result['child'])){
					getchild($result['child']);
						}				
						?>				
					],
					listeners:{
						click: function(n) {
						store_dmsDocuments.load({
							params: {
								parent_id: <?php echo $result['DmsDocument']['id'];?>
							}
						});
						
						Ext.getCmp('uplbtn').enable();
						Ext.getCmp('refreshbtn').enable();
						Ext.getCmp('newbtn').enable();
						Ext.getCmp('upbtn').enable();
						Ext.getCmp('delmessbtn').disable();
						
						thumb_browser.setVisible(true);
						detail_browser.setVisible(false);
						messagecontainer.setVisible(false);
						}
					}					
				},
				<?php 
				}
				}
				getchild($results);				
				?>				
			]
        }
		 
    });
	
	var p = center_panel.add({
		title: '<?php __('DMS'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsDocument-tab',
		layout: "border",
		items: [
			{
				region: "north",
				xtype: 'panel',
				height: 28,
				tbar: new Ext.Toolbar({
					items: [{
					xtype: 'tbbutton',
					text: '<?php __('New Message'); ?>',
					tooltip:'Send message to any number of people',
					handler: function(btn) {
						var if_file_or_folder_select=0;
						sendmessage();
					}
				},'-',' ',' ',' ',' ',' ',{
					xtype: 'tbbutton',
					id:'uplbtn',
					text: '<?php __('Upload Files'); ?>',
					tooltip:'Upload multiple files by selecting / dragging files to it',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						openuploads(store_dmsDocuments.reader.jsonData.current);
					}
				},'-',' ',{
					xtype: 'tbbutton',
					id:'newbtn',
					text: '<?php __('New Folder'); ?>',
					tooltip:'<?php __(''); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						newfolder(store_dmsDocuments.reader.jsonData.current);
					}
				},' ', '-',{
					xtype: 'tbbutton',
					id:'upbtn',
					text: '<?php __('Up'); ?>',
					tooltip:'<b>Return to parent folder / Back</b>',
					icon: 'img/table_import.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						  store_dmsDocuments.load({
								params: {
									back:1,
									current_folder:store_dmsDocuments.reader.jsonData.current
								}
							});
					}
				},' ', '-',{
					xtype: 'tbbutton',
					id:'refreshbtn',
					text: '<?php __('Refresh'); ?>',
					tooltip:'update data',
					handler:function(btn){
						RefreshDmsDocumentData();
					}
				},' ', '-',{
					xtype: 'tbbutton',
					id:'delmessbtn',
					text: '<?php __('Delete Messages'); ?>',
					tooltip:'Delete Messages',
					disabled:true,
					handler:function(btn){
						DeleteMessages();
					}
				},' ', '-',{
					xtype: 'combo',
					store: store_employee_names_all,					
					displayField: 'full_name',
					typeAhead: false,
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Search by Employee Name',
					selectOnFocus:false,
					valueField: 'user_id',
					anchor: '100%',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
					listeners :{
                            scope: this,
                            'select': function(combo, record, index){
								store_dmsMessages.load({ params: { start: 0, limit: 30, person_id: combo.getValue()} });
								store_dmsMessages2.load({ params: { start: 0, limit: 30, person_id: combo.getValue()} });
                            }
                        }
        
				},'->',{
					xtype: 'tbbutton',
					text: '<?php __('Toggle View'); ?>',
					tooltip:'<b>Return to parent folder / Back</b>',
					cls: 'x-btn-text-icon',
					handler:function(btn){
					Ext.getCmp('uplbtn').enable();
					Ext.getCmp('refreshbtn').enable();
					Ext.getCmp('newbtn').enable();
					Ext.getCmp('upbtn').enable();
					Ext.getCmp('delmessbtn').disable();
					
					messagecontainer.setVisible(false);
					if(thumb_browser.isVisible()){
						thumb_browser.setVisible(false);
						detail_browser.setVisible(true);
					}else{
						thumb_browser.setVisible(true);
						detail_browser.setVisible(false);
						}
					}
				}
					]
				})
			},{
				region: "west",
				xtype: 'panel',
				width: 175,
				minSize: 175,
				maxSize: 300,
				collapsible: true,
				title:'Folders',
				items:[tree]
			},{
				region: 'center',
				layout: 'fit',
				id: 'child_panles',
				xtype: 'panel',
				items: [messagecontainer,thumb_browser,detail_browser]
			},{
				region: 'south',
				xtype: 'panel',
				html: ''
			}]
			
	});

	center_panel.setActiveTab(p);
	
	store_dmsDocuments.load({
		params: {
			parent_id:0
		}
	});
	
	
	
}
