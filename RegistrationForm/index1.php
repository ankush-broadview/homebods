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
        #setep2 { display: none; }
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
        <!-- <div class="col-md-3"></div>
       
        <div class="col-md-6">
            <form> -->

            <?php 
            include 'step1.php';
            include 'step2.php';
            ?>
           

            <script>
                    function nextform(id){
                
                        if (id=="form1"){
                            step1.style.display = "none";
                            step2.style.display = "block";
                        }
                        if(id=="form2"){
                            step2.style.display = "none";
                            step1.style.display = "block";
                        }

                  
            }
            </script>
 <!-- </form>

</div>
<div class="col-md-3"></div> -->
</div>
</div>
</body>

</html>