		<?php
			$this->ExtForm->create('BranchPerformanceTrackingStatus');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceTrackingStatusAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'add')); ?>',
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
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('result_status', $options);
				?>			]
		});
		
		var BranchPerformanceTrackingStatusAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Performance Tracking Status'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceTrackingStatusAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceTrackingStatusAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Performance Tracking Status.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceTrackingStatusAddWindow.collapsed)
						BranchPerformanceTrackingStatusAddWindow.expand(true);
					else
						BranchPerformanceTrackingStatusAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingStatusAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingStatusAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingStatusAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingStatusAddWindow.close();
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
					BranchPerformanceTrackingStatusAddWindow.close();
				}
			}]
		});
