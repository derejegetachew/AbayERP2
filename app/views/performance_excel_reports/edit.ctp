		<?php
			$this->ExtForm->create('PerformanceExcelReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceExcelReportEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $performance_excel_report['PerformanceExcelReport']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['card_number'];
					$this->ExtForm->input('card_number', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['first_name'];
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['middle_name'];
					$this->ExtForm->input('middle_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['last_name'];
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['sex'];
					$this->ExtForm->input('sex', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['date_of_employment'];
					$this->ExtForm->input('date_of_employment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['status'];
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['last_position'];
					$this->ExtForm->input('last_position', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['branch_district'];
					$this->ExtForm->input('branch_district', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['budget_year'];
					$this->ExtForm->input('budget_year', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1'];
					$this->ExtForm->input('q1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2'];
					$this->ExtForm->input('q2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1q290'];
					$this->ExtForm->input('q1q290', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['behavioural1'];
					$this->ExtForm->input('behavioural1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['semi_annual_one'];
					$this->ExtForm->input('semi_annual_one', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3'];
					$this->ExtForm->input('q3', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4'];
					$this->ExtForm->input('q4', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3q490'];
					$this->ExtForm->input('q3q490', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['behavioural2'];
					$this->ExtForm->input('behavioural2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['semi_annual_two'];
					$this->ExtForm->input('semi_annual_two', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['annual'];
					$this->ExtForm->input('annual', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_training1'];
					$this->ExtForm->input('q1_training1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_training2'];
					$this->ExtForm->input('q1_training2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_training3'];
					$this->ExtForm->input('q1_training3', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_training1'];
					$this->ExtForm->input('q2_training1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_training2'];
					$this->ExtForm->input('q2_training2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_training3'];
					$this->ExtForm->input('q2_training3', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_training1'];
					$this->ExtForm->input('q3_training1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_training2'];
					$this->ExtForm->input('q3_training2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_training3'];
					$this->ExtForm->input('q3_training3', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_training1'];
					$this->ExtForm->input('q4_training1', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_training2'];
					$this->ExtForm->input('q4_training2', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_training3'];
					$this->ExtForm->input('q4_training3', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_technical_plan_status'];
					$this->ExtForm->input('q1_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_technical_result_status'];
					$this->ExtForm->input('q1_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q1_technical_comment'];
					$this->ExtForm->input('q1_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_technical_plan_status'];
					$this->ExtForm->input('q2_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_technical_result_status'];
					$this->ExtForm->input('q2_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_technical_comment'];
					$this->ExtForm->input('q2_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_behavioural_result_status'];
					$this->ExtForm->input('q2_behavioural_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q2_behavioural_comment'];
					$this->ExtForm->input('q2_behavioural_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_technical_plan_status'];
					$this->ExtForm->input('q3_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_technical_result_status'];
					$this->ExtForm->input('q3_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q3_technical_comment'];
					$this->ExtForm->input('q3_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_technical_plan_status'];
					$this->ExtForm->input('q4_technical_plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_technical_result_status'];
					$this->ExtForm->input('q4_technical_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_technical_comment'];
					$this->ExtForm->input('q4_technical_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_behavioural_result_status'];
					$this->ExtForm->input('q4_behavioural_result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['q4_behavioural_comment'];
					$this->ExtForm->input('q4_behavioural_comment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['report_status'];
					$this->ExtForm->input('report_status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_excel_report['PerformanceExcelReport']['report_time'];
					$this->ExtForm->input('report_time', $options);
				?>			]
		});
		
		var PerformanceExcelReportEditWindow = new Ext.Window({
			title: '<?php __('Edit Performance Excel Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceExcelReportEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceExcelReportEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Performance Excel Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceExcelReportEditWindow.collapsed)
						PerformanceExcelReportEditWindow.expand(true);
					else
						PerformanceExcelReportEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceExcelReportEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceExcelReportEditWindow.close();
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
					PerformanceExcelReportEditWindow.close();
				}
			}]
		});
