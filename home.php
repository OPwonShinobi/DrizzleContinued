<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/dashboard.js"></script>
<script src="js/myaction.js"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
<div class="panel-heading">
  <h1 class="panel-title"><i class="fa fa-image"></i> New Photos</h1>
</div>
      <div class="panel-body">
      <!-- BootStrap Image Carousel -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-wrap="true" data-interval="3000">
        <div class="carousel-inner">
        
        <!--Gets images for display in /slideshow folder -->
        <?php 
        $dir = 'slideshow';
        $images = scandir($dir);
        $images = array_diff($images,array('.','..'));
        $first = true;

        foreach ($images as $image)
        {
          if ($first)
          {
            echo '<div class="item slideimg active">';
            $first = false;
          } 
          else 
          {
            echo '<div class="item slideimg">'; 
          }
          echo '<img class="slideimg" src="/slideshow/'. $image . '">';
          echo '</div>';
          
        }
        ?>

        </div>
      </div>
      <!-- End of Carousel -->
      </div>
		</div>
	</div>
</div>

<!-- /.row -->

<div class="row">
  <!-- Column 1 my actions -->
  <div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-flag-checkered fa-fw"></i> Recently Added Challenges</h2>
			</div>
			<div class="panel-body">
        <?php
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT Description, Points from Action order by DateEntered limit 3");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $ele)
        {
          echo '<div class="panel panel-body panel-newactions">';
          echo '<h3>';
          foreach($ele as $inele)
          {
            echo $inele;
            echo ' - ';
          }
          echo 'points';
          echo '</h3>';
          echo '</div>';
        }
        ?>
			</div>
		</div>
	</div>

  <!-- Column 2 my actions -->
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> My Summary</h2>
			</div>
			<div class="panel-body">
      <!--panel items -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-green panel-body">
            <div class="col-lg-2">
              <i class="fa fa-book fa-5x"></i>
            </div>
            <div class="col-lg-8 descsum">
              <h3>Challenges Completed</h3>
            </div>
            <div class="col-lg-2 pointsum">
              <h3>
              <?php
              $conn = get_db_connection();
              $sess = $_SESSION['Userid'];;
              $stmt = $conn->prepare("SELECT COUNT(*) FROM Accomplishment WHERE UserID =" . $sess);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $ele)
                foreach ($ele as $innerele)
                  echo $innerele;
              ?>
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-yellow panel-body">
            <div class="col-lg-2">
              <i class="fa fa-trophy fa-5x"></i>
            </div>
            <div class="col-lg-8 descsum">
              <h3>Total Points</h3>
            </div>
            <div class="col-lg-2 pointsum">
              <h3>
              <?php
              $conn = get_db_connection();
              $sess = $_SESSION['Userid'];;
              $stmt = $conn->prepare("SELECT SUM(Points) FROM Action INNER JOIN Accomplishment ON ID = ActionID WHERE USERID =" . $sess);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $ele)
                foreach ($ele as $innerele)
                  echo $innerele;
              ?>
              </h3>
            </div>
          </div>
        </div>
      </div>

			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-newspaper-o fa-fw"></i> News</h2>
			</div>
			<div class="panel-body">
        <div class="panel panel-white">
          <h1>Important News Item 1</h1>
        <p>bla b;lahdkljga dsklgjadlskg das gdakljaklds gdklasg dsalk fdskljg kdslgj dklsg jdsjfkldaskjg;dslafjghl;dfjg;fidds</p>
        </div>


        <div class="panel panel-white">
        <h1>Important News Item 2</h1>
        <p> dklgfjaldskg daktg gkldjg ls;daj gkfakldgf jdskalg sldag jasdk gdsa f</p>
        </div>

			</div>
		</div>
	</div>
</div>
<!-- /.row -->
