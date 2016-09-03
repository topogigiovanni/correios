<?php

/**
 * Contém um exemplo de utilização da classe de rastreamento de objetos.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.2
 */

namespace correios\Exemplos;

require __DIR__ . '/../vendor/autoload.php';

use correios\Correios;
use correios\Rastreamento\CorreiosRastreamento;
use correios\Sro\CorreiosSroDados;

//Ajusta a codificação e o tipo do conteúdo
header('Content-type: text/txt; charset=utf-8');

try {
    //Cria o objeto
    $rastreamento = new CorreiosRastreamento('ECT', 'SRO');
    //Envia os parâmetros
    $rastreamento->setTipo(Correios::TIPO_RASTREAMENTO_INTERVALO);
    $rastreamento->setResultado(Correios::RESULTADO_RASTREAMENTO_TODOS);
    $rastreamento->setLingua(Correios::LINGUA_PORTUGUES);
    $rastreamento->addObjeto('DU607265998BR');
    $rastreamento->addObjeto('DU131229547BR');
    if ($rastreamento->processaConsulta()) {
	$retorno = $rastreamento->getRetorno();
	if ($retorno->getQuantidade() > 0) {
	    echo 'Versão.................................: ' . $retorno->getVersao() . PHP_EOL;
	    echo 'Quantidade.............................: ' . $retorno->getQuantidade() . PHP_EOL;
	    foreach ($retorno->getResultados() as $resultado) {
		echo 'Objeto.................................: ' . $resultado->getObjeto() . PHP_EOL;
		echo 'Sigla..................................: ' . $resultado->getSigla() . PHP_EOL;
		echo 'Nome...................................: ' . $resultado->getNome() . PHP_EOL;
		echo 'Categoria..............................: ' . $resultado->getCategoria() . PHP_EOL;
		//Se desejar obter informações sobre o objeto
		$dadosObjeto = new CorreiosSroDados($resultado->getObjeto());
		echo 'Serviço................................: ' . $dadosObjeto->getDescricaoTipoServico() . PHP_EOL;
		echo PHP_EOL;
		foreach ($resultado->getEventos() as $eventos) {
		    echo ' - Tipo................................: ' . $eventos->getTipo() . ' - ' . $eventos->getDescricaoTipo() . PHP_EOL;
		    echo ' - Status..............................: ' . $eventos->getStatus() . PHP_EOL;
		    echo ' - Descrição do status.................: ' . $eventos->getDescricaoStatus() . PHP_EOL;
		    echo ' - Ação relacionada ao status..........: ' . $eventos->getAcaoStatus() . PHP_EOL;
		    echo ' - Data................................: ' . $eventos->getData() . ' ' . $eventos->getHora() . PHP_EOL;
		    echo ' - Descrição...........................: ' . $eventos->getDescricao() . PHP_EOL;
		    echo ' - Detalhes............................: ' . $eventos->getDetalhe() . PHP_EOL;
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
