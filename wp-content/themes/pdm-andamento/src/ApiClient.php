<?php

namespace Pdm;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// use Doctrine\Common\Cache\FilesystemCache;
// use Guzzle\Cache\DoctrineCacheAdapter;
// use Guzzle\Plugin\Cache\CachePlugin;
// use Guzzle\Plugin\Cache\DefaultCacheStorage;

class ApiClient
{
    public $logFile = '';
    public $url;
    public $client;

    public function __construct()
    {
        $this->url = API_URL;
        $this->client = new Client();

        // $cachePlugin = new CachePlugin(array(
        //     'storage' => new DefaultCacheStorage(
        //         new DoctrineCacheAdapter(
        //             new FilesystemCache(dirname(__FILE__).'../cache/')
        //         )
        //     )
        // ));

        // $this->client->addSubscriber($cachePlugin);
    }

    protected function fazerRequisicao($path)
    {
        try {
            return $this->client->get($this->url . $path);
        } catch (RequestException $e) {
            $this->gravarLog($e->getRequest());
            if ($e->hasResponse()) {
                $this->gravarLog($e->getResponse());
            }
        }
    }

    protected function gravarLog($mensagem)
    {
        // create a log channel
        if (!($this->log instanceof Logger)) {
            $this->log = new Logger('api');
        }
        $this->log->pushHandler(new StreamHandler(dirname(__FILE__).'/../log/api.log', Logger::WARNING));

        // add records to the log
        $this->log->addWarning($mensagem);
    }

    public function getSubPrefeituras()
    {
        $response = $this->fazerRequisicao('prefectures');
        return $response->json();
    }

    public function getObjetivos()
    {
        $response = $this->fazerRequisicao('objectives');
        return $response->json();
    }

    public function getSecretarias()
    {
        $response = $this->fazerRequisicao('secretaries');
        return $response->json();
    }

    public function getEixos()
    {
        $response = $this->fazerRequisicao('axes');
        return $response->json();
    }

    public function getArticulacoes()
    {
        $response = $this->fazerRequisicao('articulations');
        return $response->json();
    }

    public function getProjeto($id)
    {
        $response = $this->fazerRequisicao('project/'.$id);
        return $response->json();
    }

    public function getMeta($id)
    {
        $response = $this->fazerRequisicao('goal/'.$id);
        return $response->json();
    }

    public function getMetasFiltradas()
    {
        $response = $this->fazerRequisicao('goals');
        return $response->json();
    }
}
