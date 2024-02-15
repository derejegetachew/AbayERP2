		<?php
			$this->ExtForm->create('EmployeePerformanceResult');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmployeePerformanceResultEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $employee_performance_result['EmployeePerformanceResult']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $employee_performance_result['EmployeePerformanceResult']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employee_performances;
					$options['value'] = $employee_performance_result['EmployeePerformanceResult']['employee_performance_id'];
					$this->ExtForm->input('employee_performance_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_lists;
					$options['value'] = $employee_performance_result['EmployeePerformanceResult']['performance_list_id'];
					$this->ExtForm->input('performance_list_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_list_choices;
					$options['value'] = $employee_performance_result['EmployeePerformanceResult']['performance_list_choice_id'];
					$this->ExtForm->input('performance_list_choice_id', $options);
				?>			]
		});
		
		var EmployeePerformanceResultEditWindow = new Ext.Window({
			title: '<?php __('Edit Employee Performance Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmployeePerformanceResultEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmployeePerformanceResultEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Employee Performance Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmployeePerformanceResultEditWindow.collapsed)
						EmployeePerformanceResultEditWindow.expand(true);
					else
						EmployeePerformanceResultEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EmployeePerformanceResultEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeePerformanceResultEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentEmployeePerformanceResultData();
<?php } else { ?>
							RefreshEmployeePerformanceResultData();
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
					EmployeePerformanceResultEditWindow.close();
				}
			}]
		});
