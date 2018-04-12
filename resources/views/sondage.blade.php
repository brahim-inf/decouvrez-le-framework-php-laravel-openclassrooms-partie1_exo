@extends('template')

@section('contenu')
  <br>
	<div class="col-sm-offset-4 col-sm-4">
		<div class="panel panel-primary">
			<div class="panel-heading">{!! $sondage['question'] !!}</div>
			<div class="panel-body"> 

				<!-- Affichage message d'erreur éventuel -->
				@if(session('error'))
					<div class="alert alert-danger">{!! session('error') !!}</div>
				@endif

				<!-- Formulaire de vote -->
				{!! Form::open(['url' => 'sondage/' . $nom]) !!}
					<div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
						{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Votre email']) !!}
						{!! $errors->first('email', '<small class="help-block">:message</small>') !!}
					</div>
					@foreach ($sondage['reponses'] as $index => $reponse)
						<div class="radio">
	  					<label>
	  						{!! Form::radio('options', $index, $index === 0) !!}{!! $reponse !!}
							</label>
						</div>
					@endforeach
					{!! Form::submit('Envoyer !', ['class' => 'btn btn-info pull-right']) !!}
				{!! Form::close() !!}
				<!-- Fin du formulaire -->

			</div>
		</div>

		<!-- Bouton de retour à la page précédente -->
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
		
	</div>
@stop