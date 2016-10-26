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
		$concernesArray= [];
		foreach($concernes as $obj){
			if(! array_key_exists($obj->getIddepenses(), $concernesArray)){
				$concernesArray[$obj->getIddepenses()] = [];
			}
			array_push($concernesArray[$obj->getIddepenses()], $obj->getIdusers());
		}
		var_dump($concernes);
		print_r($concernesArray);
		foreach ($depenses as $depense) {
			$responseData[] = array(
				'Id' => $depense->getIddepenses(),
				'montant' => $depense->getMontant(),
				'payeurs' => $depense->getPayeurs(),
				'date' => $depense->getDatedep()->format('d-m-Y'),
				'nombre concerner' => $depense->getNbconcerne(),
				'description' => $depense->getDescription(),
				'concernes' => implode(", ", $concernesArray[$depense->getIddepenses()])
			);
		}
		return $app->json($responseData);
	}

	// Get one group
	public function getOneDepenses($id, Request $request, Application $app) {
		$depenses = $app['dao.depenses']->find($id);
		if (!isset($depenses)) {
			$app->abort(404, 'User not exist');
		}

//		$user2GroupArray= [];
//		foreach($user_has_group as $obj){
//			if(! array_key_exists($obj->getIdusergroup(), $user2GroupArray)){
//				$user2GroupArray[$obj->getIdusergroup()] = [];
//			}
//			array_push($user2GroupArray[$obj->getIdusergroup()], $obj->getUserid());
//		}

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'date' => $depenses->getDatedep()->format('d-m-Y'),
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);
		return $app->json($responseData);
	}

	public function createDepenses(Request $request, Application $app) {
		if (!$request->request->has('montant')) {
			return $app->json('Missing parameter: montant', 400);
		}

		if (!$request->request->has('description')) {
			return $app->json('Missing parameter: description', 400);
		}

		$depenses = new Depenses();
		$depenses->setMontant($request->request->get('montant'));
		$depenses->setPayeurs($request->request->get('payeurs'));
		$depenses->setDatedep($request->request->get('date'));
		$depenses->setNbconcerne($request->request->get('nombre concerner'));
		$depenses->setDescription($request->request->get('description'));
		$app['dao.depenses']->save($depenses);

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'date' => $depenses->getDatedep()->format('d-m-Y'),
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);

		return $app->json($responseData, 201);
	}

	// Edit
	public function editDepenses($id, Request $request, Application $app) {
		$depenses = $app['dao.depenses']->find($id);

		$depenses->setMontant($request->request->get('montant'));
		$depenses->setPayeurs($request->request->get('payeurs'));
		$depenses->setDatedep($request->request->get('date'));
		$depenses->setNbconcerne($request->request->get('nombre concerner'));
		$depenses->setDescription($request->request->get('description'));
		$app['dao.depenses']->save($depenses);

		$responseData = array(
			'Id' => $depenses->getIddepenses(),
			'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'date' => $depenses->getDatedep()->format('d-m-Y'),
			'nombre concerner' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
		);

		return $app->json($responseData, 202);
	}

	// Delete
	public function deleteDepenses($id, Request $request, Application $app) {
		$app['dao.depenses']->delete($id);
		return $app->json('No content', 204);
	}
}
