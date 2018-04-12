<?php

namespace App\Gestion;

use Illuminate\Filesystem\Filesystem;

class SondageGestion
{

	/**
	 * Instance de FileSystem
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * Crée une nouvelle instance de SondageGestion
	 *
	 * @param \Illuminate\Filesystem\Filesystem $files
	 * @return void
	 */
	public function __construct(Filesystem $files)
	{
		$this->files = $files;
	}

	/**
	 * Récupération des intitulés et des questions de tous les sondages dans la configuration
	 *
	 * @return array
	 */
	public function getSondages()
	{
		$sondages = [];

		foreach (config('sondage') as $key => $value) 
		{
			if($key != 'files') array_push($sondages, [$key,$value['question']]);
		}

		return $sondages;
	}

	/**
	 * Récupère les informations d'un sondage
	 *
	 * @param  string $nom
	 * @return array
	 */
	public function getSondage($nom)
	{
		// On va chercher dans la configuration les données du sondage
		return config('sondage.' . $nom);
	}

	/**
	 * Enregistrement d'un vote
	 *
	 * @param string $nom
	 * @param array $inputs 
	 * @return bool
	 */
	public function save($nom, $imputs)
	{
		// On récupère le chemin dans la configuration et on ajoute le nom du fichier
		$path = config('sondage.files.path') . $nom;

		// Si le fichier n'existe pas on le crée et l'initialise
		if(!$this->files->exists($path)) {
			// On récupère les questions
			$questions = config('sondage.' . $nom . '.reponses');
			// On crée un fichier avec le bon nombre de valeurs à 0
			$this->files->put($path, implode(',', array_fill(0, count($questions), 0)));
			// On crée aussi le fichier des Emails
			$this->files->put($path . '_emails', '');
		}

		// On récupère les Emails déjà utilisés
		$emails = $this->files->get($path . '_emails');
		// Si l'Email a déjà été utilisé on renvoie une erreur
		if(strpos($emails, $imputs['email']) !== false) return false;
		// On mémorise l'Email
		$this->files->append($path . '_emails', $imputs['email'] . "\n");
		// Valeurs actuelles des scores
		$score = explode(',', $this->files->get($path));
		// Incrémentation de la valeur de l'option choisie
		++$score[$imputs['options']];
		// On enregistre les nouvelles valeurs dans le fichier
		$this->files->put($path, implode(',', $score));

		return true;
	}

	/**
	 * Récupération des résultats d'un sondage
	 *
	 * @param string $nom
	 * @return array
	 */
	public function getResults($nom)
	{
		// On récupère le chemin dans la configuration et on ajoute le nom du fichier
		$path = config('sondage.files.path') . $nom;
		// On renvoie les scores
		return explode(',', $this->files->get($path));		
	}

}