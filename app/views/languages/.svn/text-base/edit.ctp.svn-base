		<?php
			$this->ExtForm->create('Language');
			$this->ExtForm->defineFieldFunctions();
		?>
    var store_language = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'name'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'list_language')); ?>'
	})
    });
          store_language.load({
            params: {
                start: 0
            }
        });
		var LanguageEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $language['Language']['id'])); ?>,
				{
                                                    xtype: 'combo',
                                                    name: 'data[Language][name]',
                                                    emptyText: 'All',
                                                    id: 'data[Language][name]',
                                                    name: 'data[Language][name]',
                                                    store : store_language,
                                                    displayField : 'name',
                                                    valueField : 'id',
                                                    fieldLabel: '<span style="color:red;">*</span> Name',
                                                    mode: 'local',
                                                    disableKeyFilter : true,
                                                    allowBlank: false,
                                                    typeAhead: true,
                                                    emptyText: '',
                                                    editable: true,
                                                    triggerAction: 'all',
                                                    hideTrigger:true,
                                                    width:155,
                                                    value:'<?php echo $language['Language']['name']; ?>'
                                                },
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Speak', 'value' => 'Fluent');
                                        $options['items'] = array('Poor' => 'Poor', 'Basic' => 'Basic','Good'=>'Good','Fluent'=>'Fluent');
					$options['value'] = $language['Language']['speak'];
					$this->ExtForm->input('speak', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Read', 'value' => 'Fluent');
                                        $options['items'] = array('Poor' => 'Poor', 'Basic' => 'Basic','Good'=>'Good','Fluent'=>'Fluent');
					$options['value'] = $language['Language']['read'];
					$this->ExtForm->input('read', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Write', 'value' => 'Fluent');
                                        $options['items'] = array('Poor' => 'Poor', 'Basic' => 'Basic','Good'=>'Good','Fluent'=>'Fluent');
					$options['value'] = $language['Language']['write'];
					$this->ExtForm->input('write', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Listen', 'value' => 'Fluent');
                                        $options['items'] = array('Poor' => 'Poor', 'Basic' => 'Basic','Good'=>'Good','Fluent'=>'Fluent');
					$options['value'] = $language['Language']['listen'];
					$this->ExtForm->input('listen', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $language['Language']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>			]
		});
		
		var LanguageEditWindow = new Ext.Window({
			title: '<?php __('Edit Language'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LanguageEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LanguageEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Language.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LanguageEditWindow.collapsed)
						LanguageEditWindow.expand(true);
					else
						LanguageEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LanguageEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LanguageEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLanguageData();
<?php } else { ?>
							RefreshLanguageData();
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
					LanguageEditWindow.close();
				}
			}]
		});
