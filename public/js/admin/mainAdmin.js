
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

      $(document).on("click","#cancelFilters",cancelUsersFilters)

      refreshUsers();
      $("#verification-range").on("change",refreshUsers);
      $("#create-range").on("change",refreshUsers);
      $("#update-range").on("change",refreshUsers);
      $("#ddlSort").on("change",refreshUsers);
      $("#ddlRole").on("change",refreshUsers);
      $("#ddlStatus").on("change",refreshUsers);
      $("#keyword").on("keyup",refreshUsers);
      $("#ddlPerPage").on("change",refreshUsers);
    }


    if(window.location.pathname == "/admin/jobs"){
      $('.rangedatetime').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        },
        autoApply: true,
        
      })
      $("#deadline-range").val("")
      $("#create-range").val("")
      $("#update-range").val("")

      $(document).on("click","#cancelFilters",cancelJobsFilters)

      refreshJobs();
      $("#keyword").on("keyup",refreshJobs);
      $("#ddlPerPage").on("change",refreshJobs);

      $("#pageType").on("change",refreshJobs);
      $("#keyword").on("keyup",refreshJobs);
      $("#ddlSort").on("change",refreshJobs);
      $("#ddlArea").on("change",refreshJobs);
      $("#ddlTechnologies").on("change",refreshJobs);
      $("#ddlCity").on("change",refreshJobs);
      $("#ddlSeniority").on("change",refreshJobs);
      $("#ddlStatus").on("change",refreshJobs);
      $("#deadline-range").on("change",refreshJobs);
      $("#create-range").on("change",refreshJobs);
      $("#update-range").on("change",refreshJobs);
    }

    if(window.location.pathname == "/admin/companies"){
      $('.rangedatetime').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        },
        autoApply: true,
      })

      $("#create-range").val("")
      $("#update-range").val("")

      $(document).on("click","#cancelFilters",cancelCompaniesFilters);

      refreshCompanies();
      $("#keyword").on("keyup", refreshCompanies);
      $("#ddlPerPage").on("change", refreshCompanies);

      $("#keyword").on("keyup", refreshCompanies);
      $("#ddlSort").on("change", refreshCompanies);
      $("#ddlCity").on("change", refreshCompanies);
      $("#ddlStatus").on("change", refreshCompanies);
      $("#create-range").on("change", refreshCompanies);
      $("#update-range").on("change", refreshCompanies);
    }
})

function refreshUsers(e,page = 1) {
    
  let perPage = $("#ddlPerPage").val()
  let pageType = $("#pageType").val()
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
  if(pageType){
    data.pageType = pageType
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
              <td><i class="fas fa-ellipsis-v"></i></td>
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

function cancelUsersFilters() {
  $("#verification-range").val("");
  $("#create-range").val("");
  $("#update-range").val("");
  $("#keyword").val("");
  $("#ddlSort").val("").trigger('change');
  $("#ddlRole").val("").trigger('change');
  $("#ddlStatus").val("").trigger('change');
  refreshUsers();
}


function refreshJobs(e,page = 1) {
    
  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();
  let sort = $("#ddlSort").val();
  let area = $("#ddlArea").val();
  let technologies = $("#ddlTechnologies").val();
  let city = $("#ddlCity").val();
  let seniority = $("#ddlSeniority").val();
  let status = $("#ddlStatus").val();
  let deadlineRange = $("#deadline-range").val();
  let createRange = $("#create-range").val();
  let updateRange = $("#update-range").val();
  
  
  var data = {
    page : page,
  };

  if(keyword){
    data.keyword = keyword
  }
  if(perPage){
    data.perPage = perPage
  }
  if(pageType){
    data.pageType = pageType
  }
  if(area){
    data.areas = area
  }
  if(technologies){
    data.techs = technologies
  }
  if(city){
    data.cities = city
  }
  if(seniority){
    data.seniorites = seniority
  }

  if(status){
    data.status = status
  }

  if(deadlineRange){
    let deadlineRangeFrom = deadlineRange.split("-")[0];
    let deadlineRangeTo = deadlineRange.split("-")[1];

    data.deadlineRangeFrom = deadlineRangeFrom,
    data.deadlineRangeTo = deadlineRangeTo
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
    url : "/admin/jobs-api",
    method : "GET",
    datatype : "json",
    data : data,
    success : function(data) {
      console.log(data);
      printJobs(data);
      printJobsPagination(data);
      refreshJobStatistics(data.jobs)
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

function printJobs(data){

  let html = ``;
  for (const job of data.jobs) {
    html += `<tr>
              <td>${job.listNumber}</td>
              <td><a href="${job.job_details}" target="_blank" >${job.title}</a></td>
              <td><a href="${job.company_details}" target="_blank" >${job.company.name}</a></td>
              <td style="width: 15%;">${job.deadline_formated}</td>
              <td>${job.statistics}</td>
              <td class="text-center" style="width: 7%;" >${job.status}</td>
              <td style="width: 15%;" >${job.created_at_formated}</td>
              <td>${job.updated_at_formated != null ? job.updated_at_formated : "/"}</td>
              <td><i class="fas fa-ellipsis-v"></i></td>
            </tr>`;
  }

  $("#table-jobs").html(html);

}

function printJobsPagination(data){
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev jobsPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage-1}">«</a></li>`;
  for(let p=1; p<=data.totalPages; p++){
    html+= `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link jobsPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link jobsPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage+1}">»</a></li>`
  $("#jobsPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip+data.jobs.length-1} Of ${data.totalJobs} Jobs`);
  $(".jobsPage").on("click",function(e){
    e.preventDefault();
    let page = $(this).data("id");
    refreshJobs(e,page);
  })

}

function cancelJobsFilters() {
  $("#deadline-range").val("");
  $("#create-range").val("");
  $("#update-range").val("");
  $("#keyword").val("");
  $("#ddlSort").val("").trigger('change');
  $("#ddlArea").val("").trigger('change');
  $("#ddlTechnologies").val("").trigger('change');
  $("#ddlCity").val("").trigger('change');
  $("#ddlSeniority").val("").trigger('change');
  $("#ddlStatus").val("").trigger('change');
  refreshUsers();
}

function refreshJobStatistics(data){

  let dataLabels = data.map(function(c){
    return c.title;
  });

  let dataVisits = data.map(function(c){
    return c.statistics;
  });
  console.log(dataVisits,dataLabels);

  var donutChartCanvas = $('#jobStatisticsPaginated').get(0).getContext('2d')
    var donutData        = {
      labels: dataLabels,
      datasets: [
        {
          data: dataVisits,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',"navy", "red", "orange"],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
}

function refreshCompanies(e,page = 1) {
    
  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();
  let sort = $("#ddlSort").val();
  let city = $("#ddlCity").val();
  let status = $("#ddlStatus").val();
  let createRange = $("#create-range").val();
  let updateRange = $("#update-range").val();
  
  
  var data = {
    page : page,
  };

  if(keyword){
    data.keyword = keyword
  }
  if(perPage){
    data.perPage = perPage
  }
  if(pageType){
    data.pageType = pageType
  }
  if(city){
    data.city = city
  }

  if(status){
    data.status = status
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
    url : "/admin/companies-api",
    method : "GET",
    datatype : "json",
    data : data,
    success : function(data) {
      console.log(data);
      printCompanies(data.data);
      printCompaniesPagination(data.data);
      refreshCompanyStatistics(data.data.companies);
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

function printCompanies(data){

  let html = ``;
  for (const company of data.companies) {
    html += `<tr>
              <td>${company.listNumber}</td>
              <td><a href="${company.company_details}" target="_blank" >${company.name}</a></td>
              <td>${company.email}</td>
              <td style="width: 15%;"><a href="${company.user_details}" target="_blank" >${company.user.first_name} ${company.user.last_name}</a></td>
              <td class="text-center" style="width: 10%;">${company.printed_stars}<br/>(${company.vote})</td>
              <td class="text-center" style="width: 7%;" >${company.status}</td>
              <td class="text-center" style="width: 7%;" >${company.statistics}</td>
              <td style="width: 12%;" >${company.created_at_formated}</td>
              <td style="width: 12%;">${company.updated_at_formated != null ? company.updated_at_formated : "/"}</td>
              <td><i class="fas fa-ellipsis-v"></i></td>
            </tr>`;
  }

  $("#table-companies").html(html);

}

function printCompaniesPagination(data){
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev companyPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage-1}">«</a></li>`;
  for(let p=1; p<=data.totalPages; p++){
    html+= `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link companyPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link companyPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage+1}">»</a></li>`
  $("#companiesPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip+data.companies.length-1} Of ${data.totalCompanies} Companies`);
  $(".companyPage").on("click",function(e){
    e.preventDefault();
    let page = $(this).data("id");
    refreshCompanies(e,page);
  })

}

function cancelCompaniesFilters() {
  $("#create-range").val("");
  $("#update-range").val("");
  $("#keyword").val("");
  $("#ddlSort").val("").trigger('change');
  $("#ddlCity").val("").trigger('change');
  $("#ddlStatus").val("").trigger('change');
  refreshCompanies();
}

function refreshCompanyStatistics(data){

  let dataLabels = data.map(function(c){
    return c.name;
  });

  let dataVisits = data.map(function(c){
    return c.statistics;
  });
  console.log(dataVisits,dataLabels);

  var donutChartCanvas = $('#companyStatisticsPaginated').get(0).getContext('2d')
    var donutData        = {
      labels: dataLabels,
      datasets: [
        {
          data: dataVisits,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',"navy", "red", "orange"],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
}