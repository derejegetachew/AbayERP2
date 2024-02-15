		<?php
			$this->ExtForm->create('ImsTransferStoreItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferStoreItemAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 120,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				{
					xtype: 'displayfield',
					fieldLabel: 'From Store',
					name: 'From_Store',
					value: '<?php echo $store['ImsStore']['name']; ?>'
				},
				<?php 
					$options = array('fieldLabel' => 'From Store','readOnly' => 'true','hidden' => 'true');				
					$options['value'] = $store['ImsStore']['id'];
					$this->ExtForm->input('from_store', $options);
				?>,
				{
					xtype: 'displayfield',
					fieldLabel: 'From Store Keeper',
					name: 'From_Store_Keeper',
					value: '<?php echo $storeKeeper['Person']['first_name'] .' '.$storeKeeper['Person']['middle_name'] .' '.$storeKeeper['Person']['last_name']; ?>'
				},
				<?php 
					$options = array('fieldLabel' => 'From Store Keeper','readOnly' => 'true','hidden' => 'true');
					$options['value'] = $storeKeeper['id'];					
					$this->ExtForm->input('from_store_keeper', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true');
					date_default_timezone_set("Africa/Addis_Ababa");  
                    $options['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
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
					forceSelection:true					
				},				
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Remark',
						'anchor' => '100%');
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsTransferStoreItemAddWindow = new Ext.Window({
			title: '<?php __('Add Transfer Store Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferStoreItemAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferStoreItemAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Transfer Store Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferStoreItemAddWindow.collapsed)
						ImsTransferStoreItemAddWindow.expand(true);
					else
						ImsTransferStoreItemAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferStoreItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferStoreItemAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferStoreItemData();
<?php } else { ?>
							RefreshImsTransferStoreItemData();
							ViewParentImsTransferStoreItemDetails(a.result.sti_id);
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
					ImsTransferStoreItemAddWindow.close();
				}
			}]
		});
