<?php

namespace App\Service\Api;

use App\Entity\Benne;
use App\Entity\LastBennesUpdate;
use App\Service\Api\ApiConst;
use App\Repository\BenneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LastBennesUpdateRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService extends ApiConst
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var LastBennesUpdateRepository
     */
    private $lastBennesUpdateRepository;

    /**
     * @var BenneRepository
     */
    private $benneRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(HttpClientInterface $httpClient, LastBennesUpdateRepository $lastBennesUpdateRepository, BenneRepository $benneRepository, EntityManagerInterface $em)
    {
        $this->httpClient = $httpClient;
        $this->lastBennesUpdateRepository = $lastBennesUpdateRepository;
        $this->benneRepository = $benneRepository;
        $this->em = $em;
    }

    /**
     * Check last api updating
     * @return bool 
     */
    public function checkLastUpdate() 
    {
        $today = new \DateTime();
        $diff = $today->sub(new \DateInterval('P7D'));
        $lastUpdate = $this->lastBennesUpdateRepository->findOneBy([], ['id' => 'DESC']);
        if ($lastUpdate->getUpdatedAt() > $diff) {
            return false;
        } 
        return true;
    }

    /**
     * Update all bennes from remote api
     * @return void 
     * @throws Exception 
     */
    public function updateApiFromRemote()
    {
        if ($this->checkLastUpdate()) {
            try {
                $response = $this->httpClient->request('GET', self::REMOTE_URL);
                if ($response->getStatusCode() === 200 && $response->getContent() !== null) {
                    $responseData = json_decode($response->getContent(), true);
                    if (array_key_exists('records', $responseData)) {  

                        if (!empty($responseData['records'])) {

                            $bennesFromRemote = $responseData['records'];
                            
                            for ($k = 0; $k < count($bennesFromRemote); $k++) { 
                                if (isset($bennesFromRemote[$k]['fields']['numero']) && isset($bennesFromRemote[$k]['fields']['voie'])) {
                                    
                                    $benne = new Benne();
                                    $benne->setRecordid($bennesFromRemote[$k]['recordid']);
                                    $benne->setAddress($bennesFromRemote[$k]['fields']['numero'] . ' ' . $bennesFromRemote[$k]['fields']['voie']);
                                    $benne->setCommune($bennesFromRemote[$k]['fields']['commune']);
                                    $benne->setQuartier(!isset($bennesFromRemote[$k]['fields']['quartier']) ? 0 : $bennesFromRemote[$k]['fields']['quartier']);
                                    $benne->setModel($bennesFromRemote[$k]['fields']['modele']);
                                    $benne->setLatitude($bennesFromRemote[$k]['fields']['geo_point_2d'][0]);
                                    $benne->setLongitude($bennesFromRemote[$k]['fields']['geo_point_2d'][1]);
                                    
                                    $this->em->persist($benne);
                                }
                            }
                            $connection = $this->em->getConnection();
                            $platform   = $connection->getDatabasePlatform();
                            $connection->executeUpdate($platform->getTruncateTableSQL('benne', true));
                            
                            $this->em->flush();
                            
                            $l = new LastBennesUpdate();
                            $l->setErroredUpdate(false);
                            $this->em->persist($l);
                            
                            $this->em->flush();
                        } else {
                            $l = new LastBennesUpdate();
                            $l->setErroredUpdate(true);
                            $this->em->persist($l);

                            $this->em->flush();
                        }
                    }
                }
            } catch (\Throwable $e) {
                $l = new LastBennesUpdate();
                $l->setErroredUpdate(true);
                $this->em->persist($l);

                $this->em->flush();

                throw new \Exception($e->getMessage());
            }
        }
    }
}
