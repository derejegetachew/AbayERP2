		<?php
			$this->ExtForm->create('ImsSirvItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsSirvItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_sirv_item['ImsSirvItem']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirvs;
					$options['value'] = $ims_sirv_item['ImsSirvItem']['ims_sirv_id'];
					$this->ExtForm->input('ims_sirv_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_items;
					$options['value'] = $ims_sirv_item['ImsSirvItem']['ims_item_id'];
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item['ImsSirvItem']['measurement'];
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item['ImsSirvItem']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item['ImsSirvItem']['unit_price'];
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item['ImsSirvItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsSirvItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Sirv Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsSirvItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsSirvItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Sirv Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsSirvItemEditWindow.collapsed)
						ImsSirvItemEditWindow.expand(true);
					else
						ImsSirvItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsSirvItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvItemData();
<?php } else { ?>
							RefreshImsSirvItemData();
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
					ImsSirvItemEditWindow.close();
				}
			}]
		});
