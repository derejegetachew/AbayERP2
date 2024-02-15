		<?php
			$this->ExtForm->create('PerformanceStatus');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceStatusAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceStatuses', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
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
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					$this->ExtForm->input('quarter', $options);
				?>,
				
				
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Status');
					$options['items'] = array("open" => "open", "closed" => "closed");
					$this->ExtForm->input('status', $options);
				?>,
				]
		});
		
		var PerformanceStatusAddWindow = new Ext.Window({
			title: '<?php __('Add Performance Status'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceStatusAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceStatusAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Performance Status.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceStatusAddWindow.collapsed)
						PerformanceStatusAddWindow.expand(true);
					else
						PerformanceStatusAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceStatusAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceStatusAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PerformanceStatusAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceStatusAddWindow.close();
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
					PerformanceStatusAddWindow.close();
				}
			}]
		});
