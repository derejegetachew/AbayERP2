		<?php
			$this->ExtForm->create('Pension');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PensionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
                                <?php $this->ExtForm->input('payroll_id', array('hidden' => $this->Session->read('Auth.User.payroll_id'))); ?>,
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'PF: Staff %');
                                        $options['value'] = '0';
					$this->ExtForm->input('pf_staff', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'PF: Company %');
                                        $options['value'] = '0';
					$this->ExtForm->input('pf_company', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Pension: Staff %');
                                        $options['value'] = '0';
					$this->ExtForm->input('pen_staff', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Pension: Company %');
                                        $options['value'] = '0';
					$this->ExtForm->input('pen_company', $options);
				?>
                                ]
		});
		
		var PensionAddWindow = new Ext.Window({
			title: '<?php __('Add PF/Pension'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PensionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PensionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Pension.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PensionAddWindow.collapsed)
						PensionAddWindow.expand(true);
					else
						PensionAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PensionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PensionAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentPensionData();
<?php } else { ?>
							RefreshPensionData();
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
					PensionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PensionAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPensionData();
<?php } else { ?>
							RefreshPensionData();
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
					PensionAddWindow.close();
				}
			}]
		});
