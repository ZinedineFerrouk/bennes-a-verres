<?php

namespace App\DataFixtures;

use App\Entity\Benne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BenneFixtures extends Fixture
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function load(ObjectManager $manager): void
    {
        $response = $this->httpClient->request('GET', 'https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=points-dapport-volontaire-dechets-et-moyens-techniques&q=&rows=3000&facet=commune&facet=flux&facet=centre_ville&facet=prestataire&facet=zone&facet=pole&refine.flux=R%C3%A9cup%27verre&refine.commune=Toulouse');
        $responseData = json_decode($response->getContent(), true);

        $remoteApiBenne = $responseData['records'];

        for ($k = 0; $k < count($remoteApiBenne); $k++) { 
            if (isset($remoteApiBenne[$k]['fields']['numero']) && isset($remoteApiBenne[$k]['fields']['voie'])) {
              
                $benne = new Benne();
                $benne->setRecordid($remoteApiBenne[$k]['recordid']);
                $benne->setAddress($remoteApiBenne[$k]['fields']['numero'] . ' ' . $remoteApiBenne[$k]['fields']['voie']);
                $benne->setCommune($remoteApiBenne[$k]['fields']['commune']);
                $benne->setQuartier(!isset($remoteApiBenne[$k]['fields']['quartier']) ? 0 : $remoteApiBenne[$k]['fields']['quartier']);
                $benne->setModel($remoteApiBenne[$k]['fields']['modele']);
                $benne->setLatitude($remoteApiBenne[$k]['fields']['geo_point_2d'][0]);
                $benne->setLongitude($remoteApiBenne[$k]['fields']['geo_point_2d'][1]);

                $manager->persist($benne);
            }
        }
        $manager->flush();
    }
}
