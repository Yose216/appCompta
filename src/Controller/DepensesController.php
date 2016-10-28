<?php
namespace appCompta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\Depenses;
use appCompta\Domain\Concernes;

class DepensesController {
	public function getAllDepenses(Application $app) {
		$depenses = $app['dao.depenses']->findAll();
		$concernes = $app['dao.concernes']->findAll();
		$responseData = array();

		/*
		* 	Converts $user_has_group to an array $user2GroupArray having structure :
		*	[getIddepenses => [getIdusers], getIddepenses2 => [getIdusers2]]
		*/
		$concernesArray= [];
		foreach($concernes as $obj){
			if(! array_key_exists($obj->getIddepenses(), $concernesArray)){
				$concernesArray[$obj->getIddepenses()] = [];
			}
			array_push($concernesArray[$obj->getIddepenses()], $obj->getIdusers());
		}

		foreach ($depenses as $depense) {
			$responseData[] = array(
				'Id' => $depense->getIddepenses(),
				'montant' => $depense->getMontant(),
				'payeurs' => $depense->getPayeurs(),
				'concernes' => implode(", ", $concernesArray[$depense->getIddepenses()]),//array => string
				'date' => $depense->getDatedep()->format('d-m-Y'),// change the format of date
				'nombre concerner' => $depense->getNbconcerne(),
				'description' => $depense->getDescription()
			);
		}
		return $app->json($responseData);
	}

	// Get one group
	public function getOneDepenses($id, Request $request, Application $app) {
		$depenses = $app['dao.depenses']->find($id);
		$concernes = $app['dao.concernes']->findAll();
		if (!isset($depenses)) {
			$app->abort(404, 'User not exist');
		}

		/*
		* 	Converts $user_has_group to an array $user2GroupArray having structure :
		*	[getIddepenses => [getIdusers], getIddepenses2 => [getIdusers2]]
		*/
		$concernesArray= [];
		foreach($concernes as $obj){
			if(! array_key_exists($obj->getIddepenses(), $concernesArray)){
				$concernesArray[$obj->getIddepenses()] = [];
			}
			array_push($concernesArray[$obj->getIddepenses()], $obj->getIdusers());
		}

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'concernes' => implode(", ", $concernesArray[$depenses->getIddepenses()]),//array => string
			'date' => $depenses->getDatedep()->format('d-m-Y'),// change the format of date
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);
		return $app->json($responseData);
	}

	public function createDepenses(Request $request, Application $app) {
		if (!$request->request->has('montant')) {
			return $app->json('Missing parameter: montant', 400);
		}
		if (!$request->request->has('payeurs')) {
			return $app->json('Missing parameter: payeurs', 400);
		}
		if (!$request->request->has('description')) {
			return $app->json('Missing parameter: description', 400);
		}
		if (!$request->request->has('concernes')) {
			return $app->json('Missing parameter: concernes', 400);
		}

		$depenses = new Depenses();
		$depenses->setMontant($request->request->get('montant'));
		$depenses->setPayeurs($request->request->get('payeurs'));
		$depenses->setDatedep($request->request->get('date'));
		$depenses->setNbconcerne($request->request->get('nombre concerner'));
		$depenses->setDescription($request->request->get('description'));
		$app['dao.depenses']->save($depenses);

		$concernes = new Concernes();
        $concernes->setIddepenses($depenses->getIddepenses());
        $concernes->setIdusers($request->request->get('concernes'));
		$app['dao.concernes']->save($concernes);

		// add the content of request in log
		error_log(print_r($depenses, true));
		error_log(print_r($concernes, true));

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'concernes' => $concernes->getIdusers(),
			'date' => $depenses->getDatedep()->format('d-m-Y'),// Change the format of date
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);

		return $app->json($responseData, 201);
	}

	// Edit
	public function editDepenses($id, Request $request, Application $app) {
		$depenses = $app['dao.depenses']->find($id);
		$concernes = $app['dao.concernes']->findAll();

		$depenses->setMontant($request->request->get('montant'));
		$depenses->setPayeurs($request->request->get('payeurs'));
		$depenses->setDatedep($request->request->get('date'));
		$depenses->setNbconcerne($request->request->get('nombre concerner'));
		$depenses->setDescription($request->request->get('description'));
		$app['dao.depenses']->save($depenses);

		$concernes = new Concernes();
        $concernes->setIddepenses($depenses->getIddepenses());
        $concernes->setIdusers($request->request->get('concernes'));
		$app['dao.concernes']->save($concernes);

		// add the content of request in log
		error_log(print_r($depenses, true));
		error_log(print_r($concernes, true));

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'concernes' => $concernes->getIdusers(),
			'date' => $depenses->getDatedep()->format('d-m-Y'),// Change the format of date
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);

		return $app->json($responseData, 202);
	}

	// Delete depenses
	public function deleteDepenses($id, Request $request, Application $app) {
		$app['dao.concernes']->deleteIdDepenses($id);// Delete the id in table concernes
		$app['dao.depenses']->delete($id);// Delete the depense in DB
		return $app->json('No content', 204);
	}

	// Delete the concernes
	public function deleteConcernes($id, Request $request, Application $app) {
		$app['dao.concernes']->delete($id);
		return $app->json('No content', 204);
	}
}
