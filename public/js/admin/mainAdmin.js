
var token = $("input[name=_token]").val();
const base_url = window.location.origin;

$(document).ready(function(){


    if(window.location.pathname == "/admin/users"){
        refreshUsers();
        $("#ddlCompanies").on("change",refreshUsers);
        $("#ddlSort").on("change",refreshUsers);
        $("#keyword").on("keyup",refreshUsers);
    }
})

function refreshUsers() {
    
  $.ajax({
    url : "/admin/users-api",
    method : "GET",
    datatype : "json",
    data : {
      id : 5,
      _token : token
    },
    success : function(data) {
      console.log(data);
      printUsers(data)
    },
    error : function(xhr) {
      
      switch(xhr.status){
        case 404:
          makeNotification(1,xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1,"Error","Server error, please try again later.");
          break;
      }
    }
  })
}

function printUsers(data){
    
}

function makeNotification(errorType,title,message){
    var types = ["success","danger","info","warning"];
  
    $.notify({
      title: `<strong>${title}</strong>`,
      message: message
      
    },
    {
      type: types[errorType]
    },
    {
      newest_on_top: true
    });
  
}