		<?php
			$this->ExtForm->create('Loan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LoanCloseForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $loan['Loan']['id'])); ?>,
                                <?php $this->ExtForm->input('status', array('hidden' => 'closed')); ?>,
				<?php 
					$options = array();
                                         $options = array('xtype'=>'textarea');
					$this->ExtForm->input('remark', $options);
				?>
                               ]
		});
		
		var LoanCloseWindow = new Ext.Window({
			title: '<?php __('Close Loan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LoanCloseForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LoanCloseForm.getForm().reset();
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
					if(LoanCloseWindow.collapsed)
						LoanCloseWindow.expand(true);
					else
						LoanCloseWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Close Loan'); ?>',
				handler: function(btn){
					LoanCloseForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LoanCloseWindow.close();
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
					LoanCloseWindow.close();
				}
			}]
		});
