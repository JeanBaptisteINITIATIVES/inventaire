<?php
session_start();

require('config/load.php');
require('config/session.php');
require('includes/checkInputs.inc.php');

?>

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
		<link rel="stylesheet" type="text/css" href="libs/css/styles.css" />
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
				<h1>Rechercher une saisie :</h1>
				<form method="post" class="col-lg-6 col-md-6 well well-lg" id="search-input-form" action="">
					<div class="row">
						<div class="form-group">
							<label for="input-site" class="control-label">Site inventorié pour la recherche</label>
							<select class="form-control" id="input-site" name="input-site" required>
								<option value="tous les sites" selected>Tous les sites</option>
								<?php
									foreach ($list_sites as $sites)
									{
										if ( $sites['code_site'] === $_SESSION['site-control'] )
										{
											echo '<option value="' . $_SESSION['site-control'] . '" selected>' . $_SESSION['site-control'] . '</option>';
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
							<label for="search" class="control-label">Chercher une référence de produit</label>
							<input type="text" id="search-ref" name="search-ref" class="form-control" placeholder="Entrez votre référence à 8 chiffres" />
						</div>
						<div class="form-group">
							<div class="radio-inline">
								<label for="tracked"><input type="radio" id="tracked" name="tracking" value="stock" checked="checked" />Saisies produits en stock</label>
							</div>
							<div class="radio-inline">
								<label for="not-tracked"><input type="radio" id="not-tracked" name="tracking" value="no-stock" />Saisies libres</label>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default pull-right" id="search-ref-button"><span class="glyphicon glyphicon-search"></span> Chercher</button>
						</div>
					</div>
				</form>
			</div>
		</section>

		<section id="search-control-results">
			<div class="container">	
				<h1>Résultats <?php if( isset($search_site) ) { echo $search_site; } ?></span><?php if( isset($search_ref) ) { echo $search_ref; } ?></span></h1>
				<table class="table table-striped table-bordered nowrap" id="table-control" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Emplacement</th>
							<th>Référence</th>
							<th>Désignation</th>
							<th>Quantité</th>
							<th>Statut</th>
							<th>Référent</th>
							<th>Site</th>
							<th>Observations</th>
							<th>Date saisie</th>
						</tr>
					</thead>
					<tbody>
					
					<?php
						foreach ( $list_input as $res )
						{
							echo '<tr>';
								echo	'<td>' . $res['location'] . '</td>';
								echo	'<td>' . $res['reference'] . '</td>';
								echo	'<td>' . $res['designation'] . '</td>';
								echo	'<td>' . $res['quantity'] . '</td>';
								echo	'<td>' . $res['status'] . '</td>';
								echo	'<td>' . getUsernameByUserId($res['user_id']) . '</td>';
								echo	'<td>' . getSite($res['site_id']) . '</td>';
								echo	'<td>' . $res['observations'] . '</td>';
								echo	'<td>' . $res['date_input'] . '</td>';
							echo '</tr>';
						}
					?>
					
					</tbody>
				</table>
			</div>	
		</section>

		<?php require('includes/footer.php'); ?>