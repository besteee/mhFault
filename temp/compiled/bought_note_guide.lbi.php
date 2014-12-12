<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<div id="ECS_BOUGHT"><?php 
$k = array (
  'name' => 'bought_notes',
  'id' => $this->_var['id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>