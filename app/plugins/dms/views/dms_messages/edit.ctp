		<?php
			$this->ExtForm->create('DmsMessage');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsMessageEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsMessages', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_message['DmsMessage']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $dms_message['DmsMessage']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['message'];
					$this->ExtForm->input('message', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['status'];
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['old_record'];
					$this->ExtForm->input('old_record', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['size'];
					$this->ExtForm->input('size', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_message['DmsMessage']['number'];
					$this->ExtForm->input('number', $options);
				?>			]
		});
		
		var DmsMessageEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Message'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsMessageEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsMessageEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Message.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsMessageEditWindow.collapsed)
						DmsMessageEditWindow.expand(true);
					else
						DmsMessageEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsMessageEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsMessageEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsMessageData();
<?php } else { ?>
							RefreshDmsMessageData();
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
					DmsMessageEditWindow.close();
				}
			}]
		});
