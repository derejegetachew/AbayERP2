		<?php
			$this->ExtForm->create('PayrollEmployee');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PayrollEmployeeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'payrollEmployees', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$options['items'] = $payrolls;
					$this->ExtForm->input('payroll_id', $options);
				?>,
                                <?php 
					$options = array();
					$this->ExtForm->input('account_no', $options);
				?>,
                                <?php 
					$options = array();
					$this->ExtForm->input('pf_account_no', $options);
				?>,
                                <?php 
					$options = array();
					$options['value'] = 0;
					$options['fieldLabel'] = 'Special Salary';
					$this->ExtForm->input('salary', $options);
				?>,
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
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Status', 'value' => 'active');
                                        $options['items'] = array('active' => 'active');
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
				?>			]
		});
		
		var PayrollEmployeeAddWindow = new Ext.Window({
			title: '<?php __('Add Payroll Employee'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PayrollEmployeeAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PayrollEmployeeAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Payroll Employee.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PayrollEmployeeAddWindow.collapsed)
						PayrollEmployeeAddWindow.expand(true);
					else
						PayrollEmployeeAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PayrollEmployeeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollEmployeeAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PayrollEmployeeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollEmployeeAddWindow.close();
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
					PayrollEmployeeAddWindow.close();
				}
			}]
		});
