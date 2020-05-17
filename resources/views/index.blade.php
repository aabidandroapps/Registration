@include('include.header')
<body>
  <div class="image-container set-full-height" style="background-image: url('http://demos.creative-tim.com/material-bootstrap-wizard/assets/img/wizard-book.jpg')">




    <!--   Big container   -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-sm-offset-2">
          <!-- Wizard container -->
          <div class="wizard-container ">
            <div class="card wizard-card" data-color="red" id="wizard">
              <form action="" method="">
                <div class="wizard-header">
                  <h3 class="wizard-title">
                    Registration
                  </h3>
                  <h5>This information will let us know more about you.</h5>
                </div>
                <div class="wizard-navigation">
                  <ul>
                    <li><a href="#details" data-toggle="tab">User Details</a></li>
                    <li><a href="#otp" data-toggle="tab">OTP</a></li>
                  </ul>
                </div>

                <div class="tab-content">
                  <div class="tab-pane" id="details">
                    <div class="row">
                      <div class="col-sm-12">
                        <h4 class="info-text"> Let's start with the basic details.</h4>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="material-icons">account_circle</i>
                          </span>
                          <div class="form-group label-floating">
                            <label class="control-label">Your Username</label>
                            <input name="user" type="text" class="form-control">
                          </div>
                        </div>



                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="material-icons">lock_outline</i>
                          </span>
                          <div class="form-group label-floating">
                            <label class="control-label">Your Password</label>
                            <input name="password" type="password" class="form-control">
                          </div>
                        </div>

                      </div>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="material-icons">email</i>
                          </span>
                          <div class="form-group label-floating">
                            <label class="control-label">Your Email</label>
                            <input name="email" type="text" class="form-control">
                          </div>
                        </div>

                        <!-- <div class="input-group">
                          <span class="input-group-addon">
                            <i class="material-icons">lock_outline</i>
                          </span>
                          <div class="form-group label-floating">
                            <label class="control-label">Your Confirm Password</label>
                            <input name="c_pass" type="password" class="form-control">
                          </div>
                        </div> -->
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="otp">
                    <h4 class="info-text">Enter OTP Here </h4>
                    <div class="row">
                      <div class="col-sm-10 col-sm-offset-1">
                        
                        <div class="col-sm-10 offset-4">
                          <div class="input-group">
                          <span class="input-group-addon">
                            <i class="material-icons">edit</i>
                          </span>
                          <div class="form-group label-floating">
                            <label class="control-label">Your OTP</label>
                            <input name="otp" type="text" class="form-control">
                          </div>
                        </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="wizard-footer">
                  <div class="pull-right">
                    <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' id="next" name='next' value='Next' />
                    <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' id="finish" name='finish' value='Finish' />
                  </div>
                  <div class="pull-left">
                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />

                    
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div> <!-- wizard container -->
        </div>
      </div> <!-- row -->
    </div> <!--  big container -->

    
 </div>
</body>

</html>
<script>
    if ($(".wizard-card form").length > 0) {
        $(".wizard-card form").validate({
 
            rules: {
                user: {
                    required: true,
                    minlength: 5
                },
 
                email: {
                    required: true,
                    email: true,
                    remote: {
                    type: 'POST',
                    url: '{{url("/CheckEmail")}}',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {id:$('[name="email"]').val(),"_token": "{{ csrf_token() }}"},
                  }
                },
 
                password: {
                    required: true,
                    maxlength: 8,
                    minlength: 8,
                    uppercase: true,
                },
 
                otp: {
                    required: true,
                    maxlength: 6,
                },
            },
            messages: {
 
                name: {
                    required: "Please enter name",
                },
                email: {
                    required: "Please enter valid email",
                    email: "Please enter valid email",
                    remote: 'Email already exists',
                },
                password: {
                    required: "Please enter password",
                    maxlength: "Please enter only 8 character",
                    minlength: "Please enter altest 8 character",
                },
                otp: {
                    required: "Please enter password",
                    maxlength: "Please enter 6 digit otp",
                },
 
            },
        })
    } 
    jQuery.validator.addMethod("uppercase", function(value, element) {
  return this.optional(element) || /[A-Z]/.test(value);
}, "The password should have a Capital letter"); 

$("#next").click(function(ev){
  if($('.wizard-card form').valid()){
    $.ajax({
               type: 'POST',
               url: '{{url("/StoreUser")}}',
               dataType: 'json',
               headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
               data: {user:$('[name="user"]').val(),
                      email:$('[name="email"]').val(),
                      password:$('[name="password"]').val(),
                      "_token": "{{ csrf_token() }}"},

               success: function (data) {        
               },
               
    });

  }

    
});
$("#finish").click(function(ev){
  if($('.wizard-card form').valid()){
    $.ajax({
               type: 'POST',
               url: '{{url("/Checkotp")}}',
               dataType: 'json',
               headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
               data: {email:$('[name="email"]').val(),
                      otp:$('[name="otp"]').val(),
                      "_token": "{{ csrf_token() }}"},

               success: function (data) { 
                if(data == "success"){
              swal({
                  title: "Good job!",
                  text: "OTP verified successfully!",
                  icon: "success",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }). then(function(result){
                  window.location = "{{ url('/') }}";
                             });
                } 

                if(data == "false"){
                  swal({
                  title: "Something went wrong!",
                  text: "OTP not matched!",
                  icon: "error",
                  button: "OK",
                });
                }
                      
               },
               
    });
  }
    
});
 </script>