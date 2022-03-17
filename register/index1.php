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
       
        .select2-container{
            display: block !important;
        }
        .select2-results__option {
            color: #495057 !important;
        }
        .select2-container--default .select2-selection--single{
            padding: .375rem .75rem !important;
            height: auto !important; 
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 9px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            color: #495057 !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered{
            padding-left: 0 !important;
        }
        #step2{
             display:none; 
        }
        .h3 ,h3{
            padding-top:15px;
        }
       .btnback{
            background-color:#686868 !important;
            color:white !important;
            border:0vh !important;
       }
       .btnsubmit{
            background-color:#9900cc !important;
            color:white !important;
            border:0vh !important;
            margin-top: -1px !important;
       }
       .btnnext{
            background-color:#9900cc !important;
            color:white !important;
            border:0vh !important;
        }

        .hide{
            display: none !important;
        }


    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="http://localhost/homebods/assets/select2.css" rel="stylesheet" />
    <script src="http://localhost/homebods/assets/select2.js"></script>

</head>

<body class="body-formt">
    <div class="container">
<div class="row">
        <div class="col-md-3"></div>
       
        <div class="col-md-6">
            <form>

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
            </form>

            </div>
            <div class="col-md-3"></div>
            </div>
            </div>
</body>

</html>