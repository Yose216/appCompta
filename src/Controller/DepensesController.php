<?php
namespace appCompta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\Depenses;

class DepensesController {
	public function getAllDepenses(Application $app) {
		$depenses = $app['dao.depenses']->findAll();
		$responseData = array();
//		$user2GroupArray= [];
//		foreach($user_has_group as $obj){
//			if(! array_key_exists($obj->getIdusergroup(), $user2GroupArray)){
//				$user2GroupArray[$obj->getIdusergroup()] = [];
//			}
//			array_push($user2GroupArray[$obj->getIdusergroup()], $obj->getUserid());
//		}

		foreach ($depenses as $depense) {
			$responseData[] = array(
				'Id' => $depense->getIddepenses(),
				'montant' => $depense->getMontant(),
				'payeurs' => $depense->getPayeurs(),
				'date' => $depense->getDatedep()->format('d-m-Y'),
				'nombre concerner' => $depense->getNbconcerne(),
				'description' => $depense->getDescription()
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

	// Delete
	public function deleteDepenses($id, Request $request, Application $app) {
		$app['dao.depenses']->delete($id);
		return $app->json('No content', 204);
	}
}
