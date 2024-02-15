		<?php
			$this->ExtForm->create('IbdDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdDocumentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_document['IbdDocument']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_document['IbdDocument']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_document['IbdDocument']['description'];
					$this->ExtForm->input('description', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_document['IbdDocument']['controller'];
					$this->ExtForm->input('controller', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_document['IbdDocument']['action'];
					$this->ExtForm->input('action', $options);
				?>			]
		});
		
		var IbdDocumentEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Document'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdDocumentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdDocumentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Document.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdDocumentEditWindow.collapsed)
						IbdDocumentEditWindow.expand(true);
					else
						IbdDocumentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdDocumentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdDocumentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdDocumentData();
<?php } else { ?>
							RefreshIbdDocumentData();
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
					IbdDocumentEditWindow.close();
				}
			}]
		});
