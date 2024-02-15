//<script>
    <?php
        $this->ExtForm->create('ImsStore');
        $this->ExtForm->defineFieldFunctions();
    ?>
	
	var vstore_employee_names = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                'id', 'full_name','position','user_id'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => '../employees', 'action' => 'search_emp')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      vstore_employee_names.load({
            params: {
                start: 0
            }
        });
	
    var StoreEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ims_stores', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $store['ImsStore']['id'])); ?>,
            <?php 
                $options = array();
                $options['value'] = $store['ImsStore']['name'];
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options = array();
                $options['value'] = $store['ImsStore']['address'];
                $this->ExtForm->input('address', $options);
            ?>,
			{
				xtype: 'combo',
				hiddenName: 'data[ImsStore][store_keeper_one]',
				forceSelection: true,
				emptyText: 'Select Store Keepers Name',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'user_id',
				displayField: 'full_name',
				allowBlank: false,
				blankText: 'Your input is invalid.',
				store : vstore_employee_names,
				fieldLabel: 'Store Keeper',
				width:265,
				value:'<?php if($store['ImsStore']['store_keeper_one'] != 0){echo $store['StoreKeeperOne']['Person']['first_name'].' '.$store['StoreKeeperOne']['Person']['middle_name'].' '.$store['StoreKeeperOne']['Person']['last_name'];}?>',
				hideTrigger:true,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
			},
			{
				xtype: 'combo',
				hiddenName: 'data[ImsStore][store_keeper_two]',
				forceSelection: true,
				emptyText: 'Select Store Keepers Name',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'user_id',
				displayField: 'full_name',
				allowBlank: false,
				blankText: 'Your input is invalid.',
				store : vstore_employee_names,
				fieldLabel: 'Store Keeper',
				width:265,
				value:'<?php if($store['ImsStore']['store_keeper_two'] != 0){echo $store['StoreKeeperTwo']['Person']['first_name'].' '.$store['StoreKeeperTwo']['Person']['middle_name'].' '.$store['StoreKeeperTwo']['Person']['last_name'];}?>',
				hideTrigger:true,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
			},
			{
				xtype: 'combo',
				hiddenName: 'data[ImsStore][store_keeper_three]',
				forceSelection: true,
				emptyText: 'Select Store Keepers Name',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'user_id',
				displayField: 'full_name',
				allowBlank: false,
				blankText: 'Your input is invalid.',
				store : vstore_employee_names,
				fieldLabel: 'Store Keeper',
				width:265,
				value:'<?php if($store['ImsStore']['store_keeper_three'] != 0){echo $store['StoreKeeperThree']['Person']['first_name'].' '.$store['StoreKeeperThree']['Person']['middle_name'].' '.$store['StoreKeeperThree']['Person']['last_name'];}?>',
				hideTrigger:true,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
			},
			{
				xtype: 'combo',
				hiddenName: 'data[ImsStore][store_keeper_four]',
				forceSelection: true,
				emptyText: 'Select Store Keepers Name',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'user_id',
				displayField: 'full_name',
				allowBlank: false,
				blankText: 'Your input is invalid.',
				store : vstore_employee_names,
				fieldLabel: 'Store Keeper',
				width:265,
				value:'<?php if($store['ImsStore']['store_keeper_four'] != 0){echo $store['StoreKeeperFour']['Person']['first_name'].' '.$store['StoreKeeperFour']['Person']['middle_name'].' '.$store['StoreKeeperFour']['Person']['last_name'];}?>',
				hideTrigger:true,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
			}
        ]
    });
		
    var StoreEditWindow = new Ext.Window({
        title: '<?php __('Edit Store'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: StoreEditForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                StoreEditForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to modify an existing Store.',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(StoreEditWindow.collapsed)
                    StoreEditWindow.expand(true);
                else
                    StoreEditWindow.collapse(true);
            }
        }],
        buttons: [ {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                StoreEditForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        StoreEditWindow.close();
                        RefreshStoreData();
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
                StoreEditWindow.close();
            }
        }]
    });
