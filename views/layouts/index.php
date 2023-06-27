<?php
use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this)
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="<?= Yii::$app->language ?>" class="h-100"> <!--<![endif]-->
<head>

   <!--- basic page needs-->
   <meta charset="<?= Yii::$app->charset ?>">
   <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<meta name="description" content="">  
	<meta name="author" content="">

 	
	<script src="js/modernizr.js"></script> 

   <!-- favicons-->
	<link rel="icon" type="image/png" href="favicon.png">

    <?php $this->head() ?>
</head>

<body id="top">

    
	<!-- header  -->
   <header>

   	<div class="row">

   		<div class="logo">
	         <a href="index.html">Schedule</a>
	      </div>

		  <nav id="main-nav-wrap">
            <ul class="main-navigation">
               <li class="current"><a href="/web/index" title="">Home</a></li>
               <li><a href="/web/index.php?r=schedule/index" title="">Schedule</a></li>
               <?php if (!Yii::$app->user->isGuest): ?>
                  <li><a href="/web/index.php?r=load/index" title="">Load of teacher</a></li>
               <?php endif; ?>
               <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username === 'admin'): ?>
                  <li><a href="/web/index.php?r=scform/index" title="">Schedule Edition</a></li>
                  <li><a href="/web/index.php?r=loadform/index" title="">Load Edition</a></li>
               <?php endif; ?>
               <?php if (!Yii::$app->user->isGuest): ?>
                  <li class="highlight with-sep"><?= Yii::$app->user->identity->username ?></li>
                  <li class="highlight with-sep"><?= Html::a('Logout', ['/site/logout'], ['data-method' => 'post']) ?></li>
               <?php else: ?>
                  <li class="highlight with-sep"><?= Html::a('Sign Up/In', ['/login/index']) ?></li>
               <?php endif; ?>
            </ul>
         </nav>

			<a class="menu-toggle" href="#"><span>Menu</span></a>
   		
   	</div>   	
   	
   </header> <!-- /header -->

   <?php $this->beginBody() ?>
	<?= $content ?>

	

   <div id="preloader"> 
    	<div id="loader"></div>
   </div> 

   <!-- JS--> 
   <script src="js/jquery-1.11.3.min.js"></script>
   <script src="js/jquery-migrate-1.2.1.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script> 

   <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>