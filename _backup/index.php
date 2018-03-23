<?php
require_once('config/load.php');
require('config/connect.php');

// Récupération de la liste des sites
$list_sites = getSites();

?>
	
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<title>Inventaire Initiatives</title>
			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap|Open+Sans" />
			<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.bootstrap.min.css" />
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.bootstrap.min.css" />
			<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />
			<link rel="stylesheet" type="text/css" href="libs/css/styles.css" />
		</head>

		<body id="body-index">
			<div class="container" id="login-page">
				<div class="row" id="text-center">
					<img id="index-logo" src="assets/img/logo_init_md.png" alt="Initiatives">
					<h1>Inventaire</h1>
					<p>Connexion</p>
				</div>
				<div class="row">
					<form method="post" action="" id="auth-form">
				        <label for="user-alias" class="control-label">Alias du Référent</label>
				        <div class="form-group">
				        	<div class="input-group">
								<input type="text" class="form-control" id="user-alias" name="user-alias" placeholder="Alias" aria-describedby="init-addon" value="<?php if( isset($user_alias) ) { echo $user_alias; } ?>" />
								<span class="input-group-addon" id="init-addon">@initiatives.fr</span>
							</div>
				        </div>
				        <div class="alert alert-danger" role="alert" style="display:<?php echo $userAliasError ?>;">
			                <span class="glyphicon glyphicon-exclamation-sign"></span>
			                <span>Saisir un alias valide</span>
			            </div>
				        <div class="form-group">
				            <label for="password" class="control-label" id="password-label">Mot de passe</label>
				            <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="Mot de passe" />
				        </div>
				        <div class="alert alert-danger" role="alert" style="display:<?php echo $passwordError ?>;">
			                <span class="glyphicon glyphicon-exclamation-sign"></span>
			                <span>Mauvais mot de passe</span>
			            </div>
				        <div class="form-group" id="site-select">
							<label for="site" class="control-label">Site pour inventaire</label>
							<select class="form-control" id="site" name="site">
								<option value="" disabled selected>Sélectionner un site</option>
								<?php
									foreach ($list_sites as $sites)
									{
										if ( $sites['code_site'] === $site )
										{
											echo '<option value="' . $site_id . '|' . $site . '" selected>' . $site . '</option>';
										}
										else
										{
											echo '<option value="' . $sites['id'] . '|' . $sites['code_site'] . '">' . $sites['code_site'] . '</option>';
										}
									}
								?>
							</select>
						</div>
						<div class="alert alert-danger" role="alert" style="display:<?php echo $siteError ?>;">
			                <span class="glyphicon glyphicon-exclamation-sign"></span>
			                <span>Veuillez sélectionner un site</span>
			            </div>
				        <div class="form-group">
				            <button id="button-connect" type="submit" class="btn btn-info pull-right">Se connecter</button>
				        </div>
			    	</form>
				</div>
			</div>

			<?php include 'includes/footer.php'; ?>
