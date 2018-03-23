<?php require('admin.inc.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Inventaire Initiatives</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap:500" /> 
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/fh-3.1.3/r-2.2.0/datatables.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="../libs/css/styles.css" />
	</head>

	<body>
		<header>
			<nav class="navbar navbar-default" id="nav-header" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-inventory" aria-expanded="false">
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="http://www.initiatives.fr" target="_blank">
							<img src="../assets/img/logo_init.png" id="logo-init" alt="Inventaire Initiatives">
						</a>
					</div>
					<div class="collapse navbar-collapse" id="navbar-inventory">
			  			<ul class="nav navbar-nav navbar-right">
							<li class="infos-log info-user">
								<p>Connecté : <span class="infos-coul"><?php echo getUsernameByAlias($_SESSION['user-alias']); ?></span></p>
							</li>
							<li class="vertical-divider"></li>
							<li class="infos-log">
								<a id="disconnect-link" href="../config/disconnect.php" class="pull-right">Déconnexion</a>
							</li>
			  			</ul>			
					</div>
				</div>		        
			</nav>
		</header>
		
		<!-- Formulaire de recherche -->
		<section id="search-input">
			<div class="loader"></div>
			<div class="container">
				<h1>Afficher les saisies :</h1>
				<form method="post" class="col-lg-6 col-md-6 well well-lg" id="admin-input-form" action="">
					<div class="row">
						<div class="form-group">
							<label for="admin-input-site" class="control-label">Site inventorié</label>
							<select class="form-control" id="admin-input-site" name="admin-input-site" required>
								<option value="" disabled selected>Sélectionner un site</option>
								<?php
									foreach ($list_sites as $sites)
									{
										if ( $sites['code_site'] === $_SESSION['site-admin'] )
										{
											echo '<option value="' . $_SESSION['site-admin'] . '" selected>' . $_SESSION['site-admin'] . '</option>';
										}
										else
										{
											echo '<option value="' . $sites['code_site'] . '">' . $sites['code_site'] . '</option>';
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default pull-right" id="admin-button"><span class="glyphicon glyphicon-search"></span> Chercher</button>
						</div>
					</div>
				</form>
			</div>
		</section>

		<section id="search-admin-results">
			<div class="container">	
				<h1>Résultats <?php if( isset($result_search) ) { echo $result_search; } ?></span></h1>
				<a href="<?php if ( isset($handle) ) { echo $handle; } ?>" id="csv" style="display: <?php if ( isset($style_csv) ) { echo $style_csv; } ?>">Télecharger CSV</a>
				<table class="table table-striped table-bordered nowrap" id="table-admin" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Référence</th>
							<th>Désignation</th>
							<th>Statut</th>
							<th>Quantité</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ( $list_input as $res )
							{
								echo '<tr>';
									echo	'<td>' . $res['reference'] . '</td>';
									echo	'<td>' . $res['designation'] . '</td>';
									echo	'<td>' . $res['status'] . '</td>';
									echo	'<td>' . $res['quantity'] . '</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>	
		</section>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="../libs/js/datatable/datatables.js"></script>
		<script type="text/javascript" src="../libs/js/script.js"></script>
	</body>
</html>