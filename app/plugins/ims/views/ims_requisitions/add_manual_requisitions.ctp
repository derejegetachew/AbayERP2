
		<?php
			$this->ExtForm->create('ImsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsRequisitionManualAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'add_Manual_Requisitions')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('fieldLabel' => 'Ref Number');
					$this->ExtForm->input('name', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
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
					hiddenName:'data[ImsRequisition][branch_id]',
					id: 'branch',
					name: 'branch',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Branch',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Purpose',
						'anchor' => '100%'
					);
					$this->ExtForm->input('purpose', $options);
				?>
							]
		});
		
		var ImsRequisitionManualAddWindow = new Ext.Window({
			title: '<?php __('Add Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRequisitionManualAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRequisitionManualAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Requisition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsRequisitionManualAddWindow.collapsed)
						ImsRequisitionManualAddWindow.expand(true);
					else
						ImsRequisitionManualAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsRequisitionManualAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							//ImsRequisitionManualAddForm.getForm().reset();
							ImsRequisitionManualAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRequisitionData();
<?php } else { ?>
							RefreshImsRequisitionData();
							ViewParentImsRequisitionItems(a.result.po_id);
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
					ImsRequisitionManualAddWindow.close();
				}
			}]
		});
