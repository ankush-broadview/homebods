 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body-formt {

            background-color: black !important;
            color: white;
            align-content: center;
        }
        #step2{
            display:none;
        }
    </style>


    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="body-formt">
    <div class="container">
<div class="row">
        <div class="col-md-4"></div>
       
        <div class="col-md-4">
            <form> 
                <div id="step2">
                <div class="form-group mb-3 mt-3">
                    <div class="text-center">
                        <img style="height: 20vh;" class="rounded-circle" src="http://localhost/homebods/assets/images/services/company_74315.png" alt="homebods">
                        <h3>Let's Grind!</h3>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" placeholder="Enter Phone">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" placeholder="Enter Address">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" placeholder="Enter City">
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" placeholder="Enter State">
                </div>
                <div class="mb-3">
                    <label class="form-label">Zip</label>
                    <input type="text" class="form-control" placeholder="Enter Zip">
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" placeholder="Enter Country">
                </div>
                <div class="mb-3">
                    </div>

                <div class="text-center"> 
                <button type="button" id="form2" class="btn btn-secondary" onclick="nextform(this.id)">Back</button>    
                <button type="button" class="btn btn-primary">Submit</button>
                
                </div>
                </div>
                

            </form>



        </div>
        <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>