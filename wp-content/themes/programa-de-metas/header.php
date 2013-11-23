<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<!-- dns prefetch -->
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		
		<!-- meta -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		
		<!-- icons -->
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
			
		<!-- css + javascript -->
		<?php wp_head(); ?>
		<script type="text/javascript">
			var wpAjaxUrl = '<?php echo admin_url('admin-ajax.php');?>';
		</script>
	</head>
	<body <?php body_class(); ?>>
	
		<!-- wrapper -->
		<!--div class="wrapper"-->
			<div class="mask"></div>
			<!-- header -->
			<header>
				<div class="content">
					<h1>
						<a href="">
							<img src="<?php echo get_template_directory_uri(); ?>/img/logo.jpg" alt="Planeja Sampa - Fazendo junto a cidade que a gente quer" name="Planeja Sampa - Fazendo junto a cidade que a gente quer">
						</a>
					</h1>
					<h2>
						Programa de Metas
					</h2>
				</div>
			</header>
			<!-- /header -->