		<?php
			$this->ExtForm->create('EmployeePerformance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmployeePerformanceAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 300,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employeePerformances', 'action' => 'grade')); ?>',
			defaultType: 'textfield',

			items: [
                        <?php $this->ExtForm->input('employee_id', array('hidden' => $employeePerformance[0]['EmployeePerformanceResult']['employee_id'])); ?>,
                        <?php $this->ExtForm->input('employee_performance_id', array('hidden' => $employeePerformance[0]['EmployeePerformanceResult']['employee_performance_id'])); ?>,
							
                                <?php 
                                //print_r($performance_lists);
                                foreach($employeePerformance as $performance_list){
                                    
                                    $options = array();
                                    $options = array('fieldLabel'=>$performance_list['PerformanceList']['name'],'anchor' => '100%');
                                    $options['value'] = $performance_list['EmployeePerformanceResult']['value'];
                                    $this->ExtForm->input($performance_list['PerformanceList']['id'], $options);
                                    echo ',';
                                }
                                ?>
                        ]
		});
		
		var EmployeePerformanceResultWindow = new Ext.Window({
			title: '<?php __('Performance Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmployeePerformanceAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmployeePerformanceAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Employee Performance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmployeePerformanceAddWindow.collapsed)
						EmployeePerformanceAddWindow.expand(true);
					else
						EmployeePerformanceAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					EmployeePerformanceResultWindow.close();
				}
			}]
		});
