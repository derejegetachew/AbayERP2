		<?php
			$this->ExtForm->create('HoPerformancePlan');
			$this->ExtForm->defineFieldFunctions();
			
		?>
		var HoPerformancePlanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ho_performance_plan['HoPerformancePlan']['id'])); ?>,
				
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
					//	$options['items'] = $employees;
					$options['items'] = $emps;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					if($ho_performance_plan['HoPerformancePlan']['quarter'] == 1){
						$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					}
					if($ho_performance_plan['HoPerformancePlan']['quarter'] == 2){
						$options['items'] = array( 2 => "II", 1 => "I", 3 => "III", 4 => "IV");
					}
					if($ho_performance_plan['HoPerformancePlan']['quarter'] == 3){
						$options['items'] = array( 3 => "III",  1 => "I", 2 => "II",  4 => "IV");
					}
					if($ho_performance_plan['HoPerformancePlan']['quarter'] == 4){
						$options['items'] = array(  4 => "IV" , 1 => "I", 2 => "II" , 3 => "III");
					}
					

					$options['value'] = $ho_performance_plan['HoPerformancePlan']['quarter'];
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['self_technical_percent'];
					$this->ExtForm->input('self_technical_percent', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['spvr_technical_percent'];
					$this->ExtForm->input('spvr_technical_percent', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['both_technical_percent'];
					$this->ExtForm->input('both_technical_percent', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['semiannual_technical'];
					$this->ExtForm->input('semiannual_technical', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['behavioural_percent'];
					$this->ExtForm->input('behavioural_percent', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['semiannual_average'];
					$this->ExtForm->input('semiannual_average', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['plan_status'];
					$this->ExtForm->input('plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['result_status'];
					$this->ExtForm->input('result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = true;
					$options['value'] = $ho_performance_plan['HoPerformancePlan']['comment'];
					$this->ExtForm->input('comment', $options);
				?>			]
		});
		
		var HoPerformancePlanEditWindow = new Ext.Window({
			title: '<?php __('Edit Ho Performance Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: HoPerformancePlanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					HoPerformancePlanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ho Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(HoPerformancePlanEditWindow.collapsed)
						HoPerformancePlanEditWindow.expand(true);
					else
						HoPerformancePlanEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					HoPerformancePlanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HoPerformancePlanEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentHoPerformancePlanData();
<?php } else { ?>
							RefreshHoPerformancePlanData();
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
					HoPerformancePlanEditWindow.close();
				}
			}]
		});
