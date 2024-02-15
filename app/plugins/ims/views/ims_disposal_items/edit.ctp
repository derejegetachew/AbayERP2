		<?php
			$this->ExtForm->create('ImsDisposalItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsDisposalItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_disposal_item['ImsDisposalItem']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_disposals;
					$options['value'] = $ims_disposal_item['ImsDisposalItem']['ims_disposal_id'];
					$this->ExtForm->input('ims_disposal_id', $options);
				?>,				
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name','code'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>','<?php echo $result['description']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					tpl: '<tpl for="."><div ext:qtip="{name} . {position}" class="x-combo-list-item">{name} <br><b>{code}</b></div></tpl>' ,
					hiddenName:'data[ImsDisposalItem][ims_item_id]',
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					value: '<?php echo $ims_disposal_item['ImsItem']['id']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
					$options['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg', 'Roll' => 'Roll','Ream' => 'Ream','m<sup>2</sup>' => 'm<sup>2</sup>','M' => 'M','Set' => 'Set');
					$options['value'] = $ims_disposal_item['ImsDisposalItem']['measurement'];
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $ims_disposal_item['ImsDisposalItem']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,				
				<?php 
					$options = array();
					$options['value'] = $ims_disposal_item['ImsDisposalItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsDisposalItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Disposal Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsDisposalItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsDisposalItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Disposal Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsDisposalItemEditWindow.collapsed)
						ImsDisposalItemEditWindow.expand(true);
					else
						ImsDisposalItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsDisposalItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsDisposalItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsDisposalItemData();
<?php } else { ?>
							RefreshImsDisposalItemData();
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
					ImsDisposalItemEditWindow.close();
				}
			}]
		});
