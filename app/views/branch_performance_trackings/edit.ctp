		<?php
			$this->ExtForm->create('BranchPerformanceTracking');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceTrackingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_performance_tracking['BranchPerformanceTracking']['id'])); ?>,
				<?php 
					$options = array("disabled" => true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $emps;
					$options['value'] = $branch_performance_tracking['BranchPerformanceTracking']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array("disabled" => true);
					$options['value'] = $all_settings[$branch_performance_tracking['BranchPerformanceTracking']['goal']];
					$this->ExtForm->input('goal', $options);
				?>,
				
				
				{
					xtype: 'textfield',
					fieldLabel: 'Date',
					anchor: '100%',
					disabled: 'true',
					hiddenName:'data[BranchPerformanceTracking][date]',
					allowBlank: false,
					value: '<?php echo $branch_performance_tracking['BranchPerformanceTracking']['date']; ?>'
				},
				<?php 
					$options = array();
					$options['value'] = $branch_performance_tracking['BranchPerformanceTracking']['value'];
					$this->ExtForm->input('value', $options);
				?>			]
		});
		
		var BranchPerformanceTrackingEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Performance Tracking'); ?>',
			width: 700,
			minWidth: 700,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceTrackingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceTrackingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Tracking.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceTrackingEditWindow.collapsed)
						BranchPerformanceTrackingEditWindow.expand(true);
					else
						BranchPerformanceTrackingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceTrackingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceTrackingData();
<?php } else { ?>
							RefreshBranchPerformanceTrackingData();
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
					BranchPerformanceTrackingEditWindow.close();
				}
			}]
		});
