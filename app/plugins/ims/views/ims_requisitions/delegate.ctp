
		<?php
			$this->ExtForm->create('ImsDelegate');
			$this->ExtForm->defineFieldFunctions();
		?>
		Ext.ns("Hulas.ux");
			Hulas.ux.line = Ext.extend(Ext.Component, {
			autoEl: 'hr'
		});

		Ext.reg('line', Hulas.ux.line);
		
		var lineconfig = {
			xtype: 'box',
			autoEl:{
				tag: 'div',
				style:'line-height:1px; font-size: 1px;margin-bottom:14px',
				children: [{
					
				}]
			}
		};		
	
		var ImsRequisitionDelegateForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsDelegates', 'action' => 'add',)); ?>',
			defaultType: 'textfield',
			

			items: [
				<?php 
					$options = array();
					if(isset($imsRequisition))
						$options['hidden'] = $imsRequisition['ImsRequisition']['id'];
					else
						$options['items'] = $imsRequisition;
					$this->ExtForm->input('ims_requisition_id', $options);
				?>,
				{
					xtype: 'radiogroup',
					fieldLabel: 'Select your Delegate type',
					//arrange Radio Buttons into 2 columns
					columns: 2,
					itemId: 'personType',
					width:200,
					items: [
						{
							xtype: 'radio',
							boxLabel: 'Employee',
							name: "data[ImsDelegate][personType]",
							checked: false,
							inputValue: 'Employee',
							listeners: {
								change: function () {
									Ext.getCmp('user').enable();
									Ext.getCmp('name').disable();
									Ext.getCmp('phone').disable();
								}
							}
						},
						{
							xtype: 'radio',
							boxLabel: 'Other',
							name: "data[ImsDelegate][personType]",		
							checked: false,
							inputValue: 'Other',
							listeners: {
								change: function () {
									Ext.getCmp('user').disable();
									Ext.getCmp('name').enable();
									Ext.getCmp('phone').enable();
								}
							}
						}
					]
				},
				{
					xtype: 'line'
				},
				{
				ctCls : 'spaces',
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($employees as $employee){?>
					['<?php echo $employee['People']['id']?>','<?php echo $employee['People']['first_name'].' '.$employee['People']['middle_name'].' '.$employee['People']['last_name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsDelegate][user_id]',
				id: 'user',
				name: 'user',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select Employee',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;"></span> Delegated Employee',
				allowBlank: true,
				editable: true,
				disabled:true,
				layout: 'form',
				lazyRender: true,
				anchor: '100%',
				blankText: 'Your input is invalid.',
			},
			lineconfig,
				<?php 
					$options = array('id'=>'name','disabled'=>true);
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('id'=>'phone','disabled'=>true);
					$this->ExtForm->input('phone', $options);
				?>	
							]
		});
		
		var ImsRequisitionDelegateWindow = new Ext.Window({
			title: '<?php __('Add Delegate'); ?>',
			width: 500,
			minWidth: 500,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRequisitionDelegateForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRequisitionDelegateForm.getForm().reset();
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
					if(ImsRequisitionDelegateWindow.collapsed)
						ImsRequisitionDelegateWindow.expand(true);
					else
						ImsRequisitionDelegateWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Accept'); ?>',
				handler: function(btn){
					ImsRequisitionDelegateForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							//ImsRequisitionAddForm.getForm().reset();
							parentImsSirvItemsViewWindow.close();
							ImsRequisitionDelegateWindow.close();
							RefreshImsRequisitionData();
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
					ImsRequisitionDelegateWindow.close();
				}
			}]
		});
