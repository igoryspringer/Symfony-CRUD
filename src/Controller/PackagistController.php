<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PackagistController.
 */
class PackagistController extends AbstractController
{
    /**
     * @Route("/", name="package_all")
     */
    public function indexAction()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://packagist.org/packages/list.json');
        $packages = json_decode($response->getContent(), true);

        return $this->render('packages/index.html.twig', ['packages' => $packages['packageNames']]);
    }

    /**
     * @Route("/search/{name}", name="package_search")
     */
    public function saerchAction($name)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://packagist.org/search.json?q='.$name);
        $packages = json_decode($response->getContent(), true);

        return $this->render('packages/index.html.twig', ['packages' => $packages['results']]);
    }

    /**
     * @Route("/search/vendor/{vendor}", name="package_search")
     */
    public function searchVendorAction($vendor)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://packagist.org/packages/list.json?vendor='.$vendor);
        $packages = json_decode($response->getContent(), true);

        return $this->render('packages/index.html.twig', ['packages' => $packages['packagesName']]);
    }
}
