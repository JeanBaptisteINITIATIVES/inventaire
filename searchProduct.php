<?php
session_start();

require('config/load.php');
require('config/session.php');
require('includes/searchProduct.inc.php');
require('includes/header.php');

?>

		<!-- Formulaire de recherche de produits -->
		<section id="search-product">
			<div class="loader"></div>
			<div class="container">
				<h1>Recherche</h1>
				<form method="post" class="col-lg-6 col-md-6 well well-lg" id="search-form" action="">
					<div class="row">
						<div class="form-group">
							<div class="radio-inline">
								<label for="by-des"><input type="radio" id="by-des" name="search-by" value="des" checked="checked" />Par désignation</label>
							</div>
							<div class="radio-inline">
								<label for="by-ref"><input type="radio" id="by-ref" name="search-by" value="ref" />Par référence</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio-inline">
								<label for="tracking"><input type="radio" id="tracking" name="tracking-stock" value="tracked" checked="checked" />Suivi en stock</label>
							</div>
							<div class="radio-inline">
								<label for="not-tracking"><input type="radio" id="not-tracking" name="tracking-stock" value="not-tracked" />Pas suivi en stock</label>
							</div>
						</div>
						<div class="form-group">
							<label for="search" class="control-label">Mot(s)-clé(s) : </label>
							<a id="help-search" data-toggle="tooltip" class="pull-right tool">Aide</a>
							<input type="text" id="search-product" name="search-product" class="form-control" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default pull-right" id="search-button"><span class="glyphicon glyphicon-search"></span> Chercher</button>
						</div>
					</div>
				</form>
			</div>
		</section>

		<!-- Résultats de la recherche -->
		<section id="search-results">
			<div class="container">	
				<h2>Résultats <?php echo $title_search = isset($title_search) ? $title_search : ''; ?></span></h2>
				<table class="table table-striped nowrap" id="table-search" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th id="ref">Référence</th>
							<th id="des">Désignation</th>
							<!-- <th>Score</th> -->
						</tr>
					</thead>
					<tbody>
					
					<?php
						foreach ( $search_result as $res )
						{
							echo '<tr>';
								echo	'<td>' . $res['reference'] . '</td>';
								echo	'<td>' . $res['designation'] . '</td>';
								/*echo	'<td>' . $res['score'] . '</td>';*/
							echo '</tr>';
						}
					?>
					
					</tbody>
				</table>
			</div>	
		</section>
			
		<?php require('includes/footer.php'); ?>

	</body>
</html>