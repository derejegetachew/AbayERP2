		<?php
			$this->ExtForm->create('PerformanceExcelReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceExcelReportAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'add')); ?>',
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
					$this->ExtForm->input('card_number', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('middle_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('sex', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_of_employment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_position', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch_district', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('budget_year', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1q290', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('behavioural1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('semi_annual_one', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3q490', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('behavioural2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('semi_annual_two', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('annual', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_training1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_training2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_training3', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_training1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_training2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_training3', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_training1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_training2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_training3', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_training1', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_training2', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_training3', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q1_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_behavioural_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q2_behavioural_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q3_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_behavioural_result_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('q4_behavioural_comment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('report_status', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('report_time', $options);
				?>			]
		});
		
		var PerformanceExcelReportAddWindow = new Ext.Window({
			title: '<?php __('Add Performance Excel Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceExcelReportAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceExcelReportAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Performance Excel Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceExcelReportAddWindow.collapsed)
						PerformanceExcelReportAddWindow.expand(true);
					else
						PerformanceExcelReportAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceExcelReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceExcelReportAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceExcelReportData();
<?php } else { ?>
							RefreshPerformanceExcelReportData();
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
					PerformanceExcelReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceExcelReportAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceExcelReportData();
<?php } else { ?>
							RefreshPerformanceExcelReportData();
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
					PerformanceExcelReportAddWindow.close();
				}
			}]
		});
