		<?php
			$this->ExtForm->create('Field');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FieldAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                            $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Type', 'value' => 'textfield');
                                $options['items'] = array('textfield'=>'textfield','datefield' => 'datefield', 'multiple_datefield' => 'multiple_datefield','combo'=>'combo','combo_multiple'=>'combo_multiple');
                             
                                $options['listeners'] = "{
                            scope: this,
                            'select': function(combo, record, index){
                           
                                var par = Ext.getCmp('data[Field][params]');
                                if(combo.getValue()=='textfield'){
                                par.setValue('allowBlank: false');
                                }
                                if(combo.getValue()=='datefield'){
                                par.setValue('anchor: \'100%\',format:\'Y-m-d\'');
                                }
                                 if(combo.getValue()=='multiple_datefield'){
                                par.setValue('anchor: \'100%\',format:\'Y-m-d\'');
                                }
                                  if(combo.getValue()=='combo'){
                                par.setValue('typeAhead: true,emptyText: \'All Branches\',editable: false,triggerAction: \'all\',lazyRender: true,mode: \'local\',anchor: \'100%\',blankText: \'Your input is invalid.\'');
                                }
                           
                            }
                        }";
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
                                            $options = array(
                                    'xtype' => 'textarea',
                                    'height' => 370,
                                    'anchor' => '99%',
                                    'fieldLabel' => 'Parameters',
                                    'enableFont' => true,
                                    'enableFontSize' => true,
                                                'id'=>'data[Field][params]'
                                );
                          
					$this->ExtForm->input('params', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Store Type (if Combo)', 'value' => ' ');
                                $options['items'] = array(' '=>' ','PHP' => 'PHP', 'SQL' => 'SQL','choices'=>'choices');
                             
					$this->ExtForm->input('store', $options);
				?>			]
		});
		
		var FieldAddWindow = new Ext.Window({
			title: '<?php __('Add Field'); ?>',
			width: 640,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FieldAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FieldAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Field.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FieldAddWindow.collapsed)
						FieldAddWindow.expand(true);
					else
						FieldAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FieldAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FieldAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFieldData();
<?php } else { ?>
							RefreshFieldData();
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
					FieldAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FieldAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFieldData();
<?php } else { ?>
							RefreshFieldData();
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
					FieldAddWindow.close();
				}
			}]
		});
