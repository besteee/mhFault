<?php if ($this->_var['full_page']): ?>
<!-- $Id: users_list.htm 17053 2010-03-15 06:50:26Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div class="form-div">
  <form action="javascript:searchUser()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    &nbsp;<?php echo $this->_var['lang']['label_rank_name']; ?> <select name="user_rank"><option value="0"><?php echo $this->_var['lang']['all_option']; ?></option><?php echo $this->html_options(array('options'=>$this->_var['user_ranks'])); ?></select>
    &nbsp;<?php echo $this->_var['lang']['label_pay_points_gt']; ?>&nbsp;<input type="text" name="pay_points_gt" size="8" />&nbsp;<?php echo $this->_var['lang']['label_pay_points_lt']; ?>&nbsp;<input type="text" name="pay_points_lt" size="10" />
    &nbsp;<?php echo $this->_var['lang']['label_user_name']; ?> &nbsp;<input type="text" name="keyword" /> <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" />
  </form>
</div>

<form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">

<!-- start users list -->
<div class="list-div" id="listDiv">
<?php endif; ?>
<!--用户列表部分-->
<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
      <a href="javascript:listTable.sort('user_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_user_id']; ?>
    </th>
    <th><a href="javascript:listTable.sort('user_name'); "><?php echo $this->_var['lang']['username']; ?></a><?php echo $this->_var['sort_user_name']; ?></th>
    <th><a href="javascript:listTable.sort('email'); "><?php echo $this->_var['lang']['email']; ?></a><?php echo $this->_var['sort_email']; ?></th>
    <th><a href="javascript:listTable.sort('is_validated'); "><?php echo $this->_var['lang']['is_validated']; ?></a><?php echo $this->_var['sort_is_validate']; ?></th>
    <th><?php echo $this->_var['lang']['user_money']; ?></th>
    <th><?php echo $this->_var['lang']['frozen_money']; ?></th>
    <th><?php echo $this->_var['lang']['rank_points']; ?></th>
    <th><?php echo $this->_var['lang']['pay_points']; ?></th>
    <th><a href="javascript:listTable.sort('reg_time'); "><?php echo $this->_var['lang']['reg_date']; ?></a><?php echo $this->_var['sort_reg_time']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['user_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
  <tr>
    <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['user']['user_id']; ?>" notice="<?php if ($this->_var['user']['user_money'] != 0): ?>1<?php else: ?>0<?php endif; ?>"/><?php echo $this->_var['user']['user_id']; ?></td>
    <td class="first-cell"><?php echo htmlspecialchars($this->_var['user']['user_name']); ?></td>
    <td><span onclick="listTable.edit(this, 'edit_email', <?php echo $this->_var['user']['user_id']; ?>)"><?php echo $this->_var['user']['email']; ?></span></td>
    <td align="center"><?php if ($this->_var['user']['is_validated']): ?> <img src="images/yes.gif"> <?php else: ?> <img src="images/no.gif"> <?php endif; ?></td>
    <td><?php echo $this->_var['user']['user_money']; ?></td>
    <td><?php echo $this->_var['user']['frozen_money']; ?></td>
    <td><?php echo $this->_var['user']['rank_points']; ?></td>
    <td><?php echo $this->_var['user']['pay_points']; ?></td>
    <td align="center"><?php echo $this->_var['user']['reg_time']; ?></td>
    <td align="center">
      <a href="users.php?act=edit&id=<?php echo $this->_var['user']['user_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>
      <a href="users.php?act=address_list&id=<?php echo $this->_var['user']['user_id']; ?>" title="<?php echo $this->_var['lang']['address_list']; ?>"><img src="images/book_open.gif" border="0" height="16" width="16" /></a>
      <a href="order.php?act=list&user_id=<?php echo $this->_var['user']['user_id']; ?>" title="<?php echo $this->_var['lang']['view_order']; ?>"><img src="images/icon_view.gif" border="0" height="16" width="16" /></a>
      <a href="account_log.php?act=list&user_id=<?php echo $this->_var['user']['user_id']; ?>" title="<?php echo $this->_var['lang']['view_deposit']; ?>"><img src="images/icon_account.gif" border="0" height="16" width="16" /></a>
      <a href="javascript:confirm_redirect('<?php if ($this->_var['user']['user_money'] != 0): ?><?php echo $this->_var['lang']['still_accounts']; ?><?php endif; ?><?php echo $this->_var['lang']['remove_confirm']; ?>', 'users.php?act=remove&id=<?php echo $this->_var['user']['user_id']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>
    </td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
      <td colspan="2">
      <input type="hidden" name="act" value="batch_remove" />
      <input type="submit" id="btnSubmit" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" class="button" /></td>
      <td align="right" nowrap="true" colspan="8">
      <?php echo $this->fetch('page.htm'); ?>
      </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end users list -->
</form>
<script type="text/javascript" language="JavaScript">
<!--
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


onload = function()
{
    document.forms['searchForm'].elements['keyword'].focus();
    // 开始检查订单
    startCheckOrder();
}

/**
 * 搜索用户
 */
function searchUser()
{
    listTable.filter['keywords'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['rank'] = document.forms['searchForm'].elements['user_rank'].value;
    listTable.filter['pay_points_gt'] = Utils.trim(document.forms['searchForm'].elements['pay_points_gt'].value);
    listTable.filter['pay_points_lt'] = Utils.trim(document.forms['searchForm'].elements['pay_points_lt'].value);
    listTable.filter['page'] = 1;
    listTable.loadList();
}

function confirm_bath()
{
  userItems = document.getElementsByName('checkboxes[]');

  cfm = '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';

  for (i=0; userItems[i]; i++)
  {
    if (userItems[i].checked && userItems[i].notice == 1)
    {
      cfm = '<?php echo $this->_var['lang']['list_still_accounts']; ?>' + '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';
      break;
    }
  }

  return confirm(cfm);
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>