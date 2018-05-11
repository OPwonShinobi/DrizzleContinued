<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/dashboard.js"></script>
<script src="js/myaction.js"></script>

<div class="row">

	<div class="col-lg-6">
		<div class="panel panel-default">
<div class="panel-heading">
  <h1 class="panel-title"><i class="fa fa-image"></i> New Photos</h1>
</div>
      <div class="panel-body">
      <!-- BootStrap Image Carousel -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-wrap="true" data-interval="3000">
        <div class="carousel-inner">

        <?php
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT ID FROM Images WHERE favflag = '1' ORDER BY RAND()");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $url = 'retrieveImage.php?id=';
        $first = true;
        foreach ($result as $ele)
          foreach ($ele as $innerele)
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
            echo '<img class="slideimg" src="/retrieveImage.php?id='. $innerele . '">';
            echo '</div>';
          }
        ?>

        </div>
      </div>
      <!-- End of Carousel -->
      </div>
		</div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1 class="panel-title"><i class="fa fa-gift"></i> Current Prize</h1>
      </div>
      <div class="panel-body">
        <div class="col-lg-12 prize">
          <img class="prize" src="http://ddeubel.edublogs.org/files/2010/12/present-16ufgnb.jpg">
        </div>
        <div class="prizedesc col-lg-12">
          <h2>The current prize is this box!</h2>
          <p> A description of the prize with all relevant details that people will care about... </p>
        </div>
      </div> 
    </div>
 </div>
</div>
<!-- /.row -->

<div class="row row-eq-height">
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
              <h3 class="myActions">
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-yellow panel-body">
            <div class="col-lg-2">
              <i class="fa fa-tree fa-5x"></i>
            </div>
            <div class="col-lg-8 descsum">
              <h3>Total Points</h3>
            </div>
            <div class="col-lg-2 pointsum">
              <h3 class="myScore">
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-red panel-body">
            <div class="col-lg-2">
              <i class="fa fa-trophy fa-5x"></i>
            </div>
            <div class="col-lg-8 descsum">
              <h3></h3>
            </div>
            <div class="col-lg-2 pointsum">
              <h3>
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
