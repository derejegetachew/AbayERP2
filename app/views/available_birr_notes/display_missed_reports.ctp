
		
<?php  $missedReport_html ='Starting from 2020-10-12, system shows the following missed daily birr note report  '. implode(' , ', $missedReportDays) . 

"</table>"; 
?>
		var availableBirrNote_view_panel_1 = {
			html : '<?php echo $missedReport_html; ?>',
			frame : true,
			height: 130
		}
	

		var AvailableBirrNoteViewWindow = new Ext.Window({
			title: '<?php __('Checking for Missed Reports'); ?>: <?php ?>',
			width: 500,
			height:205,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				availableBirrNote_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					AvailableBirrNoteViewWindow.close();
				}
			}]
		});
