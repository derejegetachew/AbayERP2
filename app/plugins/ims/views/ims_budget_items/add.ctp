		
		<?php
			$this->ExtForm->create('ImsBudgetItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsBudgetItemAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_budgets;
					$this->ExtForm->input('ims_budget_id', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsBudgetItem][ims_item_id]',
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
					$options['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg', 'Roll' => 'Roll', 'Ream' => 'Ream');
					$this->ExtForm->input('measurement', $options);
				?>			]
		});
		
		var ImsBudgetItemAddWindow = new Ext.Window({
			title: '<?php __('Add Budget Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsBudgetItemAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsBudgetItemAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Budget Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsBudgetItemAddWindow.collapsed)
						ImsBudgetItemAddWindow.expand(true);
					else
						ImsBudgetItemAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsBudgetItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							
							Ext.getCmp("item").store.removeAt(Ext.getCmp("item").selectedIndex);
							ImsBudgetItemAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsBudgetItemData();
<?php } else { ?>
							RefreshImsBudgetItemData();
							
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
					ImsBudgetItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsBudgetItemAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsBudgetItemData();
<?php } else { ?>
							RefreshImsBudgetItemData();
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
					ImsBudgetItemAddWindow.close();
				}
			}]
		});
