<?php 
include('../template/header.php');
include('../template/footer.php')
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        Quiz Ajax
    </title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:200,300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="public/assets/css/main.css">
    <link rel="stylesheet" href="public/assets/css/index.css">
</head>
<body>
    <?php generateIndexHeader2(); ?>
    <div class="container text-center">
            <h1>Quizz Game</h1>
        </div>

        <div class="container pading-top">
            <div class="container pading-top"></div>

            <div class="row margin-top">
                <div class="col-lg-4 col-md-6 col-sm-12" id=col-1>
                    <h2 class="text-center"><i class="fa fa-home fa-2x" aria-hidden="true"></i></h2>  Welcome To Our Simple Quizz Game 
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12" id=col-2>
                    <h2 class="text-center">
                        <i class="fa fa-database fa-2x" aria-hidden="true"></i>
                    </h2>
                    Fully Supporting Database
                </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 " id=col-3>
                        <h2 class="text-center"><i class="fa fa-gamepad fa-2x" aria-hidden="true"></i></h2>
                        Enjoy An Entertaining Quizz Moment 
                    </div>
            </div>
        </div>

   
</body>
<footer>
    <?php footernavigator();?>
</footer>
</html> 
