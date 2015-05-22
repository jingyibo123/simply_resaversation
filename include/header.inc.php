<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8' />
		<?php if(isset($sScript)){echo $sScript;} ?>
<style>
	div#menu{
		text-align:center;
		width: 100%;
	}
	div#menu ul
	{
		list-style:none; /* 去掉ul前面的符号 */
		margin: 0px; /* 与外界元素的距离为0 */
		padding: 0px; /* 与内部元素的距离为0 */
		width: auto; 
	}
	div#menu ul li
	{
		float:left;
	}
/* 所有id为menu的div中的ul中的a样式(包括尚未点击的和点击过的样式) */
	div#menu ul li a, div#menu ul li a:visited
	{
		background-color: #465c71; /* 背景色 */
		border: 1px #4e667d solid; /* 边框 */
		color: #dde4ec; /* 文字颜色 */
		display: block; /* 此元素将显示为块级元素，此元素前后会带有换行符 */
		line-height: 1.35em; /* 行高 */
		padding: 4px 20px; /* 内部填充的距离 */
		text-decoration: none; /* 不显示超链接下划线 */
		white-space: nowrap; /* 对于文本内的空白处，不会换行，文本会在在同一行上继续，直到遇到 <br> 标签为止。 */
	}
	div#menu ul li a:hover
	{
		background-color: #bfcbd6; /* 背景色 */
		color: #465c71; /* 文字颜色 */
		text-decoration: none; 
	}
	div#menu ul li a:active
	{
		background-color: #465c71; /* 背景色 */
		color: #cfdbe6; /* 文字颜色 */
		text-decoration: none; /* 不显示超链接下划线 */
	}
	
	
	#container{  
        position: relative;   /*重要！保证footer是相对于wapper位置绝对*/  
        height: auto;          /* 保证页面能撑开浏览器高度时显示正常*/  
        min-height: 100%  /* IE6不支持，IE6要单独配置*/  
    } 
    
    #main-content{  
       padding-bottom: 60px; /*重要！给footer预留的空间*/  
    } 
	
	div#footer{ 
		position: absolute;  bottom: 0; /* 关键 */  
		left:0; /* IE下一定要记得 */  
		height: 40px;         /* footer的高度一定要是固定值*/  
		text-align:center;
		width: 100%;
    }  
	div#footer ul
	{
		list-style:none; /* 去掉ul前面的符号 */
		margin: 0px; /* 与外界元素的距离为0 */
		padding: 0px 0px; /* 与内部元素的距离为0 */
		width: auto; 
	}
	div#footer li  
	{
		display: inline-block;
		padding: 0px 10px; /* 内部填充的距离 */
	}
</style>
	</head>
	<body>
	<div id="container">
		<header>
			<h1>SimplyCE Système de Reservation</h1>
		</header>
		<div id="main-content">