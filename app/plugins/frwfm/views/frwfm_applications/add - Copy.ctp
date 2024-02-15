		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('order', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $locations;
					$this->ExtForm->input('location_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('mobile_phone', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('email', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('currency', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('expiry_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('license', $options);
				?>			]
		});
		
		var FrwfmApplicationAddWindow = new Ext.Window({
			title: '<?php __('Add Frwfm Application'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmApplicationAddWindow.collapsed)
						FrwfmApplicationAddWindow.expand(true);
					else
						FrwfmApplicationAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FrwfmApplicationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmApplicationAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFrwfmApplicationData();
<?php } else { ?>
							RefreshFrwfmApplicationData();
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
					FrwfmApplicationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmApplicationAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFrwfmApplicationData();
<?php } else { ?>
							RefreshFrwfmApplicationData();
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
					FrwfmApplicationAddWindow.close();
				}
			}]
		});
