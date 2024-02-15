		<?php
			$this->ExtForm->create('IbdOutstandingExportLc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOutstandingExportLcAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'add')); ?>',
		

			items: [
			{
			layout:'column',
            items:[{

			         columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array();
					$this->ExtForm->input('exporter_name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_id', $options);
				?>
				,
				
					{
				    id:'total_lc_fcy',
					xtype:'textfield',
					fieldLabel:'Total LC FCY',
					anchor:'100%',
					name :'data[IbdOutstandingExportLc][total_lc_fcy]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
                             Ext.getCmp('outstanding_remaining_lc_fcy').setValue(value);

						}
					}
			},
				
				<?php 
					$options = array();
					$this->ExtForm->input('issuing_bank_ref_no', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true);
					$options['value']=$refno;
					$this->ExtForm->input('our_ref_no', $options);
				?>

				]
			},{
                        columnWidth:.5,
						layout: 'form',
						items: [
						<?php 
					$options = array();
					$now=new DateTime('now');
					$now->modify('+3 month');
					$now = $now->format('Y-m-d');
					$options['value']=$now;
					$this->ExtForm->input('expire_date', $options);
				?>,

				<?php 
					$options = array();
					$this->ExtForm->input('date_of_issue', $options);
				?>
				,
				
				<?php 
					$options = array();
					$this->ExtForm->input('place_of_expire', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('LDS', $options);
				?>
				,
				<?php 
					$options = array('readOnly'=>true,'id'=>'outstanding_remaining_lc_fcy','fieldLabel'=>'Remaining FCY');
					$this->ExtForm->input('outstanding_remaining_lc_fcy', $options);
				?>

						]}

						]}
						]
		} );


		
		var IbdOutstandingExportLcAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Outstanding Export Lc'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOutstandingExportLcAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOutstandingExportLcAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Outstanding Export Lc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOutstandingExportLcAddWindow.collapsed)
						IbdOutstandingExportLcAddWindow.expand(true);
					else
						IbdOutstandingExportLcAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOutstandingExportLcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOutstandingExportLcAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdOutstandingExportLcData();
<?php } else { ?>
							RefreshIbdOutstandingExportLcData();
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
					IbdOutstandingExportLcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOutstandingExportLcAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdOutstandingExportLcData();
<?php } else { ?>
							RefreshIbdOutstandingExportLcData();
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
					IbdOutstandingExportLcAddWindow.close();
				}
			}]
		});
