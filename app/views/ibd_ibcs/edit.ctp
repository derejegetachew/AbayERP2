		<?php
			$this->ExtForm->create('IbdIbc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdIbcEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_ibc['IbdIbc']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['ISSUE_DATE'];
					$this->ExtForm->input('ISSUE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['NAME_OF_IMPORTER'];
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['IBC_REFERENCE'];
					$this->ExtForm->input('IBC_REFERENCE', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_ibc['IbdIbc']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['FCY_AMOUNT'];
					$this->ExtForm->input('FCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['REMITTING_BANK'];
					$this->ExtForm->input('REMITTING_BANK', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['REIBURSING_BANK'];
					$this->ExtForm->input('REIBURSING_BANK', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['PERMIT_NO'];
					$this->ExtForm->input('PERMIT_NO', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['PURCHASE_ORDER_NO'];
					$this->ExtForm->input('PURCHASE_ORDER_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['FCY_APPROVAL_INITIAL_NO'];
					$this->ExtForm->input('FCY_APPROVAL_INITIAL_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['SETT_FCY'];
					$this->ExtForm->input('SETT_FCY', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['SETT_Amount'];
					$this->ExtForm->input('SETT_Amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_ibc['IbdIbc']['SETT_Date'];
					$this->ExtForm->input('SETT_Date', $options);
				?>			]
		});
		
		var IbdIbcEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Ibc'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdIbcEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdIbcEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Ibc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdIbcEditWindow.collapsed)
						IbdIbcEditWindow.expand(true);
					else
						IbdIbcEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdIbcEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdIbcEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdIbcData();
<?php } else { ?>
							RefreshIbdIbcData();
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
					IbdIbcEditWindow.close();
				}
			}]
		});
