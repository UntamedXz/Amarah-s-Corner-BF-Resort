<?php 
session_start();
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    header("Location: ./login");
} else {
    $admin_id = $_SESSION['admin_id'];
}
require_once '../includes/database_conn.php';

$get_admin_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

$info = mysqli_fetch_array($get_admin_info);

$userProfileIcon = $info['profile_image'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/admin.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

   <!-- Montserrat Font -->
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">

<title>Admin Dashboard</title>

<STYLE>

body {
  margin: 0;
  padding: 0;
  background-color: #1d2634;
  color: #9e9ea4;
  font-family: "Montserrat", sans-serif;
}

.material-icons-outlined {
  vertical-align: middle;
  line-height: 1px;
  font-size: 35px;
}

.grid-container {
  display: grid;
  grid-template-columns: 10px 1fr 1fr 1fr;
  grid-template-rows: 0.2fr 3fr;
  grid-template-areas:
    "sidebar header header header"
    "sidebar main main main";
  height: 100vh;
}

/* ---------- MAIN ---------- */

.main-container {
  grid-area: main;
  overflow-y: auto;
  padding: 20px 20px;
  color: rgba(255, 255, 255, 0.95);
}

.main-title {
  display: flex;
  justify-content: space-between;
  color: black;
}

.main-cards {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 20px;
  margin: 20px 0;
}

.card {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  padding: 25px;
  border-radius: 5px;
  color: #ffaf08;
}

.card:first-child {
  background-color: black;
}

.card:nth-child(2) {
  background-color: black;
}

.card:nth-child(3) {
  background-color: black;
}

.card:nth-child(4) {
  background-color: black;
}

.card-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.card-inner > .material-icons-outlined {
  font-size: 45px;
}

.charts {
  display: grid;
  grid-template-columns: 1fr 1fr 2fr;
  gap: 20px;
  margin-top: 20px;
}

.charts-card {
  background-color: black;
  margin-bottom: 20px;
  padding: 20px;
  box-sizing: border-box;
  -webkit-column-break-inside: avoid;
  border-radius: 5px;
  box-shadow: 0 6px 7px -4px rgba(0, 0, 0, 0.2);
}

.chart-title {
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffaf08;
}

/* ---------- MEDIA QUERIES ---------- */

/* Medium <= 992px */

@media screen and (max-width: 560px) {
  .grid-container {
    grid-template-columns: 1fr;
    grid-template-rows: 0.05fr;
  }

  .menu-icon {
    display: inline;
  }

  .sidebar-title > span {
    display: inline;
  }
}

/* Small <= 768px */

@media screen and (max-width: 768px) {
  .main-cards {
    grid-template-columns: 1fr;
    gap: 10px;
    margin-bottom: 0;
  }

  .charts {
    grid-template-columns: 1fr;
    margin-top: 30px;
  }
}

/* Extra Small <= 576px */

@media screen and (max-width: 576px) {
  .hedaer-left {
    display: none;
  }
}

ul {
	list-style-type: none;
	margin: 0;
	padding-left: 0;
}

h1 {
	font-size: 23px;
}

h2 {
	font-size: 17px;
}

p {
	font-size: 15px;
}

a {
	text-decoration: none;
	font-size: 15px;
}
	a:hover {
		text-decoration: none;
	}
	.scnd-font-color {
		color: #9099b7;
	}
.titular {
display: block;
line-height: 60px;
margin: 0;
text-align: center;
border-top-left-radius: 5px;
border-top-right-radius: 5px;
}
.horizontal-list {
	margin: 0;
	padding: 0;
	list-style-type: none;
}
	.horizontal-list li {
		float: left;
	}
		.block {
			margin: 25px 25px 0 0;
			background: #394264;
			border-radius: 5px;
      float: left;
      width: 300px;
      overflow: hidden;
		}
		/******************************************** LEFT CONTAINER *****************************************/
		.left-container {}
			.menu-box {
				height: 100%;
			}

			.donut-chart-block {
				overflow: hidden;
                width: 100%;
                background: black;
			}
				.donut-chart-block .titular {
					padding: 10px 0;
				}
				.os-percentages li {
					width: 100%;
					border-left: 1px solid #394264;
					text-align: center;					
					background: #50597b;
				}
					.os {
						margin: 0;
						padding: 10px 0 5px;
						font-size: 15px;		
					}
						.os.ios {
							border-top: 4px solid #FFBF00;
						}
						.os.mac {
							border-top: 4px solid #E1C16E;
						}
						.os.linux {
							border-top: 4px solid #8B8000;
						}
						.os.win {
							border-top: 4px solid #E49B0F;
						}
					.os-percentage {
						margin: 0;
						padding: 0 0 15px 10px;
						font-size: 25px;
					}
			.line-chart-block, .bar-chart-block {
				width: 100%;
			}
				.line-chart {
					height: 200px;
					background: black;
				}
				.time-lenght {
					padding-top: 22px;
					padding-left: 38px;
                    justify-content: center;
          overflow: hidden;
				}
					.time-lenght-btn {
						display: block;
						width: 100px;
						line-height: 32px;
                        background: #ffaf08;
						border-radius: 5px;
						font-size: 14px;
						text-align: center;
						margin-right: 5px;
                        color: black;
					}
						.time-lenght-btn:hover {
							text-decoration: none;
							color: #ffaf08;
                            background: black;
						}
				.month-data {
					padding-top: 28px;
				}
					.month-data p {
						display: inline-block;
						margin: 0;
						padding: 0 25px 15px;            
						font-size: 16px;
					}
						.month-data p:last-child {
							padding: 0 25px;
              float: right;
							font-size: 15px;
						}
						.increment {
							color: #e64c65;
						}

/******************************************
↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓
↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ 
******************************************/

.grafico {
  padding: 2rem 1rem 1rem;
  width: 100%;
  height: 100%;
  position: relative;
  color: #fff;
  font-size: 80%;
}
.grafico span {
  display: block;
  position: absolute;
  bottom: 3rem;
  left: 2rem;
  height: 0;
  border-top: 2px solid;
  transform-origin: left center;
}
.grafico span > span {
  left: 100%; bottom: 0;
}
[data-valor='25'] {width: 75px; transform: rotate(-45deg);}
[data-valor='8'] {width: 24px; transform: rotate(65deg);}
[data-valor='13'] {width: 39px; transform: rotate(-45deg);}
[data-valor='5'] {width: 15px; transform: rotate(50deg);}
[data-valor='23'] {width: 69px; transform: rotate(-70deg);}
[data-valor='12'] {width: 36px; transform: rotate(75deg);}
[data-valor='15'] {width: 45px; transform: rotate(-45deg);}

[data-valor]:before {
  content: '';
  position: absolute;
  display: block;
  right: -4px;
  bottom: -3px;
  padding: 4px;
  background: #fff;
  border-radius: 50%;
}
[data-valor='23']:after {
  content: '+' attr(data-valor) '%';
  position: absolute;
  right: -2.7rem;
  top: -1.7rem;
  padding: .3rem .5rem;
  background: #50597B;
  border-radius: .5rem;
  transform: rotate(45deg);  
}
[class^='eje-'] {
  position: absolute;
  left: 0;
  bottom: 1.5rem;
  width: 100%;
  padding: 1rem 1rem 0 2rem;
  height: 80%;
}
.eje-x {
  height: 0.05rem;
}
.eje-y li {
  height: 22%;
  border-top: 1px solid #777;
}
[data-ejeY]:before {
  content: attr(data-ejeY);
  display: inline-block;
  width: 2rem;
  text-align: right;
  line-height: 0;
  position: relative;
  left: -2.5rem;
  top: -.5rem;
} 
.eje-x li {
  width: 8%;
  float: left;
  text-align: center;
}

/******************************************
PIE CHART
******************************************/
.donut-chart {
  position: relative;
	width: 200px;
  height: 200px;
	margin: 0 auto 2rem;
	border-radius: 100%
 }
p.center-date {
  background: black;
  position: absolute;
  text-align: center;
	font-size: 28px;
  top:0;left:0;bottom:0;right:0;
  width: 130px;
  height: 130px;
  margin: auto;
  border-radius: 50%;
  line-height: 35px;
  padding: 15% 0 0;
}
.center-date span.scnd-font-color {
 line-height: 0; 
}
.recorte {
    border-radius: 50%;
    clip: rect(0px, 200px, 200px, 100px);
    height: 100%;
    position: absolute;
    width: 100%;
  }
.quesito {
    border-radius: 50%;
    clip: rect(0px, 100px, 200px, 0px);
    height: 100%;
    position: absolute;
    width: 100%;
    font-family: monospace;
    font-size: 1.5rem;
  }
#porcion1 {
    transform: rotate(0deg);
  }

#porcion1 .quesito {
    background-color: #ffaf08;
    transform: rotate(76deg);
  }
#porcion2 {
    transform: rotate(76deg);
  }
#porcion2 .quesito {
    background-color: #ffaf08;
    transform: rotate(140deg);
  }
#porcion3 {
    transform: rotate(215deg);
  }
#porcion3 .quesito {
    background-color: #ffaf08;
    transform: rotate(113deg);
  }
#porcionFin {
    transform:rotate(-32deg);
  }
#porcionFin .quesito {
    background-color: #ffaf08;
    transform: rotate(32deg);
  }
.nota-final {
  clear: both;
  color: #4FC4F6;
  font-size: 1rem;
  padding: 2rem 0;
}
.nota-final strong {
  color: #E64C65;
}
.nota-final a {
  color: #FCB150;
  font-size: inherit;
}
/**************************
BAR-CHART
**************************/

            </STYLE>
</head>
<body>
<?php include 'top.php'; ?>
   
<div class="grid-container">


      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <h2>ADMIN DASHBOARD</h2>
        </div>

        <div class="main-cards">

        
        <div class="card">
            <div class="card-inner">
                <h3>SALES TODAY</h3>
                <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1>10,000</h1>
            </div>


          <div class="card">
            <div class="card-inner">
              <h3>PRODUCTS</h3>
              <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1>249</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>CATEGORIES</h3>
              <span class="material-icons-outlined">category</span>
            </div>
            <h1>25</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>CUSTOMERS</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <h1>1500</h1>
          </div>

        </div>

        <div class="charts">

            <div class="charts-card">
              <h2 class="chart-title">TOTAL INCOME</h2>
                <div id="bar-chart">
                  <div class="donut-chart-block block"> 
                   <div class="donut-chart">
                            <div id="porcion1" class="recorte"><div class="quesito ios" data-rel="21"></div></div>
                            <div id="porcion2" class="recorte"><div class="quesito mac" data-rel="39"></div></div>
                            <div id="porcion3" class="recorte"><div class="quesito win" data-rel="31"></div></div>
                            <div id="porcionFin" class="recorte"><div class="quesito linux" data-rel="9"></div></div>

                            <p class="center-date">YEAR<br><span class="scnd-font-color">2022</span></p>        
                    </div>
                    <ul class="os-percentages horizontal-list">
                        <li>
                            <p class="ios os scnd-font-color">OCTOBER</p>
                            <p class="os-percentage">450,980.00</p>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>

            <div class="charts-card">
                 <h2 class="chart-title">ORDER TODAY</h2>
                 <div id="bar-chart">
                  <div class="donut-chart-block block"> 
                   <div class="donut-chart">
                          
                            <p class="center-date">PIZZA<br><span class="scnd-font-color">2022</span></p>        
                    </div>
                    <ul class="os-percentages horizontal-list">
                        <li>
                            <p class="ios os scnd-font-color">CUSTOMERS TODAY</p>
                            <p class="os-percentage">25</p>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>

            <div class="charts-card">
                 <h2 class="chart-title">OVERALL SALES</h2>
                     <div id="bar-chart">
                         <div class="line-chart-block block">
                            <div class="line-chart">
                                <div class='grafico'>
                                <ul class='eje-y'>
                                    <li data-ejeY='120'></li>
                                    <li data-ejeY='90'></li>
                                    <li data-ejeY='60'></li>
                                    <li data-ejeY='30'></li>
                                    <li data-ejeY='0'></li>
                                </ul>
                                <ul class='eje-x'>
                                    <li>Jan</li>
                                    <li>Feb</li>
                                    <li>Mar</li>
                                    <li>Apr</li>
                                    <li>May</li>
                                    <li>Jun</li>
                                    <li>Jul</li>
                                    <li>Aug</li>
                                    <li>Sep</li>
                                    <li>Oct</li>
                                    <li>Nov</li>
                                    <li>Dec</li>
                                </ul>
                                    <span data-valor='25'>
                                    <span data-valor='8'>
                                        <span data-valor='13'>
                                        <span data-valor='5'>   
                                            <span data-valor='23'>   
                                            <span data-valor='12'>
                                                <span data-valor='15'>
                                                </span></span></span></span></span></span></span>
                                </div>
                            </div>

                                <ul class="time-lenght horizontal-list">
                                    <li><a class="time-lenght-btn" href="#14">Week</a></li>
                                    <li><a class="time-lenght-btn" href="#15">Month</a></li>
                                    <li><a class="time-lenght-btn" href="#16">Year</a></li>
                                </ul>
                                <ul class="month-data clear">
                                    <li>
                                        <p>JAN<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>21<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>FEB<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>48<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>MAR<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>35<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>APR<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>21<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>MAY<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>48<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>JUN<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>35<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>JULY<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>21<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>AUG<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>48<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>SEP<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>35<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>OCT<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>21<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>NOV<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>48<sup>%</sup></p>
                                    </li>
                                    <li>
                                        <p>DEC<span class="scnd-font-color"> 2022</span></p>
                                        <p><span class="entypo-plus increment"> </span>35<sup>%</sup></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
     

</div>
      </main>
      <!-- End Main -->

    </div>
    <?php include 'bottom.php' ?>
    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
   
  </body>
</html>