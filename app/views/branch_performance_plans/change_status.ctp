<?php
			$this->ExtForm->create('BranchPerformancePlan');
			$this->ExtForm->defineFieldFunctions();
			
		?>
	var ChangeStatusForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'change_status')); ?>',
			defaultType: 'textfield',

			items: [
				 <?php $this->ExtForm->input('id', array('hidden' => $branch_performance_plan['BranchPerformancePlan']['id'])); ?>, 
				<?php 
					
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Plan status');
					if($branch_performance_plan['BranchPerformancePlan']['plan_status'] == 1){
						$options['items'] = array(  2 => "pending agreement", 3 => "agreed", 4 => "agreed with reservation");
					}
					else {
						$options['items'] = array( 2 => "pending agreement", 3 => "agreed", 4 => "agreed with reservation");
					}
					
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['plan_status'];
					$this->ExtForm->input('plan_status', $options);
				?>,
				<?php 
					
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Result status');
					$options['items'] = array(1 => "pending agreement", 2 => "agreed", 3 => "agreed with reservation");
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['result_status'];
					$this->ExtForm->input('result_status', $options);
				?>

				]
		});
		
		var ChangeStatusWindow = new Ext.Window({
			title: '<?php __('Change status'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ChangeStatusForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ChangeStatusForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ChangeStatusWindow.collapsed)
                        ChangeStatusWindow.expand(true);
					else
                        ChangeStatusWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ChangeStatusForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ChangeStatusWindow.close();
<?php if(isset($parent_id)){ ?>
						RefreshBranchPerformancePlanData();
<?php } else { ?>
						RefreshBranchPerformancePlanData();
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
					ChangeStatusWindow.close();
				}
			}]
		});
