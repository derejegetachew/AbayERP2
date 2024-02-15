//<script>
    var MinMaxByCategoryForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'min_max_by_category')); ?>',
			defaultType: 'textfield',

			items: [{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($imsStore as $store){?>
						['<?php echo $store['ImsStore']['id']?>','<?php echo $store['ImsStore']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsCard][store]',
					id: 'store',
					name: 'data[ImsCard][store]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Store',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},{
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
					xtype: 'radiogroup',					
					//arrange Radio Buttons into 2 columns
					columns: 2,
					itemId: 'minmax',
					width:200,
					items: [
						{
							xtype: 'radio',
							boxLabel: 'Min',
							name: "data[ImsCard][minmax]",
							checked: false,
							inputValue: 'Min'
						},
						{
							xtype: 'radio',
							boxLabel: 'Max',
							name: "data[ImsCard][minmax]",		
							checked: false,
							inputValue: 'Max'
						}
					]
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
    
    
    var MinMaxByCategoryWindow = new Ext.Window({
	title: 'Min/Max by Category',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: MinMaxByCategoryForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MinMaxByCategoryForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view Ending Balance report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MinMaxByCategoryWindow.collapsed)
						MinMaxByCategoryWindow.expand(true);
					else
						MinMaxByCategoryWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = MinMaxByCategoryForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//MinMaxByCategoryForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    MinMaxByCategoryWindow.close();
		}
            }]
    });
	MinMaxByCategoryWindow.show();