<?php

/**
 * Classe que irá conter o resultado de um rastreamento de encomendas.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Rastreamento;

class CorreiosRastreamentoResultado extends CorreiosRastreamento {

    /**
     * Contém a versão do SRO do XML.
     *
     * @var string
     */
    private $versao;

    /**
     * Contém a quantidade de objetos consultados.
     *
     * @var integer
     */
    private $quantidade;

    /**
     * Contém resultados em forma de eventos.
     *
     * @var CorreiosRastreamentoResultadoOjeto[]
     */
    private $resultados;

    /**
     * Indica a versão do SRO do XML.
     *
     * @param string $versao Versão do SRO do XML.
     */
    public function setVersao($versao) {
        $this->versao = $versao;
    }

    /**
     * Indica a quantidade de objetos consultados.
     *
     * @param integer $quantidade Quantidade de objetos consultados.
     */
    public function setQuantidade($quantidade) {
        $this->quantidade = (int) $quantidade;
    }

    /**
     * Adiciona um resultado de objeto.
     *
     * @param CorreiosRastreamentoResultadoOjeto $objeto Resultado.
     */
    public function addResultado(CorreiosRastreamentoResultadoOjeto $objeto) {
        $this->resultados[] = $objeto;
    }

    /**
     * Retorna a versão do SRO do XML.
     *
     * @return string
     */
    public function getVersao() {
        return $this->versao;
    }

    /**
     * Retorna a quantidade de objetos consultados.
     *
     * @return integer
     */
    public function getQuantidade() {
        return $this->quantidade;
    }

    /**
     * Retorna os resultados em forma de eventos.
     *
     * @return CorreiosRastreamentoResultadoOjeto[]
     */
    public function getResultados() {
        return $this->resultados;
    }

}
