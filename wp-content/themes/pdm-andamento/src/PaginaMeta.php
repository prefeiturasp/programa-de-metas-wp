<?php

namespace Pdm;

use Pdm\ApiClient;

class PaginaMeta extends Pagina
{

    public static function startup ($params)
    {
        $query = 'meta_id='.$params['id'];
        \Timber::load_template('meta.php', $query);
    }

    public static function get_context($meta_id)
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['meta'] = $api->getMeta($meta_id);

        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        $context['eixos'] = $api->getEixos();
        $context['articulacoes'] = $api->getArticulacoes();
        $context['tipos_projeto'] = $api->getTiposProjeto();

        $selos_links = array(
            'agenda-pop-rua'        => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/direitos_humanos/poprua/',
            'historia-africa'       => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/igualdade_racial/',
            'juventude-viva'        => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/direitos_humanos/juventude/',
            'sp-aberta'             => 'http://www.saopauloaberta.prefeitura.sp.gov.br/',
            'sp-carinhosa'          => 'http://www.saopaulocarinhosa.prefeitura.sp.gov.br/',
            'sp-mais-inclusiva'     => 'http://saopaulomaisinclusiva.prefeitura.sp.gov.br/'
            );


        if (!empty($context['meta']['transversalidade'])) {
            $transvs = split(',', $context['meta']['transversalidade']);
            $context['transversalidade'] = array();

            foreach ($transvs as $transv) {
                $context['transversalidade'][$transv] = array(
                    trim($transv) , $selos_links[trim($transv)]
                );
            }
        }

        $context['meta_grouped'] = $api->metas_agrupadas;
        $status_available = $prefecture_available = array();

        foreach ($context['meta']['projects'] as $key => $value) {

            $progresso = $api->getProjetoProgresso($value['id']);
            if ($value['project_type'] != 8) {
                $fases_projeto = $api->getFasesPorTipoProjeto($value['project_type']);
            }

            $status = $api->getProjetoStatus($progresso, $fases_projeto, $value['project_type'], $value['goal_id']);
            $context['meta']['projects'][$key]['status'] = $status;

            if ($context['meta']['projects'][$key]['project_type'] == 8) {
                $context['meta']['projects'][$key]['progresso'] = $api->preparaDadosMesAMesPorPrefeitura($progresso, true);

                $progresso_total = array();
                $years = array('2013', '2014');

                foreach ($years as $year) {
                    foreach ($context['meta']['projects'][$key]['progresso'][$year] as $prog) {
                        foreach ($prog as $k => $val) {
                            if (isset($progresso_total[$year][$k])) {
                                $progresso_total[$year][$k] = $progresso_total[$year][$k] + $val;
                            } else {
                                $progresso_total[$year][$k] = $val;
                            }
                        }
                    }
                }
                // progresso total quando +1 prefeitura no mesmo projeto
                $context['meta']['projects'][$key]['progresso_total'] = $progresso_total;

                foreach ($progresso_total as $ano => $valores) {
                    $context['meta']['projects']['agrupado_total'][$ano]['01'] += $valores['01'];
                    $context['meta']['projects']['agrupado_total'][$ano]['02'] += $valores['02'];
                    $context['meta']['projects']['agrupado_total'][$ano]['03'] += $valores['03'];
                    $context['meta']['projects']['agrupado_total'][$ano]['04'] += $valores['04'];
                    $context['meta']['projects']['agrupado_total'][$ano]['05'] += $valores['05'];
                    $context['meta']['projects']['agrupado_total'][$ano]['06'] += $valores['06'];
                    $context['meta']['projects']['agrupado_total'][$ano]['07'] += $valores['07'];
                    $context['meta']['projects']['agrupado_total'][$ano]['08'] += $valores['08'];
                    $context['meta']['projects']['agrupado_total'][$ano]['09'] += $valores['09'];
                    $context['meta']['projects']['agrupado_total'][$ano]['10'] += $valores['10'];
                    $context['meta']['projects']['agrupado_total'][$ano]['11'] += $valores['11'];
                    $context['meta']['projects']['agrupado_total'][$ano]['12'] += $valores['12'];
                }
            }


            if ((!empty($status['descricao'])) && (!in_array($status['descricao'], $status_available))) {
                $status_available[] = $status['descricao'];
            }

            if (count($value['prefectures']) > 0) {
                foreach ($value['prefectures'] as $prefectures) {
                    $prefecture_available[] = $prefectures['id'];
                }
            }
        }
        $context['prefecture_available'] = $prefecture_available;
        $context['status_available'] = $status_available;

        $context['progresso'] = $api->getMetaProgresso($meta_id);

        $executado = 0;
        foreach ($context['meta']['projects'] as $project) {
            $executado = $executado + $project['budget_executed'];
        }
        $context['executado'] = $executado;

        return $context;
    }
}
