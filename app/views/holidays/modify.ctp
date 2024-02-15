		<?php
			$this->ExtForm->create('Holiday');
			$this->ExtForm->defineFieldFunctions();
		?>
		var HolidayModifyForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'modify')); ?>?task=modify',
			defaultType: 'textfield',
			buttons: [{
				<?php if($holiday['Holiday']['status']!='Taken' && $holiday['Holiday']['status']!='On Leave') echo "text: 'Save',"; else echo "text: 'Request Changes',"; ?>
				handler: function(btn){
					HolidayModifyForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HolidayEditWindow.close();
					<?php if(isset($parent_id)){ ?>
							RefreshParentHolidayData();
					<?php } else { ?>
							RefreshHolidayData();
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
			}],
			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $holiday['Holiday']['id'])); ?>,
				<?php $this->ExtForm->input('from_dates', array('hidden' => $holiday['Holiday']['from_date'],'fieldLabel'=>'from_date')); ?>,
				<?php 
					$options = array();
					$options['disabled']= 'true';
					$options['value'] = $holiday['Holiday']['from_date'];
					$this->ExtForm->input('from_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $holiday['Holiday']['to_date'];
					$this->ExtForm->input('to_date', $options);
				?> ]
		});
		
		var HolidayDeleteForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'modify')); ?>?task=delete',
			defaultType: 'textfield',
			buttons: [{
				<?php if($holiday['Holiday']['status']!='Taken' && $holiday['Holiday']['status']!='On Leave') echo "text: 'Delete',"; else echo "text: 'Request leave to be canceled',"; ?>
				handler: function(btn){
					HolidayDeleteForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HolidayEditWindow.close();
					<?php if(isset($parent_id)){ ?>
							RefreshParentHolidayData();
					<?php } else { ?>
							RefreshHolidayData();
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
				text: 'Close',
				handler: function(btn){
					HolidayEditWindow.close();
				}
			}],
			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $holiday['Holiday']['id'])); ?> ]
		});
		var panel1=new Ext.Panel({
			title:'Modify',
			height:50,
			items:HolidayModifyForm
		});
		var panel2=new Ext.Panel({
			title:'Remove',
			items:HolidayDeleteForm
		});
		var HolidayEditWindow = new Ext.Window({
			title: '<?php __(''); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: [panel1,panel2],
		});