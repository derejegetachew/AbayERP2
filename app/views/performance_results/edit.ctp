		<?php
			$this->ExtForm->create('PerformanceResult');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceResultEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $performance_result['PerformanceResult']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $performance_result['PerformanceResult']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $performance_result['PerformanceResult']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_result['PerformanceResult']['first'];
					$this->ExtForm->input('first', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_result['PerformanceResult']['second'];
					$this->ExtForm->input('second', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_result['PerformanceResult']['third'];
					$this->ExtForm->input('third', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $performance_result['PerformanceResult']['fourth'];
					$this->ExtForm->input('fourth', $options);
				?>				]
		});
		
		var PerformanceResultEditWindow = new Ext.Window({
			title: '<?php __('Edit Performance Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceResultEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceResultEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Performance Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceResultEditWindow.collapsed)
						PerformanceResultEditWindow.expand(true);
					else
						PerformanceResultEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceResultEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceResultEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceResultData();
<?php } else { ?>
							RefreshPerformanceResultData();
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
					PerformanceResultEditWindow.close();
				}
			}]
		});
