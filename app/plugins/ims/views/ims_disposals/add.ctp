		<?php
			$this->ExtForm->create('ImsDisposal');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsDisposalAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
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
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($ims_stores as $ims_store){?>
						['<?php echo $ims_store['ImsStore']['id']?>','<?php echo $ims_store['ImsStore']['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsDisposal][ims_store_id]',
					id: 'store',
					name: 'store',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Store',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Store',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: false,
					forceSelection:true,
					anyMatch : true,
				}
						]
		});
		
		var ImsDisposalAddWindow = new Ext.Window({
			title: '<?php __('Add Disposal'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsDisposalAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsDisposalAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Disposal.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsDisposalAddWindow.collapsed)
						ImsDisposalAddWindow.expand(true);
					else
						ImsDisposalAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsDisposalAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsDisposalAddForm.getForm().reset();
							ImsDisposalAddWindow.close();
							RefreshImsDisposalData();
							
							ViewParentImsDisposalItems(a.result.po_id);
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
			}, /*{
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					ImsDisposalAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsDisposalAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsDisposalData();
<?php } else { ?>
							RefreshImsDisposalData();
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
			},*/{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ImsDisposalAddWindow.close();
				}
			}]
		});
