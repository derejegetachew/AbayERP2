//<script>

    var CategoryCardForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'category_card')); ?>',
			defaultType: 'textfield',

			items: [{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($itemcategory as $category){?>
						['<?php echo $category['ImsItemCategory']['id']?>','<?php echo $category['ImsItemCategory']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsCard][category]',
					id: 'category',
					name: 'data[ImsCard][category]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item Category',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['HTML','HTML'],['PDF','PDF'],['EXCEL','EXCEL'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsCard][type]',
					id: 'type',
					name: 'type',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> OutPut Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}, {
					xtype: 'textfield',
					id: 'title',
					name: 'data[ImsCard][title]',
					hiddenName:'data[ImsCard][title]',
					emptyText: 'give a title',
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Title',
					allowBlank: false,
					blankText: 'Your input is invalid.'
					}]
		});
    
    
    var CategoryCardWindow = new Ext.Window({
	title: 'Fixed Asset',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: CategoryCardForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CategoryCardForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view fixed asset report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CategoryCardWindow.collapsed)
						CategoryCardWindow.expand(true);
					else
						CategoryCardWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = CategoryCardForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//CategoryCardForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    CategoryCardWindow.close();
		}
            }]
    });
	CategoryCardWindow.show();