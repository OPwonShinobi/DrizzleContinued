<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/badwords.js"></script>
<script src="js/dashboard.js"></script>
<script src="js/myaction.js"></script>

<div class="row">

  
        <?php
        //This checks if there is a gift image and makes slides
        // take up whole row if there is not
        // also hides if no images for slideshow

        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '2'");
        $stmt2 = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '1' ORDER BY RAND()");
        $stmt->execute();
        $stmt2->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if ($result2 != NULL) {
          if ($result == NULL)
          {
            echo '<div class="col-lg-12">';
          }
          else
          {
          echo '<div class="col-lg-6">';
          }
        }
        else
        {
          echo '<div class="col-lg-6" style="display:none;">';
        }
        ?>

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

        <?php

        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '2'");
        $stmt2 = $conn->prepare("SELECT ID,Description FROM Images WHERE favflag = '1' ORDER BY RAND()");
        $stmt->execute();
        $stmt2->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if ($result != NULL) {
          if ($result2 == NULL)
          {
            echo '<div class="col-lg-12">';
          }
          else
          {
          echo '<div class="col-lg-6">';
          }
        }
        else
        {
          echo '<div class="col-lg-6" style="display:none;">';
        }
        ?>
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
          echo '<span class="label label-danger">';
          echo $row['Points'] . ' Points';
          echo '</span>';
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
            <div class="col-lg-2 pointsum newpoints">
              <h3 class="myActions label label-success">
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
            <div class="col-lg-2 pointsum newpoints">
              <h3 class="myScore label label-success">
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
            <div class="col-lg-2 pointsum newpoints">
              <h3 class="schoolScore label label-success">
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
<?php
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://www.drizzlesociety.org/blog/',
          CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)'));
        $page = curl_exec($curl);
        curl_close($curl);
        $doc = new \DOMDocument();
        //libxml_use_internal_errors(true);
        //$doc->strictErrorChecking = FALSE;
        $doc->loadHTML($page);
        //libxml_clear_errors();

        $xpath = new \DOMXPath($doc);

        //$images = "//section[1]//img/@src";
        $base = "https://www.drizzlesociety.org";
        $titles = "//section[1]//a[contains(@class,'BlogList-item-title')]";
        $paras = "//section[1]//p";
        $readmore = "//section[1]//a[contains(@class, 'BlogList-item-readmore')]/@href";
        $datep = "//section[1]//time";
        $authors = "//section[1]//a[contains(@class, 'Blog-meta-item--author')]";

        $paras = $xpath->query($paras);
        $titles = $xpath->query($titles);
        $readmore = $xpath->query($readmore);
        $datep = $xpath->query($datep);
        $authors = $xpath->query($authors);
        //$images = $xpath->query($images);

        for ($i=0;$i<$titles->length;$i++)
        {
          echo '<div class="panel panelbody">';
          echo '<div class="newsitem">';
          echo '<h1>' .$titles->item($i)->nodeValue. '</h1>';
          echo '<h5 class="info">' .$datep->item($i)->nodeValue. ' : ' . $authors->item($i)->nodeValue .'</h5>';
          echo '<p>' .$paras->item($i)->nodeValue. '</p>';
          echo '<a class="btn btn-info" role="btn" href="' .$base. $readmore->item($i)->nodeValue. '">Read More</a>';
          echo '</div>';
          echo '</div>';
        }
        ?>



			</div>
		</div>
	</div>
</div>
<!-- /.row -->
