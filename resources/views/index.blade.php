@extends('template')

@section('contenu')
  <br>
	<div class="col-sm-offset-4 col-sm-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Liste des sondages</h3>
			</div>
			<div class="panel-body">

				<!-- Balayage de tous les sondages -->
				@foreach ($sondages as $sondage)
					{!! link_to('sondage/create/' . $sondage[0], $sondage[1], ['class' => 'btn btn-info btn-block']) !!}
				@endforeach
				<!-- Fin du balayage -->

		  </div>
		</div>
	</div>
@stop