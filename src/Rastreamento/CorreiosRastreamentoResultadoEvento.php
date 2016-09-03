<?php

/**
 * Classe que irá conter um evento de rastreamento de encomendas.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Rastreamento;

use correios\Correios;

final class CorreiosRastreamentoResultadoEvento extends CorreiosRastreamentoResultadoOjeto {

    /**
     * Contém o tipo do evento de retorno.
     *
     * @var string
     */
    private $tipoEvento;

    /**
     * Contém o status do evento de retorno.
     *
     * @var integer
     */
    private $status;

    /**
     * Contém a data do evento.
     *
     * @var string
     */
    private $data;

    /**
     * Contém a hora do evento.
     *
     * @var string
     */
    private $hora;

    /**
     * Contém a descrição do evento.
     *
     * @var string
     */
    private $descricao;

    /**
     * Contém o detalhe sobre o evento.
     *
     * @var string
     */
    private $detalhe;

    /**
     * Contém o local onde ocorreu o evento.
     *
     * @var string
     */
    private $localEvento;

    /**
     * Contém o CEP da unidade ECT.
     *
     * @var string
     */
    private $codigoEvento;

    /**
     * Contém a cidade onde ocorreu o evento.
     *
     * @var string
     */
    private $cidadeEvento;

    /**
     * Contém a unidade da federação onde ocorreu o evento.
     *
     * @var string
     */
    private $ufEvento;

    /**
     * Indica o tipo do evento de retorno.
     *
     * @param string $tipoEvento Tipo do evento de retorno.
     */
    public function setTipoEvento($tipoEvento) {
        $this->tipotipoEvento = $tipoEvento;
    }

    /**
     * Indica o status do evento de retorno.
     *
     * @param integer $status Status do evento de retorno.
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Indica a data do evento.
     *
     * @param string $data Data do evento.
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * Indica a hora do evento.
     *
     * @param string $hora Hora do evento.
     */
    public function setHora($hora) {
        $this->hora = $hora;
    }

    /**
     * Indica a descrição do evento.
     *
     * @param string $descricao Descrição do evento.
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * Indica o detalhe sobre o evento.
     *
     * @param string $detalhe Detalhe sobre o evento.
     */
    public function setDetalhe($detalhe) {
        $this->detalhe = $detalhe;
    }

    /**
     * Indica o local onde ocorreu o evento.
     *
     * @param string $local Local onde ocorreu o evento.
     */
    public function setLocalEvento($local) {
        $this->localEvento = $local;
    }

    /**
     * Indica o CEP da unidade ECT.
     *
     * @param string $codigo CEP da unidade ECT.
     */
    public function setCodigoEvento($codigo) {
        $this->codigoEvento = $codigo;
    }

    /**
     * Indica a cidade onde ocorreu o evento.
     *
     * @param string $cidade Cidade onde ocorreu o evento.
     */
    public function setCidadeEvento($cidade) {
        $this->cidadeEvento = $cidade;
    }

    /**
     * Indica a unidade da federação.
     *
     * @param string $uf Unidade da federação.
     */
    public function setUfEvento($uf) {
        $this->ufEvento = $uf;
    }

    /**
     * Retorna o tipo do evento de retorno.
     *
     * @return string
     */
    public function getTipoEvento() {
        return $this->tipoEvento;
    }

    /**
     * Retorna a descrição do tipo.
     *
     * @return string
     */
    public function getDescricaoTipo() {
        return (isset(Correios::$tipoEvento[$this->tipoEvento]) ? Correios::$tipoEvento[$this->tipoEvento] : '');
    }

    /**
     * Retorna o status do evento de retorno.
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Retorna a data do evento.
     *
     * @return string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Retorna a hora do evento.
     *
     * @return string
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Retorna a descrição do evento.
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Retorna o detalhe sobre o evento.
     *
     * @return string
     */
    public function getDetalhe() {
        return $this->detalhe;
    }

    /**
     * Retorna o local onde ocorreu o evento.
     *
     * @return string
     */
    public function getLocalEvento() {
        return $this->localEvento;
    }

    /**
     * Retorna o CEP da unidade ECT.
     *
     * @return string
     */
    public function getCodigoEvento() {
        return $this->codigoEvento;
    }

    /**
     * Retorna a cidade onde ocorreu o evento.
     *
     * @return string
     */
    public function getCidadeEvento() {
        return $this->cidadeEvento;
    }

    /**
     * Retorna a unidade da federação.
     *
     * @return string
     */
    public function getUfEvento() {
        return $this->ufEvento;
    }

    /**
     * Retorna a descrição do status do objeto.
     * @return string
     */
    public function getDescricaoStatus() {
        return isset(Correios::$statusRastreamento[$this->getStatus()][$this->tipoEvento]) ?
                     Correios::$statusRastreamento[$this->getStatus()][$this->tipoEvento]['mensagem'] :
                     'Status desconhecido.';
    }

    /**
     * Retorna a descrição do status do objeto.
     * @return string
     */
    public function getAcaoStatus() {
        return isset(Correios::$statusRastreamento[$this->getStatus()][$this->tipoEvento]) ?
                     Correios::$statusRastreamento[$this->getStatus()][$this->tipoEvento]['acao'] :
                     'Ação desconhecida.';
    }

}
