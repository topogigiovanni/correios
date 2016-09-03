<?php
/**
 * Classe que irá conter um objeto de rastreamento de encomendas.
 *
 * @author Ivan Wilhelm <ivan.whm@outlook.com>
 * @version 1.3
 */

namespace correios\Rastreamento;

class CorreiosRastreamentoResultadoOjeto extends CorreiosRastreamentoResultado
{

    /**
     * Contém o número do objeto enviado.
     *
     * @var string
     */
    private $objeto;

    /**
     * Contém a sigla do objeto enviado.
     *
     * @var string
     */
    private $sigla;

    /**
     * Contém o nome do objeto enviado.
     *
     * @var string
     */
    private $nome;

    /**
     * Contém a categoria do objeto enviado.
     *
     * @var string
     */
    private $categoria;

    /**
     * Contém a descrição de um determinado evento.
     *
     * @var CorreiosRastreamentoResultadoEvento[]
     */
    private $evento;

    /**
     * Indica o número do objeto enviado.
     *
     * @param string $objeto Número do objeto enviado.
     */
    public function setObjeto($objeto)
    {
      $this->objeto = $objeto;
    }

    /**
     * Indica a sigla do objeto enviado.
     *
     * @param string $sigla Sigla do objeto enviado.
     */
    public function setSigla($sigla)
    {
      $this->sigla = $sigla;
    }

    /**
     * Indica o nome do objeto enviado.
     *
     * @param string $nome Nome do objeto enviado.
     */
    public function setNome($nome)
    {
      $this->nome = $nome;
    }

    /**
     * Indica a categoria do objeto enviado.
     *
     * @param string $categoria Categoria do objeto enviado.
     */
    public function setCategoria($categoria)
    {
      $this->categoria = $categoria;
    }        
    
    /**
     * Adiciona um evento ao rastreamento.
     *
     * @param CorreiosRastreamentoResultadoEvento $evento Evento do objeto.
     */
    public function addEvento(CorreiosRastreamentoResultadoEvento $evento)
    {
      $this->evento[] = $evento;
    }

    /**
     * Retorna o número do objeto enviado.
     *
     * @return string
     */
    public function getObjeto()
    {
      return $this->objeto;
    }

    /**
     * Retorna a sigla do objeto enviado.
     *
     * @return string
     */
    public function getSigla()
    {
      return $this->sigla;
    }

    /**
     * Retorna o nome do objeto enviado.
     *
     * @return string
     */
    public function getNome()
    {
      return $this->nome;
    }

    /**
     * Retorna a categoria do objeto enviado.
     *
     * @return string
     */
    public function getCategoria()
    {
      return $this->categoria;
    }
    
    /**
     * Retorna a descrição de um determinado evento.
     *
     * @return CorreiosRastreamentoResultadoEvento[]
     */
    public function getEventos()
    {
      return $this->evento;
    }

}
