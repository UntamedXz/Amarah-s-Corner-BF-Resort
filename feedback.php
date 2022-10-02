<!DOCTYPE html>    
<html>    
<head>    
<meta name="viewport" content="width=device-width, initial-scale=1">    
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/backup.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

<style>   
body {
  margin: 0;
  padding: 0;
  background: url("./assets/images/feedbackbg.png");
  background-size: cover;
  padding-bottom: 100px;
  font-family: Poppins;
  
}

#contact {
  width: 100%;
  height: 100%;
}

.section-header {
  text-align: center;
  margin-top: 50px;
  padding: 8px;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 6px;
  background: black;
  border-radius: 10px
}

.contact-wrapper {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  margin: 0 auto;
  padding: 20px;
  position: relative;
  max-width: 840px;
}

/* Left contact page */
.form-horizontal {
  /*float: left;*/
  max-width: 400px;
  font-family: 'Lato';
  font-weight: 400;
}

.form-control, 
textarea {
  max-width: 400px;
  background-color: #000;
  color: #fff;
  letter-spacing: 1px;
}

.send-button {
  margin-top: 15px;
  height: 34px;
  width: 400px;
  overflow: hidden;
  color: black;
  background-color: #ffaf08;
}

.send-text {
  color: black;
  margin-top: 5px;
}

.send-button:hover {
  color: #ffaf08;
  background-color: black;
  border: 1px solid white;
}

/* Begin Right Contact Page */
.direct-contact-container {
  max-width: 400px;
}

/* Location, Phone, Email Section */
.contact-list {
  list-style-type: none;
  margin-left: -30px;
  padding-right: 20px;
}

.list-item {
  line-height: 4;
  color: #ffaf08;
}

.contact-text {
  font: 300 18px 'Lato', sans-serif;
  letter-spacing: 1.9px;
  color: #ffaf08;;
}

.place {
  margin-left: 62px;
  color: #ffaf08;;
}

.phone {
  margin-left: 56px;
  color: #ffaf08;;
}

.gmail {
  margin-left: 53px;
  color: #ffaf08;;
}

.contact-text a {
    color: #ffaf08;
  text-decoration: none;
  transition-duration: 0.2s;
}

.contact-text a:hover {
  color: #fff;
  text-decoration: none;
}


/* Social Media Icons */
.social-media-list {
  position: relative;
  font-size: 22px;
  text-align: center;
  width: 100%;
  margin: 0 auto;
  padding: 0;
  color: #ffaf08;
}

.social-media-list li a {
  color: black;
}

.social-media-list li {
  position: relative; 
  display: inline-block;
  height: 60px;
  width: 60px;
  margin: 10px 3px;
  line-height: 60px;
  border-radius: 50%;
  color: black;
  background-color: #ffaf08;
  cursor: pointer; 
  transition: all .2s ease-in-out;
}

.social-media-list li:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 60px;
  height: 60px;
  line-height: 60px;
  border-radius: 50%;
  opacity: 0;
  box-shadow: 0 0 0 1px #fff;
  transition: all .2s ease-in-out;
  
}

.social-media-list li:hover {
  background-color: black;
  color: #ffaf08;
}

.social-media-list li:hover:after {
  opacity: 1;  
  transform: scale(1.12);
  transition-timing-function: cubic-bezier(0.37,0.74,0.15,1.65);
}

.social-media-list li:hover a {
    color: #ffaf08;
}

.copyright {
  font: 200 14px 'Oswald', sans-serif;
  color: #555;
  letter-spacing: 1px;
  text-align: center;
}

hr {
  border-color: rgba(255,255,255,.6);
}

/* Begin Media Queries*/
@media screen and (max-width: 850px) {
  .contact-wrapper {
    display: flex;
    flex-direction: column;
  }
  .direct-contact-container, .form-horizontal {
    margin: 0 auto;
  }  
  
  .direct-contact-container {
    margin-top: 60px;
    max-width: 300px;
  }    
  .social-media-list li {
    height: 60px;
    width: 60px;
    line-height: 60px;
  }
  .social-media-list li:after {
    width: 60px;
    height: 60px;
    line-height: 60px;
  }
}

@media screen and (max-width: 569px) {

  .direct-contact-container, .form-wrapper {
    float: none;
    margin: 0 auto;
  }  
  .form-control, textarea {
    
    margin: 0 auto;
  }
 
  
  .name, .email, textarea {
    width: 280px;
  } 
  
  .direct-contact-container {
    margin-top: 60px;
    max-width: 280px;
  }  
  .social-media-list {
    left: 0;
  }
  .social-media-list li {
    height: 55px;
    width: 55px;
    line-height: 55px;
    font-size: 2rem;
  }
  .social-media-list li:after {
    width: 55px;
    height: 55px;
    line-height: 55px;
  }
  
}

@media screen and (max-width: 410px) {
  .send-button {
    width: 99%;
  }
}

.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #ffaf08;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
 .rateus{
  color: white;
 }
</style>    
</head>    
<body>    

<div id="preloader"></div>

<?php include './includes/navbar.php';?>

<section id="contact">
  
  <h1 class="section-header">FEEDBACK</h1>
  
  <div class="contact-wrapper">
  
  <!-- Left contact page --> 
    
    <form id="contact-form" class="form-horizontal" role="form">
       
      <div class="form-group">
        <div class="col-sm-12">
          <input type="text" class="form-control" id="name" placeholder="NAME" name="name" value="" required>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <input type="email" class="form-control" id="email" placeholder="EMAIL" name="email" value="" required>
        </div>
      </div>


      <textarea class="form-control" rows="10" placeholder="WRITE YOUR FEEDBACK" name="message" required></textarea>

      <div class="form-group">
        <div class="col-sm-12">
        <h2 class="rateus">RATE US</h2>
        <div class="rate">
         <input type="radio" id="star5" name="rate" value="5" />
         <label for="star5" title="text">5 stars</label>
         <input type="radio" id="star4" name="rate" value="4" />
         <label for="star4" title="text">4 stars</label>
         <input type="radio" id="star3" name="rate" value="3" />
         <label for="star3" title="text">3 stars</label>
         <input type="radio" id="star2" name="rate" value="2" />
         <label for="star2" title="text">2 stars</label>
         <input type="radio" id="star1" name="rate" value="1" />
         <label for="star1" title="text">1 star</label>
         </div>
        </div>
      </div>
      
      <button class="btn btn-primary send-button" id="submit" type="submit" value="SEND">
        <i class="fa fa-paper-plane"> SEND FEEDBACK</i>
   
      
      </button>
      
    </form>
    
  <!-- Left contact page --> 
    
      <div class="direct-contact-container">

        <ul class="contact-list">
          <li class="list-item"><i class="fa fa-map-marker fa-2x"><span class="contact-text place">Las Pinas City</span></i></li>
          
          <li class="list-item"><i class="fa fa-phone fa-2x"><span class="contact-text phone"><a href="tel:1-212-555-5555" title="Give me a call">111-1111</a></span></i></li>
          
          <li class="list-item"><i class="fa fa-envelope fa-2x"><span class="contact-text gmail"><a href="mailto:#" title="Send me an email">amarah@gmail.com</a></span></i></li>
          
        </ul>

        <hr>
        <ul class="social-media-list">
          <li><a href="https://web.facebook.com/amarahscornerbf?_rdc=1&_rdr" target="https://web.facebook.com/amarahscornerbf?_rdc=1&_rdr" class="contact-icon">
            <i class="fa-brands fa-facebook" aria-hidden="true"></i></a>
          </li>
          <li><a href="#" target="_blank" class="contact-icon">
            <i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
          </li>
          <li><a href="#" target="_blank" class="contact-icon">
            <i class="fa-brands fa-twitter" aria-hidden="true"></i></a>
          </li>    
        </ul>
        <hr>

        <div class="copyright">&copy; ALL OF THE RIGHTS RESERVED</div>

      </div>
    
  </div>
  
</section>  
  
<?php include './includes/cart-count.php'?>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>
    <script src="./assets/js/script.js"></script>
    <script>
        var loader = document.getElementById("preloader");

        window.addEventListener("load", function () {
            loader.style.display = "none";
        })
    </script>
<script>
    
    document.querySelector('#contact-form').addEventListener('submit', (e) => {
    e.preventDefault();
    e.target.elements.name.value = '';
    e.target.elements.email.value = '';
    e.target.elements.message.value = '';
  });

</script>
    
</body>    
</html>    