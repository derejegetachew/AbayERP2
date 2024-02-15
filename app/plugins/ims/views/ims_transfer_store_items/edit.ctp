		<?php
			$this->ExtForm->create('ImsTransferStoreItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferStoreItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 120,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_transfer_store_item['ImsTransferStoreItem']['id'])); ?>,
				{
					xtype: 'displayfield',
					fieldLabel: 'From Store',
					name: 'From_Store',
					value: '<?php echo $ims_transfer_store_item['FromStore']['name']; ?>'
				},
				{
					xtype: 'displayfield',
					fieldLabel: 'From Store Keeper',
					name: 'From_Store_Keeper',
					value: '<?php echo $ims_transfer_store_item['FromStoreKeeper']['Person']['first_name'].' '.$ims_transfer_store_item['FromStoreKeeper']['Person']['middle_name']; ?>'
				},
				<?php 
					$options = array('readOnly' => 'true');
					$options['value'] = $ims_transfer_store_item['ImsTransferStoreItem']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						fields: ['id','name'],
						
						data: [
						<?php foreach($stores as $store){?>
						['<?php echo $store['ImsStore']['id']?>','<?php echo $store['ImsStore']['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: false,
					typeAheadDelay: 15000,
					hiddenName:'data[ImsTransferStoreItem][to_store]',
					id: 'to_store',
					name: 'to_store',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Store',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> To Store',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					value: '<?php echo $ims_transfer_store_item['ImsTransferStoreItem']['to_store']; ?>'
				},							
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Remark',
						'anchor' => '100%');
					$options['value'] = $ims_transfer_store_item['ImsTransferStoreItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>							]
		});
		
		var ImsTransferStoreItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Transfer Store Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferStoreItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferStoreItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Transfer Store Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferStoreItemEditWindow.collapsed)
						ImsTransferStoreItemEditWindow.expand(true);
					else
						ImsTransferStoreItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferStoreItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferStoreItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferStoreItemData();
<?php } else { ?>
							RefreshImsTransferStoreItemData();
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
					ImsTransferStoreItemEditWindow.close();
				}
			}]
		});
