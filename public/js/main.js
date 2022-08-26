
var token = $("input[name=_token]").val();
const base_url = window.location.origin;

$(document).ready(function(){


  $(".my-select").multipleSelect({
    filter: true
  }); 
  
  
  if(window.location.pathname == "/options/user-companies"){
    refreshUserCompanies();
  }

  if(window.location.pathname == "/options/user-jobs"){
    refreshUserJobs();
    $("#ddlCompanies").on("change",refreshUserJobs);
    $("#ddlSort").on("change",refreshUserJobs);
    $("#keyword").on("keyup",refreshUserJobs);
  }

  if(window.location.pathname.includes("/job-details/")){
    
    if($("#cv-apply").is(":checked")){
      manageCvInput();
    }

    $("#cv-apply").on("click",manageCvInput);
  }

  if(window.location.pathname.includes("/company-details")){
    var star = '.star',
    selected = '.selected';

    $(star).on('click', function(){
      $(selected).each(function(){
        $(this).removeClass('selected');
      });
      $(this).addClass('selected');
    });
  }

  if(window.location.pathname == "/options/user-applications"){
    $("#ddlSort").on("change",refreshApplications);
    $("#ddlCompanies").on("change",refreshApplications);
    $("#keyword").on("keyup",refreshApplications);
    refreshApplications();
  }

  if(window.location.pathname == "/jobs"){
    refreshJobs();
    $("#btnSearch").on("click",refreshJobs);
    $("#ddlTech").on("change",refreshJobs);
    $("#ddlArea").on("change",refreshJobs);
    $("#ddlCity").on("change",refreshJobs);
    $("#ddlSeniority").on("change",refreshJobs);
    $("#ddlSort").on("change",refreshJobs);
    $("#ddlPerPage").on("change",refreshJobs);
  }

  if(window.location.pathname == "/companies"){
    refreshCompanies();
    $("#ddlSort").on("change",refreshCompanies);
    $("#ddlCity").on("change",refreshCompanies);
    $("#btnSearch").on("click",refreshCompanies);
    $("#ddlRating").on("change",refreshCompanies);
    $("#ddlPerPage").on("change",refreshCompanies);
  }
  
  $("#chbShowPass").on("click",togglePasswordVisibility);

  $("#btnComment").on("click",function () {
    let message = $("#message").val();
    let userId = $("#userId").val();
    let companyId = $("#companyId").val();

    $.ajax({
      url : "/company-details/insert-comment",
      method : "POST",
      datatype : "json",
      data : {
        message : message,
        userId : userId,
        companyId : companyId,
        _token : token
      },
      success : function (data) {
        makeNotification(0,"Success: ",data.message)
        refreshCompanyComments(companyId);
      },
      error : function (xhr) {
        switch(xhr.status){
          case 422:
            let errorsArray = Object.entries(xhr.responseJSON.errors);
            console.log(errorsArray)

            for(let error of errorsArray){
              makeNotification(1,error[0],error[1]);
            }
            break;
          case 500: 
            makeNotification(1,"Error: ",xhr.responseJSON.message);
            break;
        }

        
      }
    })
  })

  $(".vote").on("click",function(){
    let vote = $(this).data("id");
    let companyId = $("#companyId").val();
    let userId = $("#userId").val();


    $.ajax({
      url : "/company-details/"+companyId+"/vote",
      method : "POST",
      data : {
        _token : token,
        vote : vote,
        companyId : companyId,
        userId : userId
      },
      success : function(data){
        makeNotification(0,"Success: ",data.message);
      },
      error : function(xhr){
        switch(xhr.status){
          case 422:
            let errorsArray = Object.entries(xhr.responseJSON.errors);
            console.log(errorsArray)

            for(let error of errorsArray){
              makeNotification(1,error[0],error[1]);
            }
            break;
          case 500,404: 
            makeNotification(1,"Error: ",xhr.responseJSON.message);
            break;
        }
      }
    })
  })

  $("#loadMore").on("click",function(e) {
    e.preventDefault();

    let companyId = $("#companyId").val();
    
    
    let take = parseInt($(this).data("take"));
    
    $(this).data("take", take+5 ); 

    refreshCompanyComments(companyId);
  })
  $("#loadMoreUserJobs").on("click",function(e){
    e.preventDefault();

    let take = parseInt($(this).data("take"));
    
    $(this).data("take",take+5);

    refreshUserJobs();
  });
  $("#loadMoreApplications").on("click",function(e){
    e.preventDefault();

    let take = parseInt($(this).data("take"));
    
    $(this).data("take",take+15);

    refreshApplications();
  });
  
  $("#saveJob").on("click",function() {
    let span = $("#saveJob span");
    let userId = $("#userId").val();
    let jobId = $("#jobId").val();

    if(span.hasClass("icon-heart-o")){

      $.ajax({
        url : "/job-details/save-job",
        method : "POST",
        data : {
          userId : userId,
          jobId : jobId,
          _token : token
        },
        datatype : "json",
        success : function() {
          makeNotification(0,"Success: ","Job successfully saved.");
          span.removeClass("icon-heart-o");
          span.addClass("icon-heart");
        },
        error : function(xhr){
          switch(xhr.status){
            case 422:
              let errorsArray = Object.entries(xhr.responseJSON.errors);
              console.log(errorsArray)
  
              for(let error of errorsArray){
                makeNotification(1,error[0],error[1]);
              }
              break;
            case 409:
              makeNotification(1,"Error: ",xhr.responseJSON.message);
              break;
            case 500: 
              makeNotification(1,"Error: ",xhr.responseJSON.message);
              break;
          }
        }
      })

      
    }else{
      $.ajax({
        url : "/job-details/unsave-job",
        method : "DELETE",
        data : {
          userId : userId,
          jobId : jobId,
          _token : token
        },
        datatype : "json",
        success : function() {
          makeNotification(0,"Success: ","Job successfully unsaved.");
          span.removeClass("icon-heart");
          span.addClass("icon-heart-o");
        },
        error : function(xhr){
          switch(xhr.status){
            case 422:
              let errorsArray = Object.entries(xhr.responseJSON.errors);
              console.log(errorsArray)
  
              for(let error of errorsArray){
                makeNotification(1,error[0],error[1]);
              }
              break;
            case 404:
              makeNotification(1,"Error: ",xhr.responseJSON.message);
              break;
            case 500: 
              makeNotification(1,"Error: ",xhr.responseJSON.message);
              break;
          }
        }
      })

      
     
    }
    
  })

  $(".btn-remove-docs").on("click",function(){
    
    let id = $(this).data("id");

    $.ajax({
      url : "/remove-user-docs",
      method : "DELETE",
      data : {
        _token : token,
        id : id
      },
      success : function(){
        window.location.reload();
        makeNotification(0,"Success: ","Document successfully deleted.");
      },
      error : function(xhr){
        switch(xhr.status){
          case 500:
            makeNotification(1,"Error",xhr.responseJSON.message);
            break;
          case 404:
            makeNotification(1,"Error",xhr.responseJSON.message);
            break;
        }
      }
    })
  })
})

function manageCvInput() {
  if($("#cv-apply").is(":checked")){
    $("#cv").attr("disabled","disabled");
    $("#user-cvs").removeAttr("disabled");
  }else{
    $("#user-cvs").attr("disabled","disabled");
    $("#cv").removeAttr("disabled");
  }
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

function togglePasswordVisibility() {
  var x = document.getElementById("tbPass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


function refreshCompanyComments(id) {
  
  let loadMore = $("#loadMore");
  let skip = loadMore.data("skip");
  let take = loadMore.data("take");

  
  
  $.ajax({
    url : "/api/company-details/get-comments",
    method : "GET",
    datatype : "json",
    data : {
      id : id,
      skip : parseInt(skip),
      take : parseInt(take),
      _token : token
    },
    success : function(data) {
      console.log(data);
      printComments(data)
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
function printComments(data) {
  let html = "";
  if(!data.nextPage){
    $("#loadMore").addClass("sr-only");
  }
  for(let c of data.comments){
    html += `<li class="comment">
              <div class="vcard bio">
                <img src="${c.image}" alt="${c.user.image.src}">
              </div>
              <div class="comment-body">
                <h3>${c.user.first_name} ${c.user.last_name}</h3>
                <div class="meta">${c.createdAt}</div>
                <p>${c.text}</p>
              </div>
            </li>`
  }
  $("#comment-list").html(html);
  $("#comment-count").html(data.totalCommentsCount + " Comments")
}


function refreshUserCompanies() {
  let userId = $("#userId").val();

  $.ajax({
    url : "/options/companies",
    method : "GET",
    data : {
      _token : token,
      userId : userId
    },
    success : function(data) {
     
      if(data.data.companies.length){
        printUserCompanies(data.data.companies);
      }else{
        $("#companies").html("<h2>You don't have any companies assigned.</h2>");
      }
      
    },
    error : function(xhr,status,error) {
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error","Server error, please try again later.");
          break;
      }
    }
  })
}
function printUserCompanies(data) {
  let html = ``;
  for(let c of data){
    html += `<div class="card col-md-5 col-lg-5 col-sm-12 mt-4" style="width: 18rem;">
              <img class="card-img-top" src="${c.logo_image_src}" height="200" alt="${c.logo_image_alt}">
              <div class="card-body">
                  <h5 class="card-title">${c.name}</h5>
                  <p class="card-text mb-0">Email: ${c.email}</p>`;

                  if(c.website){
                    html += `<a href="${c.website}" target="_blank" class="card-link mb-5 text-secondary">Website: ${c.website.split(".")[1]}</a>`;
                  }

                  html += `<div class="row d-flex justify-content-around">
                    <a href="${c.company_details}" class="btn btn-info mt-3 text-white">See details</a>
                    <a href="${c.company_edit}"  class="btn btn-info mt-3 text-white">Edit</a>
                    <button  data-id="${c.id}" class="btn btn-danger mt-3 btn-companyDelete">Delete</button>
                  </div>
              </div>
          </div>`;
  }
  $("#companies").html(html);
  $(".btn-companyDelete").on("click",deleteCompany);
}


function refreshUserJobs() {
  let userId = $("#userId").val();
  let companyId = $("#ddlCompanies").val();
  let sort = $("#ddlSort").val();
  let keyword = $("#keyword").val();
  let pageType = $("#pageType").val();

  let loadMore = $("#loadMoreUserJobs");
  let take = loadMore.data("take");
 
  console.log(take);
  let data = {
    "userId" : userId,
    "pageType" : pageType,
    "perPage" : take,
    "_token" : token
  };

  if(sort){
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }
  if(companyId){
    data.companyId = companyId;
  }
  if(keyword){
    data.keyword = keyword
  }
  
  $.ajax({
    url : "/options/jobs",
    method : "GET",
    data : data,
    datatype : "json",
    success : function(data) {
      console.log(data.jobs)
      if(data.jobs.length){
        printUserJobs(data);
      }else{
        $("#jobs").html("<h2>You don't have any jobs.</h2>");
      }
    },
    error : function(xhr){
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error","Server error, please try again later.");
          break;
      }
    }
  })
}
function printUserJobs(data) {
  let html = ``;
  if(!data.nextPage){
    $("#load-more").addClass("sr-only");
  }
  for(let j of data.jobs){
    html += `<div class="col-lg-12 col-md-12 job-listing d-block d-sm-flex pb-3 pb-sm-0 p-4 align-items-center">

              <div class="row w-100 bg-white">

                  <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                      <div class="job-listing-position custom-width w-100 mb-3 mb-sm-0">
                          <a href="${j.job_details}"> 
                              <h4> ${j.title} </h4> 
                          </a>
                          <strong>${j.company.name}</strong> <span> / </span> <span class="icon-room"></span> ${j.city.name}
                      </div>
                      <div class="job-listing-meta ">
                          <span class="badge badge-danger">${j.emp_status}</span>
                      </div>

                  </div>
                  <div class="col-md-12 d-flex justify-content-between ">
                  <div class="tags">`;
                      
                      for(let t of j.technologies){
                          html+=`<span class="badge badge-info mx-1">${t.name}</span>`;
                      }

                    html += `</div>
                      
                  <div class="expire-date ml-4">
                      <p>Days left: ${j.deadline_formated}</p>
                  </div>
                  </div>

              </div>
              
            </div>`;
  }
  $("#jobs").html(html);
}

function refreshApplications(){
  let sort = $("#ddlSort").val();
  let companyId = $("#ddlCompanies").val();
  let keyword = $("#keyword").val();

  
  let take = $("#loadMoreApplications").data("take");

  let data = {
    role : $("#role").val(),
    userId : $("#userId").val(),
    perPage : take,
    _token : token
  };

  

  if(sort){
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }
  if(companyId){
    data.companyId = companyId;
  }
  if(keyword){
    data.keyword = keyword;
  }


  $.ajax({
    url : "/options/applications",
    method : "GET",
    data : data,
    datatype : "json",
    success : function(data){
      console.log(data.data);
      printApplications(data);
    },
    error : function(xhr){
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error",xhr.responseJSON.message);
          break;
      }
    }
  })
}
function printApplications(data){
  let html = ``;
  let br = 1;
  console.log(data)
  if(data.nextPage == false){
    $("#load-more-app").addClass("sr-only");
  }
  for(let a of data.applications){
    html += `<tr>
              <th scope="row">${br}</th>
              <td><a href="${a.job_url}" class="text-secondary">${a.job.title}</a></td>
              <td><a href="${a.company_url}" class="text-secondary">${a.job.company.name}</a></td>
              <td>${a.status_name}</td>
              <td>${a.applied_at}</td>
              <td ><a href="#" data-id="${a.id}" class="details" data-toggle="modal" data-target="#application-modal"><i class="far fa-file-alt icons text-secondary"></i></a></td>
            </tr>`;
    br++;
  }
  $("#applications").html(html);
  $(".details").on("click",getOneApplication);
}
function getOneApplication(e){
  e.preventDefault();
  let appId = $(this).data("id");

  $.ajax({
    url : "/options/applications/"+appId,
    method : "GET",
    datatype : "json",
    success : function(data){
      console.log(data.data)
      printSingleApplication(data.data);
    },
    error : function(xhr){
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error",xhr.responseJSON.message);
          break;
      }
    }
  })
}
function printSingleApplication(app){
  app.app_status = Object.values(app.app_status) 
  let role = $("#role").val();
  let html = `
            <div class="modal-content ">
              <div class="modal-header">
                <h5 class="modal-title" id="application-modalLabel">Informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h4 class="text-center">User info</h4>
                <div class="row">
                  <div class="col-md-5">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                          <img src="${app.user_image}" alt="user" class="rounded-circle" width="150">
                          <div class="mt-3">
                            <h4>${app.user.first_name} ${app.user.last_name}</h4>
                            <p class="text-secondary mb-1">Candidate</p>
                            <button class="btn btn-primary"><a class="text-white" href="${app.user_profile}">See profile</a></button>
                            <button class="btn btn-outline-primary">Message</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            ${app.user.first_name} ${app.user.last_name}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            ${app.user.email}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            ${app.user.phone}
                          </div>
                        </div>
                        <hr>`;
                        if(app.user.linkedin){
                          html += `<div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0">Linkedin</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                      <a href="${app.user.linkedin}" class="text-secondary">${app.user.linkedin}</a>
                                    </div>
                                  </div>
                                  <hr>`;
                        }
                        if(app.user.github){
                          html +=`<div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0">Github</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                      <a href="${app.user.github}" class="text-secondary">${app.user.github}</a>
                                    </div>
                                  </div>
                                  <hr>`;
                        }
                        if(app.user.portfolio_link){
                          html += `<div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0">Portfolio website</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                      <a href="${app.user.portfolio_link}" class="text-secondary">${app.user.portfolio_link}</a>
                                    </div>
                                  </div>
                                  <hr>`
                        }
                        
                        html +=`<div class="row">
                            <div class="col-sm-12">
                            <a class="btn btn-info" href="${app.userCV}" download>Download CV</a>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <h5 class="text-center">Candidate message</h5>
                          </div>
                        </div>
                        <hr>
                        <div class="row p-3">`;
                         if(app.message){
                           html += `${app.message}`;
                         }else{
                           html += `<h4>No message</h4>`
                         }
                        html += `</div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr />
                <h4 class="text-center">Application info</h4>
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Job title</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <a href="${app.job_url}" class="text-secondary">${app.job.title}</a>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Company</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <a href="${app.company_url}" class="text-secondary">${app.job.company.name}</a>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Seniority and city</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            ${app.seniority[app.job.seniority]}, ${app.job.city.name}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Applied at</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            ${app.applied_at}
                          </div>
                        </div>
                        <hr>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Status</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">`;
                            if(role == "Employer"){
                              html += `<input type="hidden" id="appId" name="appId" value="${app.id}">`
                              html += `<select class="form-control" name="changeStatus" id="changeStatus">`;
                                        for(let key in app.app_status){
                                          html +=`<option value="${key}"`;
                                          if(key == app.status){
                                            html += `selected`;
                                          }
                                          html +=`>${app.app_status[key]}</option>`;
                                        }
                              html += `</select>`;
                            }else{
                              html += `${app.app_status[app.status]}`
                            }
                          html+=`</div>
                        </div>
                        <hr>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>`;
  $("#application-dialog").html(html);
  $("#changeStatus").on("change",changeAppStatus);
}
function changeAppStatus(){
  let appStatus = $(this).val();
  let appId = $("#appId").val();
  
  $.ajax({
    url : "/options/applications/"+appId,
    method : "PATCH",
    data : {
      appStatus : appStatus,
      _token : token
    },
    success : function(data){
      makeNotification(0,"Success: ","Application status successfully changed.");
    },
    error : function(xhr){
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

function refreshJobs(e,page = 1){
  let pageType = $("#pageType").val();
  let keyword = $("#keyword").val();
  let techs = $("#ddlTech").val();
  let cities = $("#ddlCity").val();
  let areas = $("#ddlArea").val();
  let seniorites = $("#ddlSeniority").val();
  let sort = $("#ddlSort").val();
  let perPage = $("#ddlPerPage").val();
  

  data = {
    pageType : pageType,
    page : page
  };

  if(techs.length > 0){
    data.techs = techs
  }
  if(cities.length > 0){
    data.cities = cities
  }
  if(areas.length > 0){
    data.areas = areas
  }
  if(seniorites.length > 0){
    data.seniorites = seniorites
  }
  if(keyword){
    data.keyword = keyword
  }
  if(perPage){
    data.perPage = perPage
  }
 
  if(sort){
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url : "/options/jobs",
    method : "GET",
    data : data,
    success : function(data){
      console.log(data)
      printJobs(data.jobs);
      printJobsPagination(data);
    },
    error : function(xhr){
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error","Server error loading jobs, please try again later.");
          break;
      }
    }
    
  })
}
function printJobs(jobs){
  html = ``;
  for(let j of jobs){
    html += `<li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
              <a href="job-single.html"></a>

              <div class="job-listing-logo col-md-3">
                <a href="${j.company_details}" target="_blank" rel="noopener noreferrer">
                  <img src="${j.companyLogo}" alt="${j.company.logo_image.alt}" class="img-fluid">
                </a>
              </div>

              <div class="col-md-9">

                <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                    <div class="job-listing-position custom-width w-75 mb-3 mb-sm-0">
                      <h2> <a href="${j.job_details}" class="text-black">${j.title}</a> </h2>
                      <strong><a href="${j.company_details}" class="text-secondary mt-4">${j.company.name}</a></strong> <span> / </span> <span class="icon-room"></span> ${j.city.name}
                    </div>
                    <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                      
                    </div>
                    <div class="job-listing-meta ">
                      <span class="badge badge-danger">${j.emp_status}</span>
                    </div>

                </div>
                <div class="col-md-12 d-flex justify-content-between">
                  <div class="tags">`;
                  if(j.technologies.length > 0){
                    for(let t of j.technologies){
                      html+=`<span class="badge badge-info mx-1">${t.name}</span>`;
                    }
                  }
                  html += `</div>
                    
                  <div class="expire-date ml-4">
                    <p>Days left: ${j.deadline_formated}</p>
                  </div>
                </div>
              </div>
            </li>`;
  }
  $("#jobs").html(html);
}
function printJobsPagination(data){
  html = `<a href="#" id="prevPage" class="prev jobPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage-1}">Prev</a>`;
  for(let p=1; p<=data.totalPages; p++){
    html+= `<a href="#" class="jobPage ${p == data.curentPage ? 'active' : ''}" data-id="${p}">${p}</a>`;
  }
  html += `<a href="#" id="nextPage" class="next jobPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage+1}">Next</a>`
  $("#jobsPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip+data.jobs.length-1} Of ${data.totalJobs} Jobs`);
  $(".jobPage").on("click",function(e){
    e.preventDefault();
    let page = $(this).data("id");
    refreshJobs(e,page);
  })
  $("#totalJobsTitle").html(`${data.totalJobs} Job Found`)
}


function deleteCompany() {

  let companyId = $(this).data("id");
  
  $.ajax({
    url : "/options/companies/"+companyId,
    method : "DELETE",
    data : {
      _token : token
    },
    success : function(data) {
      console.log(data);
      makeNotification(0,"Success: ","Company successfully deleted.");
      refreshCompanies();
    },
    error : function(xhr,status,error) {
      console.log(xhr);
      makeNotification(1,"Error: ",xhr.responseJSON.message);
    }
  })
}

function refreshCompanies(e,page = 1) {
  let sort = $("#ddlSort").val();
  let keyword = $("#keyword").val();
  let city = $("#ddlCity").val();
  let rating = $("#ddlRating").val();
  let perPage = $("#ddlPerPage").val();

 
  data = {
    perPage : perPage,
    page : page
  };

  if(keyword){
    data.keyword = keyword;
  }
  if(city){
    data.city = city;
  }
  if(rating){
    data.rating = rating;
  }
  if(sort){
    let sortValues = sort.split("-");
    data.orderBy = sortValues[0];
    data.order = sortValues[1];
  }

  $.ajax({
    url : "/options/companies",
    method : "GET",
    data : data,
    success : function(data){
      console.log(data);
      printCompanies(data.data.companies)
      printCompaniesPagination(data.data);
    },
    error : function(xhr){
      switch(xhr.status){
        case 500:
          makeNotification(1,"Error","Server error loading companies, please try again later.");
          break;
      }
    }
  })
}
function printCompanies(data) {
  let html = ``;
  for(let c of data){
    html += `<div class="col-md-4 p-2">
          
                <div class="card col-md-12">

                  <div class="card-body p-1">
                    <div class="d-flex justify-content-around">
                      <div class="col-md-3 p-0">
                        <a href="${c.company_details}" class="text-reset text-decoration-none" target="_blank">
                          <img class="card-img-top img-fluid" src="${c.logo_image_src}" alt="${c.logo_image_alt}">
                        </a>
                      </div>
                      <div class="col-md-9 d-flex align-items-center justify-content-center">
                        <a href="${c.company_details}" class="text-reset text-decoration-none" target="_blank"><h5 class="card-title ">${c.name}</h5></a>
                      </div>
                      
                    </div>
                  </div>
                  <ul class="list-group list-group-flush company-info">
                    <li class="list-group-item d-flex justify-content-between">
                      <p class="m-0">
                        Rating: ${c.printed_stars} (${c.vote})
                      </p>
                      <p class="m-0">Comments: ${c.comments_count}</p> 
                    </li>
                    <li class="list-group-item">Head office: ${c.city.name}</li>
                    <li class="list-group-item company-web">Web: <a href="${c.website}" target="_blank" rel="noopener noreferrer" class="text-secondary">${c.website ? c.website.split("//")[1] : "-"}</a></li>
                  </ul>
                  <div class="my-2 text-center">
                    <a href="${c.company_details}" target="_blank" class="btn btn-info my-2 text-white">See details</a>
                  </div>

                </div>
              </div>`;
  }
  $("#companies").html(html);
}
function printCompaniesPagination(data){
  let html = `<a href="#" id="prevPage" class="prev companyPage btn-link ${data.prevPage ? "" : "disabled"}" data-id="${data.curentPage-1}">Prev</a>`;
  for(let p=1; p<=data.totalPages; p++){
    html+= `<a href="#" class="companyPage ${p == data.curentPage ? 'active' : ''}" data-id="${p}">${p}</a>`;
  }
  html += `<a href="#" id="nextPage" class="next companyPage btn-link ${data.nextPage ? "" : "disabled"}" data-id="${data.curentPage+1}">Next</a>`
  $("#companiesPagination").html(html);
  $("#paginationInfo").html(`Showing ${data.skip}-${data.skip+data.companies.length-1} Of ${data.totalCompanies} Companies`);
  $(".companyPage").on("click",function(e){
    e.preventDefault();
    let page = $(this).data("id");
    refreshCompanies(e,page);
  })
  $("#totalJobsTitle").html(`${data.totalJobs} Job Found`)
}
