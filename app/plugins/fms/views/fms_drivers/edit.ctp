		<?php
			$this->ExtForm->create('FmsDriver');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsDriverEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_driver['FmsDriver']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $people;
					$options['value'] = $fms_driver['FmsDriver']['person_id'];
					$this->ExtForm->input('person_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_driver['FmsDriver']['license_no'];
					$this->ExtForm->input('license_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_driver['FmsDriver']['date_given'];
					$this->ExtForm->input('date_given', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_driver['FmsDriver']['expiration_date'];
					$this->ExtForm->input('expiration_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_driver['FmsDriver']['created_by'];
					$this->ExtForm->input('created_by', $options);
				?>			]
		});
		
		var FmsDriverEditWindow = new Ext.Window({
			title: '<?php __('Edit Fms Driver'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsDriverEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsDriverEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Driver.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsDriverEditWindow.collapsed)
						FmsDriverEditWindow.expand(true);
					else
						FmsDriverEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsDriverEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDriverEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsDriverData();
<?php } else { ?>
							RefreshFmsDriverData();
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
					FmsDriverEditWindow.close();
				}
			}]
		});
