<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>



       


</section>

<section class="reviews" id="reviews">

    <h1 class="title">Programmer</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/396658220_1439572533263054_8535521977937471961_n.jpg" alt="">
            <p>Hello! My name is Christian Mangao, and I am a third-year college student at Don Mariano Marcos Memorial State University - South La Union Campus (DMMMSU-SLUC). I am 18 years old and currently pursuing a degree in Computer Science.

As a budding programmer, I am passionate about technology and coding. Over the past few years, I have developed a strong foundation in various programming languages and technologies, and I am eager to further enhance my skills and knowledge in the field of computer science.

Through my academic journey and hands-on projects, I aim to contribute to innovative solutions and advance my understanding of the ever-evolving tech industry. I look forward to exploring new opportunities and challenges as I continue to grow as a programmer.

</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Christian Mangao</h3>
        </div>

        <div class="box">
            <img src="images/pic-2.png" alt="">
            <p>Hello! My name is Angelica Datangel, an 25-year-old third-year Computer Science student at Don Mariano Marcos Memorial State University - South La Union Campus (DMMMSU-SLUC). My passion for technology and programming began in high school and has only grown stronger over the years.

At DMMMSU-SLUC, I've honed my skills in various programming languages and technologies. Under the guidance of Christian Mangao, my leader in programming, I've gained invaluable insights and significantly enhanced my technical abilities.

I am particularly interested in software development, artificial intelligence, and cybersecurity. I look forward to using my skills to develop innovative solutions that address real-world challenges and make a positive impact in the tech industry.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Angelica Datangel</h3>
        </div>

     
        
    </div>

</section>











<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>