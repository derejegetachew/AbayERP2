		<?php
			$this->ExtForm->create('DmsMessage');
			$this->ExtForm->defineFieldFunctions();
		?>
		function viewgroups(){
			 Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'DmsGroups', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_group = response.responseText;

                eval(parent_group);

                parentDmsGroupsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Attachment view form. Error code'); ?>: ' + response.status);
            }
        });
		}

		
		var store_parent_dmsGroupsm = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','public','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'list_data')); ?>'	})
});
      store_parent_dmsGroupsm.load({
            params: {
                start: 0
            }
        });
		var DmsDocumentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			height:100,
			id:'DmsDocumentAddForm',
			autoHeight: true,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
			{
								xtype:'checkbox',
								fieldLabel:'To All Employees (Broadcast)',
								name:'data[DmsMessage][all]',
								id:'checkbox',
								disabled:false,
								handler: function(chk,checked) {
									if(checked==true){
										Ext.getCmp('employees').disable();
										Ext.getCmp('group-selector').disable();
											alert('This will send your message to all employees.\nSo please use this feature  responsibly\n\nWhen you use this feature you should have a permission from your \nsupervisor and a good reason if every user needs to read your message.\n\nThank You,\nIT Team');
									}else{
										Ext.getCmp('employees').enable();
										Ext.getCmp('group-selector').enable();
									}				
								}
								},{
				msgTarget: 'under',
                allowAddNewData: true,
                id:'group-selector',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'To Groups',
                emptyText: 'Enter or select one or more groups here',
                resizable: true,
                name: 'data[DmsMessage][groups][]',
                anchor:'100%',
                store: store_parent_dmsGroupsm,
                mode: 'local',
                displayField: 'name',
                valueField: 'id',
                extraItemCls: 'x-tag',
                listeners: {
                    beforeadditem: function(bs,v){
                        //console.log('beforeadditem:', v);
                        //return false;
                    },
                    additem: function(bs,v){
                        //console.log('additem:', v);
                    },
                    beforeremoveitem: function(bs,v){
                        //console.log('beforeremoveitem:', v);
                        //return false;
                    },
                    removeitem: function(bs,v){
                        //console.log('removeitem:', v);
                    },
                    newitem: function(bs,v){
                        v = v.slice(0,1).toUpperCase() + v.slice(1).toLowerCase();
                        var newObj = {
                            id: v,
                            name: v
                        };
                        bs.addItem(newObj);
                    }
                }
             },{
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'To Employees',
                emptyText: 'Write Names Here',
                resizable: true,
                name: 'data[DmsMessage][employees][]',
                anchor:'100%',
                store: store_employee_names,
                mode: 'local',
                displayField: 'full_name',
                valueField: 'user_id',
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item"><div><img src="{photo}" style="float:left;width:32px"/> </div> {full_name} <br><b>{position}</b></div></tpl>',
                extraItemCls: 'x-tag',
                listeners: {
                    beforeadditem: function(bs,v){
                        //console.log('beforeadditem:', v);
                        //return false;
                    },
                    additem: function(bs,v){
                        //console.log('additem:', v);
                    },
                    beforeremoveitem: function(bs,v){
                        //console.log('beforeremoveitem:', v);
                        //return false;
                    },
                    removeitem: function(bs,v){
                        //console.log('removeitem:', v);
                    },
                    newitem: function(bs,v){
                        v = v.slice(0,1).toUpperCase() + v.slice(1).toLowerCase();
                        var newObj = {
                            id: v,
                            name: v
                        };
                        bs.addItem(newObj);
                    }
                }
             },
			 <?php 
					$options = array();
					$options['fieldLabel']='Subject';
					$this->ExtForm->input('name', $options);
				?>,
				<?php
					$options = array();
				$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Message (optional)',
						'anchor' => '100%'					
						);
					
					$this->ExtForm->input('message', $options);
					?>]
		});
		
		var DmsDocumentSendWindow = new Ext.Window({
			title: '<?php __('Send Message'); ?>',
			width: 700,
			height: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			shadow:false,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsDocumentAddForm,
			buttons: [{
				text: '<?php __('Send'); ?>',
				handler: function(btn){
					DmsDocumentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						timeout: 260000,
						success: function(f,a){							
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'Message Sent',
                                icon: Ext.MessageBox.INFO
							});
							DmsDocumentSendWindow.close();
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
				text: '<?php __('Add Attachment Files'); ?>',
				handler: function(btn){
							ViewParentAttachments(0);

			}},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					DmsDocumentSendWindow.close();
				}
			},' ','-',' ',{
				text: '<i style="color:gray">Manage Groups</i>',
				handler: function(btn){
							viewgroups();

			}}]
		});
