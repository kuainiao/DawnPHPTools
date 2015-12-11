<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

//获取数据
$sql='select id,name,u_rank from category where u_id='.$uid . ' order by u_rank';
$rows=mysql_query($sql,$GLOBALS['DB']);
?>

<html>
<head>
<title>编辑分类</title>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
</head>
<body>

<div class=header>
<h1>管理&gt;编辑目录信息</h1>
<pre>
	可以增添、删除、修改目录名称。可以修改目录的显示顺序。	
</pre>
<div class='category'>
<a href='index.php'><input type='button' class='btn' value='&lt;&lt;返回首页' /></a>
<input type='button' id='add' class='btn blue' value='添加分类' />

<form method='post' action='doEditCate.php?a=send'>
<table>
	<tr>
		<th>目录名称</th>
		<th>显示顺序</th>
		<th>操作</th>
	</tr>
<?php 
	$i=1;
	while($row=mysql_fetch_assoc($rows)){
		$i++;
?>
	<tr class=<?php echo ($i%2==0)?'even':'odd'; ?>>
		<input type='hidden' name='id[]' value="<?php echo $row['id']?>" />
		<td><input type='text' name='name[]' value="<?php echo $row['name']?>" /></td>	
		<td><input type='text' name='u_rank[]' value="<?php echo $row['u_rank']?>" /> </td>
		<td><input type='button' class='btn' onclick='javascript:deleteCate(<?php echo $row['id'];?>);'value='删除' /></td>
	</tr>
<?php }?>
	
</table>
	<input type='hidden' id='isModify' value=0 />
	
	<a href='index.php'><input type='button' class='btn' value='&lt;&lt;返回首页(放弃修改)' /></a>
	<input id='send' type='button' class='btn blue' value="提交修改" />   
</form>
</div>

<script>
var u_id=<?php echo (new Dawn())->sessionGet('uid');?>;
var cate_id=-1;

window.onload=function(){
	//添加新分类
	$('add').onclick=function(){
		var new_cate=prompt('请输入新分类名字：');
		if(trim(new_cate)==''){return;}
		var ajax=new Ajax();
		ajax.get('doEditCate.php?a=add&name='+new_cate,function(s){
			//console.log(s);
			if(s)window.location.reload();
		})
	};
	
	//按钮会解锁提交按钮
	 aInput=document.getElementsByTagName('input');
	for(var i=0;i<aInput.length;i++){
		oInput=aInput[i];
		oInput.onchange=function(){
			$('isModify').value=1;
		}
	}
	

	
	//提交按钮
	$('send').onclick=function(){
		if($('isModify').value<1){
			alert('没有检测到修改，请修改后再提交。');
		}else{
			//添加提交
			document.forms[0].submit();
		}
	}
}


	//删除按钮
	function deleteCate(cate_id){
		//询问确认
		var conf=confirm('你确定要删除该条目吗？');
		if(!conf){return;}
		var url='doEditCate.php?a=del&cate_id='+cate_id;
		//执行删除
		var ajax2=new Ajax();
		ajax2.get(url,function(s){
			if(s)window.location.reload();
		});

		return false;
	}
</script>

</div>
</body>
<html>