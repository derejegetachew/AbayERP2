		<?php
			$this->ExtForm->create('IbdSettelment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdSettelmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_settelment['IbdSettelment']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['reference'];
					$this->ExtForm->input('reference', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['opening_date'];
					$this->ExtForm->input('opening_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['fcy_amount'];
					$this->ExtForm->input('fcy_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['rate'];
					$this->ExtForm->input('rate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['lcy_amount'];
					$this->ExtForm->input('lcy_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['margin_amount'];
					$this->ExtForm->input('margin_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_settelment['IbdSettelment']['ibc_no'];
					$this->ExtForm->input('ibc_no', $options);
				?>			]
		});
		
		var IbdSettelmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Settelment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdSettelmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdSettelmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Settelment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdSettelmentEditWindow.collapsed)
						IbdSettelmentEditWindow.expand(true);
					else
						IbdSettelmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdSettelmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdSettelmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSettelmentData();
<?php } else { ?>
							RefreshIbdSettelmentData();
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
					IbdSettelmentEditWindow.close();
				}
			}]
		});
