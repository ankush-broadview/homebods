<div id="step1">   
    <div class="form-group mb-3">
        <label class="form-label">First Name</label>
        <input type="text" class="form-control" name="first_name" maxlength=20 id="first_name" placeholder="Enter First Name">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-control" name="last_name" id="last_name" maxlength=20  placeholder="Enter Last Name">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control"  name="staff_email" id="staff_email" placeholder="Enter Email">
        <label for="staff_email" style="display: none;" id="staff_email_exist" generated="true" class="error">Email ID Already Exist</label>
           	</label>
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Fitness Pro User ID</label>
        <input type="text" class="form-control" name="staff_user_id" id="staff_user_id"  placeholder="Enter Fitness User ID">
        <label for="staff_user_id" style="display: none;" id="staff_user_id_exist" generated="true" class="error">User ID Already Exist</label>
         </label>
    </div>
   
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="staff_password" id="staff_password" class="form-control" placeholder="Enter Password">
    </div>
    <div class="mb-3">
        <label class="form-label">Re-enter Password</label>
        <input type="password" name="staff_repassword"  id="staff_repassword" class="form-control" placeholder="Re-enter Password">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Bio/Services Offered</label>
        <input type="text" class="form-control" name="staff_bio" id="staff_bio" placeholder="Enter Bio/Services">
    </div>

    <div class="form-group mb-3">
        <label class="form-label">Custom Rate</label>
        <input  maxlength="8" class="form-control"  onkeypress="return isNumberKey(event,this);"   type="text" placeholder="Enter Custom Rate" name="custom_rate" id="custom_rate" />
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Single Customer Rate</label>
        <input type="text" class="form-control"  placeholder="Enter Single Custom Rate" onkeypress="return isNumberKey(event,this);"  maxlength="8"  name="single_customer_rate" id="single_customer_rate" />
    </div>



    <div class="form-group mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="staff_phone"  onkeypress="return onlyNumberKey(event)"  maxlength=10 id="staff_phone" class="form-control" placeholder="Enter Phone">
    </div>
    
    <div class="mb-3">
        <button type="button" class="form-control btnnext staff_register_front" id="form1" >Next</button>
    </div>
    
</div><script>
    
    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>