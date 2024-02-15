		<?php
			$this->ExtForm->create('BranchPerformanceTrackingStatus');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceTrackingStatusEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['quarter'];
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_performance_tracking_status['BranchPerformanceTrackingStatus']['result_status'];
					$this->ExtForm->input('result_status', $options);
				?>			]
		});
		
		var BranchPerformanceTrackingStatusEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Performance Tracking Status'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceTrackingStatusEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceTrackingStatusEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Tracking Status.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceTrackingStatusEditWindow.collapsed)
						BranchPerformanceTrackingStatusEditWindow.expand(true);
					else
						BranchPerformanceTrackingStatusEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingStatusEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingStatusEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceTrackingStatusData();
<?php } else { ?>
							RefreshBranchPerformanceTrackingStatusData();
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
					BranchPerformanceTrackingStatusEditWindow.close();
				}
			}]
		});
