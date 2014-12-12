<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<div id="ECS_COMMENTZX"> <?php 
$k = array (
  'name' => 'zxcomments',
  'type' => $this->_var['type'],
  'id' => $this->_var['id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
