		<?php
			$this->ExtForm->create('ImsSirvItemBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsSirvItemBeforeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_befores;
					$this->ExtForm->input('ims_sirv_before_id', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($ims_items as $ims_item){?>
						['<?php echo $ims_item['ImsItem']['id']?>','<?php echo $ims_item['ImsItem']['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsSirvItemBefore][ims_item_id]',
					id: 'item_id',
					name: 'item_id',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select item',
					selectOnFocus:true,
					valueField: 'id',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					layout: 'form',
					lazyRender: true,
					blankText: 'Your input is invalid.',
				},	
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
					$options['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg', 'Roll' => 'Roll','Ream' => 'Ream','m<sup>2</sup>' => 'm<sup>2</sup>','M' => 'M','Set' => 'Set');
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsSirvItemBeforeAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Sirv Item Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsSirvItemBeforeAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsSirvItemBeforeAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Sirv Item Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsSirvItemBeforeAddWindow.collapsed)
						ImsSirvItemBeforeAddWindow.expand(true);
					else
						ImsSirvItemBeforeAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsSirvItemBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvItemBeforeAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvItemBeforeData();
<?php } else { ?>
							RefreshImsSirvItemBeforeData();
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
					ImsSirvItemBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvItemBeforeAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvItemBeforeData();
<?php } else { ?>
							RefreshImsSirvItemBeforeData();
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
					ImsSirvItemBeforeAddWindow.close();
				}
			}]
		});
