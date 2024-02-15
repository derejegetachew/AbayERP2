		<?php
			$this->ExtForm->create('PayrollEmployee');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PayrollEmployeeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $payroll_employee['PayrollEmployee']['id'])); ?>,
                                <?php 
					$options = array();
                                        $options['value'] = $payroll_employee['PayrollEmployee']['account_no'];
					$this->ExtForm->input('account_no', $options);
				?>,
                                <?php 
					$options = array();
                                        $options['value'] = $payroll_employee['PayrollEmployee']['pf_account_no'];
					$this->ExtForm->input('pf_account_no', $options);
				?>,
                                <?php 
					$options = array();
                    $options['value'] = $payroll_employee['PayrollEmployee']['salary'];
					$options['fieldLabel'] = 'Special Salary';
					$this->ExtForm->input('salary', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Status');
                                        $options['items'] = array('active' => 'active','deactivated' => 'deactivated');
                                         $options['value'] = $payroll_employee['PayrollEmployee']['status'];
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $payroll_employee['PayrollEmployee']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var PayrollEmployeeEditWindow = new Ext.Window({
			title: '<?php __('Edit Payroll'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PayrollEmployeeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PayrollEmployeeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Payroll Employee.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PayrollEmployeeEditWindow.collapsed)
						PayrollEmployeeEditWindow.expand(true);
					else
						PayrollEmployeeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PayrollEmployeeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollEmployeeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPayrollEmployeeData();
<?php } else { ?>
							RefreshPayrollEmployeeData();
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
					PayrollEmployeeEditWindow.close();
				}
			}]
		});
