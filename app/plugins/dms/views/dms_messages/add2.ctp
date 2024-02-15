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
	var store_employee_names = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'user_id', 'full_name','position','photo'		
				]
		}),
		proxy: new Ext.data.HttpProxy({
				url: '<?php echo $this->Html->url(array('controller' => '../employees', 'action' => 'search_emp2')); ?>'
		}),	
			sortInfo:{field: 'full_name', direction: "ASC"}
		});
      store_employee_names.load({
            params: {
                start: 0
            }
        });
		
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
			height:900,
			id:'DmsDocumentAddForm',
			autoHeight: true,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
			<?php if($typ=='forward'){ ?>
			{
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'To',
                emptyText: 'Enter or select one or more receipients here',
                resizable: true,
                name: 'data[DmsMessage][employees][]',
                anchor:'100%',
                store: store_employee_names,
                mode: 'local',
                displayField: 'full_name',
                valueField: 'user_id',
				value:345,
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
             }
			 <?php } ?>
			 <?php if($typ=='reply') $this->ExtForm->input('employees][', array('hidden' => $dms_message['DmsMessage']['user_id'])); ?>,
			 <?php 
					$options = array();
					$options['fieldLabel']='Subject';
					if($typ=='reply') $options['value']='Reply: ';
					if($typ=='forward') $options['value']='Forward: ';
					$options['value'].=$dms_message['DmsMessage']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php
					$options = array();
				$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Message (optional)',
						'anchor' => '100%',
						'height'=> '200',						
						);
					$addtxt='\n\n\n----------------------------------------------------------------';
					$addtxt.='\nFrom: '.$dms_message['User']['Person']['first_name'].' '.$dms_message['User']['Person']['middle_name'];
					$addtxt.='\nSubject: '.str_replace("&#8217;", "\'", $dms_message['DmsMessage']['name']);
					$addtxt.='\nDate: '.$dms_message['DmsMessage']['created'];
					$dms_message['DmsMessage']['message'] = str_replace("<br />", " \\n ", $dms_message['DmsMessage']['message']);
					$dms_message['DmsMessage']['message'] = str_replace("&#8217;", "\'", $dms_message['DmsMessage']['message']);
					$addtxt.='\n\n'.$dms_message['DmsMessage']['message'];
					
					$options['value']=$addtxt;
					$this->ExtForm->input('message', $options);
					?>]
		});
		
		var DmsDocumentSendWindow = new Ext.Window({
			title: '<?php __('Send Message'); ?>',
			width: 700,
			height: 1500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
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
				text: '<?php __('Attachments'); ?>',
				handler: function(btn){
							ViewParentAttachments(0);

			}},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					DmsDocumentSendWindow.close();
				}
			}]
		});
