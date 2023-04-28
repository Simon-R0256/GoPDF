
//Ajax Request Function
function ajaxRequest(table, data, sendurl) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: sendurl,
        method: "POST",
        dataType: "JSON",

        data: data,

        success: function () {
            $(table).DataTable().ajax.reload(null,false);
        },

        error: function (response) { 
            showMessage(response.responseJSON.errors,"danger")
        }   

    });
}

//zeigt ErrorBox/en mit Messages, die automatisch wieder ausgeblendet wird
function showMessage(msg, type){
    $(".messageBox").html("");
    $(".messageBox").show();

    $.each(msg, function (key, value) {
        $(".messageBox").append(
            '<div class="alert alert-'+type+'">' + value + "</div>"
        );
    });

    window.setTimeout(function () {
        $(".messageBox").fadeTo(1000, 0, function () {
            $(".messageBox").hide();
            $(".messageBox").css("opacity", "1");
        });
    }, 3000);
}

//Nutzerverwaltung--------------------------------------------------------

$('#userCreateForm').submit(function (event) {
    event.preventDefault();
    var data = {
        email: $("#userEmail").val(),
        password: $("#userPassword").val(),
        check: $("#userCheck").prop("checked"),
    };
    ajaxRequest("#userTable", data, "admin/user_create");
    $("#userCreateForm").trigger("reset");
});

$('#userDeleteForm').submit(function (event) {
    event.preventDefault();
    var data = { id: $("#userId").val() };
    ajaxRequest("#userTable", data, "admin/user_delete");
    $("#userDeleteForm").trigger("reset");
});

//API Verwaltung-------------------------------------------------------------

$('#keyCreateForm').submit(function (event) {
    event.preventDefault();
    var data = { date: $("#keyDate").val() };
    ajaxRequest("#keyTable", data, "/admin/key_create", "/admin/api");
    $("#keyCreateForm").trigger("reset");

});

$("#keyDeleteForm").submit(function (event) {
    event.preventDefault();
    var data = { key: $("#keyTextField").val() };
    ajaxRequest("#keyTable", data, "/admin/key_delete", "/admin/api");
    $("#keyDeleteForm").trigger("reset");
});

//Dokumentenverwaltung--------------------------------------------------------

function release(input) {
    var data = { id: input.value };
    ajaxRequest("#documentTable", data, "/documents/release");
}

function deleteDocument(input) {
    var data = { id: input.value };
    ajaxRequest("#documentTable", data, "/documents/delete");
}

function releaseAccept(input) {
    var data = { id: input.value };
    ajaxRequest("#documentTable", data, "/documents/accept");
}

function releaseDecline(input) {
    var data = { id: input.value };
    ajaxRequest("#documentTable", data, "/documents/decline");
}

function releaseRevert(input) {
    var data = { id: input.value };
    ajaxRequest("#documentTable", data, "/documents/revert");
}

//Profile------------------------------------------------------------------

function loadMyKey(input){
    ajaxKeyRequest("profile/showKey",{id : input.dataset.id}, false);
}

function getMyKey(input){
    ajaxKeyRequest("profile/getKey",{id: input.dataset.id}, true);
}

function ajaxKeyRequest(url, data, msg){

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: url,
        method: "POST",
        dataType: "JSON",

        data: data,

        success: function (response) {
            $("#myKeyValue").html(response.key);
            $("#myKeyDate").html(response.date);
        },

        error: function () {
            if(msg){
                showMessage(["Kein Key Verfügbar"], "danger")
            }
            else{
                console.log("Etwas hat nicht funktioniert")
            }
        },
    });
}
