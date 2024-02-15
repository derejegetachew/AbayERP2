//<script>

    var SupplierPOForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'supplier_po')); ?>',
			defaultType: 'textfield',

			items: [{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($suppliers as $supplier){?>
						['<?php echo $supplier['ImsSupplier']['id']?>','<?php echo $supplier['ImsSupplier']['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					typeAheadDelay: 15000,					
					hiddenName:'data[ImsPurchaseOrder][ims_supplier_id]',
					id: 'supplier',
					name: 'supplier',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Supplier',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Supplier',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
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
					hiddenName:'data[ImsPurchaseOrder][type]',
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
				}]
		});
    
    
    var SupplierPOWindow = new Ext.Window({
	title: 'Purchase Order by Supplier',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: SupplierPOForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SupplierPOForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view PO report by supplier.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SupplierPOWindow.collapsed)
						SupplierPOWindow.expand(true);
					else
						SupplierPOWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = SupplierPOForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//SupplierPOForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    SupplierPOWindow.close();
		}
            }]
    });
	SupplierPOWindow.show();