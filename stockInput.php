<?php
session_start();

require('config/load.php');
require('config/session.php');
require('includes/stockInput.inc.php');
require('includes/header.php');

?>
		
		<!-- Formulaire de saisie de produits en stock -->
		<section id="input-area">
			<div class="loader"></div>
			<div class="container">
				<h2>Saisie de produits suivis en stock sur <span class="infos-title"><?php echo $_SESSION['site']; ?></span> :</h2>
				<form method="post" class="well" id="add-form" action="">
					<div class="row">
						<div class="form-group col-md-2" id="add-loc">
							<label for="location" class="control-label">Emplacement</label>
							<input type="text" class="form-control input-sm" id="location" name="location" placeholder="emplacement" value="<?php echo $loc = ($_SESSION['site'] === 'AURIC') ? getLastStockLocation($user_id) : 'AUTRE'; ?>" />
      						<span class="help-block" id="help-loc"></span>
						</div>
						<div class="form-group col-md-2" id="add-ref">
							<label for="reference" class="control-label">Référence</label>
							<input type="text" class="form-control input-sm" id="reference" name="reference" placeholder="référence" />
      						<span class="help-block" id="help-ref"></span>
						</div>
						<div class="form-group col-md-8" id="add-des">
							<label for="designation" class="control-label">Désignation</label>
							<input type="text" class="form-control input-sm" id="designation" name="designation" placeholder="désignation" />
      						<span class="help-block" id="help-des"></span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2" id="add-qty">
							<label for="quantity" class="control-label">Quantité</label>
							<input type="text" class="form-control input-sm" id="quantity" name="quantity" placeholder="quantité" />
      						<span class="help-block" id="help-qty"></span>
						</div>
						<div class="form-group col-md-2">
							<label for="statut" class="control-label">Statut</label>
							<select class="form-control input-sm" id="status" name="status">
								<optgroup label="Statut">
									<option selected>A</option>
									<option>Q</option>
									<option>R</option>
								</optgroup>
							</select>
						</div>
						<div class="form-group col-md-8">
							<label for="observations" class="control-label">Observations</label>
							<input type="text" class="form-control input-sm" id="observations" name="observations" placeholder="observations" />
						</div>
						<button type="submit" class="btn btn-warning pull-right" id="add-button"><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
					</div>
					<p id="input-help-block" class="form-text text-muted"></p>
				</form>
			</div>
		</section>
		
		<!-- Liste des produits saisis du formulaire -->
		<section id="products-area">
			<div class="container">	
				<h2>Produits suivis saisis sur <span class="infos-title"><?php echo $_SESSION['site']; ?></span> par <span class="infos-user"><?php echo getUsernameByAlias($_SESSION['user-alias']); ?></span> :</h2>
				<table class="table table-striped nowrap" id="table-stock-input" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Date</th>
							<th>Emplacement</th>
							<th>Référence</th>
							<th>Désignation</th>
							<th>Quantité</th>
							<th>Statut</th>
							<th>Commentaire</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ( $list_input as $list )
							{
								echo '<tr>';
								echo	'<td>' . $list['date_input'] . '</td>';
								echo	'<td>' . $list['location'] . '</td>';
								echo	'<td>' . $list['reference'] . '</td>';
								echo	'<td>' . $list['designation'] . '</td>';
								echo	'<td>' . $list['quantity'] . '</td>';
								echo	'<td>' . $list['status'] . '</td>';
								echo	'<td>' . $list['observations'] . '</td>';
								echo	'<td>
											<button type="button" class="btn btn-sm btn-table btn-primary" data-toggle="modal" data-target="#modal-change" data-backdrop="false" data-id="' . $list['id'] . '" data-tooltip="tooltip" data-placement="top" title="Modifier"><span class="glyphicon glyphicon-pencil"></span></button>
											<button type="button" class="btn btn-sm btn-table btn-danger" data-toggle="modal" data-target="#modal-delete" data-backdrop="false" data-id="' . $list['id'] . '" data-tooltip="tooltip" data-placement="top" title="Supprimer"><span class="glyphicon glyphicon-remove"></span></button>
										</td>
									</tr>';
							}
						?>
						
						<!-- Modal de modification d'une saisie -->
						<div class="modal fade" tabindex="-1" role="dialog" id="modal-change">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
										<h2>Modifier la saisie :</h2>
									</div>
									<div class="modal-body">
										<form method="post" action="" id="change-form">
											<div class="row">
												<div class="form-group col-md-2" id="change-stock-loc">
													<label for="change-loc" class="control-label">Emplacement</label>
													<input type="text" name="change-loc" id="change-loc" class="form-control" />
													<span class="help-block" id="help-stock-loc"></span>
												</div>
												<div class="form-group col-md-2" id="change-stock-ref">
													<label for="change-ref" class="control-label">Référence</label>
													<input type="text" name="change-ref" id="change-ref" class="form-control" />
													<span class="help-block" id="help-stock-ref"></span>
												</div>
												<div class="form-group col-md-8" id="change-stock-des">
													<label for="change-des" class="control-label">Désignation</label>
													<input type="text" name="change-des" id="change-des" class="form-control" />
													<span class="help-block" id="help-stock-des"></span>
												</div>
											</div>
											<div class="row">
												<div class="form-group col-md-2" id="change-stock-qty">
													<label for="change-qty" class="control-label">Quantité</label>
													<input type="text" name="change-qty" id="change-qty" class="form-control" />
													<span class="help-block" id="help-stock-qty"></span>
												</div>
												<div class="form-group col-md-2">
													<label for="change-sts" class="control-label">Statut</label>
													<select class="form-control" id="change-sts" name="change-sts">
														<optgroup label="Statut">
															<option>A</option>
															<option>Q</option>
															<option>R</option>
															</optgroup>
													</select>
												</div>
												<div class="form-group col-md-8">
													<label for="change-obs" class="control-label">Observations</label>
													<input type="text" name="change-obs" id="change-obs" class="form-control"/>
												</div>
											</div>
											<input type="hidden" id="change-id" name="change-id" />
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
										<button type="button" id="change-button" class="btn btn-success success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Modal de suppression d'une saisie -->
						<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
										<h2>Supprimer la saisie ?</h2>
									</div>
									<div class="modal-body">
										<form method="post" action="" id="delete-form">
											<div class="row">
												<div class="form-group col-md-2">
													<label for="delete-loc" class="control-label">Emplacement</label>
													<input type="text" name="delete-loc" id="delete-loc" class="form-control" disabled />
												</div>
												<div class="form-group col-md-2">
													<label for="delete-ref" class="control-label">Référence</label>
													<input type="text" name="delete-ref" id="delete-ref" class="form-control" disabled />
													</div>
												<div class="form-group col-md-8">
													<label for="delete-des" class="control-label">Désignation</label>
													<input type="text" name="delete-des" id="delete-des" class="form-control" disabled />
												</div>
											</div>
											<div class="row">
												<div class="form-group col-md-2">
													<label for="delete-qty" class="control-label">Quantité</label>
													<input type="text" name="delete-qty" id="delete-qty" class="form-control" disabled />
												</div>
												<div class="form-group col-md-2">
													<label for="delete-sts" class="control-label">Statut</label>
													<select class="form-control" id="delete-sts" name="delete-sts" disabled>
														<optgroup label="Statut">
															<option>A</option>
															<option>Q</option>
															<option>R</option>
															</optgroup>
													</select>
												</div>
												<div class="form-group col-md-8">
													<label for="delete-obs" class="control-label">Observations</label>
													<input type="text" name="delete-obs" id="delete-obs" class="form-control" disabled/>
												</div>
											</div>
											<input type="hidden" id="delete-id" name="delete-id" />
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
										<button type="button" id="delete-button" class="btn btn-success success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
									</div>
								</div>
							</div>
						</div>
					</tbody>
				</table>
			</div>
		</section>

		<?php include 'includes/footer.php'; ?>


		