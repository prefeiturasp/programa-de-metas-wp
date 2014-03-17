<?php

namespace Pdm;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiClient
{
    public $logFile = '';
    public $url;
    public $client;

    public function __construct()
    {
        $this->url = API_URL;
        $this->client = new Client();
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
