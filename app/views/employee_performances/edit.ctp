		<?php
			$this->ExtForm->create('EmployeePerformance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmployeePerformanceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $employee_performance['EmployeePerformance']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $employee_performance['EmployeePerformance']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performances;
					$options['value'] = $employee_performance['EmployeePerformance']['performance_id'];
					$this->ExtForm->input('performance_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $employee_performance['EmployeePerformance']['status'];
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var EmployeePerformanceEditWindow = new Ext.Window({
			title: '<?php __('Edit Employee Performance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmployeePerformanceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmployeePerformanceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Employee Performance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmployeePerformanceEditWindow.collapsed)
						EmployeePerformanceEditWindow.expand(true);
					else
						EmployeePerformanceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EmployeePerformanceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeePerformanceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentEmployeePerformanceData();
<?php } else { ?>
							RefreshEmployeePerformanceData();
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
					EmployeePerformanceEditWindow.close();
				}
			}]
		});
