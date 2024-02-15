		<?php
			$this->ExtForm->create('Perrdiemm');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerrdiemmAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $this->Session->read('Auth.User.payroll_id');
					$this->ExtForm->input('payroll_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('days', $options);
				?>,
				<?php 
					$options = array();
					 $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Rate');
					 $options['items'] = array('230' => '230');
					 $options['value'] = '230';
					$this->ExtForm->input('rate', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Taxable Above');
					$options['items'] = array('230' => '150');
					$options['value'] = '150';
					$this->ExtForm->input('taxable', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = date('Y-m-d');
					$this->ExtForm->input('date', $options);
				?>			]
		});
		
		var PerrdiemmAddWindow = new Ext.Window({
			title: '<?php __('Add Perdium'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerrdiemmAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerrdiemmAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Perrdiemm.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerrdiemmAddWindow.collapsed)
						PerrdiemmAddWindow.expand(true);
					else
						PerrdiemmAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerrdiemmAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerrdiemmAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerrdiemmData();
<?php } else { ?>
							RefreshPerrdiemmData();
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
					PerrdiemmAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerrdiemmAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerrdiemmData();
<?php } else { ?>
							RefreshPerrdiemmData();
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
					PerrdiemmAddWindow.close();
				}
			}]
		});
