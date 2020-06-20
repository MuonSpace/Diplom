<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?> 

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>1</title>
<script src="/js/JQ/external/jquery/jquery.js" 			type="text/javascript"></script>
<script src="/js/JQ/jquery-ui.js" 						type="text/javascript"></script>
<link  	href="/js/JQ/jquery-ui.css" 						rel="stylesheet" type="text/css"   /> 
<link  	href="/js/JQ/jquery-ui.structure.css" 			rel="stylesheet" type="text/css"   /> 
<link  	href="/js/JQ/jquery-ui.theme.css" 				rel="stylesheet" type="text/css"   /> 
<!--jqGrid-->
<script src="/js/jqGrid/src/jquery.jqGrid.js" 			type="text/javascript"></script>
<link   href="/js/jqGrid/css/ui.jqgrid.css" 				rel="stylesheet" type="text/css"/>
<script src="/js/jqGrid/js/i18n/grid.locale-ru.js" 		type="text/javascript"></script> 
<script src="/js/jqGrid/plugins/grid.addons.js" 			type="text/javascript"></script>
<script src="/js/jqGrid/plugins/grid.postext.js" 		type="text/javascript"></script>
<script src="/js/jqGrid/plugins/grid.setcolumns.js" 		type="text/javascript"></script>
<script src="/js/jqGrid/plugins/jquery.contextmenu.js" 	type="text/javascript"></script>
<script src="/js/jqGrid/plugins/jquery.searchFilter.js" 	type="text/javascript"></script>
<script src="/js/jqGrid/plugins/jquery.tablednd.js" 		type="text/javascript"></script>
<link  	href="/js/jqGrid/plugins/searchFilter.css" 		rel="stylesheet" type="text/css"   /> 
<link  	href="/js/jqGrid/plugins/ui.multiselect.css" 	rel="stylesheet" type="text/css"   /> 
<script src="/js/jqGrid/plugins/ui.multiselect.js" 		type="text/javascript"></script>
<!-- style-->
<style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
<!--tinymce-->
<script src="/js/tinymce/tinymce.min.js" 		type="text/javascript"></script>
<script src="/js/tinymce/langs/ru.js" 		type="text/javascript"></script>

<!--MY-->

<script src="/js/core.js" 								type="text/javascript"></script>


<!--/head>
<body>

 <textarea id="Tms">
 </textarea-->
 <!--
<div class="widget">
  <h2> </h2>
  <fieldset>
    <legend> </legend>
    <label for="radio-1">Все</label>
    <input type="radio" name="radio-1" id="radio-1">
    <label for="radio-2">Только опубликованные</label>
    <input type="radio" name="radio-1" id="radio-2">
  </fieldset>
</div>
-->

<table width="80%" id="editgrid"></table>
<div id="pagered"></div>


<!--
<input type="BUTTON" id="addNote" value="Добавить запись" />
<input type="BUTTON" id="editNote" value="Изменить запись" />
<input type="BUTTON" id="delNote" value="Удалить запись" /> 
-->



<div id="dialog-form" title="Create new user">
  <p class="validateTips">All form fields are required.</p>
 
  <form>
    <fieldset>
     
      <input type="hidden" name="Id" id="Id" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Position">Position</label>
      <input type="text" name="Position" id="Position" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Disable">Disable</label>
      <input type="text" name="Disable" id="Disable" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Replay">Replay</label>
      <input type="text" name="Replay" id="Replay" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Type">Type</label>
      <input type="text" name="Type" id="Type" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Begin">Begin</label>
      <input type="text" name="Begin" id="Begin" value=" " class="text ui-widget-content ui-corner-all">

      <label for="End">End</label>
      <input type="text" name="End" id="End" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Delay">Delay!</label>
      <input type="text" name="Delay" id="Delay" value=" " class="text ui-widget-content ui-corner-all">

      <label for="Content">Content</label>
      <input type="file" name="Content" id="Content" value=" " class="text ui-widget-content ui-corner-all">

 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
 
<!-- 
<div id="users-contain" class="ui-widget">
  <h1>Existing Users:</h1>
  <table id="users" class="ui-widget ui-widget-content">
    <thead>
      <tr class="ui-widget-header ">
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John Doe</td>
        <td>john.doe@example.com</td>
        <td>johndoe1</td>
      </tr>
    </tbody>
  </table>
</div>
<button id="create-user">Create new user</button>
 -->


</body>
</html>