<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/badwords.js"></script>
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
        $stmt = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '1' ORDER BY RAND()");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $first = true;
        foreach ($result as $row)
        {
            if ($first)
            {
              echo '<div class="item active">';
              $first = false;
            }
            else
            { 
              echo '<div class="item">'; 
            }

            echo '<img class="slideimg" src="/retrieveImage.php?id='. $row['ID'] . '">';
          echo '<figcaption class="imgcap">' . $row['Description'] . '</figcaption>';
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
        <div class="col-lg-12">
<?php 
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '2'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
          echo '<img class="prize" src="/retrieveImage.php?id=';
          echo $row['ID'];
          echo '">';
          echo '<figcaption class="imgcap">' . $row['Description'] . '</figcaption>';
        } 
        ?>
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
        $stmt = $conn->prepare("SELECT Description,Category,Points from Action order by DateEntered limit 3");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
          echo '<div class="panel panel-body">';
          echo '<div class="col-lg-3">';
          echo '<img class ="imagenewact" src="images/categories/' . $row['Category'] .'.png">';
          echo '</div>';
          echo '<div class="col-lg-6">';
          echo '<h3>';
          echo $row['Description'];
          echo '</h3>';
          echo '</div>';
          echo '<div class="col-lg-3 newpoints">';
          echo '<h3>';
          echo $row['Points'] . ' Points';
          echo '</h3>';
          echo '</div>';
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
              <i class="fa fa-university fa-5x"></i>
            </div>
            <div class="col-lg-8 descsum">
              <h3>School Points</h3>
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
			<div class="panel-body panel-news">
        <div class="panel panel-white">
<?php
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://www.drizzlesociety.org/blog/',
          CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)'));
        $page = curl_exec($curl);
        curl_close($curl);
        //echo $page;
        //$xml = new SimpleXMLElement($page);
        //$result = $xml->xpath('/p');
        //echo $result;
        $q1 = '//*[@id="post-5964f49be6f2e1c378931b75"]/div[2]/p';
        $doc = new DOMDocument; 
        $doc->loadHTML( $page);
        $xpath = new DOMXpath( $doc);
        $node = $xpath->query($q1);
        //echo $node;
        ?>
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
