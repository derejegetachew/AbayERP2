		<?php
			$this->ExtForm->create('Loan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LoanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'skip')); ?>',
			defaultType: 'textfield',
                        html:'Format: Month/Year',
			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $loan['Loan']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $loan['Loan']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
                                <?php 
					$options = array();
					$options['hidden'] = true;
					$options['value'] = $loan['Loan']['start'];
					$this->ExtForm->input('startt', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Skip Month');
					//$options['value'] = $loan['Loan']['skipped_months'];
					$this->ExtForm->input('skipped_months', $options);
				?>			]
		});
		
		var LoanSkipWindow = new Ext.Window({
			title: '<?php __('Skip Loan payment month'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LoanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LoanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Loan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LoanSkipWindow.collapsed)
						LoanSkipWindow.expand(true);
					else
						LoanSkipWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LoanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LoanSkipWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLoanData();
<?php } else { ?>
							RefreshLoanData();
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
					LoanSkipWindow.close();
				}
			}]
		});
