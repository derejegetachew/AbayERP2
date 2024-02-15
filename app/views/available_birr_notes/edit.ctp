<?php
			$this->ExtForm->create('AvailableBirrNote');
			$this->ExtForm->defineFieldFunctions();
		?>
		var AvailableBirrNoteEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $available_birr_note['AvailableBirrNote']['id'])); ?>,
			
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['old_10_birr'];
					$this->ExtForm->input('old_10_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['old_50_birr'];
					$this->ExtForm->input('old_50_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['old_100_birr'];
					$this->ExtForm->input('old_100_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_200_birr'];
					$this->ExtForm->input('new_200_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_100_birr'];
					$this->ExtForm->input('new_100_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_50_birr'];
					$this->ExtForm->input('new_50_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_10_birr'];
					$this->ExtForm->input('new_10_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_5_birr'];
					$this->ExtForm->input('new_5_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_1_birr'];
					$this->ExtForm->input('new_1_birr', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_50_cents'];
					$this->ExtForm->input('new_50_cents', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_25_cents'];
					$this->ExtForm->input('new_25_cents', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_10_cents'];
					$this->ExtForm->input('new_10_cents', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $available_birr_note['AvailableBirrNote']['new_5_cents'];
					$this->ExtForm->input('new_5_cents', $options);
				?>,
				<?php 
					$options = array();
					$options = array('disabled' => true);
					$options['value'] = $available_birr_note['AvailableBirrNote']['date_of'];
					$this->ExtForm->input('date_of', $options);
				?>			]
		});
		
		var AvailableBirrNoteEditWindow = new Ext.Window({
			title: '<?php __('Edit Available Birr Note'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AvailableBirrNoteEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AvailableBirrNoteEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Available Birr Note.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AvailableBirrNoteEditWindow.collapsed)
						AvailableBirrNoteEditWindow.expand(true);
					else
						AvailableBirrNoteEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AvailableBirrNoteEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AvailableBirrNoteEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentAvailableBirrNoteData();
<?php } else { ?>
							RefreshAvailableBirrNoteData();
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
					AvailableBirrNoteEditWindow.close();
				}
			}]
		});
