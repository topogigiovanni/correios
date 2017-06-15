# Correios - Várias Classes em PHP para diversos serviços dos Correios

[![Build Status](https://travis-ci.org/ivanwhm/correios.svg)](https://travis-ci.org/ivanwhm/correios)
[![Build Status](https://scrutinizer-ci.com/g/ivanwhm/correios/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ivanwhm/correios/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ivanwhm/correios/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ivanwhm/correios/?branch=master)

## Cálculo de Preço e Prazo de entrega

O cálculo remoto de preços e prazos de encomendas dos [Correios](http://www.correios.com.br) é destinado aos clientes que possuem [contrato](http://www.correios.com.br/para-sua-empresa/servicos-para-o-seu-contrato) de Sedex, e-Sedex e PAC, que necessitam calcular, no seu site e de forma personalizada, o preço e o prazo de entrega de uma encomenda.

É possível também a um cliente que **não** possui contrato de encomenda com os [Correios](http://www.correios.com.br) realizar o cálculo, porém, neste caso os preços apresentados serão aqueles praticados no balcão da agência.

Os manuais de especificação estão salvos na pasta [docs](/docs/delivery_and_price) deste projeto, e você pode ter um exemplo de uso [clicando aqui](/examples/delivery_and_price_calculation.php).

A versão atual das classes está trabalhando de acordo com a versão 1.9 do webservice dos [Correios](http://www.correios.com.br).


## Rastreamento de encomendas

Para automatizar o processo de retorno de informações sobre o rastreamento de objetos, o cliente pode conectar-se ao servidor do Sistema de Rastreamento de Objetos – SRO e obter detalhes dos objetos postados fazendo uso do padrão XML (eXtensible Markup Language) para intercâmbio das informações.

Cada consulta ao sistema fornece informações sobre o rastreamento de até 5000 objetos por conexão, sem limites de conexões.

O cliente deverá informar os números dos objetos a rastrear através de uma conexão HTTP (HyperText Transfer Protocol).

Os manuais de especificação estão salvos na pasta [docs](/docs/rastreamento) deste projeto, e você pode ter um exemplo de uso [clicando aqui](/examples/rastreamento_objeto.php).

A versão atual das classes está trabalhando de acordo com a versão 1.5 do webservice dos [Correios](http://www.correios.com.br).

> Desde a última alteração da URL de rastreamento, notamos uma lentidão enorme nas chamadas SOAP. Já estou trabalhando para criar uma alternativa utilizando cUrl. Infelizmente por falta de tempo, não tenho previsão e se você desejar ajudar, faça ajustes e envie um Pull Request.


## Validação/Identificação/Geração de dígito verificador de códigos de rastreio (SRO)

Conjunto de funções responsável por validar, identificar os parâmetros e gerar dígito de validação
de código de rastreamento (ou número de objeto) SRO dos [Correios](http://www.correios.com.br). Pode ser útil quando se deseja obter informações a respeito de um objeto ou para entrada de dados externas em seus sistemas.

Você pode ter um exemplo de uso [clicando aqui](/examples/sro_information.php).

## Como reportar problemas

Tenho usado a ferramenta de Issues do GitHub para reportar problemas. Caso você tenha alguma dúvida ou problema, abre um Issue e eu terei o maior prazer de responder.

## Como ajudar

Caso queira ajudar no projeto, terei o maior prazer em tê-lo(a), para isto, sugiro a leitura do artigo [Be Social](https://help.github.com/articles/be-social/) do GitHub para entender melhor.


Feito com &hearts; por **Ivan Wilhelm**

Coded with [PhpStorm](https://www.jetbrains.com/phpstorm/) by [JetBrains](https://www.jetbrains.com/)