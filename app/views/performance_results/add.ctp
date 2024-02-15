		<?php
			$this->ExtForm->create('PerformanceResult');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceResultAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceResults', 'action' => 'add')); ?>',
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
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('first', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('second', $options);
				?>		]
		});
		
		var PerformanceResultAddWindow = new Ext.Window({
			title: '<?php __('Add Performance Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceResultAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceResultAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Performance Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceResultAddWindow.collapsed)
						PerformanceResultAddWindow.expand(true);
					else
						PerformanceResultAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceResultAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PerformanceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceResultAddWindow.close();
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
					PerformanceResultAddWindow.close();
				}
			}]
		});
