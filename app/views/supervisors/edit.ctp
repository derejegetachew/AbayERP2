	<?php
            $this->ExtForm->create('Supervisor');
            $this->ExtForm->defineFieldFunctions();
	?>    
    var vstore_employee_names = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                'id', 'full_name','position'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
     /* vstore_employee_names.load({
            params: {
                start: 0
            }
        });*/
        
    var SupervisorEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 150,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'supervisors', 'action' => 'edit')); ?>',
            defaultType: 'textfield',
            <?php if(is_array($supervisor)){ echo "html:' Supervisor Assigned: <b>".$supervisor['SupEmployee']['User']['Person']['first_name'].' '.$supervisor['SupEmployee']['User']['Person']['middle_name'].' '.$supervisor['SupEmployee']['User']['Person']['last_name']."</b><br><br>&nbsp;',";} ?>
            items: [
            <?php if(is_array($supervisor)){
                $this->ExtForm->input('id', array('hidden' => $supervisor['Supervisor']['id'])); echo ",";
                }
            ?>
                <?php 
                $this->ExtForm->input('emp_id', array('hidden' =>$employee['Employee']['id'])); echo ",";
                /*
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $supers;
                                $this->ExtForm->input('sup_emp_id', $options);
                 * 
                 */
                            ?>
            {
                        xtype: 'combo',
                        hiddenName: 'data[Supervisor][sup_emp_id]',
                        forceSelection: true,
                        emptyText: 'Select Supervisor Name',
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        valueField: 'id',
                        displayField: 'full_name',
                        allowBlank: false,
                        blankText: 'Your input is invalid.',
                        store : store_employee_names,
                        fieldLabel: 'Assign <?php if(is_array($supervisor)) echo 'new '; ?>Supervisor',
                        width:200,
                        hideTrigger:true,
                        tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
                                    }			]
             });
    
         var parentSupervisorsViewWindow = new Ext.Window({
			title: 'Supervisor for: <i><?php echo $employee['User']['Person']['first_name'] . ' ' . $employee['User']['Person']['middle_name'] . ' ' . $employee['User']['Person']['last_name']; ?></i>',
			width: 400,
                        minWidth: 400,
                        authoHeight:true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SupervisorEditForm,
                        
                        buttons:[
                        {
				text: '<?php __('Save Change'); ?>',
				handler: function(btn){
					SupervisorEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							parentSupervisorsViewWindow.close();

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
					parentSupervisorsViewWindow.close();
				}
			}
                        ]
			
		});
