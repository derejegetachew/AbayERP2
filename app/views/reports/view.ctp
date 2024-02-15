		<?php
			$this->ExtForm->create('Report');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ReportViewForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'report')); ?>',
			defaultType: 'textfield',
                        standardSubmit: 'true',
			items: [
				<?php   
                                        foreach($fields as $field){
                                            if($field['type']=='textfield'){
                                                echo " \n { xtype: 'textfield',\n fieldLabel: '".$field['fieldLabel']."', \n name: 'data[field][".$field['name']."]', \n id: 'data[field][".$field['name']."]', \n ";
                                                $params=explode(',',$field['params']);
                                                foreach($params as $param){
                                                    echo $param.", \n ";
                                                }
                                                echo "},";
                                            }
											elseif($field['type']=='datefield'){
                                              
                                               echo " \n { xtype: 'datefield',\n fieldLabel: '".$field['fieldLabel']."', \n name: 'data[field][".$field['name']."]', \n id: 'data[field][".$field['name']."]', \n ";
                                                $params=explode(',',$field['params']);
                                                foreach($params as $param){
                                                    echo $param.", \n ";
                                                }
                                                echo "},";
                                                
                                            }
                                            elseif($field['type']=='multiple_datefield'){
                                              echo "{   
													xtype:'fieldset',
													title: '".$field['fieldLabel']."',
													autoHeight: true,
													boxMinHeight: 300,
													items: [{
															layout:'column',
															items:[{
																	columnWidth:.5,
																	layout: 'form',
																	items:[";  
																	   echo " \n { xtype: 'datefield',\n fieldLabel: 'From', \n name: 'data[field][".$field['name']."_from]', \n id: 'data[field][".$field['name']."_from]', \n ";
																		$params=explode(',',$field['params']);
																		foreach($params as $param){
																			echo $param.", \n ";
																		}
																		echo "}";
																		echo "]}, {
																columnWidth:.5,
																layout: 'form',
																items:[ ";
																	echo " \n { xtype: 'datefield',\n fieldLabel: 'To', \n name: 'data[field][".$field['name']."_to]', \n id: 'data[field][".$field['name']."_to]', \n ";
																	$params=explode(',',$field['params']);
																	foreach($params as $param){
																		echo $param.", \n ";
																	}
																	echo "}";
																	echo "]}]}]},";
                                            }
                                            elseif($field['type']=='combo'){
                                                echo " \n {";
                                                if($field['data']==true){
                                                        echo "store: new Ext.data.ArrayStore({
                                                                            id: 0,
                                                                            fields: ['id', 'name' ],
                                                                            data: [";
                                                        foreach($field['store'] as $store){
                                                            echo "['".$store['id']."','".$store['name']."'],";
                                                        }
                                                        echo "  ]}), \n ";
                                                    }
                                                echo "xtype: 'combo',\n fieldLabel: '".$field['fieldLabel']."', \n name: 'data[field][".$field['name']."]', \n id: 'data[field][".$field['name']."]', \n ";
                                                 if($field['data']==true) 
                                                echo "valueField: 'id',displayField: 'name',hiddenName:'data[field][".$field['name']."]', \n";
                                                $params=explode(',',$field['params']);
                                                foreach($params as $param){
                                                    echo $param.", \n ";
                                                }
                                                echo "},";
                                                
                                            }else{
                                                
                                                
                                            }
                                        }
				?>
                        <?php
                                
                                $this->ExtForm->input('title');
                            ?>,
                         <?php
                                if($report['Report']['output']=='Table'){
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Output', 'value' => 'HTML');
                                $options['items'] = array('HTML' => 'HTML', 'Exel'=>'Exel','PDF'=>'PDF');
                                $this->ExtForm->input('output', $options);
                                echo ',';
                                }
                            ?>
                            <?php $this->ExtForm->input('rows',array('hidden' => ' ')); ?>,
                             <?php $this->ExtForm->input('id',array('hidden' => $id)); ?>,
                        ]
		});
		function moveup(id){
                alert(Ext.StoreMgr.lookup("MyStore").getAt(index));
                }
                <?php   echo "store_rows= new Ext.data.ArrayStore({
                                                            id: 0,
                                                            fields: [{name:'id',type:'int'},{name:'order',type:'int'}, 'name',{name: 'checked', type: 'bool'} ],
                                                            data: [";
                                        foreach($rows as $row){
                                            echo "['".$row['id']."','".($row['id']+1)."','".$row['name']."','".$row['checked']."'],";
                                        }
                                        echo "  ]}); \n ";
                                 ?>
                var report_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:200,
			plain:true,
			defaults:{autoScroll: true},
			items:[ {
				xtype: 'grid',
				loadMask: true,
                                height: 200,
                                id:'mygrid',
				stripeRows: true,
				store:store_rows,
				title: '<?php __('Fields'); ?>',
                                sm: new Ext.grid.RowSelectionModel({
                                    singleSelect: false
                                }),
				enableColumnMove: true,
				columns: [
					{header: "<?php __('Order'); ?>", dataIndex: 'order', sortable: true},
                                        {header: "<?php __('Field'); ?>", dataIndex: 'name', sortable: true},
                                        {xtype: 'checkcolumn',header: 'Included?',dataIndex: 'checked',width: 55}
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.Toolbar({
			
                                items: [{
					xtype: 'tbbutton',
					text: '<?php __('Move Up'); ?>',
					tooltip:'<?php __('<b>UP</b>'); ?>',
                                        id:'move-up',
                                        disabled: true,
					handler: function(btn) {
                                            var sm = ReportViewWindow.findById('mygrid').getSelectionModel();
                                            var sel = sm.getSelected();
                                            if (sm.hasSelection()){
                                            var idx=sel.data.id;
                                            var orderx=sel.data.order;
                                            //alert(idx);
                                            if(orderx>1){
                                            var record = store_rows.getAt(idx);
                                            record.beginEdit();
                                            record.set('order',-1);
                                            record.endEdit();
                                            record.commit();
                                            
                                            idx2=store_rows.find('order',(orderx - 1));
                                            //alert(idx2);
                                            var record2 = store_rows.getAt(idx2);
                                            record2.beginEdit();
                                            record2.set('order',orderx);
                                            record2.endEdit();
                                            record2.commit();
                                            
                                            idx3=store_rows.find('order',-1);
                                            //alert(idx3);
                                            var record3 = store_rows.getAt(idx3);
                                            record3.beginEdit();
                                            record3.set('order',(orderx - 1));
                                            record3.endEdit();
                                            record3.commit();
                                            
                                            store_rows.commitChanges();
                                            }
                                             
                                            };
                                        }
                                        },{
					xtype: 'tbbutton',
					text: '<?php __('Move Down'); ?>',
					tooltip:'<?php __('<b>Down</b>'); ?>',
                                        id:'move-down',
                                        disabled: true,
					 handler: function(btn) {
                                            var sm = ReportViewWindow.findById('mygrid').getSelectionModel();
                                            var sel = sm.getSelected();
                                            if (sm.hasSelection()){
                                            var idx=sel.data.id;
                                            var orderx=sel.data.order;
                                            //alert(idx);
                                            if(orderx<store_rows.data.length){
                                            var record = store_rows.getAt(idx);
                                            record.beginEdit();
                                            record.set('order',-1);
                                            record.endEdit();
                                            record.commit();
                                            
                                            idx2=store_rows.find('order',(orderx + 1));
                                            //alert(idx2);
                                            var record2 = store_rows.getAt(idx2);
                                            record2.beginEdit();
                                            record2.set('order',orderx);
                                            record2.endEdit();
                                            record2.commit();
                                            
                                            idx3=store_rows.find('order',-1);
                                            //alert(idx3);
                                            var record3 = store_rows.getAt(idx3);
                                            record3.beginEdit();
                                            record3.set('order',(orderx + 1));
                                            record3.endEdit();
                                            record3.commit();
                                            
                                            store_rows.commitChanges();
                                            }
                                             
                                            };
                                        }
                                        }]
                                        })
			}]
                        });
		var ReportViewWindow = new Ext.Window({
			title: '<?php __('View Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'pViewing:5px;',
			buttonAlign:'right',
			items: [ ReportViewForm<?php if($report['Report']['output']=='Table') echo ',report_view_panel_2 '; ?>],
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ReportViewForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportViewWindow.collapsed)
						ReportViewWindow.expand(true);
					else
						ReportViewWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Display'); ?>',
				handler: function(btn){
                                var string='';
                                for(var i = 0; i < store_rows.data.length; i++) {
                                var record3 = store_rows.getAt(i);
                                string=string + '|' + record3.get('id') + ',' + record3.get('order') + ',' + record3.get('name') + ',' + record3.get('checked');
                                }
                                 ReportViewForm.getForm().findField('data[Report][rows]').setValue(string);
                                    var form = ReportViewForm.getForm(); // or inputForm.getForm();
     var el = form.getEl().dom;
     var target = document.createAttribute("target");
     target.nodeValue = "_blank";
     el.setAttributeNode(target);
     el.action = form.url;
     el.submit();
					//ReportViewForm.getForm().submit({  target:'_blank'});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ReportViewWindow.close();
				}
			}]
		});
                <?php if($report['Report']['output']=='Table'): ?>
        var p=ReportViewWindow.findById('mygrid');
        
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getBottomToolbar().findById('move-up').enable();
		p.getBottomToolbar().findById('move-down').enable();
		if(this.getSelections().length > 1){
			p.getBottomToolbar().findById('move-up').disable();
                        p.getBottomToolbar().findById('move-down').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getBottomToolbar().findById('move-up').disable();
                        p.getBottomToolbar().findById('move-down').disable();
		}
		else if(this.getSelections().length == 1){
			p.getBottomToolbar().findById('move-up').enable();
                        p.getBottomToolbar().findById('move-down').enable();
		}
		else{
			p.getBottomToolbar().findById('move-up').disable();
                        p.getBottomToolbar().findById('move-down').disable();
		}
	});
        <?php endif; ?>
