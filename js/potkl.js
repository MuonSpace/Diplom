var php_table = '/php/reks.php';
var php_table_edit = '/update.php?type=1';
var php_tablelist = '/php/list.php';

function OpenAdding_People() {
    $("#Adding_People").dialog("open");
}
$('#Open_People').on("click",function () {
    $("#Adding_People").dialog("open");
})


$(document).ready(function () {

	var dialog = $("#Adding_People").dialog({
        autoOpen: false,
        height: 700,
        width: 900,
        modal: true,
        buttons: {
            /*"Сохранить": function () {
                var user_login = $("#user_login").val();
                var user_password = $("#user_password").val();
                $.ajax({
                    url: "php/my.php?Add&user_id=" + user_id + "$user_login=" + user_login + "$user_password" + user_password,
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: Content,
                    type: "POST",
                    success: function (data) {
                        $("#tableusers").trigger("reloadGrid");
                        dialog.dialog("close");
                    }
                })
            },*/
           /* "Назад": function () {
                dialog.dialog("close");
		   },*/
        }
    });
	
	var dialog = $("#dialog-user").dialog({
	autoOpen: false,
        height: 700,
        width: 900,
        modal: true,
        buttons: {
            "Сохранить": function () {
                var user_login = $("#user_login").val();
                var user_password = $("#user_password").val();
                $.ajax({
                    url: "php/my.php?Add&user_id=" + user_id + "$user_login=" + user_login + "$user_password" + user_password,
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: Content,
                    type: "POST",
                    success: function (data) {
                        $("#tableusers").trigger("reloadGrid");
                        dialog.dialog("close");
                    }
                })
            },
            Cancel: function () {
                dialog.dialog("close");
            }
        }
    });
	
	
	$("#tableusers").jqGrid({
		url: php_table + "",
		editurl:  'php/my.php',
		datatype: "xml",
		mtype: "POST",
		regional: 'ru',
		height: '80%',
		width: '864',
		colNames: [ "id","login", "password", 'Дата последнего входа'],//
		colModel: [
					{ name: "user_id", index: 'user_id', width: 200,"hidden": true, editable: false, editoptions: { size: 100 } },//key: true,
					{ name: "user_login", index: 'user_login', width: 200, editable: true, editoptions: { size: 100 } },
					{ name: "user_password", index: 'user_password', width: 200, editable: true, editoptions: { size: 100 } },
					{
								name: "date", index: 'date', width: 125, editable: false, sortable: "date", formatter: 'date', editoptions: {
									size: 25,
									dataInit: function (element) {
										$(element).datepicker({
											dateFormat: 'dd.mm.yyyy'
										})
									}
								},
						}
		],
		
		pager: '#result',
		scrollOffset: 21,
		rowNum: 100,
		rowList: [10, 20, 50],
		//sortname: "Position",
		sortorder: "asc",
		viewrecords: true,
		caption: "Пользователи которые могут работать в панели администратора",
	}).jqGrid('navGrid', '#result', { edit: true, add: true, del: true, refresh:true, search: false })
	
	//кнопка добавление человека
/*	.navButtonAdd('#result', {
		caption: "",
		title: "Добавить пользователя",
		buttonicon: "ui-icon-plusthick",
		onClickButton: function () {
			//1. очистить форму 
			clear_form();
			$.ajax({
				url: "php/query.php",
				success: function (data) {
					var returne = JSON.parse(data);
					$("#user_id").val(returne['user_id']);
				}
			});
			$("#dialog-form").dialog("open");
		}
	})*/
	
	//кнопка удаления
	/*	.navButtonAdd('#result', {
		caption: "",
		title: "Удалить пользователя",
		buttonicon: "ui-icon-trash",
		onClickButton: function () {
			var myGrid = $('#tableusers'),
			selectedRowId = myGrid.jqGrid('getGridParam', 'selrow');
			$.ajax({
				url: "php/my.php?Del&id=" + selectedRowId,
				success: function (data) {
					$("#tableusers").trigger("reloadGrid");
					alert("Запись удалена");
				},
				//position: "first"
			});
		}
	});*/
	
	/*function clear_form() {
		$("#user_login").val('');
		$("#user_password").val('');
	};*/
});


//Черный список
	function Open_black_list() {
    $("#Black").dialog("open");
}
$('#Open_Black').on("click",function () {
    $("#Black").dialog("open");
})
$(document).ready(function () {
	var dialog = $("#Black").dialog({
        autoOpen: false,
        height: 700,
        width: 900,
        modal: true,
        buttons: {
            /*"Сохранить": function () {
                var user_login = $("#user_login").val();
                var user_password = $("#user_password").val();
                $.ajax({
                    url: "php/my.php?Add&user_id=" + user_id + "$user_login=" + user_login + "$user_password" + user_password,
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: Content,
                    type: "POST",
                    success: function (data) {
                        $("#tableusers").trigger("reloadGrid");
                        dialog.dialog("close");
                    }
                })
            },*/
            "Назад": function () {
                dialog.dialog("close");
            },
        }
    });
	
	var dialog = $("#farm-dialog").dialog({
	autoOpen: false,
        height: 700,
        width: 900,
        modal: true,
        buttons: {
            "Сохранить": function () {
                var user_ip = $("#user_ip").val();
                $.ajax({
                    url: "php/sqllist.php?del&user_id=" + user_id + "$user_ip=" + user_ip,
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: Content,
                    type: "POST",
                    success: function (data) {
                        $("#tableblack").trigger("reloadGrid");
                        dialog.dialog("close");
                    }
                })
            },
            Cancel: function () {
                dialog.dialog("close");
            }
        }
    });
	
	
	$("#tableblack").jqGrid({
		url: php_tablelist + "",
		editurl:  'php/sqllist.php',
		datatype: "xml",
		mtype: "POST",
		regional: 'ru',
		height: '80%',
		width: '864',
		colNames: [ "ip",'Дата блокировки'],//, "id"
		colModel: [
					//{ name: "user_id", width: 200, "hidden": false, editable: false, editoptions: { size: 100 } },//key: true,
					{ name: "user_ip", index: 'user_ip', width: 200, editable: true, editoptions: { size: 100 } },
						{
								name: "date", index: 'date', width: 125, editable: false, sortable: "date", formatter: 'date', editoptions: {
									size: 25,
									dataInit: function (element) {
										$(element).datepicker({
											dateFormat: 'dd.mm.yyyy'
										})
									}
								},
						}
		],
		
		pager: '#gogo',
		scrollOffset: 21,
		rowNum: 100,
		rowList: [10, 20, 50],
		//sortname: "Position",
		sortorder: "asc",
		viewrecords: true,
		caption: "Пользователи которые заблакированы",
	}).jqGrid('navGrid', '#gogo', { edit: false, add: false, del: true, refresh:true, search: false})
	
	/*
		function formatDate(date) {
		
		var dd = date.getDate();
		if (dd < 10) dd = '0' + dd;
		
		var mm = date.getMonth() + 1;
		if (mm < 10) mm = '0' + mm;
		
		var yy = date.getFullYear() % 100;
		if (yy < 10) yy = '0' + yy;
		
		return dd + '.' + mm + '.' + yy;
		
		{
								name: "End", index: 'End', width: 125, editable: true, sortable: "date", formatter: 'date', editoptions: {
									size: 25,
									dataInit: function (element) {
										$(element).datepicker({
											dateFormat: 'dd.mm.yyyy'
										})
									}
								},
	}*/
});
	