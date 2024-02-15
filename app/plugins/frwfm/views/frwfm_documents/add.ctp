		<?php
			$this->ExtForm->create('FrwfmDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmDocumentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'add')); ?>',
			defaultType: 'textfield',
			fileUpload: true,

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $frwfm_applications;
					$this->ExtForm->input('frwfm_application_id', $options);
				?>,
				{
					xtype: 'fileuploadfield',
					id: 'form-file',
					emptyText: 'Select File',
					fieldLabel: 'File',
					name: 'data[FrwfmDocument][file]',
					buttonText: 'Browse',
					anchor:'100%'
				}		]
		});
		
		var FrwfmDocumentAddWindow = new Ext.Window({
			title: '<?php __('Upload Attachment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmDocumentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmDocumentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Frwfm Document.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmDocumentAddWindow.collapsed)
						FrwfmDocumentAddWindow.expand(true);
					else
						FrwfmDocumentAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Upload'); ?>',
				handler: function(btn){
					FrwfmDocumentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmDocumentAddWindow.close();
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
					FrwfmDocumentAddWindow.close();
				}
			}]
		});
