<?php

namespace Pdm;

class PaginaInicial
{
    public static function get_context()
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['metas'] = $api->getMetasFiltradas($projeto_id);
        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        $context['eixos'] = $api->getEixos();
        $context['articulacoes'] = $api->getArticulacoes();
        $context['selos'] = $api->getSelos();

        $context['subprefeitura'] = $_GET['subprefeitura'];
        $context['objetivo'] = $_GET['objetivo'];
        $context['secretaria'] = $_GET['secretaria'];
        $context['status'] = $_GET['status'];
        $context['eixo'] = $_GET['eixo'];
        $context['articulacao'] = $_GET['articulacao'];
        $context['selo'] = $_GET['selo'];


        $context['total_metas'] = count($context['metas']);

        if (count($_GET) > 0) {
            $context['filtros_usados'] = array();

            if (!empty($context['subprefeitura'])) {
                foreach ($context['subprefeituras'] as $key => $value) {
                    if ($value['id']==$context['subprefeitura']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Subprefeitura: ' . $name;
            }

            if (!empty($context['objetivo'])) {
                foreach ($context['objetivos'] as $key => $value) {
                    if ($value['id']==$_GET['objetivo']) {
                        $name = $value['description'];
                    }
                }
                $context['filtros_usados'][] = 'Objetivo: ' . $name;
            }

            if (!empty($context['secretaria'])) {
                foreach ($context['secretarias'] as $key => $value) {
                    if ($value['id']==$_GET['secretaria']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Secretaria: ' . $name;
            }

            if (!empty($context['status'])) {
                if (1==$_GET['status']) {
                    $name = 'Não iniciada';
                } elseif (2==$_GET['status']) {
                    $name = 'Em andamento';
                } elseif (3==$_GET['status']) {
                    $name = 'Já beneficiam a população';
                } elseif (4==$_GET['status']) {
                    $name = 'Concluídas';
                }
                $context['filtros_usados'][] = 'Situação: ' . $name;
            }

            if (!empty($context['eixo'])) {
                foreach ($context['eixos'] as $key => $value) {
                    if ($value['id']==$context['eixo']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Eixo: ' . $name;
            }

            if (!empty($context['articulacao'])) {
                foreach ($context['articulacoes'] as $key => $value) {
                    if ($value['id']==$context['articulacao']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Articulação: ' . $name;
            }


            if (!empty($context['selo'])) {
                foreach ($context['selos'] as $key => $value) {
                    if ($value['id']==$context['selo']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Selo: ' . $name;
            }

        }


        $context['subprefeitura_active'] = $_GET['subprefeitura'];
        if (!empty($_GET['subprefeitura'])) {
            $context['filtro_so_subprefeitura'] = 'sim';
        }
        return $context;
    }

    public static function buscaPorCoordenada($lat, $long)
    {
        $api = new ApiClient;
        return $api->getSubPrefeiturasPorCoordenadas($lat, $long);
    }

    public static function metaFollow($params)
    {
        $api = new ApiClient;

        $valid = false;
        if ((!empty($params['name'])) &&
            (!empty($params['email']))) {

            $valid = true;
        }

        if (($valid) && ($api->seguirMeta($params['meta'], $params['name'], $params['email']))) {
            return '<h4>Olá ' . $params['name'] . ', seu e-email ' . $params['email'] .
                   ' foi incluído com sucesso</h4>';
        } else {
            return 'Falha ao tentar cadastrar seu email. Verifique seus dados e tente novamente.';
        }
    }
}
