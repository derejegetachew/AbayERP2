		<?php
			$this->ExtForm->create('SpPlan');
			$this->ExtForm->defineFieldFunctions();
		?>


		var  dataSourceItems=[];
		var SpPlanAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'add1', $parent_id)); ?>',
			defaultType: 'textfield',

			items: [
				{
					store: new Ext.data.ArrayStore(
						{ 
                        sortInfo: { field: "name", direction: "ASC" },
							fields: [ 'id', 'name' ], 
					data: [
						<?php
						foreach($list_group as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>'],
						<?php
						}
						?>
						]
				}), 
				xtype: 'combo', 
				name: 'sp_item_group_id', 
				hiddenName: 'data[SpPlan][sp_item_group_id]', 
				//tpl: '<tpl for="."><div ext:qtip="{name}" class="x-combo-list-item">{name}</div></tpl>',
				fieldLabel: '<b style="color:black">* Category</b>',
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
				disableKeyFilter: true,
				listeners:{
					select: function(combo,record,index){
						Ext.Ajax.request({
                         url:'<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'setParent')); ?>/'+record.data.id,
                         success:function(data,opts){
                            var jsonData = Ext.util.JSON.decode(data.responseText);

                          // console.log(jsonData[0]);
                           if(jsonData[0]!==null){
dataSourceItems=[];
                            Ext.each(jsonData, function(obj) {
                                   				                dataSourceItems.push([obj.id,obj.name,obj.desc,obj.remark]);
				            });
                        }

				            if(jsonData[0]!==null){
							   Ext.getCmp('sp_item_id').getStore().loadData(dataSourceItems);
				            }else{
 dataSourceItems=[];
				            	/*while (dataSourceItems.length > 0) {
										    dataSourceItems.pop();
										}*/
				            	Ext.getCmp('sp_item_id').getStore().loadData(dataSourceItems);
				            }
				            
							
                         },
                         failed:function(data,opts){
                          console.log(data);
                         }
			    		});
					}
				}
			}
			,
				{
					store: new Ext.data.ArrayStore(
						{ 
							fields: [ 'id', 'name','desc','um'], 
							data:dataSourceItems
				}), 
				xtype: 'combo', 
				id:'sp_item_id',
				name: 'sp_item_id', 
				hiddenName: 'data[SpPlan][sp_item_id]', 
				tpl: '<tpl for="."><div ext:qtip="{name}" class="x-combo-list-item">{name} <br><b>{desc};{um}</b></div></tpl>' ,
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
					$options = array('anchor' => '60%');
					$this->ExtForm->input('march_end', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'June Estimate','anchor' => '60%');
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
					$options = array('anchor' => '60%');
					$this->ExtForm->input('july', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('august', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('september', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('october', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('november', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('december', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('january', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('february', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('march', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('april', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('may', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('june', $options);
				?>	]}
				,
				<?php 
					$options = array('fieldLabel'=>'Remark(Optional)');
					$this->ExtForm->input('remark', $options);
				?>
				]
		});
		
		var SpPlanAddWindow = new Ext.Window({
			title: '<?php __('New Badget List'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpPlanAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpPlanAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Sp Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpPlanAddWindow.collapsed)
						SpPlanAddWindow.expand(true);
					else
						SpPlanAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save & Add More'); ?>',
				handler: function(btn){
					SpPlanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpPlanAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpPlanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpPlanAddWindow.close();
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
					SpPlanAddWindow.close();
				}
			}]
		});
