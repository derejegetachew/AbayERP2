<?php header('HTTP/1.0 500 Internal Server Error'); ?>
{
	"success": false,
	"errormsg": '<?php echo $this->Session->flash(); ?>'
}