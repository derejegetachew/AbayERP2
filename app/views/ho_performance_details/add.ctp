<?php
			$this->ExtForm->create('HoPerformanceDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var HoPerformanceDetailAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'add')); ?>',
			defaultType: 'textfield',


			items: [
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Perspective');
					$options['items'] = array("Financial" => "Financial", "Customer" => "Customer", "Internal Business Processes" => "Internal Business Processes", "Learning and Growth" => "Learning and Growth");
					$this->ExtForm->input('perspective', $options);

					//$options = array();
				//	$this->ExtForm->input('perspective', $options);
				?>,

				<?php 
					$options = array();
					$this->ExtForm->input('objective', $options);
				?>,
				

				<?php 
					$options = array('fieldLabel' => 'Plan Description (KPI)');
					$this->ExtForm->input('plan_description', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('plan_in_number', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('actual_result', $options);
				?>
				,
					<?php 
					$options = array();
					$this->ExtForm->input('measure', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('weight', $options);
				?>,
				<?php 
					//$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('accomplishment', $options);
				?>,
				<?php 
					//$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('total_score', $options);
				?>,
				<?php 
					//$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('final_score', $options);
				?>,
					<?php 
					//$options = array();
					//$options['hidden'] = 1;
					//$this->ExtForm->input('direction', $options);

					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Direction');
					$options['items'] = array(1 => "incremental", 2 => "decremental", 3 => "Error", 4 => "No of Complains", 5 => "Delay", 6 => "SDT(Standard Delivery Time)", 7 => "NPL", 8 => "RATE");
					$this->ExtForm->input('direction', $options);

				?>,
				<?php 
				
				$options = array();
				if(isset($parent_id))
					$options['hidden'] = $parent_id;
				else
					$options['items'] = $ho_performance_plans;
				$this->ExtForm->input('ho_performance_plan_id', $options);
			?>

				]

		});
		
		var HoPerformanceDetailAddWindow = new Ext.Window({
			title: '<?php __('Add Ho Performance Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: HoPerformanceDetailAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					HoPerformanceDetailAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ho Performance Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(HoPerformanceDetailAddWindow.collapsed)
						HoPerformanceDetailAddWindow.expand(true);
					else
						HoPerformanceDetailAddWindow.collapse(true);
				}
			}],

			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					HoPerformanceDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HoPerformanceDetailAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentHoPerformanceDetailData();
<?php } else { ?>
							RefreshHoPerformanceDetailData();
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
					HoPerformanceDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HoPerformanceDetailWindow.close();
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
			}, {
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					HoPerformanceDetailAddWindow.close();
				}
			}]
			
		
		});
