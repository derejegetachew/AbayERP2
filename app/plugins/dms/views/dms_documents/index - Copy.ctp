
var store_dmsDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'images',
		totalProperty: 'results',
		fields: [
			'id','name','url','type','tag','size','file_type','created','shared']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'list_data')); ?>'
	})
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
	thumb_browser.setVisible(false);
	detail_browser.setVisible(false);
	Ext.getCmp('child_panles').insert(0,Ext.getCmp('main'));
	Ext.getCmp('child_panles').insert(1,Ext.getCmp('g'));
	Ext.getCmp('child_panles').doLayout();
	Ext.getCmp('main').setVisible(true);
	Ext.getCmp('g').setVisible(true);
	
	Ext.getCmp('uplbtn').disable();
	Ext.getCmp('refreshbtn').disable();
	Ext.getCmp('newbtn').disable();
	Ext.getCmp('upbtn').disable();
	//Ext.getStore('store_dmsMessages').load();
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
function RefreshDmsDocumentData() {
	store_dmsDocuments.reload();
}


    function showMenu(dview, index, event) {
        event.stopEvent();
        var record = dview.getStore().getAt(index);
        var btnStatus = 1; 
		var btnStatus2 = 1;
		var btnStatus3 = 1;
		if(record.get('shared') == 0 && record.get('shared') != '' && record.get('type')=='folder') btnStatus2=0;
		var btnStatus3 = (record.get('shared') == 1)? false: true;
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
                    disabled: btnStatus
                }, '-',
				{
                    text: 'Zip and download folder',
                    disabled: btnStatus
                }
            ]
        }).showAt(event.xy);
    }
	
	var detail_browser = new Ext.grid.GridPanel({
	store: store_dmsDocuments,
	loadMask: true,
	stripeRows: true,
	hidden:true,
	width:935,
	height:423,
    id: 'dmsDocumentGrid',
	columns: [
		{dataIndex: 'url', sortable: false,width:40,fixed:true,menuDisabled:true, 
		renderer: function(value, metaData, record, rowIndex, colIndex, store) {
			return '<img height="15"  src="'+value+'"/>';
		}},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: false},
		{header: "<?php __('Size'); ?>", dataIndex: 'size', sortable: false},
		{header: "<?php __('File Type'); ?>", dataIndex: 'file_type', sortable: false},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: false} ],
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
		    '<span class="x-editable">{shortName}{tag}</span></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
	);
	
	  var thumb_browser = new Ext.Panel({
        id:'images-view',
        width:935,
		height:423,
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
		title:'Folders',
        // auto create TreeLoader
       //dataUrl:'http://localhost/AbayERP/files/tree.php',

        root: {
            nodeType: 'async',
            text: 'Document',
            draggable: false,
            id: 'src',
			collapsible: true,
			children: [
				{ text:'Inbox',
					leaf:true,
					listeners:{
						click: function(n) {
					Inbox();
					}
					}
				},
				
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
					
						Ext.getCmp('main').setVisible(false);
						Ext.getCmp('g').setVisible(false);
						thumb_browser.setVisible(true);
						detail_browser.setVisible(false);
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
if(center_panel.find('id', 'dmsDocument-tab') != "") {
	var p = center_panel.findById('dmsDocument-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Documents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsDocument-tab',
		layout:'table',
		layoutConfig: {columns:3},
		items:[{
			items:[tree]
		},{
			colspan:2,
			id:'child_panles',
			items:[thumb_browser,detail_browser],
			tbar: new Ext.Toolbar({
			
			items: ['->',{
					xtype: 'tbbutton',
					text: '<?php __('Toggle View'); ?>',
					tooltip:'<b>Return to parent folder / Back</b>',
					cls: 'x-btn-text-icon',
					handler:function(btn){
					Ext.getCmp('uplbtn').enable();
					Ext.getCmp('refreshbtn').enable();
					Ext.getCmp('newbtn').enable();
					Ext.getCmp('upbtn').enable();
					
					Ext.getCmp('main').setVisible(false);
					Ext.getCmp('g').setVisible(false);
						if(thumb_browser.isVisible()){
						thumb_browser.setVisible(false);
						detail_browser.setVisible(true);
						}else{
						thumb_browser.setVisible(true);
						detail_browser.setVisible(false);
						}
					}
				}]
		   })
		},{
			frame:true,
			colspan:3
		}],
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
				}
		
		]
		})
	});

	center_panel.setActiveTab(p);
	
	store_dmsDocuments.load({
		params: {
			parent_id:0
		}
	});
	
	
	
}
