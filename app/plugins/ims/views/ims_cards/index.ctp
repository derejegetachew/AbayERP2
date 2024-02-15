//<script>
var store_cards = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','item','quantity','unit_price','grn','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: "<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'list_data')); ?>"
	})
        ,	sortInfo:{field: 'ims_item_id', direction: "ASC"},
	groupField: 'quantity'
});


function AddCard() {
	Ext.Ajax.request({
		url: "<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'add')); ?>",
		success: function(response, opts) {
			var card_data = response.responseText;
			
			eval(card_data);
			
			CardAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Cannot get the card add form. Error code'); ?>: " + response.status);
		}
	});
}

function EditCard(id) {
	Ext.Ajax.request({
		url: "<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'edit')); ?>/"+id,
		success: function(response, opts) {
			var card_data = response.responseText;
			
			eval(card_data);
			
			CardEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Cannot get the card edit form. Error code'); ?>: " + response.status);
		}
	});
}

function ViewCard(id) {
    Ext.Ajax.request({
        url: "<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'view')); ?>/"+id,
        success: function(response, opts) {
            var card_data = response.responseText;

            eval(card_data);

            CardViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Cannot get the card view form. Error code'); ?>: " + response.status);
        }
    });
}

function DeleteCard(id) {
	Ext.Ajax.request({
		url: "<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'delete')); ?>/"+id,
		success: function(response, opts) {
			Ext.Msg.alert("<?php __('Success'); ?>", "<?php __('Card successfully deleted!'); ?>");
			RefreshCardData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Cannot get the card add form. Error code'); ?>: " + response.status);
		}
	});
}

function SearchCard(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'search')); ?>',
		success: function(response, opts){
			var card_data = response.responseText;

			eval(card_data);

			cardSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Cannot get the card search form. Error Code'); ?>: " + response.status);
		}
	});
}

function SearchByCardName(value){
	var conditions = '\'Card.name LIKE\' => \'%' + value + '%\'';
	store_cards.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCardData() {
	store_cards.reload();
}


if(center_panel.find('id', 'card-tab') != "") {
	var p = center_panel.findById('card-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cards'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'card-tab',
		xtype: 'grid',
		store: store_cards,
		columns: [
			{header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Grn'); ?>", dataIndex: 'grn', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Cards" : "Card"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCard(Ext.getCmp('card-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: "<?php __('Add'); ?>",
					tooltip: "<?php __('<b>Add Cards</b><br />Click here to create a new Card'); ?>",
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCard();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: "<?php __('Edit'); ?>",
					id: 'edit-card',
					tooltip: "<?php __('<b>Edit Cards</b><br />Click here to modify the selected Card'); ?>",
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCard(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: "<?php __('Delete'); ?>",
					id: 'delete-card',
					tooltip: "<?php __('<b>Delete Cards(s)</b><br />Click here to remove the selected Card(s)'); ?>",
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: "<?php __('Remove Card'); ?>",
									buttons: Ext.MessageBox.YESNO,
									msg: "<?php __('Remove'); ?> "+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCard(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: "<?php __('Remove Card'); ?>",
									buttons: Ext.MessageBox.YESNO,
									msg: "<?php __('Remove the selected Cards'); ?>?",
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCard(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert("<?php __('Warning'); ?>", "<?php __('Please select a record first'); ?>");
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: "<?php __('View Card'); ?>",
					id: 'view-card',
					tooltip: "<?php __('<b>View Card</b><br />Click here to see details of the selected Card'); ?>",
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCard(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  "<?php __('Item'); ?>: ", {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($items as $item){if($st) echo ",
							";?>['<?php echo $item['Item']['id']; ?>' ,'<?php echo $item['Item']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cards.reload({
								params: {
									start: 0,
									limit: list_size,
									item_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: "<?php __('[Search By Name]'); ?>",
					id: 'card_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCardName(Ext.getCmp('card_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: "<?php __('GO'); ?>",
                                        tooltip: "<?php __('<b>GO</b><br />Click here to get search results'); ?>",
					id: "card_go_button",
					handler: function(){
						SearchByCardName(Ext.getCmp('card_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: "<?php __('Advanced Search'); ?>",
                                        tooltip:"<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>",
					handler: function(){
						SearchCard();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cards,
			displayInfo: true,
			displayMsg: "<?php __('Displaying {0} - {1} of {2}'); ?>",
			beforePageText: "<?php __('Page'); ?>",
			afterPageText: "<?php __('of {0}'); ?>",
			emptyMsg: "<?php __('No data to display'); ?>"
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-card').enable();
		p.getTopToolbar().findById('delete-card').enable();
		p.getTopToolbar().findById('view-card').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-card').disable();
			p.getTopToolbar().findById('view-card').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-card').disable();
			p.getTopToolbar().findById('view-card').disable();
			p.getTopToolbar().findById('delete-card').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-card').enable();
			p.getTopToolbar().findById('view-card').enable();
			p.getTopToolbar().findById('delete-card').enable();
		}
		else{
			p.getTopToolbar().findById('edit-card').disable();
			p.getTopToolbar().findById('view-card').disable();
			p.getTopToolbar().findById('delete-card').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cards.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}