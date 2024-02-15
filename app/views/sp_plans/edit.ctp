		<?php
			$this->ExtForm->create('SpPlan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpPlanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $sp_plan['SpPlan']['id'])); ?>,
					{
					store: new Ext.data.ArrayStore(
						{ 
                        sortInfo: { field: "name", direction: "ASC" },
							fields: [ 'id', 'name','desc' ], 
					data: [
				<?php
						foreach($sp_items as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name'].' | CODE:'.$result['id']?>','<?php echo $result['desc'].' | '.$result['remark']?>'],
						<?php
						}
						?>
						]
				}), 
				xtype: 'combo', 
				name: 'sp_item_id', 
				hiddenName: 'data[SpPlan][sp_item_id]', 
				tpl: '<tpl for="."><div ext:qtip="{name}" class="x-combo-list-item">{name} <br><b>{desc}</b></div></tpl>' ,
				fieldLabel: '<b style="color:black">* Checklist</b>',
				 typeAhead: true, 
				 typeAheadDelay: 15000,
				 emptyText: 'Type to search', 
				 editable: true, 
				 selectOnFocus:false,
				 forceSelection: true, 
				 triggerAction: 'all', 
				 lazyRender: true, 
				 mode: 'local', 
				valueField: 'id', 
				displayField: 'name', 
				allowBlank: false, 
				anchor: '100%',
				value: '<?php echo $sp_plan['SpPlan']['sp_item_id']?>',
				anyMatch : true,
				disableKeyFilter: true,
				doQuery : function(q, forceAll){
						
						if(q === undefined || q === null){
							q = '';
						}
						var qe = {
							query: q,
							forceAll: forceAll,
							combo: this,
							cancel:false
						};
						if(this.fireEvent('beforequery', qe)===false || qe.cancel){
							return false;
						}
						q = qe.query;
						forceAll = qe.forceAll;
						if(forceAll === true || (q.length >= this.minChars)){
							if(this.lastQuery !== q){
								this.lastQuery = q;
								if(this.mode == 'local'){
									this.selectedIndex = -1;
									if(forceAll){
										this.store.clearFilter();
									}else{
							this.store.filter(this.displayField, q, this.anyMatch);
									}
									this.onLoad();
								}else{
									this.store.baseParams[this.queryParam] = q;
									this.store.load({
										params: this.getParams(q)
									});
									this.expand();
								}
							}else{
								this.selectedIndex = -1;
								this.onLoad();
							}
						}
					} 
			},{   
                                xtype:'fieldset',
                                title: 'Current Budget Year (For Branches)',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['march_end']);
					$this->ExtForm->input('march_end', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'June Estimate','anchor' => '60%','value'=>$sp_plan['SpPlan']['june_end']);
					$this->ExtForm->input('june_end', $options);
				?>,
				]
				},
				{   
                                xtype:'fieldset',
                                title: '<b style="color:black">Monthly Plan (Quantity or Amount:ETB)</b>',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['july']);
					$this->ExtForm->input('july', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['august']);
					$this->ExtForm->input('august', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['september']);
					$this->ExtForm->input('september', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['october']);
					$this->ExtForm->input('october', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['november']);
					$this->ExtForm->input('november', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['december']);
					$this->ExtForm->input('december', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['january']);
					$this->ExtForm->input('january', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['february']);
					$this->ExtForm->input('february', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['march']);
					$this->ExtForm->input('march', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['april']);
					$this->ExtForm->input('april', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['may']);
					$this->ExtForm->input('may', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%','value'=>$sp_plan['SpPlan']['june']);
					$this->ExtForm->input('june', $options);
				?>	]}
				,
				<?php 
					$options = array('fieldLabel'=>'Remark(Optional)','value'=>$sp_plan['SpPlan']['remark']);
					$this->ExtForm->input('remark', $options);
				?>		]
		});
		
		var SpPlanEditWindow = new Ext.Window({
			title: '<?php __('Edit Sp Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpPlanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpPlanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpPlanEditWindow.collapsed)
						SpPlanEditWindow.expand(true);
					else
						SpPlanEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpPlanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpPlanEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpPlanData();
<?php } else { ?>
							RefreshSpPlanData();
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
					SpPlanEditWindow.close();
				}
			}]
		});
