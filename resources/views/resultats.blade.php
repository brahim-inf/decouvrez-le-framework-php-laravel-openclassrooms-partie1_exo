@extends('template')

@section('contenu')
  <br>
	<div class="col-sm-offset-4 col-sm-4">
		<div class="panel panel-primary">
			<div class="panel-heading">{{ $sondage['question'] }}</div>
			<div class="panel-body"> 
				<p>Merci d'avoir participé à ce sondage. Voici les résultats actuels :</p>

			 	<!-- Balayage de tous les résultats -->
				@for ($i = 0; $i < count($sondage['reponses']); $i++)
					<p>
						<strong>{{ $sondage['reponses'][$i] }}</strong> : {{ $resultats[$i] }}
						@if ($resultats[$i] > 1) votes	@else vote	@endif
					</p>
					<div class="progress">
						<?php $pourcentage = number_format($resultats[$i] / array_sum($resultats) * 100) ?>
					  <div class="progress-bar progress-bar-success" style="width: {{ $pourcentage }}%;">
					  	{{ $pourcentage }} %
					  </div>
					</div> 					
				@endfor
				<!-- Fin du balayage -->

			</div>
		</div>

		<!-- Retour -->
		{!! link_to('sondage', 'Retour Accueil', ['class' => 'btn btn-primary']) !!}
		
	</div>
@stop