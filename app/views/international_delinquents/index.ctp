
var store_internationalDelinquents = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Nationality','BOD','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'Nationality'
});


function AddInternationalDelinquent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var internationalDelinquent_data = response.responseText;
			
			eval(internationalDelinquent_data);
			
			InternationalDelinquentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the internationalDelinquent add form. Error code'); ?>: ' + response.status);
		}
	});
}
function upload() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'upload')); ?>',
		success: function(response, opts) {
			var internationalDelinquent_data = response.responseText;
			
			eval(internationalDelinquent_data);
			
			InternationalDelinquentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the internationalDelinquent add form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditInternationalDelinquent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var internationalDelinquent_data = response.responseText;
			
			eval(internationalDelinquent_data);
			
			InternationalDelinquentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the internationalDelinquent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewInternationalDelinquent(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var internationalDelinquent_data = response.responseText;

            eval(internationalDelinquent_data);

            InternationalDelinquentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the internationalDelinquent view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteInternationalDelinquent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('InternationalDelinquent successfully deleted!'); ?>');
			RefreshInternationalDelinquentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the internationalDelinquent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchInternationalDelinquent(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'search')); ?>',
		success: function(response, opts){
			var internationalDelinquent_data = response.responseText;

			eval(internationalDelinquent_data);

			internationalDelinquentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the internationalDelinquent search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByInternationalDelinquentName(value){
	var conditions = '\'InternationalDelinquent.name LIKE\' => \'%' + value + '%\'';
	store_internationalDelinquents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshInternationalDelinquentData() {
	store_internationalDelinquents.reload();
}


if(center_panel.find('id', 'internationalDelinquent-tab') != "") {
	var p = center_panel.findById('internationalDelinquent-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('International Delinquents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'internationalDelinquent-tab',
		xtype: 'grid',
		store: store_internationalDelinquents,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Nationality'); ?>", dataIndex: 'Nationality', sortable: true},
			{header: "<?php __('BOD'); ?>", dataIndex: 'BOD', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "InternationalDelinquents" : "InternationalDelinquent"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewInternationalDelinquent(Ext.getCmp('internationalDelinquent-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Upload'); ?>',
					tooltip:'<?php __('<b>Upload </b>'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						upload();
					}
				}, /*{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add InternationalDelinquents</b><br />Click here to create a new InternationalDelinquent'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddInternationalDelinquent();
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-internationalDelinquent',
					tooltip:'<?php __('<b>Edit InternationalDelinquents</b><br />Click here to modify the selected InternationalDelinquent'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditInternationalDelinquent(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-internationalDelinquent',
					tooltip:'<?php __('<b>Delete InternationalDelinquents(s)</b><br />Click here to remove the selected InternationalDelinquent(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove InternationalDelinquent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteInternationalDelinquent(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove InternationalDelinquent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected InternationalDelinquents'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteInternationalDelinquent(sel_ids);
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
					text: '<?php __('View InternationalDelinquent'); ?>',
					id: 'view-internationalDelinquent',
					tooltip:'<?php __('<b>View InternationalDelinquent</b><br />Click here to see details of the selected InternationalDelinquent'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewInternationalDelinquent(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, */' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'internationalDelinquent_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByInternationalDelinquentName(Ext.getCmp('internationalDelinquent_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'internationalDelinquent_go_button',
					handler: function(){
						SearchByInternationalDelinquentName(Ext.getCmp('internationalDelinquent_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchInternationalDelinquent();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_internationalDelinquents,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-internationalDelinquent').enable();
		p.getTopToolbar().findById('delete-internationalDelinquent').enable();
		p.getTopToolbar().findById('view-internationalDelinquent').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-internationalDelinquent').disable();
			p.getTopToolbar().findById('view-internationalDelinquent').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-internationalDelinquent').disable();
			p.getTopToolbar().findById('view-internationalDelinquent').disable();
			p.getTopToolbar().findById('delete-internationalDelinquent').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-internationalDelinquent').enable();
			p.getTopToolbar().findById('view-internationalDelinquent').enable();
			p.getTopToolbar().findById('delete-internationalDelinquent').enable();
		}
		else{
			p.getTopToolbar().findById('edit-internationalDelinquent').disable();
			p.getTopToolbar().findById('view-internationalDelinquent').disable();
			p.getTopToolbar().findById('delete-internationalDelinquent').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_internationalDelinquents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
