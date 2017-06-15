<?php

/**
 * Contém um exemplo de utilização da classe de rastreamento de objetos.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Exemplos;

require __DIR__ . '/../vendor/autoload.php';

use correios\Correios;
use correios\Rastreamento\CorreiosRastreamento;
use correios\Sro\CorreiosSroData;

//Ajusta a codificação e o tipo do conteúdo
header('Content-type: text/txt; charset=utf-8');

try {
    //Cria o objeto
    $rastreamento = new CorreiosRastreamento('ECT', 'SRO');
    //Envio dos parâmetros
    $rastreamento->setTipo(Correios::TIPO_RASTREAMENTO_LISTA);
    //Não use a opção TIPO_RASTREAMENTO_INTERVALO. Quando utilizada está retornando NullPointerException
    $rastreamento->setResultado(Correios::RESULTADO_RASTREAMENTO_ULTIMO);
    $rastreamento->setLingua(Correios::LINGUA_PORTUGUES);
    $rastreamento->addObjeto('DU607265998BR');
    $rastreamento->addObjeto('JO144618395BR');
    $rastreamento->addObjeto('PJ964348359BR');
    $rastreamento->addObjeto('PL125563535BR');

    if ($rastreamento->process()) {
        $retorno = $rastreamento->getRetorno();
        if ($retorno->getQuantidade() > 0) {
            echo 'Versão.................................: ' . $retorno->getVersao() . PHP_EOL;
            echo 'Quantidade.............................: ' . $retorno->getQuantidade() . PHP_EOL;
            foreach ($retorno->getResultados() as $resultado) {
                echo PHP_EOL;
                echo 'Objeto.................................: ' . $resultado->getObjeto() . PHP_EOL;
                echo 'Sigla..................................: ' . $resultado->getSigla() . PHP_EOL;
                echo 'Nome...................................: ' . $resultado->getNome() . PHP_EOL;
                echo 'Categoria..............................: ' . $resultado->getCategoria() . PHP_EOL;
                //Se desejar obter informações sobre o objeto
                $dadosObjeto = new CorreiosSroData($resultado->getObjeto());
                echo 'Serviço................................: ' . $dadosObjeto->getServiceDescription() . PHP_EOL;
                echo 'Eventos do objeto: ' . PHP_EOL;
                foreach ($resultado->getEventos() as $eventos) {
                    echo PHP_EOL;
                    echo ' - Tipo................................: ' . $eventos->getTipoDoEvento() . ' - ' . $eventos->getDescricaoTipo() . PHP_EOL;
                    echo ' - Status..............................: ' . $eventos->getStatus() . PHP_EOL;
                    echo ' - Descrição do status.................: ' . $eventos->getDescricaoStatus() . PHP_EOL;
                    echo ' - Ação relacionada ao status..........: ' . $eventos->getAcaoStatus() . PHP_EOL;
                    echo ' - Data................................: ' . $eventos->getData() . ' ' . $eventos->getHora() . PHP_EOL;
                    echo ' - Descrição...........................: ' . $eventos->getDescricao() . PHP_EOL;
                    echo ' - Local do evento.....................: ' . $eventos->getLocalEvento() . ' (' . $eventos->getCidadeEvento() . ', ' . $eventos->getUfEvento() . ')' . PHP_EOL;
                }
            }
        }
    } else {
        echo 'Nenhum rastreamento encontrado.' . PHP_EOL;
    }
} catch (\Exception $e) {
    echo 'Ocorreu um erro ao processar sua solicitação. Erro: ' . $e->getMessage() . PHP_EOL;
}
