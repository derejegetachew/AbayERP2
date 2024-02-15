
		<?php
			$this->ExtForm->create('ImsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsRequisitionManualEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit_manual_requisitions')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_requisition['ImsRequisition']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Ref Number');
					$options['value'] = $ims_requisition['ImsRequisition']['name'];
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
					value: '<?php echo $ims_requisition['ImsRequisition']['branch_id'] ?>',
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
					$options['value'] = $ims_requisition['ImsRequisition']['purpose'];
					$this->ExtForm->input('purpose', $options);
				?>			
				
							]
		});
		
		var ImsRequisitionManualEditWindow = new Ext.Window({
			title: '<?php __('Edit Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRequisitionManualEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRequisitionManualEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Requisition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsRequisitionManualEditWindow.collapsed)
						ImsRequisitionManualEditWindow.expand(true);
					else
						ImsRequisitionManualEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsRequisitionManualEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsRequisitionManualEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRequisitionData();
<?php } else { ?>
							RefreshImsRequisitionData();
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
					ImsRequisitionManualEditWindow.close();
				}
			}]
		});
