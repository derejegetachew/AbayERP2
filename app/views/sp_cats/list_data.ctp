{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($sp_cats as $sp_cat){ if($st) echo ","; ?>			{

Warning: Invalid argument supplied for foreach() in C:\wamp\www\AbayERP\cake\console\templates\default\views\list_data.ctp on line 13

Call Stack:
    0.0030     542872   1. {main}() C:\wamp\www\AbayERP\cake\console\cake.php:0
    0.0032     543656   2. ShellDispatcher->ShellDispatcher() C:\wamp\www\AbayERP\cake\console\cake.php:660
    5.3635    2738680   3. ShellDispatcher->dispatch() C:\wamp\www\AbayERP\cake\console\cake.php:139
   15.6032    5378032   4. BakeShell->all() C:\wamp\www\AbayERP\cake\console\cake.php:373
  378.6831    9343712   5. ViewTask->execute() C:\wamp\www\AbayERP\cake\console\libs\bake.php:188
  379.1661   10494960   6. ViewTask->getContent() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:137
  379.1662   10495008   7. TemplateTask->generate() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:392
  379.2252   10554792   8. include('C:\wamp\www\AbayERP\cake\console\templates\default\views\list_data.ctp') C:\wamp\www\AbayERP\cake\console\libs\tasks\template.php:146

			}
<?php $st = true; } ?>		]
}