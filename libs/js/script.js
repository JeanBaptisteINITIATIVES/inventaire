$(function() {

	// Loader
	$('.loader').fadeOut('500');

	// Focus sur champ "alias" à l'ouverture de la page d'index
	$('#user-alias').focus();

	// Menu collapse se referme au clic d'un lien
    $(document).on('click','.navbar-collapse.in',function(e)
    {
        if( $(e.target).is('li') )
        {
            $(this).collapse('hide');
        }
    });


	// Focus sur le champ "emplacement" au chargement de la page
	$('#location, #free-loc').focus().select();

	
	// Sélection du texte des champs au focus
	$('#location, #reference, #designation, #quantity, #observations, #change-loc, #change-ref, #change-des, #change-qty, #change-obs, #free-loc, #free-ref, #free-des, #free-qty, #free-obs, #change-free-loc, #change-free-ref, #change-free-des, #change-free-qty, #change-free-obs').on('focus', function() {
		$(this).select();
	});


	// Focus sur référence si emplacement fait partie de useful_loc
	var usefulLoc = ['ATE', 'SAS', 'ZONE PREPA', 'STOCKAGE', 'MASSE', 'PLATEFORME STOCKAGE', 'PLATEFORME ATE', 'AUTRE'];
	var locStockVal = $('#location').val();
	var locFreeVal = $('#free-loc').val();

	for (var i = 0; i < usefulLoc.length; i++)
	{
		if ( locStockVal == usefulLoc[i] )
		{
			$('#reference').focus();
		}
	}

	for (var i = 0; i < usefulLoc.length; i++)
	{
		if ( locFreeVal == usefulLoc[i] )
		{
			$('#free-ref').focus();
		}
	}


	// Tooltips
	$('[data-tooltip="tooltip"]').tooltip();

	$('#help-search').tooltip({
								title: "<p id='search-tooltip'><strong>\" \"</strong><br/>\"expression\"  = expression exacte<br/><strong>*</strong><br/>expression*  = commençant par expression<br/><strong>+</strong><br/>mot1 +mot2  = mot2 obligatoire</p>",
								html: true,
								placement: "right"
							});
						
	

	// Contrôle données envoyées dans saisie stock et ajout si OK dans bdd
	$('#add-form').submit(function(e) {
        e.preventDefault();
        $('#add-form .help-block').empty();
        var postdata = $('#add-form').serialize();
        
        $.ajax({
            type: 'POST',
            url: '../../ajax/addStockInput.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                 
                if(json.isSuccess) 
                {
                    $('#add-form .form-group').removeClass('has-error');
                    $('#add-form')[0].reset();
                    location.reload();
                }
                else
                {
                    $('#add-loc, #add-ref, #add-des, #add-qty').addClass('has-error');
                    $('#help-loc').html(json.locError);
                    $('#help-ref').html(json.refError);
                    $('#help-des').html(json.desError);
                    $('#help-qty').html(json.qtyError);
                    
                    if ( json.locError == "" )
                    {
                    	$('#add-loc').removeClass('has-error');
                    }
                	if ( json.refError == "" )
                	{
                		$('#add-ref').removeClass('has-error');
                	}
                	if ( json.desError == "" )
                	{
                		$('#add-des').removeClass('has-error');
                	}
                	if ( json.qtyError == "" )
                	{
                		$('#add-qty').removeClass('has-error');
                	}
                	if ( json.inputError != "" )
                	{
                		$('#input-help-block').text(json.inputError);
                	}
                }                
            }
        });
    });

    // Contrôle données envoyées dans saisie libre et ajout si OK dans bdd
	$('#add-free-form').submit(function(e) {
        e.preventDefault();
        $('#add-free-form .help-block').empty();
        var postdata = $('#add-free-form').serialize();
        
        $.ajax({
            type: 'POST',
            url: '../../ajax/addFreeInput.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                 
                if(json.isSuccess) 
                {
                    $('#add-free-form .form-group').removeClass('has-error');
                    $('#add-free-form')[0].reset();
                    location.reload();
                }
                else
                {
                    $('#add-free-loc, #add-free-des, #add-free-qty').addClass('has-error');
                    $('#help-free-loc').html(json.locFreeError);
                    $('#help-free-des').html(json.desFreeError);
                    $('#help-free-qty').html(json.qtyFreeError);

                    if ( json.locFreeError == "" )
                    {
                    	$('#add-free-loc').removeClass('has-error');
                    }
                    if ( json.desFreeError == "" )
                	{
                		$('#add-free-des').removeClass('has-error');
                	}
                	if ( json.qtyFreeError == "" )
                	{
                		$('#add-free-qty').removeClass('has-error');
                	}
                }                
            }
        });
    });


	// Affichage des infos de la ligne du tableau dans le modal de modification
	$('#modal-change').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var idInput = button.data('id');
		$.ajax({
		 	type: 'GET',
		 	url: '../../ajax/displayStockInput.php',
		 	data: 'id=' + idInput,
		 	dataType: 'json',
		 	success: function(json) {
				$('#change-loc').val(json.location);
				$('#change-ref').val(json.reference);
				$('#change-des').val(json.designation);
				$('#change-qty').val(json.quantity);
				$('#change-sts').val(json.status);
				$('#change-obs').val(json.observations);

				$('#change-id').val(idInput);
		 	}
		});
	});

	$('#modal-free-change').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var idInput = button.data('id');
		$.ajax({
		 	type: 'GET',
		 	url: '../../ajax/displayFreeInput.php',
		 	data: 'id=' + idInput,
		 	dataType: 'json',
		 	success: function(json) {
				$('#change-free-loc').val(json.location);
				$('#change-free-ref').val(json.reference);
				$('#change-free-des').val(json.designation);
				$('#change-free-qty').val(json.quantity);
				$('#change-free-sts').val(json.status);
				$('#change-free-obs').val(json.observations);

				$('#change-free-id').val(idInput);
		 	}
		});
	});

	// Modal de mise à jour produits Scoore (admin)
	$('#update-button').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'GET',
			url: '../../config/api.php',
			beforeSend: function() {
				$('#modal-update').fadeOut();
				$('.loader').fadeIn();
			},
			complete: function() {
				location.reload();
			}
		});
	});
	

	// Focus après ouverture des modals
	$('#modal-change').on('shown.bs.modal', function(e) {
		$('#change-qty').focus();
	});

	$('#modal-free-change').on('shown.bs.modal', function(e) {
		$('#change-free-qty').focus();
	});

	$('#modal-update').on('shown.bs.modal', function (e) {
		$('#update-button').focus();
	});

	// On enlève les messages d'erreur à la fermeture du modal de modification
	$('#modal-change').on('hidden.bs.modal', function() {
		$('#change-stock-loc, #change-stock-ref, #change-stock-des, #change-stock-qty').removeClass('has-error');
		$('#help-stock-loc, #help-stock-ref, #help-stock-des, #help-stock-qty').empty();
	});

	$('#modal-free-change').on('hidden.bs.modal', function() {
		$('#change-loc-free, #change-ref-free, #change-des-free, #change-qty-free').removeClass('has-error');
		$('#help-free-loc, #help-free-ref, #help-free-des, #help-free-qty').empty();
	});


	// Blur à la fermeture du modal
	$('[data-tooltip="tooltip"]').on('focus', function() {
        $(this).blur();
	});

	$('#csv').on('focus', function() {
        $(this).blur();
	});


	// Modification des données dans bdd + page à validation
	$('#change-button').on('click', function(e) {
		e.preventDefault();
		var postdata = $('#change-form').serialize();
		$('#change-form .help-block').empty();

		$.ajax({
		 	type: 'POST',
		 	url: '../../ajax/updateStockInput.php',
		 	data: postdata,
		 	dataType: 'json',
		 	success: function(json) {
				if ( json.isSuccess )
				{
					$('#change-form .form-group').removeClass('has-error');
					$('#modal-change').fadeOut();
					location.reload();
				}
				else
				{
					$('#change-stock-loc, #change-stock-ref, #change-stock-des, #change-stock-qty').addClass('has-error');
                    $('#help-stock-loc').html(json.locError);
                    $('#help-stock-ref').html(json.refError);
                    $('#help-stock-des').html(json.desError);
                    $('#help-stock-qty').html(json.qtyError);
                    
                    if ( json.locError == "" )
                    {
                    	$('#change-stock-loc').removeClass('has-error');
                    }
                	if ( json.refError == "" )
                	{
                		$('#change-stock-ref').removeClass('has-error');
                	}
                	if ( json.desError == "" )
                	{
                		$('#change-stock-des').removeClass('has-error');
                	}
                	if ( json.qtyError == "" )
                	{
                		$('#change-stock-qty').removeClass('has-error');
                	}
				}
		 	}
		});
	});

	$('#change-free-button').on('click', function(e) {
		e.preventDefault();
		var postdata = $('#change-free-form').serialize();
		$('#change-free-form .help-block').empty();

		$.ajax({
		 	type: 'POST',
		 	url: '../../ajax/updateFreeInput.php',
		 	data: postdata,
		 	dataType: 'json',
		 	success: function(json) {
				if ( json.isSuccess )
				{
					$('#change-free-form .form-group').removeClass('has-error');
					$('#modal-free-change').fadeOut();
					location.reload();
				}
				else
				{
					$('#change-loc-free, #change-ref-free, #change-des-free, #change-qty-free').addClass('has-error');
                    $('#help-free-change-loc').html(json.locError);
                    $('#help-free-change-ref').html(json.refError);
                    $('#help-free-change-des').html(json.desError);
                    $('#help-free-change-qty').html(json.qtyError);
                    
                    if ( json.locError == "" )
                    {
                    	$('#change-loc-free').removeClass('has-error');
                    }
                	if ( json.refError == "" )
                	{
                		$('#change-ref-free').removeClass('has-error');
                	}
                	if ( json.desError == "" )
                	{
                		$('#change-des-free').removeClass('has-error');
                	}
                	if ( json.qtyError == "" )
                	{
                		$('#change-qty-free').removeClass('has-error');
                	}
				}
		 	}
		});
	});


	// Affichage des infos de la ligne du tableau dans le modal de suppression
	$('#modal-delete').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var idInput = button.data('id');

		$.ajax({
		 	type: 'GET',
		 	url: '../../ajax/displayStockInput.php',
		 	data: 'id=' + idInput,
		 	dataType: 'json',
		 	success: function(json) {
				$('#delete-loc').val(json.location);
				$('#delete-ref').val(json.reference);
				$('#delete-des').val(json.designation);
				$('#delete-qty').val(json.quantity);
				$('#delete-sts').val(json.status);
				$('#delete-obs').val(json.observations);

				$('#delete-id').val(idInput);
		 	}
		});
	});

	$('#modal-free-delete').on('show.bs.modal', function(e) {
		var button = $(e.relatedTarget);
		var idInput = button.data('id');

		$.ajax({
		 	type: 'GET',
		 	url: '../../ajax/displayFreeInput.php',
		 	data: 'id=' + idInput,
		 	dataType: 'json',
		 	success: function(json) {
				$('#delete-free-loc').val(json.location);
				$('#delete-free-ref').val(json.reference);
				$('#delete-free-des').val(json.designation);
				$('#delete-free-qty').val(json.quantity);
				$('#delete-free-sts').val(json.status);
				$('#delete-free-obs').val(json.observations);

				$('#delete-free-id').val(idInput);
		 	}
		});
	});


	// Focus sur bouton de validation à l'ouverture du modal
	$('#modal-delete').on('shown.bs.modal', function(e) {
		$('#delete-button').focus();
	});

	$('#modal-free-delete').on('shown.bs.modal', function(e) {
		$('#delete-free-button').focus();
	});


	// Suppression des données dans bdd + page à validation
	$('#delete-button').on('click', function(e) {
		e.preventDefault();
		var postdata = $('#delete-form').serialize();

		$.ajax({
		 	type: 'POST',
		 	url: '../../ajax/deleteStockInput.php',
		 	data: postdata,
		 	success: function() {
				$('#modal-delete').fadeOut();
				location.reload();
		 	}
		});
	});

	$('#delete-free-button').on('click', function(e) {
		e.preventDefault();
		var postdata = $('#delete-free-form').serialize();

		$.ajax({
		 	type: 'POST',
		 	url: '../../ajax/deleteFreeInput.php',
		 	data: postdata,
		 	success: function() {
				$('#modal-free-delete').fadeOut();
				location.reload();
		 	}
		});
	});


	
	//////////////////////////////////////////////////////////////////////
	//////////////////////// DATATABLE ///////////////////////////////////
	//////////////////////////////////////////////////////////////////////

	// https://datatables.net
	// https://connect.ed-diamond.com/GNU-Linux-Magazine/GLMF-189/DataTables-interagir-avec-les-tableaux-HTML
	
	// Datatable responsive "saisie stock"
	$('#table-stock-input').dataTable({
		fixedHeader: true,
		responsive: true,
		pagingType: "full_numbers",
		lengthMenu: [5, 10, 15, 20, 25, 50, 100],
		pageLength: 10,
		order: [0, 'desc'],
		columns: [
			{type: "text", visible: false, orderable: false, searchable: false},
			{type: "text"},
			{type: "num"},
			{type: "text"},
			{type: "num", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{orderable: false, searchable: false}
		],
		language: {
	        url: '../../assets/lang/datatableFrench.json'
    	}
	});


	// Datatable responsive "recherche"
	$('#table-search').dataTable({
		fixedHeader: true,
		bSort: false,
		responsive: true,
		pagingType: "full_numbers",
		lengthMenu: [5, 10, 25, 50, 100],
		pageLength: 10,
		language: {
	        url: '../../assets/lang/datatableFrench.json'
    	}
	});


	// Datatable responsive "saisie libre"
	$('#table-free-input').dataTable({
		fixedHeader: true,
		responsive: true,
		pagingType: "full_numbers",
		lengthMenu: [5, 10, 15, 20, 25, 50, 100],
		pageLength: 10,
		order: [0, 'desc'],
		columns: [
			{type: "text", visible: false, orderable: false, searchable: false},
			{type: "text"},
			{type: "num"},
			{type: "text"},
			{type: "num", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{orderable: false, searchable: false}
		],
		language: {
	        url: '../../assets/lang/datatableFrench.json'
    	}
	});


	// Datatable responsive "contrôle saisies"
	$('#table-control').dataTable({
		fixedHeader: true,
		responsive: true,
		pagingType: "full_numbers",
		lengthMenu: [5, 10, 15, 20, 25, 50, 100],
		pageLength: 10,
		columns: [
			{type: "text"},
			{type: "num"},
			{type: "text", orderable: false},
			{type: "num", orderable: false, searchable: false},
			{type: "text", orderable: false},
			{type: "text", orderable: false},
			{type: "text", orderable: false, searchable: false},
			{type: "text"},
			{orderable: false, searchable: false}
		],
		language: {
	        url: '../../assets/lang/datatableFrench.json'
    	}
	});


	// Datatable responsive "affichage saisies"
	$('#table-admin').dataTable({
		fixedHeader: true,
		responsive: true,
		pagingType: "full_numbers",
		pageLength: 20,
		columns: [
			{type: "num", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{type: "text", orderable: false, searchable: false},
			{type: "num", orderable: false, searchable: false},
		],
		language: {
	        url: '../../assets/lang/datatableFrench.json'
    	}
	});


	
	//////////////////////////////////////////////////////////////////////
	//////////////////////// AUTOCOMPLETION //////////////////////////////
	//////////////////////////////////////////////////////////////////////

	var cache = {};   // Variable pour la mise en cache des réponses
	var term  = null; // Initialisation des réponses

	if ( $(location).attr('pathname') == '/stockInput.php' )
	{
		// Autocomplétion "emplacements"
		$("#location").autocomplete({
			minLength: 1,
			delay: 200,
			source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							$.ajax({
								type: 'GET',
								url: '../../ajax/getLocation.php',
								data: 'term=' + request.term,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	if (!data.length)
										 	{
										 		var result = [{
										 			label: "Aucun emplacement trouvé...",
										 			value: null
										 		}];
										 		response(result);
										 	}
										 	else
										 	{
										 		response(data);
											}
								}
							});
						}
			},
			select: function(e, ui)
			{
				$("#reference").focus();
			}
		});

		// Autocomplétion "référence" saisie stock
		$("#reference").autocomplete({
	        minLength: 2,
	        delay: 400,
	        source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = -1;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getReference.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#reference").val(ui.item.reference);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#reference").val(ui.item.reference);
				$("#designation").val(ui.item.designation);
				$("#quantity").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };

	    // Autocomplétion "désignation" saisie stock
	    $("#designation").autocomplete({
	      	minLength: 3,
	      	delay: 400,
	      	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = -1;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getDesignation.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#designation").val(ui.item.designation);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#reference").val(ui.item.reference);
				$("#designation").val(ui.item.designation);
				$("#quantity").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };

		// Autocomplétions modal de modification
		$("#change-loc").autocomplete({
			minLength: 1,
			delay: 200,
			source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							$.ajax({
								type: 'GET',
								url: '../../ajax/getLocation.php',
								data: 'term=' + request.term,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	if (!data.length)
										 	{
										 		var result = [{
										 			label: "Aucun emplacement trouvé...",
										 			value: null
										 		}];
										 		response(result);
										 	}
										 	else
										 	{
										 		response(data);
											}
								}
							});
						}
			},
			select: function(e, ui)
			{
				$("#change-button").focus();
			}
		});

		$("#change-ref").autocomplete({
	      	minLength: 2,
	 		delay: 400,
	      	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = -1;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getReference.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#change-ref").val(ui.item.reference);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#change-ref").val(ui.item.reference);
				$("#change-des").val(ui.item.designation);
				$("#change-button").focus();
	        	return false;
	      	}
    	})
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };

		$("#change-des").autocomplete({
	      	minLength: 3,
	 		delay: 400,
	      	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = -1;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getDesignation.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#change-des").val(ui.item.designation);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#change-ref").val(ui.item.reference);
				$("#change-des").val(ui.item.designation);
				$("#change-button").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };
	}
	
	if ( $(location).attr('pathname') == '/freeInput.php' )
	{
		// Autocomplétion "emplacements" de la saisie libre
		$("#free-loc").autocomplete({
			minLength: 1,
			delay: 200,
			source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							$.ajax({
								type: 'GET',
								url: '../../ajax/getLocation.php',
								data: 'term=' + request.term,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	if (!data.length)
										 	{
										 		var result = [{
										 			label: "Aucun emplacement trouvé...",
										 			value: null
										 		}];
										 		response(result);
										 	}
										 	else
										 	{
										 		response(data);
											}
								}
							});
						}
			},
			select: function(e, ui)
			{
				$("#free-ref").focus();
			}
		});

		// Autocomplétion "référence" saisie libre
		$("#free-ref").autocomplete({
	        minLength: 2,
	        delay: 400,
	        source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = 0;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getReference.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#reference").val(ui.item.reference);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#free-ref").val(ui.item.reference);
				$("#free-des").val(ui.item.designation);
				$("#free-qty").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };

	    // Autocomplétion "désignation" saisie libre
	    $("#free-des").autocomplete({
	      	minLength: 3,
	      	delay: 400,
	      	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = 0;							

							$.ajax({
								type: 'GET',
								url: '../../ajax/getDesignation.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#designation").val(ui.item.designation);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#free-ref").val(ui.item.reference);
				$("#free-des").val(ui.item.designation);
				$("#free-qty").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };

	    $("#change-free-loc").autocomplete({
			minLength: 1,
			delay: 200,
			source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							$.ajax({
								type: 'GET',
								url: '../../ajax/getLocation.php',
								data: 'term=' + request.term,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	if (!data.length)
										 	{
										 		var result = [{
										 			label: "Aucun emplacement trouvé...",
										 			value: null
										 		}];
										 		response(result);
										 	}
										 	else
										 	{
										 		response(data);
											}
								}
							});
						}
			},
			select: function(e, ui)
			{
				$("#change-free-button").focus();
			}
		});

	    $("#change-free-ref").autocomplete({
	 		minLength: 2,
	 		delay: 400,
	       	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = 0;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getReference.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#change-ref").val(ui.item.reference);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#change-free-ref").val(ui.item.reference);
				$("#change-free-des").val(ui.item.designation);
				$("#change-free-button").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };
		
		$("#change-free-des").autocomplete({
	      	minLength: 3,
	 		delay: 400,
	      	source: function(request, response) {
						term = request.term;
						if (term in cache)
						{
							response(cache[term]);
						}
						else
						{
							var typeOfEntry = 0;

							$.ajax({
								type: 'GET',
								url: '../../ajax/getDesignation.php',
								data: 'term=' + request.term + '&entry=' + typeOfEntry,
								dataType: 'json',
								async: true,
								cache: true,
								success: function(data) {
										 	cache[term] = data;
										 	response(data);
								}
							});
						}
			},
	       //  focus: function(e, ui) {
	       //  	$("#change-des").val(ui.item.designation);
	       //  	return false;
	      	// },
	      	select: function(e, ui) {
		        $("#change-free-ref").val(ui.item.reference);
				$("#change-free-des").val(ui.item.designation);
				$("#change-free-button").focus();
	        	return false;
	      	}
	    })
	    .data('ui-autocomplete')._renderItem = function(ul, item) {
	      	return $("<li>")
		        .append( "<div>" + item.reference + " - " + item.designation + "</div>" )
		        .appendTo(ul);
	    };
	}

	if ( $(location).attr('pathname') == '/checkInputs.php' )
	{
		$("#search-ref").autocomplete({
			minLength: 2,
			delay: 400,
			source: function (request, response) {
				term = request.term;
				if (term in cache) {
					response(cache[term]);
				}
				else {
					var typeOfEntry = $('input[name=tracking]:checked').val();
					
					$.ajax({
						type: 'GET',
						url: '../../ajax/getInputs.php',
						data: 'term=' + request.term + '&entry=' + typeOfEntry,
						dataType: 'json',
						async: true,
						cache: true,
						success: function (data) {
							cache[term] = data;
							if (!data.length) {
								var result = [{
									label: "Aucune saisie trouvée...",
									value: null
								}];
								response(result);
							}
							else {
								response(data);
							}
						}
					});
				}
			},
			//  focus: function(e, ui) {
			//  	$("#change-des").val(ui.item.designation);
			//  	return false;
			// },
			select: function (e, ui) {
				$("#search-ref").val(ui.item.reference);
				$("#search-ref-button").focus();
				return false;
			}
		})
			.data('ui-autocomplete')._renderItem = function (ul, item) {
				return $("<li>")
					.append("<div>" + item.reference + " - " + item.designation + "</div>")
					.appendTo(ul);
			};
	}

});