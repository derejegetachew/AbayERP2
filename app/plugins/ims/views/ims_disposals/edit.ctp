		<?php
			$this->ExtForm->create('ImsDisposal');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsDisposalEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_disposal['ImsDisposal']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ims_disposal['ImsDisposal']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_disposal['ImsDisposal']['status'];
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_stores;
					$options['value'] = $ims_disposal['ImsDisposal']['ims_store_id'];
					$this->ExtForm->input('ims_store_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_disposal['ImsDisposal']['created_by'];
					$this->ExtForm->input('created_by', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_disposal['ImsDisposal']['approved_by'];
					$this->ExtForm->input('approved_by', $options);
				?>			]
		});
		
		var ImsDisposalEditWindow = new Ext.Window({
			title: '<?php __('Edit Disposal'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsDisposalEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsDisposalEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Disposal.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsDisposalEditWindow.collapsed)
						ImsDisposalEditWindow.expand(true);
					else
						ImsDisposalEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsDisposalEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsDisposalEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsDisposalData();
<?php } else { ?>
							RefreshImsDisposalData();
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
					ImsDisposalEditWindow.close();
				}
			}]
		});
