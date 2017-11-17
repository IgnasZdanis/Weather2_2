<?php

namespace AppBundle\Controller;

use NfqWeatherBundle\Services\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $provider = $this->container->get('nfq_weather');
        $location = new Location(54.6872, 25.2797);
        var_dump($provider->fetch($location));
        return $this->render('default/index.html.twig');
    }
}
