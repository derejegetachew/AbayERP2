		<?php
			$this->ExtForm->create('PayrollReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PayrollReportAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
                                <?php $this->ExtForm->input('payroll_id', array('hidden' => $this->Session->read('Auth.User.payroll_id'))); ?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var PayrollReportAddWindow = new Ext.Window({
			title: '<?php __('Add Payroll Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PayrollReportAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PayrollReportAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Payroll Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PayrollReportAddWindow.collapsed)
						PayrollReportAddWindow.expand(true);
					else
						PayrollReportAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PayrollReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollReportAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentPayrollReportData();
<?php } else { ?>
							RefreshPayrollReportData();
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
					PayrollReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollReportAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPayrollReportData();
<?php } else { ?>
							RefreshPayrollReportData();
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
					PayrollReportAddWindow.close();
				}
			}]
		});
