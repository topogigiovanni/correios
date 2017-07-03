<?php

/**
 * Classe que irá conter um evento de rastreamento de encomendas.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Rastreamento;

use correios\Correios;

final class CorreiosRastreamentoResultadoEvento extends CorreiosRastreamentoResultadoObjeto {

    /**
     * Contém o tipo do evento de retorno.
     *
     * @var string
     */
    private $tipoDoEvento;

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
     * Retorna o tipo do evento de retorno.
     *
     * @return string
     */
    public function getTipoDoEvento() {
        return $this->tipoDoEvento;
    }

    /**
     * Indica o tipo do evento de retorno.
     *
     * @param string $tipoDoEvento Tipo do evento de retorno.
     */
    public function setTipoDoEvento($tipoDoEvento) {
        $this->tipoDoEvento = $tipoDoEvento;
    }

    /**
     * Retorna a descrição do tipo.
     *
     * @return string
     */
    public function getDescricaoTipo() {
        return (isset(Correios::$eventTypes[$this->tipoDoEvento]) ? Correios::$eventTypes[$this->tipoDoEvento] : '');
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
     * Indica a data do evento.
     *
     * @param string $data Data do evento.
     */
    public function setData($data) {
        $this->data = $data;
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
     * Indica a hora do evento.
     *
     * @param string $hora Hora do evento.
     */
    public function setHora($hora) {
        $this->hora = $hora;
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
     * Indica a descrição do evento.
     *
     * @param string $descricao Descrição do evento.
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
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
     * Indica o local onde ocorreu o evento.
     *
     * @param string $local Local onde ocorreu o evento.
     */
    public function setLocalEvento($local) {
        $this->localEvento = $local;
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
     * Indica o CEP da unidade ECT.
     *
     * @param string $codigo CEP da unidade ECT.
     */
    public function setCodigoEvento($codigo) {
        $this->codigoEvento = $codigo;
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
     * Indica a cidade onde ocorreu o evento.
     *
     * @param string $cidade Cidade onde ocorreu o evento.
     */
    public function setCidadeEvento($cidade) {
        $this->cidadeEvento = $cidade;
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
     * Indica a unidade da federação.
     *
     * @param string $uf Unidade da federação.
     */
    public function setUfEvento($uf) {
        $this->ufEvento = $uf;
    }

    /**
     * Retorna a descrição do status do objeto.
     * 
     * @return string
     */
    public function getDescricaoStatus() {
        return isset(Correios::$trackingStatus[$this->getStatus()][$this->tipoDoEvento]) ?
                Correios::$trackingStatus[$this->getStatus()][$this->tipoDoEvento]['message'] : 'Status desconhecido.';
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
     * Indica o status do evento de retorno.
     *
     * @param integer $status Status do evento de retorno.
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Retorna a descrição do status do objeto.
     * 
     * @return string
     */
    public function getAcaoStatus() {
        return isset(Correios::$trackingStatus[$this->getStatus()][$this->tipoDoEvento]) ?
                Correios::$trackingStatus[$this->getStatus()][$this->tipoDoEvento]['action'] : 'Ação desconhecida.';
    }

}
