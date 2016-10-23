<?php

/**
 * Classe para Rastreamento de Objetos via XML.
 * Baseado na versão 1.5 do manual.
 *
 * Para automatizar o processo de retorno de informações sobre o rastreamento de objetos,
 * o cliente pode conectar-se ao servidor do Sistema de Rastreamento de Objetos – SRO e
 * obter detalhes (rastros) dos objetos postados fazendo uso do padrão XML
 * (eXtensible Markup Language) para intercâmbio das informações.
 *
 * Cada consulta ao sistema fornece informações sobre o rastreamento de até 50 objetos
 * por conexão, sem limites de conexões.
 *
 * O Cliente deverá informar os números dos objetos a rastrear através de uma
 * conexão HTTP (HyperText Transfer Protocol).
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Rastreamento;

use correios\Correios;
use correios\Sro\CorreiosSro;

class CorreiosRastreamento extends Correios {

    /**
     * Contém a definição de como a lista de identificadores de objetos deverá ser
     * interpretada pelo servidor de SRO.
     *
     * @var string
     */
    private $tipo;

    /**
     * Contém o idioma de retorno das informações.
     *
     * @var string
     */
    private $lingua;

    /**
     * Contém a delimitação de escopo da resposta a ser data à consulta do
     * rastreamento de cada objeto.
     *
     * @var string
     */
    private $resultado;

    /**
     * Contém a lista de objetos a pesquisar.
     *
     * @var array
     */
    private $objetos = array();

    /**
     * Contém o objeto de retorno.
     *
     * @var CorreiosRastreamentoResultado
     */
    private $retorno;

    /**
     * Indica como a lista de identificadores de objetos deverá ser
     * interpretada pelo servidor de SRO.
     *
     * @param string $tipo Tipo de rastreamento.
     * @throws \Exception
     */
    public function setTipo($tipo) {
        if (in_array($tipo, parent::$tiposRastreamento)) {
            $this->tipo = $tipo;
        } else {
            throw new \Exception('O tipo de rastreamento informado é inválido.');
        }
    }

    /**
     * Indica o idioma do resultado do rastreamento.
     *
     * @param string $lingua Idioma do rastreamento.
     * @throws \Exception
     */
    public function setLingua($lingua) {
        if (in_array($lingua, parent::$linguasRastreamento)) {
            $this->lingua = $lingua;
        } else {
            throw new \Exception('O idioma de rastreamento informado é inválido.');
        }
    }

    /**
     * Indica o escopo da resposta a ser data à consulta do rastreamento de cada objeto.
     *
     * @param string $resultado Resultado do rastreamento.
     * @throws \Exception
     */
    public function setResultado($resultado) {
        if (in_array($resultado, parent::$resultadosRastreamento)) {
            $this->resultado = $resultado;
        } else {
            throw new \Exception('O tipos de resultado de rastreamento informado é inválido.');
        }
    }

    /**
     * Adiona um objeto a lista de objetos a serem pesquisados.
     *
     * @param string $objeto Objeto de rastreamento
     * @throws \Exception
     */
    public function addObjeto($objeto) {
        if (CorreiosSro::validaSro($objeto)) {
            $this->objetos[] = $objeto;
        } else {
            throw new \Exception('O número de objeto informado é inválido.');
        }
    }

    /**
     * Retorna a lista dos objetos a serem pesquisados um após o outro,
     * sem espaços ou outro símbolo separador.
     *
     * @return array
     */
    private function getObjetos() {
        return $this->objetos;
    }

    /**
     * Retorna o objeto do resultado.
     *
     * @return CorreiosRastreamentoResultado
     */
    public function getRetorno() {
        return $this->retorno;
    }

    /**
     * Returna os parâmetros necessários para a chamada.
     *
     * @return array
     */
    protected function getParametros() {
        $parametros = array(
            'usuario' => (string) $this->getUsuario(),
            'senha' => (string) $this->getSenha(),
            'tipo' => (string) $this->tipo,
            'lingua' => (string) $this->lingua,
            'resultado' => (string) $this->resultado,
            'objetos' => $this->getObjetos(),
        );
        return $parametros;
    }

    /**
     * Processa a consulta e armazena o resultado.
     *
     * @return boolean
     * @throws Exception
     */
    public function processaConsulta() {

        ini_set("allow_url_fopen", 1);
        ini_set("soap.wsdl_cache_enabled", 0);
        ini_set("default_socket_timeout", 15);

        $retorno = FALSE;
        //Valida se o servidor está no ar
        if (@fopen(parent::URL_RASTREADOR, 'r')) {
            try {
                $soap = new \SoapClient(parent::URL_RASTREADOR);
                $resultado = $soap->buscaEventosLista($this->getParametros());

                if ($resultado instanceof \stdClass) {
                    $rastreamento = new CorreiosRastreamentoResultado();
                    $rastreamento->setVersao(isset($resultado->return->versao) ? (string) $resultado->return->versao : '');
                    $rastreamento->setQuantidade(isset($resultado->return->qtd) ? (int) $resultado->return->qtd : 0);
                    if ($rastreamento->getQuantidade() > 0 && isset($resultado->return->objeto)) {
                        //Verifica os objetos
                        foreach ((array) $resultado->return->objeto as $objetoDetalhe) {
                            if (!isset($objetoDetalhe->erro)) {
                                $objeto = new CorreiosRastreamentoResultadoObjeto();
                                $objeto->setObjeto(isset($objetoDetalhe->numero) ? (string) $objetoDetalhe->numero : '');
                                $objeto->setSigla(isset($objetoDetalhe->sigla) ? (string) $objetoDetalhe->sigla : '');
                                $objeto->setNome(isset($objetoDetalhe->nome) ? (string) $objetoDetalhe->nome : '');
                                $objeto->setCategoria(isset($objetoDetalhe->categoria) ? (string) $objetoDetalhe->categoria : '');

                                if (isset($objetoDetalhe->evento) && is_array($objetoDetalhe->evento)) {
                                    //Verifica os eventos do objeto
                                    foreach ((array) $objetoDetalhe->evento as $eventoObjeto) {
                                        $evento = new CorreiosRastreamentoResultadoEvento();
                                        $evento->setTipoDoEvento(isset($eventoObjeto->tipo) ? (string) $eventoObjeto->tipo : '');
                                        $evento->setStatus(isset($eventoObjeto->status) ? (integer) $eventoObjeto->status : 0);
                                        $evento->setData(isset($eventoObjeto->data) ? (string) $eventoObjeto->data : '');
                                        $evento->setHora(isset($eventoObjeto->hora) ? (string) $eventoObjeto->hora : '');
                                        $evento->setDescricao(isset($eventoObjeto->descricao) ? (string) $eventoObjeto->descricao : '');
                                        $evento->setLocalEvento(isset($eventoObjeto->local) ? (string) $eventoObjeto->local : '');
                                        $evento->setCodigoEvento(isset($eventoObjeto->codigo) ? (string) $eventoObjeto->codigo : '');
                                        $evento->setCidadeEvento(isset($eventoObjeto->cidade) ? (string) $eventoObjeto->cidade : '');
                                        $evento->setUfEvento(isset($eventoObjeto->uf) ? (string) $eventoObjeto->uf : '');
                                        //Adiciona os detalhes do evento na lista
                                        $objeto->addEvento($evento);
                                    }
                                } elseif (isset($objetoDetalhe->evento) && $objetoDetalhe->evento instanceof \stdClass) {
                                    $evento = new CorreiosRastreamentoResultadoEvento();
                                    $evento->setTipoDoEvento(isset($objetoDetalhe->evento->tipo) ? (string) $objetoDetalhe->evento->tipo : '');
                                    $evento->setStatus(isset($objetoDetalhe->evento->status) ? (integer) $objetoDetalhe->evento->status : 0);
                                    $evento->setData(isset($objetoDetalhe->evento->data) ? (string) $objetoDetalhe->evento->data : '');
                                    $evento->setHora(isset($objetoDetalhe->evento->hora) ? (string) $objetoDetalhe->evento->hora : '');
                                    $evento->setDescricao(isset($objetoDetalhe->evento->descricao) ? (string) $objetoDetalhe->evento->descricao : '');
                                    $evento->setLocalEvento(isset($objetoDetalhe->evento->local) ? (string) $objetoDetalhe->evento->local : '');
                                    $evento->setCodigoEvento(isset($objetoDetalhe->evento->codigo) ? (string) $objetoDetalhe->evento->codigo : '');
                                    $evento->setCidadeEvento(isset($objetoDetalhe->evento->cidade) ? (string) $objetoDetalhe->evento->cidade : '');
                                    $evento->setUfEvento(isset($objetoDetalhe->evento->uf) ? (string) $objetoDetalhe->evento->uf : '');
                                    //Adiciona os detalhes do evento na lista
                                    $objeto->addEvento($evento);
                                }

                                //Adiciona o resultado do objeto na lista
                                $rastreamento->addResultado($objeto);
                            } else {
                                $reduzQtd = (int) $rastreamento->getQuantidade();
                                $rastreamento->setQuantidade($reduzQtd--);
                            }

                            $retorno = TRUE;
                        }
                    }
                    $this->retorno = $rastreamento;
                }
            } catch (\SoapFault $sf) {
                throw new \Exception($sf->getMessage());
            }
        }
        return $retorno;
    }

}
