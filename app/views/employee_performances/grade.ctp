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
                        <?php $this->ExtForm->input('employee_id', array('hidden' => $employee_id)); ?>,
                        <?php $this->ExtForm->input('employee_performance_id', array('hidden' => $employee_performance_id)); ?>,
							
                                <?php 
                                //print_r($performance_lists);
                                foreach($performance_lists as $performance_list){
                                    
                                    $options = array();
                                    $options = array('fieldLabel'=>$performance_list['PerformanceList']['name'],'anchor' => '100%');
                                    $this->ExtForm->input($performance_list['PerformanceList']['id'], $options);
                                    echo ',';
                                }
                                ?>
                        ]
		});
		
		var EmployeePerformanceGradeWindow = new Ext.Window({
			title: '<?php __('Grade Employee Performance'); ?>',
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
			buttons: [  {
				text: '<?php __('Grade'); ?>',
				handler: function(btn){
					EmployeePerformanceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeePerformanceGradeWindow.close();
                                                        RefreshParentEmployeePerformanceData();
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
					EmployeePerformanceGradeWindow.close();
				}
			}]
		});
