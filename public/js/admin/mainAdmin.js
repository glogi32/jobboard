var token = $("input[name=_token]").val();
const base_url = window.location.origin;

$(document).ready(function () {


  $('#confirm-delete').on('show.bs.modal', function (e) {
    let id = $(e.relatedTarget).data('id')
    $("#id").val(id);
  });

  if (window.location.pathname.includes("/admin/user-edit")) {
    $("#btn-confirm-delete").on("click", deleteUserDocs);
  }

  if (window.location.pathname == "/admin/users") {
    $('.rangedatetime').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      },
      autoApply: true,
    })
    $("#verification-range").val("")
    $("#create-range").val("")
    $("#update-range").val("")

    $(document).on("click", "#cancelFilters", cancelUsersFilters)

    refreshUsers();
    $("#verification-range").on("change", refreshUsers);
    $("#create-range").on("change", refreshUsers);
    $("#update-range").on("change", refreshUsers);
    $("#ddlSort").on("change", refreshUsers);
    $("#ddlRole").on("change", refreshUsers);
    $("#ddlStatus").on("change", refreshUsers);
    $("#keyword").on("keyup", refreshUsers);
    $("#ddlPerPage").on("change", refreshUsers);
    $("#btn-confirm-delete").on("click", deleteUser);
  }


  if (window.location.pathname == "/admin/jobs") {
    $('.rangedatetime').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      },
      autoApply: true,

    })
    $("#deadline-range").val("")
    $("#create-range").val("")
    $("#update-range").val("")

    $(document).on("click", "#cancelFilters", cancelJobsFilters)

    refreshJobs();
    $("#keyword").on("keyup", refreshJobs);
    $("#ddlPerPage").on("change", refreshJobs);

    $("#pageType").on("change", refreshJobs);
    $("#keyword").on("keyup", refreshJobs);
    $("#ddlSort").on("change", refreshJobs);
    $("#ddlArea").on("change", refreshJobs);
    $("#ddlTechnologies").on("change", refreshJobs);
    $("#ddlCity").on("change", refreshJobs);
    $("#ddlSeniority").on("change", refreshJobs);
    $("#ddlStatus").on("change", refreshJobs);
    $("#deadline-range").on("change", refreshJobs);
    $("#create-range").on("change", refreshJobs);
    $("#update-range").on("change", refreshJobs);
    $("#btn-confirm-delete").on("click", deleteJob);
  }

  if (window.location.pathname == "/admin/companies") {
    $('.rangedatetime').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      },
      autoApply: true,
    })

    $("#create-range").val("")
    $("#update-range").val("")

    $(document).on("click", "#cancelFilters", cancelCompaniesFilters);

    refreshCompanies();
    $("#keyword").on("keyup", refreshCompanies);
    $("#ddlPerPage").on("change", refreshCompanies);

    $("#keyword").on("keyup", refreshCompanies);
    $("#ddlSort").on("change", refreshCompanies);
    $("#ddlCity").on("change", refreshCompanies);
    $("#ddlStatus").on("change", refreshCompanies);
    $("#create-range").on("change", refreshCompanies);
    $("#update-range").on("change", refreshCompanies);
    $("#btn-confirm-delete").on("click", deleteCompany);
  }

  if (window.location.pathname == "/admin/cities") {
    refreshCities();
    $("#keyword").on("keyup", refreshCities);
    $("#ddlPerPage").on("change", refreshCities);
    $("#btn-confirm-delete").on("click", deleteCity);
  }

  if (window.location.pathname == "/admin/technologies") {
    refreshTech();
    $("#keyword").on("keyup", refreshTech);
    $("#ddlPerPage").on("change", refreshTech);
    $("#btn-confirm-delete").on("click", deleteTech);
  }

  if (window.location.pathname == "/admin/areas") {
    refreshAreas();
    $("#keyword").on("keyup", refreshAreas);
    $("#ddlPerPage").on("change", refreshAreas);
    $("#btn-confirm-delete").on("click", deleteTech);
  }
})

function refreshUsers(e, page = 1) {

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
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }
  if (role) {
    data.role = role
  }
  if (status) {
    data.status = status
  }
  if (verificationRange) {
    let verificationRangeFrom = verificationRange.split("-")[0];
    let verificationRangeTo = verificationRange.split("-")[1];

    data.verificationRangeFrom = verificationRangeFrom,
      data.verificationRangeTo = verificationRangeTo
  }
  if (createRange) {
    let createRangeFrom = createRange.split("-")[0];
    let createRangeTo = createRange.split("-")[1];

    data.createRangeFrom = createRangeFrom,
      data.createRangeTo = createRangeTo
  }
  if (updateRange) {
    let updateRangeFrom = updateRange.split("-")[0];
    let updateRangeTo = updateRange.split("-")[1];

    data.updateRangeFrom = updateRangeFrom,
      data.updateRangeTo = updateRangeTo
  }



  if (sort) {
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url: "/admin/users-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      console.log(data);
      printUsers(data);
      printUsersPagination(data);
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printUsers(data) {

  let html = ``;
  for (let user of data.users) {
    html += `<tr>
              <td>${user.listNumber}</td>
              <td><a href="${user.user_url}" target="_blank" >${user.first_name} ${user.last_name}</a></td>
              <td>${user.email}</td>
              <td>${user.role.name}</td>
              <td>${user.verified != null ? user.verified : "/"}</td>
              <td class="text-center" style="width: 7%;" >${user.status}</td>
              <td style="width: 13%;" >${user.created_at_formated}</td>
              <td>${user.updated_at_formated != null ? user.updated_at_formated : "/"}</td>
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" target="_blank"  href="${user.userAdminEditUrl}" data-id="${user.id}">Edit</a>
                  <a class="dropdown-item  ${user.deleted_at ? "disabled" : ""}" data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${user.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-users").html(html);

}

function printUsersPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev usersPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link usersPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link usersPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#usersPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.users.length - 1} Of ${data.totalUsers} Jobs`);
  $(".usersPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshUsers(e, page);
  })

}

function makeNotification(errorType, title, message) {
  var types = ["success", "danger", "info", "warning"];

  $.notify({
    title: `<strong>${title}</strong>`,
    message: message

  }, {
    type: types[errorType]
  }, {
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

function deleteUser() {
  let id = $("#id").val();

  $.ajax({
    url: "/admin/users-api/" + id,
    method: "DELETE",
    datatype: "json",
    data: {
      _token: token
    },
    success: function (data) {
      console.log(data)
      refreshUsers();
      makeNotification(0, "Success: ", data.message)
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}

function deleteUserDocs() {
  let id = $("#id").val();

  $.ajax({
    url: "/remove-user-docs",
    method: "DELETE",
    datatype: "json",
    data: {
      _token: token,
      id: id
    },
    success: function (data) {
      makeNotification(0, "Success: ", data.message)
      $(`#${id}`).remove();
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}


function refreshJobs(e, page = 1) {

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
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }
  if (area) {
    data.areas = area
  }
  if (technologies) {
    data.techs = technologies
  }
  if (city) {
    data.cities = city
  }
  if (seniority) {
    data.seniorites = seniority
  }

  if (status) {
    data.status = status
  }

  if (deadlineRange) {
    let deadlineRangeFrom = deadlineRange.split("-")[0];
    let deadlineRangeTo = deadlineRange.split("-")[1];

    data.deadlineRangeFrom = deadlineRangeFrom,
      data.deadlineRangeTo = deadlineRangeTo
  }
  if (createRange) {
    let createRangeFrom = createRange.split("-")[0];
    let createRangeTo = createRange.split("-")[1];

    data.createRangeFrom = createRangeFrom,
      data.createRangeTo = createRangeTo
  }
  if (updateRange) {
    let updateRangeFrom = updateRange.split("-")[0];
    let updateRangeTo = updateRange.split("-")[1];

    data.updateRangeFrom = updateRangeFrom,
      data.updateRangeTo = updateRangeTo
  }

  if (sort) {
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url: "/admin/jobs-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      console.log(data);
      printJobs(data);
      printJobsPagination(data);
      refreshJobStatistics(data.jobs)
      refreshTopJobsStatistics()
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printJobs(data) {

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
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item  ${job.deleted_at ? "disabled" : ""}" data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${job.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-jobs").html(html);

}

function printJobsPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev jobsPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link jobsPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link jobsPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#jobsPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.jobs.length - 1} Of ${data.totalJobs} Jobs`);
  $(".jobsPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshJobs(e, page);
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

function refreshJobStatistics(data) {
  let donutChartCanvas = null;
  let donutData = null;
  let donutOptions = null;
  let dataLabels = [];
  let dataVisits = [];

  dataLabels = data.map(function (c) {
    return c.title;
  });

  dataVisits = data.map(function (c) {
    return c.statistics;
  });
  console.log(dataVisits, dataLabels);

  donutChartCanvas = $('#jobStatisticsPaginated').get(0).getContext('2d')
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
  donutData = {
    labels: dataLabels,
    datasets: [{
      data: dataVisits,
      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', "navy", "red", "orange"],
    }]
  }
  donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
}

function refreshTopJobsStatistics() {

  var dataLabels = [];
  var dataVisits = [];
  var donutChartCanvas = null;
  var donutData = null;
  var donutOptions = null;

  $.ajax({
    url: "/admin/jobs-stats",
    method: "GET",
    async: false,
    datatype: "json",
    success: function (data) {
      dataLabels = data.data.map(function (c) {
        return c.title;
      });

      dataVisits = data.data.map(function (c) {
        return c.statistics;
      });


    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })

  donutChartCanvas = $('#topJobsStatistics').get(0).getContext('2d')
  donutData = {
    labels: dataLabels,
    datasets: [{
      data: dataVisits,
      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', "navy", "red", "orange"],
    }]
  }
  donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
}

function deleteJob() {
  let id = $("#id").val();

  $.ajax({
    url: "/admin/jobs-api/" + id,
    method: "DELETE",
    datatype: "json",
    data: {
      id: id,
      _token: token
    },
    success: function (data) {
      console.log(data)
      refreshJobs();
      makeNotification(0, "Success: ", data.message)
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}


function refreshCompanies(e, page = 1) {

  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();
  let sort = $("#ddlSort").val();
  let city = $("#ddlCity").val();
  let status = $("#ddlStatus").val();
  let createRange = $("#create-range").val();
  let updateRange = $("#update-range").val();


  var data = {
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }
  if (city) {
    data.city = city
  }

  if (status) {
    data.status = status
  }

  if (createRange) {
    let createRangeFrom = createRange.split("-")[0];
    let createRangeTo = createRange.split("-")[1];

    data.createRangeFrom = createRangeFrom,
      data.createRangeTo = createRangeTo
  }
  if (updateRange) {
    let updateRangeFrom = updateRange.split("-")[0];
    let updateRangeTo = updateRange.split("-")[1];

    data.updateRangeFrom = updateRangeFrom,
      data.updateRangeTo = updateRangeTo
  }

  if (sort) {
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url: "/admin/companies-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      console.log(data);
      printCompanies(data.data);
      printCompaniesPagination(data.data);
      refreshCompanyStatistics(data.data.companies);
      refreshTopCompaniesStatistics();
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printCompanies(data) {

  let html = ``;
  for (let company of data.companies) {
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
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item  ${company.deleted_at ? "disabled" : ""}" data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${company.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-companies").html(html);

}

function printCompaniesPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev companyPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link companyPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link companyPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#companiesPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.companies.length - 1} Of ${data.totalCompanies} Companies`);
  $(".companyPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshCompanies(e, page);
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

function refreshCompanyStatistics(data) {

  let dataLabels = data.map(function (c) {
    return c.name;
  });

  let dataVisits = data.map(function (c) {
    return c.statistics;
  });
  console.log(dataVisits, dataLabels);

  var donutChartCanvas = $('#companyStatisticsPaginated').get(0).getContext('2d')
  var donutData = {
    labels: dataLabels,
    datasets: [{
      data: dataVisits,
      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', "navy", "red", "orange"],
    }]
  }
  var donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }

  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
}

function refreshTopCompaniesStatistics() {
  var dataLabels = [];
  var dataVisits = [];

  $.ajax({
    url: "/admin/companies-stats",
    method: "GET",
    async: false,
    datatype: "json",
    success: function (data) {
      dataLabels = data.data.map(function (c) {
        return c.name;
      });

      dataVisits = data.data.map(function (c) {
        return c.statistics;
      });


    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })

  var donutChartCanvas = $('#companyStatisticsTop').get(0).getContext('2d')
  var donutData = {
    labels: dataLabels,
    datasets: [{
      data: dataVisits,
      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', "navy", "red", "orange"],
    }]
  }
  var donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
}

function deleteCompany() {
  let id = $("#id").val();

  $.ajax({
    url: "/admin/companies-api/" + id,
    method: "DELETE",
    datatype: "json",
    data: {
      _token: token
    },
    success: function (data) {
      console.log(data)
      refreshCompanies();
      makeNotification(0, "Success: ", data.message)
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}


function refreshCities(e, page = 1) {
  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();

  var data = {
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }

  $.ajax({
    url: "/admin/cities-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      console.log(data);
      printCities(data.data);
      printCitiesPagination(data.data);
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printCities(data) {
  let html = ``;
  for (let city of data.cities) {
    html += `<tr>
              <td>${city.listNumber}</td>
              <td><a href="${city.city_details}" target="_blank" >${city.name}</a></td>
              <td style="width: 12%;" >${city.created_at_formated}</td>
              <td style="width: 12%;">${city.updated_at_formated != null ? city.updated_at_formated : "/"}</td>
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item"  data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${city.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-cities").html(html);
}

function printCitiesPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev cityPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link cityPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link cityPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#citiesPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.cities.length - 1} Of ${data.totalCities} Cities`);
  $(".cityPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshCities(e, page);
  })

}

function deleteCity() {
  let id = $("#id").val();

  $.ajax({
    url: "/admin/cities-api/" + id,
    method: "DELETE",
    datatype: "json",
    data: {
      _token: token
    },
    success: function (data) {
      console.log(data)
      refreshCities();
      makeNotification(0, "Success: ", data.message)
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}


function refreshTech(e, page = 1) {
  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();

  var data = {
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }

  $.ajax({
    url: "/admin/technologies-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      printTechs(data.data);
      printTechsPagination(data.data);
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printTechs(data) {
  let html = ``;
  for (let tech of data.techs) {
    html += `<tr>
              <td>${tech.listNumber}</td>
              <td><a href="${tech.tech_details}" target="_blank" >${tech.name}</a></td>
              <td style="width: 12%;" >${tech.created_at_formated}</td>
              <td style="width: 12%;">${tech.updated_at_formated != null ? tech.updated_at_formated : "/"}</td>
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item"  data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${tech.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-tech").html(html);
}

function printTechsPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev techPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link techPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link techPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#citiesPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.techs.length - 1} Of ${data.totalTechs} Cities`);
  $(".techPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshTech(e, page);
  })

}

function deleteTech() {
  let id = $("#id").val();

  $.ajax({
    url: "/admin/technologies-api/" + id,
    method: "DELETE",
    datatype: "json",
    data: {
      _token: token
    },
    success: function (data) {
      refreshTech();
      makeNotification(0, "Success: ", data.message)
    },
    error: function (xhr) {
      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  }).done(function () {
    $('#confirm-delete').modal("hide");
  })
}


function refreshAreas(e, page = 1) {
  let perPage = $("#ddlPerPage").val();
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();

  var data = {
    page: page,
  };

  if (keyword) {
    data.keyword = keyword
  }
  if (perPage) {
    data.perPage = perPage
  }
  if (pageType) {
    data.pageType = pageType
  }

  $.ajax({
    url: "/admin/areas-api",
    method: "GET",
    datatype: "json",
    data: data,
    success: function (data) {
      printAreas(data.data);
      printAreasPagination(data.data);
    },
    error: function (xhr) {

      switch (xhr.status) {
        case 404:
          makeNotification(1, xhr.responseJSON.message);
          break;
        case 500:
          makeNotification(1, "Error", "Server error, please try again later.");
          break;
      }
    }
  })
}

function printAreas(data) {
  let html = ``;
  for (let areas of data.areas) {
    html += `<tr>
              <td>${areas.listNumber}</td>
              <td><a href="${areas.areas_details}" target="_blank" >${areas.name}</a></td>
              <td style="width: 12%;" >${areas.created_at_formated}</td>
              <td style="width: 12%;">${areas.updated_at_formated != null ? areas.updated_at_formated : "/"}</td>
              <td>
                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item"  data-toggle="modal" data-target="#confirm-delete" href="#" data-id="${areas.id}">Delete</a>
                </div>
              </td>
            </tr>`;
  }

  $("#table-areas").html(html);
}

function printAreasPagination(data) {
  html = `<li class="page-item"><a href="#" id="prevPage" class="page-link prev areasPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage - 1}">«</a></li>`;
  for (let p = 1; p <= data.totalPages; p++) {
    html += `<li class="page-item ${p == data.curentPage ? 'active' : ''}"><a class="page-link areasPage " data-id="${p}" href="#">${p}</a></li>`;
  }
  html += `<li class="page-item"><a href="#" id="nextPage" class="next page-link areasPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage + 1}">»</a></li>`
  $("#areasPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip + data.areas.length - 1} Of ${data.totalAreas} Areas`);
  $(".areasPage").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("id");
    refreshAreas(e, page);
  })

}