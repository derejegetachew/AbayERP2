		<?php
			$this->ExtForm->create('DmsDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsDocumentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_document['DmsDocument']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $dms_document['DmsDocument']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $parents;
					$options['value'] = $dms_document['DmsDocument']['parent_id'];
					$this->ExtForm->input('parent_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['shared'];
					$this->ExtForm->input('shared', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['size'];
					$this->ExtForm->input('size', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['file_type'];
					$this->ExtForm->input('file_type', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['file_name'];
					$this->ExtForm->input('file_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_document['DmsDocument']['share_to'];
					$this->ExtForm->input('share_to', $options);
				?>			]
		});
		
		var DmsDocumentEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Document'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsDocumentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsDocumentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Document.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsDocumentEditWindow.collapsed)
						DmsDocumentEditWindow.expand(true);
					else
						DmsDocumentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsDocumentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsDocumentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsDocumentData();
<?php } else { ?>
							RefreshDmsDocumentData();
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
					DmsDocumentEditWindow.close();
				}
			}]
		});
