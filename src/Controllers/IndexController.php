<?php

namespace VSS\Controllers;

use VSS\DTOs\BasketDTO;
use VSS\Forms\BasketForm;

use VSS\Repositories\CountryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\UX\Turbo\TurboBundle;

class IndexController extends AbstractController
{
	#[Route(path: '/', name: 'index', methods: ['GET', 'POST'])]
	public function index(Request $request, CountryRepository $country_repository): Response
	{
		$basket = new BasketDTO($country_repository);

		$form = $this->createForm(BasketForm::class, $basket, [
			'action' => $this->generateUrl('index'),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if ($request->getPreferredFormat() === TurboBundle::STREAM_FORMAT) {
				$request->setRequestFormat(TurboBundle::STREAM_FORMAT);
				return $this->render('basket.stream.html.twig', [
					'form' => $form,
					'basket' => $basket
				]);
			}
		} else {
			$basket = null;
		}

		return $this->render('index.html.twig', [
			'form' => $form,
			'basket' => $basket
		]);
	}
}