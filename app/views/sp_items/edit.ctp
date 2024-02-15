		<?php
			$this->ExtForm->create('SpItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $sp_item['SpItem']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $sp_item['SpItem']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Calculate",'xtype' => 'combo', 'value' => $sp_item['SpItem']['um']);
					$options['items'] = array('No Calculation' => 'No Calculation', 'Fixed Cost' => 'Fixed Cost','Monthly Cost' => 'Monthly Cost');
					$this->ExtForm->input('um', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Amount");
					$options['value'] = $sp_item['SpItem']['price'];
					$this->ExtForm->input('price', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => "Category");
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $sp_item_groups;
					$options['value'] = $sp_item['SpItem']['sp_item_group_id'];
					$this->ExtForm->input('sp_item_group_id', $options);
				?>,
                   <?php 
					$options = array('fieldLabel' => "Applicable For",'xtype' => 'combo', 'value' => $sp_item['SpItem']['sp_cat_id']);
					$options['items'] = array('1' => 'Both', '2' => 'Branch Only','3' => 'Head Office Only');
					$this->ExtForm->input('sp_cat_id', $options);
				?>
				,
				<?php 
					$options = array('fieldLabel' => "remark");
					$options['value'] = $sp_item['SpItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>	,
				<?php 
					$options = array('fieldLabel' => "Status",'xtype'=>'combo','value' => $sp_item['SpItem']['suspend']);
				    $options['items'] = array('0' => 'Active', '1' => 'InActive');
					$this->ExtForm->input('suspend', $options);
				?>			

				]
		});
		
		var SpItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpItemEditWindow.collapsed)
						SpItemEditWindow.expand(true);
					else
						SpItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpItemData();
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
					SpItemEditWindow.close();
				}
			}]
		});
