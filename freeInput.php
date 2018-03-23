<?php
session_start();

require('config/load.php');
require('config/session.php');
require('includes/freeInput.inc.php');
require('includes/header.php');

?>
		
		<!-- Formulaire de saisie de produits non-suivis en stock -->
		<section id="free-input-area">
			<div class="loader"></div>
			<div class="container">
				<h1>Saisie libre :</h1>
				<form method="post" class="well" id="add-free-form" action="">
					<div class="row">
						<div class="form-group col-md-2" id="add-free-loc">
							<label for="free-loc" class="control-label">Emplacement</label>
							<input type="text" class="form-control input-sm" id="free-loc" name="free-loc" placeholder="emplacement" value="<?php echo $loc = ($_SESSION['site'] === 'AURIC') ? getLastFreeLocation($user_id) : 'AUTRE'; ?>" />
							<span class="help-block" id="help-free-loc"></span>
						</div>
						<div class="form-group col-md-2">
							<label for="free-ref" class="control-label">Référence</label>
							<input type="text" class="form-control input-sm" id="free-ref" name="free-ref" placeholder="référence" />
						</div>
						<div class="form-group col-md-8" id="add-free-des">
							<label for="free-des" class="control-label">Désignation</label>
							<input type="text" class="form-control input-sm" id="free-des" name="free-des" placeholder="désignation" />
							<span class="help-block" id="help-free-des"></span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2" id="add-free-qty">
							<label for="free-qty" class="control-label">Quantité</label>
							<input type="text" class="form-control input-sm" id="free-qty" name="free-qty" placeholder="quantité" />
							<span class="help-block" id="help-free-qty"></span>
						</div>
						<div class="form-group col-md-2">
							<label for="free-sts" class="control-label">Statut</label>
							<select class="form-control input-sm" id="free-sts" name="free-sts">
								<optgroup label="Statut">
									<option selected>A</option>
									<option>Q</option>
									<option>R</option>
								</optgroup>
							</select>
						</div>
						<div class="form-group col-md-8">
							<label for="free-obs" class="control-label">Observations</label>
							<input  type="text" class="form-control input-sm" id="free-obs" name="free-obs" placeholder="observations" />
						</div>
						<button type="submit" class="btn btn-warning pull-right" id="add-free-button"><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
					</div>
				</form>
			</div>
		</section>

		<!-- Liste des produits saisis du formulaire -->
		<section id="products-area">
			<div class="container">	
				<h1>Produits saisis :</h1>
				<table class="table table-striped nowrap" id="table-free-input" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Date</th>
							<th>Emplacement</th>
							<th>Référence</th>
							<th>Désignation</th>
							<th>Quantité</th>
							<th>Statut</th>
							<th>Observations</th>
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
											<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-free-change" data-backdrop="false" data-id="' . $list['id'] . '" data-tooltip="tooltip" data-placement="top" title="Modifier"><span class="glyphicon glyphicon-pencil"></span></button>
											<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-free-delete" data-backdrop="false" data-id="' . $list['id'] . '" data-tooltip="tooltip" data-placement="top" title="Supprimer"><span class="glyphicon glyphicon-remove"></span></button>
										</td>
									</tr>';
							}
						?>
						
						<!-- Modal de modification d'une saisie -->
						<div class="modal fade" tabindex="-1" role="dialog" id="modal-free-change">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
										<h2>Modifier la saisie :</h2>
									</div>
									<div class="modal-body">
										<form method="post" action="" id="change-free-form">
											<div class="row">
												<div class="form-group col-md-2" id="change-loc-free">
													<label for="change-free-loc" class="control-label">Emplacement</label>
													<input type="text" name="change-free-loc" id="change-free-loc" class="form-control" />
													<span class="help-block" id="help-free-change-loc"></span>
												</div>
												<div class="form-group col-md-2" id="change-ref-free">
													<label for="change-free-ref" class="control-label">Référence</label>
													<input type="text" name="change-free-ref" id="change-free-ref" class="form-control" />
													<span class="help-block" id="help-free-change-ref"></span>
												</div>
												<div class="form-group col-md-8" id="change-des-free">
													<label for="change-free-des" class="control-label">Désignation</label>
													<input type="text" name="change-free-des" id="change-free-des" class="form-control" />
													<span class="help-block" id="help-free-change-des"></span>
												</div>
											</div>
											<div class="row">
												<div class="form-group col-md-2" id="change-qty-free">
													<label for="change-free-qty" class="control-label">Quantité</label>
													<input type="text" name="change-free-qty" id="change-free-qty" class="form-control" />
													<span class="help-block" id="help-free-change-qty"></span>
												</div>
												<div class="form-group col-md-2">
													<label for="change-free-sts" class="control-label">Statut</label>
													<select class="form-control" id="change-free-sts" name="change-free-sts">
														<optgroup label="Statut">
															<option>A</option>
															<option>Q</option>
															<option>R</option>
															</optgroup>
													</select>
												</div>
												<div class="form-group col-md-8">
													<label for="change-free-obs" class="control-label">Observations</label>
													<input type="text" name="change-free-obs" id="change-free-obs" class="form-control"/>
												</div>
											</div>
											<input type="hidden" id="change-free-id" name="change-free-id" />
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
										<button type="button" id="change-free-button" class="btn btn-success success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Modal de suppression d'une saisie -->
						<div class="modal fade" tabindex="-1" role="dialog" id="modal-free-delete">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
										<h2>Supprimer la saisie ?</h2>
									</div>
									<div class="modal-body">
										<form method="post" action="" id="delete-free-form">
											<div class="row">
												<div class="form-group col-md-2">
													<label for="delete-free-loc" class="control-label">Emplacement</label>
													<input type="text" name="delete-free-loc" id="delete-free-loc" class="form-control" disabled />
												</div>
												<div class="form-group col-md-2">
													<label for="delete-free-ref" class="control-label">Référence</label>
													<input type="text" name="delete-free-ref" id="delete-free-ref" class="form-control" disabled />
													</div>
												<div class="form-group col-md-8">
													<label for="delete-free-des" class="control-label">Désignation</label>
													<input type="text" name="delete-free-des" id="delete-free-des" class="form-control" disabled />
												</div>
											</div>
											<div class="row">
												<div class="form-group col-md-2">
													<label for="delete-free-qty" class="control-label">Quantité</label>
													<input type="text" name="delete-free-qty" id="delete-free-qty" class="form-control" disabled />
												</div>
												<div class="form-group col-md-2">
													<label for="delete-free-sts" class="control-label">Statut</label>
													<select class="form-control" id="delete-free-sts" name="delete-free-sts" disabled>
														<optgroup label="Statut">
															<option>A</option>
															<option>Q</option>
															<option>R</option>
															</optgroup>
													</select>
												</div>
												<div class="form-group col-md-8">
													<label for="delete-free-obs" class="control-label">Observations</label>
													<input type="text" name="delete-free-obs" id="delete-free-obs" class="form-control" disabled/>
												</div>
											</div>
											<input type="hidden" id="delete-free-id" name="delete-free-id" />
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
										<button type="button" id="delete-free-button" class="btn btn-success success"><span class="glyphicon glyphicon-ok"></span> Valider</button>
									</div>
								</div>
							</div>
						</div>
					</tbody>
				</table>
			</div>
		</section>
		
		<?php include 'includes/footer.php'; ?>


