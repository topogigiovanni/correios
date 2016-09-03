<?php

/**
 * Contém um exemplo de utilização da classe de Cálculo Remoto de Preços e Prazos
 * dos Correios.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace Exemplos;

require __DIR__ . '/../vendor/autoload.php';

use correios\Correios;
use correios\PrecoPrazo\CorreiosPrecoPrazo;

//Ajusta a codificação e o tipo do conteúdo
header('Content-type: text/txt; charset=utf-8');

date_default_timezone_set('America/Sao_Paulo');

try {
    //Cria o objeto, definindo que o retorno deve ser preço e prazo.
    //Nesta nova versão é possível retornar apenas o preço ou apenas o prazo.
    $calculo = new CorreiosPrecoPrazo('ECT', 'ECT', Correios::TIPO_CALCULO_PRECO_TODOS);
    //Envia os parâmetros
    //Parâmetros necessários apenas nos tipos de cálculo todos OU SO_PRAZO
    $calculo->setCepOrigem('89050100');
    $calculo->setCepDestino('89010130');
    $calculo->addServico(Correios::SERVICO_SEDEX_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_PAC_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_SEDEX_10_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_ESEDEX_COM_CONTRATO);
    //Parâmetros necessários apenas nos tipos de cálculo TODOS ou SO_PRECO
    $calculo->setFormato(Correios::FORMATO_CAIXA_PACOTE);
    $calculo->setPeso(9.56);
    $calculo->setValorDeclarado(637.89);
    $calculo->hasMaoPropria(FALSE);
    $calculo->hasAvisoRecebimento(TRUE);
    $calculo->setAltura(2.0);
    $calculo->setLargura(11.0);
    $calculo->setComprimento(16.0);
    //Se as chamadas forem realizadas a partir de uma database
    //Caso contrário não necessita chamar o método.
    $calculo->setDataBaseCalculo(new \DateTime('03/03/2013'));
    //Verifica processamento
    if ($calculo->processaConsulta()) {
        //Itera no retorno
        foreach ($calculo->getRetorno() as $retorno) {
            //Se não teve erro
            if ($retorno->getErro() === 0) {
                //Imprime o resultado
                echo 'Serviço................................: ' . $retorno->getCodigo() . ' (' . Correios::$descricaoServico[$retorno->getCodigo()] . ')' . PHP_EOL;
                if ($calculo->getDataBaseCalculo() instanceof \DateTime) {
                    echo 'Database de cálculo....................: ' . $calculo->getDataBaseCalculo()->format('d/m/Y') . PHP_EOL;
                }
                if (($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_TODOS) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_SO_PRAZO) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_TODOS_COM_DATABASE) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_SO_PRAZO_COM_DATABASE)) {
                    $entregaDomiciliar = $retorno->getEntregaDomiciliar() ? 'Sim' : 'Não';
                    $entregaSabado = $retorno->getEntregaSabado() ? 'Sim' : 'Não';
                    echo 'Prazo de entrega.......................: ' . $retorno->getPrazoEntrega() . PHP_EOL;
                    echo 'Entrega domiciliar.....................: ' . $entregaDomiciliar . PHP_EOL;
                    echo 'Entrega sábado.........................: ' . $entregaSabado . PHP_EOL;
                }
                if (($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_TODOS) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_SO_PRECO) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_TODOS_COM_DATABASE) ||
                    ($calculo->getTipoCalculo() == Correios::TIPO_CALCULO_PRECO_SO_PRECO_COM_DATABASE)) {
                    echo 'Valor..................................: R$ ' . number_format($retorno->getValor(), 2, ',', '.') . PHP_EOL;
                    echo 'Valor do serviço mão própria...........: R$ ' . number_format($retorno->getValorMaoPropria(), 2, ',', '.') . PHP_EOL;
                    echo 'Valor do serviço aviso de recebimento..: R$ ' . number_format($retorno->getValorAvisoRecebimento(), 2, ',', '.') . PHP_EOL;
                    echo 'Valor do serviço valor declarado.......: R$ ' . number_format($retorno->getValorValorDeclarado(), 2, ',', '.') . PHP_EOL;
                }
                echo PHP_EOL;
            } else {
                echo 'Ocorreu um erro no cálculo do serviço ' . $retorno->getCodigo() . ' (' . Correios::$descricaoServico[$retorno->getCodigo()] . '): ' . $retorno->getMensagemErro() . PHP_EOL . PHP_EOL;
            }
        }
    } else {
        echo 'Ocorreu um erro, tente novamente mais tarde.' . PHP_EOL;
    }
} catch (\Exception $e) {
    echo 'Ocorreu um erro ao processar sua solicitação. Erro: ' . $e->getMessage() . PHP_EOL;
}
