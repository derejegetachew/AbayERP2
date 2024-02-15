		<?php
			$this->ExtForm->create('DmsDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsDocumentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$options['fieldLabel']='Folder Name';
					$this->ExtForm->input('name', $options);
				?>,
				<?php $this->ExtForm->input('parent_id', array('hidden' => $parent_id)); ?>,]
		});
		
		var DmsDocumentAddWindow = new Ext.Window({
			title: '<?php __('New Folder'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsDocumentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsDocumentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Dms Document.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsDocumentAddWindow.collapsed)
						DmsDocumentAddWindow.expand(true);
					else
						DmsDocumentAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Create'); ?>',
				handler: function(btn){
					DmsDocumentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsDocumentAddWindow.close();
							RefreshDmsDocumentData();

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
					DmsDocumentAddWindow.close();
				}
			}]
		});
