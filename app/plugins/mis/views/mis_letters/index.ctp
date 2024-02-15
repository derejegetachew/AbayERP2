
var store_misLetters = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ref_no','applicant','defendant','letter_no','date','deadline','source','office','messenger','file','status','created_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ref_no', direction: "ASC"},
	groupField: 'source'
});


function AddMisLetter() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var misLetter_data = response.responseText;
			
			eval(misLetter_data);
			
			MisLetterAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetter add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditMisLetter(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var misLetter_data = response.responseText;
			
			eval(misLetter_data);
			
			MisLetterEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetter edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function SendMisLetter(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'send')); ?>/'+id,
		success: function(response, opts) {
				Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Letter successfully sent to branch!'); ?>');
                RefreshMisLetterData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot send the letter. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewMisLetter(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var misLetter_data = response.responseText;

            eval(misLetter_data);

            MisLetterViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetter view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentMisLetterDetails(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_misLetterDetails_data = response.responseText;

            eval(parent_misLetterDetails_data);

            parentMisLetterDetailsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteMisLetter(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('MisLetter successfully deleted!'); ?>');
			RefreshMisLetterData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetter add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchMisLetter(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'search')); ?>',
		success: function(response, opts){
			var misLetter_data = response.responseText;

			eval(misLetter_data);

			misLetterSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the misLetter search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByMisLetterName(value){
	var conditions = '\'OR\' => array(\'MisLetter.ref_no LIKE\' => \'%' + value + '%\', \'MisLetter.letter_no LIKE\' => \'%' + value + '%\', \'MisLetter.applicant LIKE\' => \'%' + value + '%\',\'MisLetter.defendant LIKE\' => \'%' + value + '%\', \'MisLetter.defendant LIKE\' => \'%' + value + '%\', \'MisLetter.messenger LIKE\' => \'%' + value + '%\')';
	store_misLetters.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshMisLetterData() {
	store_misLetters.reload();
}

function LetterPrepared(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'letterPrepared')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Letter prepared successfully!'); ?>');
                RefreshMisLetterData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot prepare the letter. Error code'); ?>: ' + response.status);
            }
	});
}

function Completed(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'completed')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Letter completed successfully!'); ?>');
                RefreshMisLetterData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot complete the letter. Error code'); ?>: ' + response.status);
            }
	});
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
		var btnFile = (record.get('file').indexOf('No file') == -1)? false: true;
		var btnLetter = (record.get('status').indexOf('created') != -1  || record.get('status').indexOf('Branch Replied') != -1 || record.get('status').indexOf('On Process') != -1)? false: true;
		var btnComplete = (record.get('status').indexOf('Letter Prepared') != -1)? false: true;
		
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Download Scanned File</b>',
                    icon: 'img/download.gif',
                    handler: function() {
                        DownloadFile(record.get('id'));
                    },
                    disabled: btnFile
                },
				{
                    text: '<b>Letter prepared</b>',
                    icon: 'img/letter.png',
                    handler: function() {
                        LetterPrepared(record.get('id'));
                    },
                    //disabled: btnLetter
					disabled: false
                },
				{
                    text: '<b>Completed</b>',
                    icon: 'img/complete.png',
                    handler: function() {
                        Completed(record.get('id'));
                    },
                    disabled: btnComplete
                }
            ]
        }).showAt(event.xy);
}

function DownloadFile(id) {
         url = '<?php echo $this->Html->url(array('controller' => 'mis_letters', 'action' => 'download')); ?>/' + id;	
		 window.open(url);
}

if(center_panel.find('id', 'misLetter-tab') != "") {
	var p = center_panel.findById('misLetter-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Letters'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'misLetter-tab',
		xtype: 'grid',
		store: store_misLetters,
		columns: [
			{header: "<?php __('Ref No'); ?>", dataIndex: 'ref_no', sortable: true},
			{header: "<?php __('Applicant'); ?>", dataIndex: 'applicant', sortable: true},
			{header: "<?php __('Defendant'); ?>", dataIndex: 'defendant', sortable: true},
			{header: "<?php __('Letter No'); ?>", dataIndex: 'letter_no', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true, hidden: true},
			{header: "<?php __('Deadline'); ?>", dataIndex: 'deadline', sortable: true},
			{header: "<?php __('Source'); ?>", dataIndex: 'source', sortable: true},
			{header: "<?php __('Office'); ?>", dataIndex: 'office', sortable: true},
			{header: "<?php __('Messenger'); ?>", dataIndex: 'messenger', sortable: true},
			{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Letters" : "Letter"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewMisLetter(Ext.getCmp('misLetter-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid, index, event) {
				showMenu(grid, index, event);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add MisLetters</b><br />Click here to create a new MisLetter'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddMisLetter();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-misLetter',
					tooltip:'<?php __('<b>Edit MisLetters</b><br />Click here to modify the selected MisLetter'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditMisLetter(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-misLetter',
					tooltip:'<?php __('<b>Delete MisLetters(s)</b><br />Click here to remove the selected MisLetter(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove MisLetter'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteMisLetter(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove MisLetter'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected MisLetters'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteMisLetter(sel_ids);
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
					text: '<?php __('View Letter'); ?>',
					id: 'view-misLetter',
					tooltip:'<?php __('<b>View MisLetter</b><br />Click here to see details of the selected MisLetter'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewMisLetter(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Letter Details'); ?>',
							id: 'view-misLetterDetail',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							disabled: true,
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentMisLetterDetails(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Send'); ?>',
					id: 'send-misLetter',
					tooltip:'<?php __('<b>Send Letters</b><br />Click here to send the selected Letter to branches'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							SendMisLetter(sel.data.id);
						};
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'misLetter_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByMisLetterName(Ext.getCmp('misLetter_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'misLetter_go_button',
					handler: function(){
						SearchByMisLetterName(Ext.getCmp('misLetter_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchMisLetter();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_misLetters,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status.indexOf('created') != -1){
			p.getTopToolbar().findById('edit-misLetter').enable();
			p.getTopToolbar().findById('delete-misLetter').enable();
			Ext.getCmp('view-misLetterDetail').enable();
		}
		if(this.getSelections()[0].data.status.indexOf('On Process') != -1){
			p.getTopToolbar().findById('edit-misLetter').enable();
			p.getTopToolbar().findById('send-misLetter').enable();
			p.getTopToolbar().findById('delete-misLetter').enable();
			Ext.getCmp('view-misLetterDetail').enable();
		}
		if(this.getSelections()[0].data.status.indexOf('Branch Replied') != -1){
			Ext.getCmp('view-misLetterDetail').enable();
		}
		p.getTopToolbar().findById('view-misLetter').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-misLetter').disable();
			p.getTopToolbar().findById('send-misLetter').disable();
			p.getTopToolbar().findById('view-misLetter').disable();
			Ext.getCmp('view-misLetterDetail').disable();
		}
		
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-misLetter').disable();
			p.getTopToolbar().findById('send-misLetter').disable();
			p.getTopToolbar().findById('view-misLetter').disable();
			Ext.getCmp('view-misLetterDetail').disable();
			if(this.getSelections()[0].data.status.indexOf('created') != -1){
				p.getTopToolbar().findById('delete-misLetter').enable();
			}
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status.indexOf('created') != -1){
				p.getTopToolbar().findById('edit-misLetter').enable();
				p.getTopToolbar().findById('delete-misLetter').enable();
				Ext.getCmp('view-misLetterDetail').enable();
			}
			if(this.getSelections()[0].data.status.indexOf('On Process') != -1){
				p.getTopToolbar().findById('edit-misLetter').enable();
				p.getTopToolbar().findById('send-misLetter').enable();
				p.getTopToolbar().findById('delete-misLetter').enable();
				Ext.getCmp('view-misLetterDetail').enable();
			}
			if(this.getSelections()[0].data.status.indexOf('Branch Replied') != -1){
				Ext.getCmp('view-misLetterDetail').enable();
			}
			p.getTopToolbar().findById('view-misLetter').enable();			
		}
		else{
			p.getTopToolbar().findById('edit-misLetter').disable();
			p.getTopToolbar().findById('send-misLetter').disable();
			p.getTopToolbar().findById('view-misLetter').disable();
			p.getTopToolbar().findById('delete-misLetter').disable();
			Ext.getCmp('view-misLetterDetail').disable();
		}
		
	});
	center_panel.setActiveTab(p);
	
	store_misLetters.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
