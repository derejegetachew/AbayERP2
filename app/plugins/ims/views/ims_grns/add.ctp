//<script>

    <?php
        $this->ExtForm->create('ImsGrn');
        $this->ExtForm->defineFieldFunctions();		
    ?> 
	 var store_pos = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
			totalProperty: 'results',
            fields: [
                'id','name','items'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'list_data_combo')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "DESC"}
	
    });
store_pos.load({
								params: {
									start: 0,          
									limit: 10,
									//name: field.getRawValue()
								}
							});
    var GrnAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'add')); ?>',
        defaultType: 'textfield',

        items: [
            <?php 
                $options0 = array('fieldLabel' => 'Ref Number','readOnly' => 'true');
                date_default_timezone_set("Africa/Addis_Ababa");
                $options0['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
                $this->ExtForm->input('name', $options0);
            ?>,
            /*{
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
				typeAhead: false,
				typeAheadDelay: 15000,					
				hiddenName:'data[ImsGrn][ims_supplier_id]',
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
			},*/
			{
			xtype: 'combo',	
			forceSelection: true,
			typeAhead: false,
			lazyRender: true,
			loadingText: 'Searching...',			
			pageSize:1,
			hideTrigger:true,
			tpl: '<tpl for="."><div ext:qtip="{name} . {position}" class="x-combo-list-item">{name} <br><b>{items}</b></div></tpl>' ,
			hiddenName:'data[ImsGrn][ims_purchase_order_id]',			
			name: 'name',
			id:'id',
			emptyText: 'Select Purchase Order',
			displayField : 'name',
			valueField : 'id',
			allowBlank: false,
            blankText: 'You have to select Purchase Order.',
			fieldLabel: 'Purchase Order',
			mode: 'local',
			disableKeyFilter : false,
			store:store_pos,
			editable: true,
			triggerAction: 'all', 
			anchor: '100%',
			enableKeyEvents:false,	
			},
            <?php 
                $options3 = array('xtype'=>'datefield','fieldLabel'=>'Date Received');
                $this->ExtForm->input('date_purchased', $options3);
            ?>		
        ]
    });
    
    function AddGrnItems(grn_id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'add_grn_items')); ?>/'+grn_id,
            success: function(response, opts) {
                var grn_items_data = response.responseText;
		
                eval(grn_items_data);
		
                GrnAddItemsWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN Items Add form. Error code'); ?>: ' + response.status);
            }
	});
    }
    
    var GrnAddWindow = new Ext.Window({
        title: '<?php __('Add Goods Receiving Notes'); ?>',
        width: 750,
        minWidth: 570,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: GrnAddForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                GrnAddForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to insert a new GRN. When you click on "Save and Close" you will be allowed to select the specific items to be purchased from the PO',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(GrnAddWindow.collapsed)
                    GrnAddWindow.expand(true);
                else
                    GrnAddWindow.collapse(true);
            }
        }],
        buttons: [  {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                GrnAddForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        GrnAddWindow.close();
                        //GrnAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
                        RefreshParentGrnData();
<?php } else { ?>
                        RefreshGrnData();
                        //alert(a.result.grn_id);
                        AddGrnItems(a.result.grn_id);
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
            text: '<?php __('Cancel'); ?>',
            handler: function(btn){
                GrnAddWindow.close();
            }
        }]
    });