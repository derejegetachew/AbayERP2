		<?php
			$this->ExtForm->create('FrwfmDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmDocumentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_document['FrwfmDocument']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $frwfm_applications;
					$options['value'] = $frwfm_document['FrwfmDocument']['frwfm_application_id'];
					$this->ExtForm->input('frwfm_application_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_document['FrwfmDocument']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_document['FrwfmDocument']['file_path'];
					$this->ExtForm->input('file_path', $options);
				?>			]
		});
		
		var FrwfmDocumentEditWindow = new Ext.Window({
			title: '<?php __('Edit Frwfm Document'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmDocumentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmDocumentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Frwfm Document.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmDocumentEditWindow.collapsed)
						FrwfmDocumentEditWindow.expand(true);
					else
						FrwfmDocumentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FrwfmDocumentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmDocumentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFrwfmDocumentData();
<?php } else { ?>
							RefreshFrwfmDocumentData();
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
					FrwfmDocumentEditWindow.close();
				}
			}]
		});
