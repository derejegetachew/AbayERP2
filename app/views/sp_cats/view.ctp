
		
<?php $spCat_html = "<table cellspacing=3>" . 
Warning: Invalid argument supplied for foreach() in C:\wamp\www\AbayERP\cake\console\templates\default\views\view.ctp on line 43

Call Stack:
    0.0030     542872   1. {main}() C:\wamp\www\AbayERP\cake\console\cake.php:0
    0.0032     543656   2. ShellDispatcher->ShellDispatcher() C:\wamp\www\AbayERP\cake\console\cake.php:660
    5.3635    2738680   3. ShellDispatcher->dispatch() C:\wamp\www\AbayERP\cake\console\cake.php:139
   15.6032    5378032   4. BakeShell->all() C:\wamp\www\AbayERP\cake\console\cake.php:373
  378.6831    9343712   5. ViewTask->execute() C:\wamp\www\AbayERP\cake\console\libs\bake.php:188
  379.2760   10488896   6. ViewTask->getContent() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:137
  379.2762   10488944   7. TemplateTask->generate() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:392
  379.2908   10589832   8. include('C:\wamp\www\AbayERP\cake\console\templates\default\views\view.ctp') C:\wamp\www\AbayERP\cake\console\libs\tasks\template.php:146

"</table>"; 
?>
		var spCat_view_panel_1 = {
			html : '<?php echo $spCat_html; ?>',
			frame : true,
			height: 80
		}
		var spCat_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var SpCatViewWindow = new Ext.Window({
			title: '<?php __('View SpCat'); ?>: <?php echo $spCat['SpCat']['name']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				spCat_view_panel_1,
				spCat_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpCatViewWindow.close();
				}
			}]
		});
