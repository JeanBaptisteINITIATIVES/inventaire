<?php require('admin.inc.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Inventaire Initiatives</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap:500" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" />
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
            <div class="container" id="admin-actions">
                <h1>Actions</h1>
                <button type="button" class="btn btn-info" id="update-nav" data-toggle="modal" data-target="#modal-update"><span class="glyphicon glyphicon-refresh"></span> Synchro Scorre</button>
				<button type="button" class="btn btn-warning" id="delete-nav" data-toggle="modal" data-target="#modal-remove"><span class="glyphicon glyphicon-remove"></span> Effacer saisies</button>
                <button type="button" class="btn btn-danger" id="import-nav" data-toggle="modal" data-target="#modal-import"><span class="glyphicon glyphicon-download-alt"></span> Importer données</button>
                <p id="import-help"><?php echo $error = isset($_SESSION["error"]) ? $_SESSION["error"] : ""; ?></p>
                <p id="import-final-message"><?php echo $final_message = isset($_SESSION["final-message"]) ? $_SESSION["final-message"] : ""; ?></p>
                <div class="modal fade" tabindex="-1" role="dialog" id="modal-update">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h2>Synchro des produits Scorre</h2>
                            </div>
                            <div class="modal-body">
                                <p>Mettre à jour la base de données des produits ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                                <button type="button" id="update-button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="modal-remove">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h2>Reset des saisies de l'inventaire</h2>
                            </div>
                            <div class="modal-body">
                                <p>Vider les tables et les utilisateurs concernant toutes les saisies de l'inventaire ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                                <button type="button" id="remove-button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="modal-import">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h2>Importation de données externes</h2>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="" id="import-form" enctype="multipart/form-data">
                                    <h3 id="import-title">Importer les données inventoriée du site <?php echo "<span id='span-import'>" . $_SESSION['site'] . "</span>"; ?> :</h3>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="import-file">Choisir un fichier  *.csv</label>
                                            <input type="file" name="import-file" id="import-file" />
                                        </div>
                                        <div class="form-group col-md-8">
                                            <p id="help-info-import">Le fichier .csv doit comporter les champs suivants :<br />
                                                • référence (suivie en stock)<br />
                                                • quantité<br />
                                                • statut<br />
                                                • observations</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="user" class="control-label">Référent de cet inventaire</label>
                                            <select class="form-control" id="user" name="user">
                                                <option value="" disabled selected>Sélectionner un utilisateur</option>
                                                <?php
                                                    foreach ($list_users as $user_import)
                                                    {
                                                        if ( $user_import['name'] === $user_import )
                                                        {
                                                            echo '<option value="' . $user_import . '" selected>' . $user_import . '</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="' . $user_import['name'] . '">' . $user_import['name'] . '</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <button type="submit" id="import-button" class="btn btn-sm btn-success">
                                                <span class="glyphicon glyphicon-ok"></span> Importer
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="container" id="display-entry">
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
							<button type="submit" class="btn btn-default pull-right" id="admin-button"><span class="glyphicon glyphicon-eye-open"></span> Afficher</button>
						</div>
					</div>
				</form>
			</div>
		</section>

		<section id="search-admin-results">
			<div class="container">	
				<h1>Résultats <?php if( isset($result_search) ) { echo $result_search; } ?></span></h1>
				<a href="<?php if ( isset($handle) ) { echo $handle; } ?>" id="csv" style="display: <?php if ( isset($style_csv) ) { echo $style_csv; } ?>">Télecharger CSV</a>
				<table class="table table-striped nowrap" id="table-admin" cellspacing="0" width="100%">
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