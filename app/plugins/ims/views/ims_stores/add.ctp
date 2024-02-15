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
	
    var StoreAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ims_stores', 'action' => 'add')); ?>',
        defaultType: 'textfield',

        items: [
            <?php 
                $options = array();
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options = array();
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
				hideTrigger:true,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
			}
        ]
    });
		
    var StoreAddWindow = new Ext.Window({
        title: '<?php __('Add Store'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: StoreAddForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                StoreAddForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to insert a new Store.',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(StoreAddWindow.collapsed)
                    StoreAddWindow.expand(true);
                else
                    StoreAddWindow.collapse(true);
            }
        }],
        buttons: [  {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                StoreAddForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        StoreAddForm.getForm().reset();
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
        }, {
            text: '<?php __('Save & Close'); ?>',
            handler: function(btn){
                StoreAddForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        StoreAddWindow.close();
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
                StoreAddWindow.close();
            }
        }]
    });
