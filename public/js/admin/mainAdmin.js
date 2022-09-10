
var token = $("input[name=_token]").val();
const base_url = window.location.origin;

$(document).ready(function(){


    if(window.location.pathname == "/admin/users"){
      $('.rangedatetime').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        },
        autoApply: true,
        
      })
      $("#verification-range").val("")
      $("#create-range").val("")
      $("#update-range").val("")

      refreshUsers();
      $("#verification-range").on("change",refreshUsers);
      $("#create-range").on("change",refreshUsers);
      $("#update-range").on("change",refreshUsers);
      $("#ddlSort").on("change",refreshUsers);
      $("#keyword").on("keyup",refreshUsers);
      $("#ddlPerPage").on("change",refreshUsers);
    }
})

function refreshUsers(e,page = 1) {
    
  let perPage = $("#ddlPerPage").val()
  let keyword = $("#keyword").val();
  let sort = $("#ddlSort").val();
  let role = $("#ddlRole").val();
  let status = $("#ddlStatus").val();
  let verificationRange = $("#verification-range").val();
  let createRange = $("#create-range").val();
  let updateRange = $("#update-range").val();
  
  
  data = {
    page : page,
  };

  if(keyword){
    data.keyword = keyword
  }
  if(perPage){
    data.perPage = perPage
  }
  if(role){
    data.role = role
  }
  if(status){
    data.status = status
  }
  if(verificationRange){
    let verificationRangeFrom = verificationRange.split("-")[0];
    let verificationRangeTo = verificationRange.split("-")[1];

    data.verificationRangeFrom = verificationRangeFrom,
    data.verificationRangeTo = verificationRangeTo
  }
  if(createRange){
    let createRangeFrom = createRange.split("-")[0];
    let createRangeTo = createRange.split("-")[1];

    data.createRangeFrom = createRangeFrom,
    data.createRangeTo = createRangeTo
  }
  if(updateRange){
    let updateRangeFrom = updateRange.split("-")[0];
    let updateRangeTo = updateRange.split("-")[1];

    data.updateRangeFrom = updateRangeFrom,
    data.updateRangeTo = updateRangeTo
  }



  if(sort){
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url : "/admin/users-api",
    method : "GET",
    datatype : "json",
    data : data,
    success : function(data) {
      console.log(data);
      printUsers(data);
      printUsersPagination(data);
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

  let html = ``;
  for (const user of data.users) {
    html += `<tr>
              <td>${user.listNumber}</td>
              <td><a href="${user.user_url}" target="_blank" >${user.first_name} ${user.last_name}</a></td>
              <td>${user.email}</td>
              <td>${user.role.name}</td>
              <td>${user.verified != null ? user.verified : "/"}</td>
              <td class="text-center" style="width: 7%;" >${user.status}</td>
              <td style="width: 13%;" >${user.created_at_formated}</td>
              <td>${user.updated_at_formated != null ? user.updated_at_formated : "/"}</td>
              <td>Actions</td>
            </tr>`;
  }

  $("#table-users").html(html);

}

function printUsersPagination(data){
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev usersPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage-1}">«</a></li>`;
  for(let p=1; p<=data.totalPages; p++){
    html+= `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link usersPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link usersPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage+1}">»</a></li>`
  $("#usersPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip+data.users.length-1} Of ${data.totalUsers} Jobs`);
  $(".usersPage").on("click",function(e){
    e.preventDefault();
    let page = $(this).data("id");
    refreshUsers(e,page);
  })

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