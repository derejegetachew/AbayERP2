		<?php
			$this->ExtForm->create('PerformanceStatus');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceStatusEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $performance_status['PerformanceStatus']['id'])); ?>,
				<?php 
					$options = array('disabled' => true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $performance_status['PerformanceStatus']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter', 'disabled' => true);
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					$options['value'] = $performance_status['PerformanceStatus']['quarter'];
					$this->ExtForm->input('quarter', $options);
				?>,
				
				
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Status');
					$options['items'] = array("open" => "open", "closed" => "closed");
					$options['value'] = $performance_status['PerformanceStatus']['status'];
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var PerformanceStatusEditWindow = new Ext.Window({
			title: '<?php __('Edit Performance Status'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceStatusEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceStatusEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Performance Status.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceStatusEditWindow.collapsed)
						PerformanceStatusEditWindow.expand(true);
					else
						PerformanceStatusEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceStatusEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceStatusEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceStatusData();
<?php } else { ?>
							RefreshPerformanceStatusData();
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
					PerformanceStatusEditWindow.close();
				}
			}]
		});
