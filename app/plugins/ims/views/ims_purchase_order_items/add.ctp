//<script>
    <?php
        $this->ExtForm->create('ImsPurchaseOrderItem');
        $this->ExtForm->defineFieldFunctions();
    ?>
    Ext.apply(Ext.form.VTypes, {
        Number:  function(v) {
            return /^\d+$/.test(v);
        },
        NumberText: 'Must be a numeric IP address',
        NumberMask: /[0-9]/i
    });	
    
    var PurchaseOrderItemAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 150,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'add')); ?>',
        defaultType: 'textfield',

        items: [
            <?php
                $options = array();
                if (isset($parent_id))
                    $options['hidden'] = $parent_id;
                else
                    $options['items'] = $purchase_orders;
                $this->ExtForm->input('ims_purchase_order_id', $options);
            ?>,
            {
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsPurchaseOrderItem][ims_item_id]',
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
            
			{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['name'],
						
						data: [['Pcs'],['Pkt'],['Pad'],['Kg'],['Roll'],['Ream'],['M'],['Set'],['m<sup>2</sup>'],]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsPurchaseOrderItem][measurement]',
					id: 'measurement',
					name: 'measurement',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select measurement',
					selectOnFocus:true,
					valueField: 'name',
					anchor: '60%',
					fieldLabel: '<span style="color:red;">*</span> Measurement',
					allowBlank: false,
					editable: false,
					forceSelection: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
            <?php
                $options = array('anchor' => '60%', 'vtype' => 'Decimal1');
                $options['maskRe'] = '/[0-9.]/i';
                $this->ExtForm->input('ordered_quantity', $options);
            ?>,
            <?php
                $options = array('anchor' => '60%', 'xtype' => 'hidden', 'value' => '0');
                $this->ExtForm->input('purchased_quantity', $options);
            ?>,
            <?php
                $options = array('anchor' => '60%', 'vtype' => 'Currency1');
                $options['maskRe'] = '/[0-9.]/i';
                $this->ExtForm->input('unit_price', $options);
            ?>	,
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>			
        ]
    });
		
    var PurchaseOrderItemAddWindow = new Ext.Window({
        title: '<?php __('Add Purchase Order Item'); ?>',
        width: 500,
        minWidth: 500,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: PurchaseOrderItemAddForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function () {
                    PurchaseOrderItemAddForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function () {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to insert a new Purchase Order Item.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function () {
                    if(PurchaseOrderItemAddWindow.collapsed)
                        PurchaseOrderItemAddWindow.expand(true);
                    else
                        PurchaseOrderItemAddWindow.collapse(true);
                }
            }],
        buttons: [  {
                text: '<?php __('Save'); ?>',
                handler: function(btn){
                    PurchaseOrderItemAddForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: a.result.flag
                            });
							Ext.getCmp("item").store.removeAt(Ext.getCmp("item").selectedIndex);
                            PurchaseOrderItemAddForm.getForm().reset();
<?php if (isset($parent_id)) { ?>
                            RefreshParentPurchaseOrderItemData();
<?php } else { ?>
                            RefreshPurchaseOrderItemData();
<?php } ?>
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
                text: '<?php __('Save & Close'); ?>',
                handler: function(btn){
                    PurchaseOrderItemAddForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: a.result.flag
                            });
                            PurchaseOrderItemAddWindow.close();
<?php if (isset($parent_id)) { ?>
                            RefreshParentPurchaseOrderItemData();
<?php } else { ?>
                            RefreshPurchaseOrderItemData();
<?php } ?>
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
            },{
                text: '<?php __('Cancel'); ?>',
                handler: function(btn){
                    PurchaseOrderItemAddWindow.close();
                }
            }
        ]
    });
