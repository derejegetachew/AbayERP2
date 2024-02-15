
var store_compositions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','region','branch','count','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'list_data2')); ?>'
	})
});


function AddComposition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var composition_data = response.responseText;
			
			eval(composition_data);
			
			CompositionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var composition_data = response.responseText;
			
			eval(composition_data);
			
			CompositionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewComposition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var composition_data = response.responseText;

            eval(composition_data);

            CompositionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition view form. Error code'); ?>: ' + response.status);
        }
    });
}
  function ViewParentPositions(id){
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_users_data = response.responseText;

                eval(parent_users_data);

                parentCompositionsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the users view form. Error code'); ?>: ' + response.status);
            }
        });
    }
function DeleteComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Composition successfully deleted!'); ?>');
			RefreshCompositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchComposition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var composition_data = response.responseText;

			eval(composition_data);

			compositionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the composition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompositionName(value){
	var conditions = '\'Composition.name LIKE\' => \'%' + value + '%\'';
	store_compositions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompositionData() {
	store_compositions.reload();
}


if(center_panel.find('id', 'composition-tab') != "") {
	var p = center_panel.findById('composition-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Manage Establishment'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'composition-tab',
		xtype: 'grid',
		store: store_compositions,
		columns: [
			{header: "<?php __('Region'); ?>", dataIndex: 'region', sortable: true},
			{header: "<?php __('Office'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Total'); ?>", dataIndex: 'count', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Compositions" : "Composition"]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewComposition(Ext.getCmp('composition-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('New Setup'); ?>',
					tooltip:'<?php __('<b>Add Compositions</b><br />Click here to create a new Composition'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddComposition();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Manage Office'); ?>',
					id: 'edit-composition',
					tooltip:'<?php __('<b>Edit Compositions</b><br />Click here to modify the selected Composition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewParentPositions(sel.data.id);
						};
					}
				}, '->','Reports: ',{
					xtype: 'tbbutton',
					text: '<?php __('Vacant Positions'); ?>',
					handler: function(btn) {
						window.open('http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Cvacant_positions.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=500&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report&1746233509');
					}
				},{
					xtype: 'tbbutton',
					text: '<?php __('- UnApproved Positions'); ?>',
					handler: function(btn) {
						window.open('http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Cunplanned_positions.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=500&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report&-15055386');
					}
				},' ', '-',  '<?php __('Find'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_compositions.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_compositions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-composition').enable();
		p.getTopToolbar().findById('delete-composition').enable();
		p.getTopToolbar().findById('view-composition').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
			p.getTopToolbar().findById('delete-composition').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-composition').enable();
			p.getTopToolbar().findById('view-composition').enable();
			p.getTopToolbar().findById('delete-composition').enable();
		}
		else{
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
			p.getTopToolbar().findById('delete-composition').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_compositions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
