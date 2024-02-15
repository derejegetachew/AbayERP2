		<?php
			$this->ExtForm->create('BpCumulative');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpCumulativeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_cumulative['BpCumulative']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$options['value'] = $bp_cumulative['BpCumulative']['bp_item_id'];
					$this->ExtForm->input('bp_item_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_months;
					$options['value'] = $bp_cumulative['BpCumulative']['bp_month_id'];
					$this->ExtForm->input('bp_month_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $bp_cumulative['BpCumulative']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_cumulative['BpCumulative']['plan'];
					$this->ExtForm->input('plan', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_cumulative['BpCumulative']['actual'];
					$this->ExtForm->input('actual', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_cumulative['BpCumulative']['cumilativePlan'];
					$this->ExtForm->input('cumilativePlan', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_cumulative['BpCumulative']['cumilativeActual'];
					$this->ExtForm->input('cumilativeActual', $options);
				?>			]
		});
		
		var BpCumulativeEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Cumulative'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpCumulativeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpCumulativeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Cumulative.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpCumulativeEditWindow.collapsed)
						BpCumulativeEditWindow.expand(true);
					else
						BpCumulativeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpCumulativeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpCumulativeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpCumulativeData();
<?php } else { ?>
							RefreshBpCumulativeData();
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
					BpCumulativeEditWindow.close();
				}
			}]
		});
