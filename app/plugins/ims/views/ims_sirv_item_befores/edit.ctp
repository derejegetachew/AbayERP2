		<?php
			$this->ExtForm->create('ImsSirvItemBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsSirvItemBeforeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_sirv_item_before['ImsSirvItemBefore']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_befores;
					$options['value'] = $ims_sirv_item_before['ImsSirvItemBefore']['ims_sirv_before_id'];
					$this->ExtForm->input('ims_sirv_before_id', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name','code'],
						
						data: [
						<?php foreach($ims_items as $result){?>
						['<?php echo $result['ImsItem']['id']?>','<?php echo $result['ImsItem']['name']?>','<?php echo $result['ImsItem']['description']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					tpl: '<tpl for="."><div ext:qtip="{name} . {position}" class="x-combo-list-item">{name} <br><b>{code}</b></div></tpl>' ,
					hiddenName:'data[ImsSirvItemBefore][ims_item_id]',
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					value: '<?php echo $ims_sirv_item_before['ImsSirvItemBefore']['ims_item_id']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item_before['ImsSirvItemBefore']['measurement'];
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item_before['ImsSirvItemBefore']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item_before['ImsSirvItemBefore']['unit_price'];
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_item_before['ImsSirvItemBefore']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsSirvItemBeforeEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Sirv Item Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsSirvItemBeforeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsSirvItemBeforeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Sirv Item Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsSirvItemBeforeEditWindow.collapsed)
						ImsSirvItemBeforeEditWindow.expand(true);
					else
						ImsSirvItemBeforeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsSirvItemBeforeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvItemBeforeEditWindow.close();
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
					ImsSirvItemBeforeEditWindow.close();
				}
			}]
		});
