//<script>
    <?php
        $this->ExtForm->create('ImsPurchaseOrder');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var PurchaseOrderEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $purchase_order['ImsPurchaseOrder']['id'])); ?>,
            <?php
                $options = array();
                $options['value'] = $purchase_order['ImsPurchaseOrder']['name'];
                $this->ExtForm->input('name', $options);
            ?>,
			<?php 
				$options = array();
				if(isset($parent_id))
						$options['hidden'] = $parent_id;
				else
						$options['items'] = $suppliers;
				$options['value'] = $purchase_order['ImsPurchaseOrder']['ims_supplier_id'];
				$this->ExtForm->input('ims_supplier_id', $options);
			?>,
			{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [[1,'Planned'],[0,'Unplanned'],]
						
					}),					
					displayField: 'name',
					typeAhead: false,
					hiddenName:'data[ImsPurchaseOrder][planned]',
					id: 'planned',
					name: 'planned',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select one',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '60%',
					value: '<?php echo $purchase_order['ImsPurchaseOrder']['planned']?>',
					fieldLabel: '<span style="color:red;">*</span> Is Planned?',
					allowBlank: false,
					editable: false,
					forceSelection: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}
        ]
    });
		
    var PurchaseOrderEditWindow = new Ext.Window({
        title: '<?php __('Edit Purchase Order'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: PurchaseOrderEditForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function () {
                    PurchaseOrderEditForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function () {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to modify an existing Purchase Order.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function () {
                    if(PurchaseOrderEditWindow.collapsed)
                        PurchaseOrderEditWindow.expand(true);
                    else
                        PurchaseOrderEditWindow.collapse(true);
                }
            }],
        buttons: [{
                text: '<?php __('Save'); ?>',
                handler: function(btn){
                    PurchaseOrderEditForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
                            });
                            PurchaseOrderEditWindow.close();
                            RefreshPurchaseOrderData();
                    },
                    failure: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Warning'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.errormsg,
                            icon: Ext.MessageBox.ERROR
                        });
                    }
                });
            }
        }, {
            text: '<?php __('Cancel'); ?>',
            handler: function(btn){
                PurchaseOrderEditWindow.close();
            }
        }]
    });
