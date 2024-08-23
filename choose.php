

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>

<img class="wave" src="imgBG/wave.png">
    <div class="container">
        <div class="img">
            <img src="imgBG/bg.svg">  
        </div>
        
<section class="form-container">

   <form action="" method="post" id="loginForm" class="login-content" >
   
   <h3>login now</h3>
   
      <input type="submit" class="btn" name="submit" value="login now"  onclick="goToSignUp()">
      <input type="submit" class="btn" name="submit" value="Signup" >
      
   </form>

</section>
<script type="text/javascript" src="choose.js"></script>
    <script>
        function goToSignUp() {
            document.getElementById("loginForm").action = "login.php";
            document.getElementById("loginForm").submit();
        }
        const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});
    </script>
</body>
</html>
