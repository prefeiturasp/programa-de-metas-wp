# Programa de Metas

## O que é?
Um programa da Prefeitura que diz quais são as metas que devem ser cumpridos durante a gestão atual.

## Versão inicial - 0.1
Foi criado rapidamente para atender uma demanda urgente que era a de disponibilização das metas na web.

Download dessa versão [aqui](https://bitbucket.org/pmsp-smdu/programa-de-metas/src/08ac61ad8b3bddc8cb48b4f03d6af5a23bc595af/?at=0.1).

## Inclusão de Acompanhamento e melhora na usabilidade - 0.2
Foi criada [um estudo em wireframe](https://docs.google.com/drawings/d/1PLo3cUmlCq9Beh-tEBLr5_S2HgcqUMWNNPQZ3c6nr4c/edit) de como melhorar o formato atual de navegação e visualização.

## API

Obrigatoriamente a instalação do wordpress necessita estar com o tema selecionado e com a ***criação de uma página com o template API*** na instalação.

Para fazer um teste, segue um trecho de código exemplo:

```
$baseUrl = 'http://planejasampa.prefeitura.sp.gov.br/programademetas/api/?meta=1';

$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, $baseUrl); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
$result = json_decode($output);
curl_close($ch);
```

### Bando de dados

Disponível na área [downloads do repositório](https://bitbucket.org/pmsp-smdu/programa-de-metas/downloads).