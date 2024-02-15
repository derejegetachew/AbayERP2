		<?php
			$this->ExtForm->create('PayrollReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PayrollReportEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $payroll_report['PayrollReport']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $payroll_report['PayrollReport']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $payroll_report['PayrollReport']['payroll_id'];
					$this->ExtForm->input('payroll_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $payroll_report['PayrollReport']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var PayrollReportEditWindow = new Ext.Window({
			title: '<?php __('Edit Payroll Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PayrollReportEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PayrollReportEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Payroll Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PayrollReportEditWindow.collapsed)
						PayrollReportEditWindow.expand(true);
					else
						PayrollReportEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PayrollReportEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollReportEditWindow.close();
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
					PayrollReportEditWindow.close();
				}
			}]
		});
