		<?php
			$this->ExtForm->create('EmployeePerformanceResult');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmployeePerformanceResultAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'add')); ?>',
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
						$options['items'] = $employee_performances;
					$this->ExtForm->input('employee_performance_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_lists;
					$this->ExtForm->input('performance_list_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_list_choices;
					$this->ExtForm->input('performance_list_choice_id', $options);
				?>			]
		});
		
		var EmployeePerformanceResultAddWindow = new Ext.Window({
			title: '<?php __('Add Employee Performance Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmployeePerformanceResultAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmployeePerformanceResultAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Employee Performance Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmployeePerformanceResultAddWindow.collapsed)
						EmployeePerformanceResultAddWindow.expand(true);
					else
						EmployeePerformanceResultAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EmployeePerformanceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeePerformanceResultAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					EmployeePerformanceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeePerformanceResultAddWindow.close();
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
					EmployeePerformanceResultAddWindow.close();
				}
			}]
		});
