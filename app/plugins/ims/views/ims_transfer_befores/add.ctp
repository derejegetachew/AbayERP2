		<?php
			$this->ExtForm->create('ImsTransferBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferBeforeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_befores;
					$this->ExtForm->input('ims_sirv_before_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('from_user', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('to_user', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('from_branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('to_branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('observer', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('approved_by', $options);
				?>			]
		});
		
		var ImsTransferBeforeAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Transfer Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferBeforeAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferBeforeAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Transfer Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferBeforeAddWindow.collapsed)
						ImsTransferBeforeAddWindow.expand(true);
					else
						ImsTransferBeforeAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferBeforeAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferBeforeData();
<?php } else { ?>
							RefreshImsTransferBeforeData();
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
					ImsTransferBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferBeforeAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferBeforeData();
<?php } else { ?>
							RefreshImsTransferBeforeData();
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
					ImsTransferBeforeAddWindow.close();
				}
			}]
		});
