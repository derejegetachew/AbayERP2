		<?php
			$this->ExtForm->create('SpItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpItemAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Calculate",'xtype' => 'combo', 'value' => 'No Calculation');
					$options['items'] = array('No Calculation' => 'No Calculation', 'Fixed Cost' => 'Fixed Cost','Monthly Cost' => 'Monthly Cost');
					$this->ExtForm->input('um', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Amount");
					$this->ExtForm->input('price', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Category");
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $sp_item_groups;
					$this->ExtForm->input('sp_item_group_id', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Applicable For",'xtype' => 'combo', 'value' => 1);
					$options['items'] = array('1' => 'Both', '2' => 'Branch Only','3' => 'Head Office Only');
					$this->ExtForm->input('sp_cat_id', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "remark");
					$this->ExtForm->input('remark', $options);
				?>				]
		});
		
		var SpItemAddWindow = new Ext.Window({
			title: '<?php __('Add Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpItemAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpItemAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Sp Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpItemAddWindow.collapsed)
						SpItemAddWindow.expand(true);
					else
						SpItemAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpItemAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshSpItemData();
<?php } else { ?>
							RefreshSpItemData();
							
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					SpItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpItemAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshSpItemData();
<?php } else { ?>
							RefreshSpItemData();
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
					SpItemAddWindow.close();
				}
			}]
		});
