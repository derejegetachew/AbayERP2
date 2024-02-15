
    <?php
    //print_r($employee);
    $this->ExtForm->create('Employee');
    $this->ExtForm->defineFieldFunctions();
    
    ?>

    var EmployeeEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'editphoto')); ?>',
            defaultType: 'textfield',
            fileUpload: true,
            items:[
				<?php $this->ExtForm->input('id', array('hidden' => $employee['Employee']['id'])); ?>,
                            {
                            xtype: 'fileuploadfield',
                            id: 'form-file',
                            emptyText: 'Select Image',
                            fieldLabel: 'New Photo',
                            name: 'data[Employee][photo]',
                            buttonText: '',
                            anchor:'100%',
                            buttonCfg: {
                                iconCls: 'upload-icon'
                            }}
                   ]
        });

        var activetab=1;
        var EmployeeEditWindow = new Ext.Window({
            title: '<?php __('Change Photo'); ?>',
            width: 300,
            minWidth: 200,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: EmployeeEditForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        EmployeeEditForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                        Ext.Msg.show({
                            title: 'Help',
                            buttons: Ext.MessageBox.OK,
                            msg: 'This form is used to Edit Employee Information.',
                            icon: Ext.MessageBox.INFO
                        });
                    }
                }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                        if(EmployeeEditWindow.collapsed)
                            EmployeeEditWindow.expand(true);
                        else
                            EmployeeEditWindow.collapse(true);
                    }
                }],
            buttons: [{
                    text: '<?php __('Upload'); ?>',
                    id:'next',
                    handler: function(btn){
                       
                            
                            EmployeeEditForm.getForm().submit({
                                waitMsg: '<?php __('Submitting your data...'); ?>',
                                waitTitle: '<?php __('Wait Please...'); ?>',
                                success: function(f,a){
                                    Ext.Msg.show({
                                        title: '<?php __('Success'); ?>',
                                        buttons: Ext.MessageBox.OK,
                                        msg: a.result.msg,
                                        icon: Ext.MessageBox.INFO
                                    });
                                    EmployeeEditWindow.close();
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
                   
                    }
                ,{
                    text: '<?php __('Cancel'); ?>',
                    handler: function(btn){
                        EmployeeEditWindow.close();
                    }
                }]
        });
