		<?php
			$this->ExtForm->create('PayrollReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PayrollReportApproveForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'payrollReports', 'action' => 'approve')); ?>',
			defaultType: 'textfield',
                        html:'You are about to approve this payroll, are you sure?',

			items: [	
                        <?php 
                        if(isset($id))
                            $this->ExtForm->input('id', array('hidden' => $id)); ?>
                        ]
		});
		
		var PayrollReportApproveWindow = new Ext.Window({
			title: '<?php __('Approve Payroll Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PayrollReportApproveForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PayrollReportApproveForm.getForm().reset();
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
					if(PayrollReportApproveWindow.collapsed)
						PayrollReportApproveWindow.expand(true);
					else
						PayrollReportApproveWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Approve'); ?>',
				handler: function(btn){
					PayrollReportApproveForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
                                                timeout:240000,
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PayrollReportApproveWindow.close();
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
					PayrollReportApproveWindow.close();
				}
			}]
		});
