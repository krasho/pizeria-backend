<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>"
      lang="<?php echo Yii::app()->language; ?> class="no-js""
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="< ?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <!--+++++-->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- JS -->
	<!--script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.6.4.min.js"></script-->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/css3-mediaqueries.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>
	<!--script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/tabs.js"></script-->
    
    <!-- superfish -->
		<link rel="stylesheet" media="screen" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/superfish.css" /> 
		<script  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/superfish-1.4.8/js/superfish.js"></script>
		<script  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- prettyPhoto -->
		<script  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css"  media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- poshytip -->
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/poshytip-1.1/src/tip-twitter/tip-twitter.css"  />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/poshytip-1.1/src/tip-yellowsimple/tip-yellowsimple.css"  />
		<script  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/poshytip-1.1/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,300' rel='stylesheet' type='text/css'>
		
		<!-- Flex Slider -->
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/flexslider.css" >
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
		<!-- ENDS Flex Slider -->
		
		<!-- Less framework -->
		<link rel="stylesheet" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/lessframework.css"/>
		
		<!-- modernizr -->
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/modernizr.js"></script>
		
		<!-- SKIN -->
		<link rel="stylesheet" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/skin.css"/>
    
</head>

<body>

<?php //Yii::app()->bootstrap->register(); ?>
<?php $cs = Yii::app()->getClientScript(); ?>
<?php $cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/estilo.css'); ?>

<!-- HEADER -->
	<header class="clearfix">
		<div class="wrapper clearfix">
        	<div class="title">
        		PIZZERIA
            </div>
            <div class="logo">
	        	<img  src="<?php echo Yii::app()->theme->baseUrl; ?>/img/logo.png" alt="Ninos">
            </div>
		</div>
	</header>
    
    <!-- MAIN -->
	<div id="main">	
		<div class="wrapper">
			<!-- slider holder -->
			<!--div id="slider-holder" class="clearfix">	    
                <!-- breadcrumbs -->
                <div class="breadcrumbs">                
                <?php if (isset($this->breadcrumbs)): ?>
					<?php $this->widget(
                    	'bootstrap.widgets.TbBreadcrumbs',
                         array(
                             'homeLink' => 'Home',
                             'links'    => $this->breadcrumbs
                         )
                     );?>
                 <?php endif ?>     
                 </div>
            	<!-- ENDS breadcrumbs -->
                                
                <div class="varMENU">
				<?php
                ?>
                </div>
			<!--/div>
			<!-- ENDS slider holder -->
            
            <!-- space -- >
    		<div class="clear"></div>
            <!-- ENDS space -->
			
            <!--content-->
             <div class="home-block" >      
             	<?php echo $content; ?>       
             </div>
             <!-- ENDS content -->   
		</div>
	    <!-- ENDS wrapper -->    	
	</div>
	<!-- ENDS MAIN -->

	<!-- footer -->
    <div id="footer">
    <footer>
	<div class="wrap-footer zerogrid">
		<div class="copyright">
			<p><?php echo Yii::app()->params['creditos']; ?></p>
		</div>
	</div>
	</footer>
    </div>
    <!--ENDS footer -->
</body>
</html>