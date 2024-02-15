<?php
			$this->ExtForm->create('AvailableBirrNote');
			$this->ExtForm->defineFieldFunctions();
		?>
		var AvailableBirrNoteAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [{
        // Fieldset in Column 1 - collapsible via toggle button
        xtype:'fieldset',
        labelAlign: 'right',
        columnWidth: 0.5,
        title: 'Old Birr Note',
        collapsible: true,
        defaultType: 'textfield',
        defaults: {anchor: '100%'},
        items :[<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('old_10_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('old_50_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('old_100_birr', $options);
				?>]
    }, {
			
		// Fieldset in Column 2 - collapsible via checkbox, collapsed by default, contains a panel
        xtype:'fieldset',
        labelAlign: 'right',
        columnWidth: 0.5,
        title: 'New and Proceeding Birr Note',
        collapsible: true,
        defaultType: 'textfield',
        defaults: {anchor: '100%'},
        items :[
		
				<?php 
				
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('new_200_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('new_100_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('new_50_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
					$this->ExtForm->input('new_10_birr', $options);
				?>,
				<?php 
					$options = array();
					$options = array('allowBlank' => false);
                                        $options = array('value' => 0);
					$this->ExtForm->input('new_5_birr', $options);
				?>,
					<?php 
					$options = array();
					$options = array('allowBlank' => false);
                                        $options = array('value' => 0);
					$this->ExtForm->input('new_1_birr', $options);
				?>,
			
				<?php 
				$options = array();
				$options = array('allowBlank' => false);
                                $options = array('value' => 0);
				$this->ExtForm->input('new_50_cents', $options);
			?>,
			<?php 
				$options = array();
				$options = array('allowBlank' => false);
                                $options = array('value' => 0);
				$this->ExtForm->input('new_25_cents', $options);
			?>,
			<?php 
				$options = array();
				$options = array('allowBlank' => false);
                                $options = array('value' => 0);
				$this->ExtForm->input('new_10_cents', $options);
			?>,
			<?php 
				$options = array();
				$options = array('allowBlank' => false);
                                $options = array('value' => 0);
				$this->ExtForm->input('new_5_cents', $options);
			?>
		
			]
    },{
			
			// Fieldset in Column 2 - collapsible via checkbox, collapsed by default, contains a panel
			xtype:'fieldset',
		
			items :[
			
				
					<?php 
						$options = array();
						$options = array('allowBlank' => false);
                                                $options = array('maxValue' => date('Y-m-d',strtotime('+1 day')));                                         
						$this->ExtForm->input('date_of', $options);
					?>]
		}]	
							
		});
		
		var AvailableBirrNoteAddWindow = new Ext.Window({
			title: '<?php __('Add Available Birr Note'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AvailableBirrNoteAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AvailableBirrNoteAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Available Birr Note.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AvailableBirrNoteAddWindow.collapsed)
						AvailableBirrNoteAddWindow.expand(true);
					else
						AvailableBirrNoteAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AvailableBirrNoteAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',


						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AvailableBirrNoteAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentAvailableBirrNoteData();
<?php } else { ?>
							RefreshAvailableBirrNoteData();
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
					AvailableBirrNoteAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AvailableBirrNoteAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentAvailableBirrNoteData();
<?php } else { ?>
							RefreshAvailableBirrNoteData();
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
					AvailableBirrNoteAddWindow.close();
				}
			}]
		});
