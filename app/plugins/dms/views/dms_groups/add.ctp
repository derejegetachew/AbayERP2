		<?php
			$this->ExtForm->create('DmsGroup');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsGroupAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$user = $this->Session->read();	
					$user_id = $user['Auth']['User']['id'];
					if(isset($parent_id))
						$options['hidden'] = $user_id;
					else
						$options['items'] = $users;
					$this->ExtForm->input('user_id', $options);
				?>,
				{
								xtype:'checkbox',
								fieldLabel:'Public',
								name:'data[DmsGroup][public]',
								anchor: '100%',
								handler: function(chk,checked) {
									if(checked==true){
alert('Before sharing your group to all employees, Please Note:-\n\nTo keep others from being mislead, please organize your list correctly and update it regulary. or else keep it private. \nWhen you use public feature you should have a permission from your supervisor.\n\nThank You,\nIT Team');
									}			
								}
								}				]
		});
		
		var DmsGroupAddWindow = new Ext.Window({
			title: '<?php __('Add Dms Group'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsGroupAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsGroupAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Dms Group.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsGroupAddWindow.collapsed)
						DmsGroupAddWindow.expand(true);
					else
						DmsGroupAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsGroupAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsGroupData();
<?php } else { ?>
							RefreshDmsGroupData();
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
					DmsGroupAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsGroupData();
<?php } else { ?>
							RefreshDmsGroupData();
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
					DmsGroupAddWindow.close();
				}
			}]
		});
