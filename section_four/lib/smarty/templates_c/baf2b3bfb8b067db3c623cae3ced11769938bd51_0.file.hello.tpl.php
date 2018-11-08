<?php
/* Smarty version 3.1.33, created on 2018-10-25 14:34:15
  from '/Applications/XAMPP/xamppfiles/htdocs/pl_crashcourse/section_four/views/hello.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bd1b847cba635_99446136',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'baf2b3bfb8b067db3c623cae3ced11769938bd51' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/pl_crashcourse/section_four/views/hello.tpl',
      1 => 1540470855,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bd1b847cba635_99446136 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/pl_crashcourse/section_four/lib/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<html>
    <head>
         <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
         <title>Home</title>
    </head>

    <body>
         <p>Hello <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['user']->value, 'UTF-8');?>
!</p><p>Today is <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['date']->value,"%a the %d of %B %G");?>
</p>
    </body>

</html><?php }
}
