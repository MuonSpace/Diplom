$(document).ready(function () {
	var php_table = '/php/table.php';
	var php_table_edit = '/update.php?type=1';
	
	var img = '/data/';
	//selector: '#Tms',
	
	
	
	//ajax на получение значений для selector name="Position"
	$.ajax({
		url: "php/query.php? echo ($sqlPositions)"
	});
	
	$('input[name=Type]').on('click', function () {
		var obj = $('input[name=Type]:checked');
		if (obj[0].id === 'Type-1') {
			
			$('#tabs-1').html('<label id="Pic2" for="Pic">Выберете файл</label>'
			+ '<input type="file" name="Pic" id="Pic" value=" ">'); 
			
			
			} else if(obj[0].id === 'Type-2') {
			
			
			$('#tabs-1').html('<textarea id="Content"> </textarea>');
			
			tinymce.init({
				selector: "#Content",
				height: 500,
				plugins: [
					"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
				],
				
				toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
				toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
				toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print  | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
				
				
				menubar: false,
				toolbar_items_size: 'small',
				
			});
			} else{
			//тут добавление погоды
		}
	})
	
	$("#Begin, #End").datepicker({
		dateFormat: 'dd.mm.yy',
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
			'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
		'Октябрь', 'Ноябрь', 'Декабрь'],
		dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
		firstDay: 1,
	})
	
	var dialog = $("#dialog-form").dialog({
		autoOpen: false,
		height: 700,
		width: 900,
		modal: true,
		buttons: {
			"Сохранить": function () {
				var id = $("#Id").val();
				var Position = $("#Position").val();
				var Disable = $("#Disable").val();
				var Name = $("#Name").val();
				var Replay = $("#Replay").val();
				var Begin = $("#Begin").val();
				var End = $("#End").val();
				var Delay = $("#Delay").val();
				var Content;
				//type 
				var obj = $('input[name=Type]:checked');
				var Type;
				if (obj[0].id === 'Type-1') {
					Type = 'pic';
					//////////// Для отправки файла ////////////////////
					/**/var Content = new FormData;                 /**/
					/**/var file_data = $('#Pic').prop('files')[0]; /**/
					/**/Content.append('file', file_data);          /**/
					////////////////////////////////////////////////////
					$.ajax({
						url: "php/Record.php?Add&id=" + id + "&Position=" + Position + "&Disable=" + Disable + "&Name=" + Name + "&Replay=" + Replay + "&Type=" + Type + "&Begin=" + Begin + "&End=" + End + "&Delay=" + Delay,
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: Content,
						type: "POST",
						success: function (data) {
							$("#editgrid").trigger("reloadGrid");
							dialog.dialog("close");
						}
					});
					
					} else if (obj[0].id === 'Type-2') {  //добавить условие для weather
					Type = 'html';
					Content = tinymce.activeEditor.getContent();
					$.ajax({
						url: "php/Record.php?Add&id=" + id + "&Position=" + Position + "&Disable=" + Disable + "&Name=" + Name + "&Replay=" + Replay + "&Type=" + Type + "&Begin=" + Begin + "&End=" + End + "&Delay=" + Delay,
						async: true,
						processData: false,
						contentType: false,
						//dataType: "html",
						data: { Content: Content },
						type: "POST",
						success: function (data) {
							$("#editgrid").trigger("reloadGrid");
							dialog.dialog("close");
						}
					});
				}else {
					Type = 'weather';
					Content = '';
					$.ajax({
						url: "php/Record.php?Add&id=" + id + "&Position=" + Position + "&Disable=" + Disable + "&Name=" + Name + "&Replay=" + Replay + "&Type=" + Type + "&Begin=" + Begin + "&End=" + End + "&Delay=" + Delay,
						async: true,
						processData: false,
						contentType: false,
						//dataType: "html",
						data: { Content: Content },
						type: "POST",
						success: function (data) {
							$("#editgrid").trigger("reloadGrid");
							dialog.dialog("close");
						}
					});
				}
				
				
			},
			
			Cancel: function () {
				dialog.dialog("close");
			}
		},
	});
	
	
	
	$("#editgrid").jqGrid({
		url: php_table + "",
		editurl: php_table_edit + '',
		datatype: "xml",
		mtype: "POST",
		regional: 'ru',
		height: '80%',
		width: '1200',
		colNames: ["id", "Позиция", "Состояние", 'Название', "Повтор", 'Тип публикации', " Дата начала ", "Дата конца", 'Время показа', 'Контент'],
		colModel: [{ name: "id", width: 55, index: 'id', editable: false, editopions: { readaonly: true, size: 10 } },
			{ name: "Position", index: 'Positions', width: 80, editable: true, editoptions: { size: 10 }, sortable: true },
			{ name: "Disable", index: 'Disable', width: 30, align: "center", editable: true, edittype: "checkbox", editopions: { value: "Вкл:Выкл" },
				formatter: function (cellvalue, options, rowObject) {
					if (cellvalue === '0') {
						return 'Выкл';
						}else if (cellvalue === '1') {
						return 'Вкл';
					} } },
					{ name: "Name", index: 'Name', width: 200, editable: true, editoptions: { size: 10 } },
					{ name: "Replay", index: 'Replay', width: 70, editable: true, edittype: "select", editoptions: { value: "0:Выкл;1:Раз в день;2:Раз в месяц;3:Раз в год" },
						formatter: function (cellvalue, options, rowObject) {
							//var type = rowObject.children[5].textContent;
							if (cellvalue === '1') {
								return 'Раз в день';
								} else if (cellvalue === '2') {
								return 'Раз в месяц';
								}else if (cellvalue === '3') {
								return 'Раз в год';
								} else if (cellvalue === '0') {
								return 'Выкл';
							} }},
							{ name: "Type", index: 'Type', width: 100, editable: true, edittype: "select", editoptions: { value: "Img:Картинка;Text:Текст;Wheater:Погода" } },
							{
								name: "Begin", index: 'Begin', width: 125, editable: true, sortable: "date", formatter: 'date', editoptions: {
									size: 25,
									dataInit: function (element) {
										$(element).datepicker({
											dateFormat: 'dd.mm.yyyy'
										})
									}
								},
								editrules: { date: true }
							},
							{
								name: "End", index: 'End', width: 125, editable: true, sortable: "date", formatter: 'date', editoptions: {
									size: 25,
									dataInit: function (element) {
										$(element).datepicker({
											dateFormat: 'dd.mm.yyyy'
										})
									}
								},
								editrules: { date: true }
							},
							{ name: "Delay", width: 50, align: "center", "search": false, stype: 'text', editable: false },
							{
								name: "Content", index: 'Content', width: 125, editable: true, sortable: false, edittype: "textarea", editoptions: { size: 40 }, 
								formatter: function (cellvalue, options, rowObject) {
									var type = rowObject.children[5].textContent;
									if (type === 'html') {
										return 'html content';
										} else if (type === 'pic') {
										
										if(cellvalue === undefined){
											return '';
											}else{
											return '<img src = "data/' + cellvalue + '" width = "100">';
										}
									}
									else
									{
										return '';
									}
								}
							}
							
		],
		
		pager: '#pagered',
		scrollOffset: 21,
		rowNum: 100,
		rowList: [10, 20, 50],
		sortname: "Position",
		sortorder: "asc",
		viewrecords: true,
		caption: "Таблица контента для монитора при входе",
		
		
	}).jqGrid('navGrid', '#pagered', { edit: false, add: false, del: false ,search: false})
    //кнопка добавления 
    .navButtonAdd('#pagered', {
		caption: "",
		title: "Добавить запись",
		buttonicon: "ui-icon-plusthick",
		onClickButton: function () {
			//1. очистить форму 
			clear_form();
			$.ajax({
				url: "php/query.php",
				success: function (data) {
					var returne = JSON.parse(data);
					$("#Id").val(returne['id']);
					$("#Position").val(returne['Position']);
				}
			});
			$("#dialog-form").dialog("open");
		}
	})
	
    //кнопка редактирования
    .navButtonAdd('#pagered', {
		caption: "",
		title: "Изменить запись",
		buttonicon: "ui-icon-pencil",
		
		onClickButton: function () {
			var myGrid = $('#editgrid'),
			selectedRowId = myGrid.jqGrid('getGridParam', 'selrow');
			$.ajax({
				url: "php/Record.php?select&id=" + selectedRowId,
				success: function (data) {
					$("#editgrid").trigger("reloadGrid");
					$("#dialog-form").dialog("open");
					
					//распарсить json
					
					var returne = JSON.parse(data);
					//console.log(returne);
					$("#Id").val(returne[0]['id']);
					$("#Position").val(returne[0]['Position']);
					$("#Disable").val(returne[0]['Disable']);
					$("#Name").val(returne[0]['Name']);
					$("#Replay").val(returne[0]['Replay']);
					
					var Begin = returne[0]['Begin'].slice(0, 10);
					Begin.replace(new RegExp("-",'g'),",");
					Begin = new Date(Begin);
					Begin = formatDate(Begin);
					$("#Begin").val(Begin);
					
					if(returne[0]['End']==null){
						$("#End").val('');
						}else{
						var End = returne[0]['End'].slice(0, 10);
						End.replace(new RegExp("-",'g'),",");
						End = new Date(End);
						End = formatDate(End);
						$("#End").val(End);
					}
					$("#Delay").val(returne[0]['Delay']);
					//выставление радио кнопки в соответствие с типом
					$("#Type").val(returne[0]['Type']);
					if(returne[0]['Type'] === 'pic'){
						document.getElementById('Type-1').checked = true;
						//$("#Pic").val(returne[0]['Content']); ретурнить путь к картинке и записывать в ссылку ниже
						//код на вставку html элемента с картинкой и крестиком на ней
						var Content = returne[0]['Content'];
						console.log(Content);
						if(Content == ""){
							$('#tabs-1').html('<label id="Pic2" for="Pic">Выберете файл</label>'
							+ '<input type="file" name="Pic" id="Pic" value=" ">');  
							}else{
							$('#tabs-1').html('<div style="position: relative; left: 0; top: 0;">' //нужен путь к картинке
								+'<img src="data/'+returne[0]['Content']+'" style="position: relative; top: 0; left: 0;" width="200" height="200"/>'
								+'<img src="cl.jpg" id="close" style="position: absolute; margin-top: 0px; margin-right: 0px;cursor:pointer;" width="20" height="20"/>'
							+'</div>');
							//функция на удаление картинки
							$('#close').on('click', function () {
								delpic(returne[0]['id']);
								
							});
						}
						
						}else if(returne[0]['Type'] === 'html'){
						document.getElementById('Type-2').checked = true;
						$('#tabs-1').html('<textarea id="Content"> </textarea>');
						
						tinymce.init({
							selector: "#Content",
							height: 500,
							plugins: [
								"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
								"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
								"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
							],
							
							toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
							toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
							toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print  | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
							
							
							menubar: false,
							toolbar_items_size: 'small',
							
						});
						
						
						//если в Content ""  и Type = pic то вставляем кнопку выбора файла
						
						$("#Content").val(Content);
						
					}
					else if(returne[0]['Type'] === 'weather'){
						document.getElementById('Type-3').checked = true;
						//$("#Content").val(returne[0]['Content']); че то ретурнится сюды
					}
					//  $("#Content").val(returne[0]['Content']);
					
					
					
				}});
		}
		
		//$('#Type').disable();
		
		
		
	})
	
	//кнопка удаления
	.navButtonAdd('#pagered', {
		caption: "",
		title: "Удалить запись",
		buttonicon: "ui-icon-trash",
		onClickButton: function () {
			var myGrid = $('#editgrid'),
			selectedRowId = myGrid.jqGrid('getGridParam', 'selrow');
			$.ajax({
				url: "php/Record.php?Del&id=" + selectedRowId,
				success: function (data) {
					$("#editgrid").trigger("reloadGrid");
					alert("Запись удалена");
				},
				//position: "first"
			});
		}
	});
	
	
	function clear_form() {
		$("#Id").val('');
		$("#Position").val('');
		$("#Disable").val('');
		$("#Name").val('');
		$("#Replay").val('');
		$("#Begin").val('');
		$("#End").val('');
		$("#Delay").val('');
		$("#Content").val('');
		$('input[name=Type]:checked').prop("checked", false);
		
	};
	function up(id) {
		$.ajax({
			url: "php/Position.php?id=" + id + "&up",
			success: function (data) {
				$("#editgrid").trigger("reloadGrid");
			}
		});
	};
	
	function down(id) {
		$.ajax({
			url: "php/Position.php?id=" + id + "&down",
			success: function (data) {
				$("#editgrid").trigger("reloadGrid");
			}
		});
	};
	
	//Удаление пикчи
	function delpic(id){
		$.ajax({
			url: "php/Record.php?id=" + id + "&delpic",
			success: function (data) {
				var err = JSON.parse(data); 
				if(err['Error'] == '2')
				{
					alert('Изображение не удаленно');
					
				}else if(err['Error'] == '3')
				{
					alert('Это не картинка');
					
				}else if(err['Error'] == '1')
				{
					alert('Картинка удалена');
					$('#tabs-1').html('<label id="Pic2" for="Pic">Выберете файл</label>'
					+ '<input type="file" name="Pic" id="Pic" value=" ">');
					$("#editgrid").trigger("reloadGrid");
				}
			}
		});
	};
	
	//функция форматирования даты
	function formatDate(date) {
		
		var dd = date.getDate();
		if (dd < 10) dd = '0' + dd;
		
		var mm = date.getMonth() + 1;
		if (mm < 10) mm = '0' + mm;
		
		var yy = date.getFullYear() % 100;
		if (yy < 10) yy = '0' + yy;
		
		return dd + '.' + mm + '.' + yy;
	}
	
})



//Всякий хлам
/*
	//jQuery("#editgrid").jqGrid('navGrid',"#pagered",{edit:true,add:true,del:true,editSettings,addSettings,delSettings});
	// jQuery("#editgrid").jqGrid('inlineNav',"#pagered");
	$("#editNote").click(function(){
	var gr = jQuery("#editgrid").jqGrid('getGridParam','selrow');
	if( gr != null ) {jQuery("#editgrid").jqGrid('editGridRow',gr,{height:340,reloadAfterSubmit:false});}
	else {alert("Please Select Row");}
	});
	
	$("#addNote").click(function(){
	jQuery("#editgrid").jqGrid('editGridRow',"new",{height:340,reloadAfterSubmit:false});
	});
	
	$("#delNote").click(function(){
	var gr = jQuery("#editgrid").jqGrid('getGridParam','selrow');
	if( gr != null ) jQuery("#editgrid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
	else alert("Please Select Row to delete!");
	});
	
	,error: function (error) {
	alert('Картинка удалена');
	$('#tabs-1').html('<label id="Pic2" for="Pic">Выберете файл</label>'
	+ '<input type="file" name="Pic" id="Pic" value=" ">');
    }
	
	
	var editSettings = {
	//recreateForm: true,
	jqModal: false,
	reloadAfterSubmit: false,
	closeOnEscape: true,
	savekey: [true, 13],
	closeAfterEdit: true,
	onclickSubmit: editNote
    };
	
    var addSettings = {
	//recreateForm: true,
	jqModal: false,
	reloadAfterSubmit: false,
	savekey: [true, 13],
	closeOnEscape: true,
	closeAfterAdd: true,
	onclickSubmit: addNote
    };
	
var delSettings = { onclickSubmit: delNote };*/
