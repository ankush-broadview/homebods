<div id="step1">
   <form id="step1Form">
    <div class="form-group mb-3">
        <label class="form-label">First Name</label>
        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-control" name="last_name" id="last_name"  placeholder="Enter Last Name">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Homebod User ID</label>
        <input type="text" class="form-control" name="grinder_user_id" id="grinder_user_id" placeholder="Enter Homebod User ID">
        <label for="grinder_user_id" style="display: none;" id="grinder_user_id_exist" generated="true" class="error">User ID Already Exist</label>
         </label>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" name="client_email" id="client_email" placeholder="Enter Email">
        <label for="client_email" style="display: none;" id="client_email_exist" generated="true" class="error">Email ID Already Exist</label>
           	</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Bio/Fitness Goal</label>
        <input type="text" class="form-control" id="fitness_goal" name="fitness_goal" placeholder="Enter Bio/Fitness Goal">
    </div>
    
   
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"  name="client_password" id="client_password" class="form-control" placeholder="Enter Password">
    </div>
    <div class="mb-3">
        <label class="form-label">Re-enter Password</label>
        <input type="password" name="client_repassword"  id="client_repassword" class="form-control" placeholder="Re-enter Password">
    </div>
     
    
    <div class="mb-3">
        <button type="button" class="form-control btnnext" onclick="nextform(this.id)" id="form1" >Next</button>
    </div>
    </form>
</div>