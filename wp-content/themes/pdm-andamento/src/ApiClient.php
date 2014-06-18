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

    public $metas_agrupadas = array(
                11, // (consultórios na rua),
                35, // (Unid. Habitacionais),
                37, // (Regularização fundiária),
                42, // (Casas de mediação),
                47, // (Esporte 24h),
                54, // (CEFAI),
                73, // (Praças wifi),
                89, // (Coleta seletiva),
                97 // (ciclovias)
        );

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

    protected function fazerRequisicao($path, $type = 'get', $data = null)
    {
        try {
            if (($type == 'post') && (count($data) > 0)) {
                return $this->client->post($this->url . $path, array(
                    'body' => $data));
            } else {
                return $this->client->get($this->url . $path);
            }
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

    public function getSelos()
    {
        $response = $this->fazerRequisicao('labels');
        return $response->json();
    }

    public function getProjeto($id)
    {
        $response = $this->fazerRequisicao('project/'.$id);
        return $response->json();
    }

    public function getTiposProjeto()
    {
        $response = $this->fazerRequisicao('projects/types');
        return $response->json();
    }

    public function getProjetoProgresso($id)
    {
        $response = $this->fazerRequisicao('project/'.$id.'/progress');
        return $response->json();
    }

    public function preparaDadosMesAMesPorPrefeitura($progresso)
    {
        $dados_mensais = array('2013'=>array(), '2014'=>array() );

        foreach ($progresso as $key => $value) {
            $nome_prefeitura = $value['prefecture']['name'];
            $id_prefeitura = $value['prefecture']['id'];
            $year = \DateTime::createFromFormat('Y-m-d H:i:s', $value['month_year']);

            if (array_key_exists($id_prefeitura, $dados_mensais[$year->format('Y')])) {
                $dados_mensais[$year->format('Y')][$id_prefeitura]['nome'] = $nome_prefeitura;
            }

            if (empty($value['value'])) {
                $value['value'] = 0;
            }

            $dados_mensais[$year->format('Y')][$id_prefeitura]['dados'][] = $value['value'];
        }

        // foreach ($prefeituras as $key => $value) {
        //     $novo_progresso[$key]
        // }

        return $dados_mensais;
    }

    protected function getProjetoDeFasesStatus($projetos, $fases_projeto)
    {
        $status_total = 0;
        foreach ($projetos as $progresso) {
            if ($progresso['status'] == 50) {
                $status_total = $status_total + ($fases_projeto[$progresso['milestone']]['percentage']/2);
            } elseif ($progresso['status'] > 50) {
                $status_total = $status_total + ($fases_projeto[$progresso['milestone']]['percentage']);
            } else {
                $status_total = $status_total + 0;
            }
        }

        if ($status_total == 0) {
            $data['descricao'] = 'Não iniciada';
        } elseif (($status_total > 0) && ($status_total < 100)) {
            $data['descricao'] = 'Em andamento';
        } elseif ($status_total == 100) {
            $data['descricao'] = 'Concluído';
        }

        $data['absoluto'] = $status_total;

        return $data;
    }

    protected function getProjetoMesAMesStatus($projetos)
    {
        $total = 0;
        //$years = array('2013', '2014');
        //foreach ($years as $year) {
            foreach ($projetos as $progresso) {
                $total = $total + $progresso['value'];
            }
        //}

        $target = $projetos[0]['goal_target'];

        if ($total != 0) {
            $status_total = ($total*100) / $target;
        }

        if ($status_total == 0) {
            $data['descricao'] = 'Não iniciada';
        } elseif (($status_total > 0) && ($status_total < 100)) {
            $data['descricao'] = 'Em andamento';
        } elseif ($status_total == 100) {
            $data['descricao'] = 'Concluído';
        }

        $data['absoluto'] = $status_total;

        return $data;
    }

    public function getProjetoStatus($projetos, $fases_projeto, $tipo_projeto, $meta_id)
    {
        if ($tipo_projeto == 8) {
            if (in_array($meta_id, $this->metas_agrupadas)) {
                return "-";
            } else {
                return $this->getProjetoMesAMesStatus($projetos);
            }
        }

        return $this->getProjetoDeFasesStatus($projetos, $fases_projeto);

    }

    public function getFasesPorTipoProjeto($tipo)
    {
        $response = $this->fazerRequisicao('project/type/'.$tipo.'/milestones');
        return $response->json();
    }

    public function getMeta($id)
    {
        $response = $this->fazerRequisicao('goal/'.$id);
        return $response->json();
    }

    public function getMetaPorcentagemConcluida($id)
    {
        $response = $this->fazerRequisicao('goal/'.$id.'/status');
        return $response->json();
    }

    public function getMetaProgresso($id)
    {
        $response = $this->fazerRequisicao('goal/'.$id.'/progress');
        return $response->json();
    }

    protected function validateInput($value)
    {
        if (!empty($value)) {
            return true;
        }
        return false;
    }

    public function getMetasFiltradas()
    {
        $filter = array();

        if ($this->validateInput($_GET['subprefeitura'])) {
            $filter['prefecture'] = $_GET['subprefeitura'];
        }

        if ($this->validateInput($_GET['objetivo'])) {
            $filter['objective'] = $_GET['objetivo'];
        }

        if ($this->validateInput($_GET['secretaria'])) {
            $filter['secretary'] = $_GET['secretaria'];
        }

        if ($this->validateInput($_GET['eixo'])) {
            $filter['axis'] = $_GET['eixo'];
        }

        if ($this->validateInput($_GET['articulacao'])) {
            $filter['articulation'] = $_GET['articulacao'];
        }

        if ($this->validateInput($_GET['selo'])) {
            $filter['label'] = $_GET['selo'];
        }

        if ($this->validateInput($_GET['status'])) {
            $filter['status'] = $_GET['status'];
        }

        $url_filters = 'goals?' .  http_build_query($filter);

        $response = $this->fazerRequisicao($url_filters);
        return $response->json();
    }

    public function getSubPrefeiturasPorCoordenadas($lat, $long)
    {
        $response = $this->fazerRequisicao('prefectures/findByCoordinates/'.$lat.'/'.$long);
        return $response->json();
    }

    public function seguirMeta($meta, $name, $email)
    {
        $data = array('name'=>$name, 'email'=>$email);
        $response = $this->fazerRequisicao('goal/'.$meta.'/follow', "post", $data);
        return $response->json();
    }
}
