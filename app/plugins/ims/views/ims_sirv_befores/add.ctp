		<?php
			$this->ExtForm->create('ImsSirvBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsSirvBeforeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('fieldLabel' => 'Number');
					$this->ExtForm->input('name', $options);
				?>,
				{
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($branches as $branch){?>
					['<?php echo $branch['Branch']['id']?>','<?php echo $branch['Branch']['name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsSirvBefore][branch_id]',
				id: 'branch_id',
				name: 'branch_id',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select branch',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> Branch',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				anchor: '100%',
				blankText: 'Your input is invalid.',
			}		]
		});
		
		var ImsSirvBeforeAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Sirv Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsSirvBeforeAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsSirvBeforeAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Sirv Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsSirvBeforeAddWindow.collapsed)
						ImsSirvBeforeAddWindow.expand(true);
					else
						ImsSirvBeforeAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsSirvBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvBeforeAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvBeforeData();
<?php } else { ?>
							RefreshImsSirvBeforeData();
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
					ImsSirvBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvBeforeAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvBeforeData();
<?php } else { ?>
							RefreshImsSirvBeforeData();
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
					ImsSirvBeforeAddWindow.close();
				}
			}]
		});
