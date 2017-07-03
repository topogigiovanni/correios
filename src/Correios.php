<?php

/**
 * Class Brazilian Postal Services (Correios).
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.3
 * @abstract
 */

namespace correios;

abstract class Correios {

    const URL_CALCULATION = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';
    const URL_TRACKING = 'https://webservice.correios.com.br/service/rastro/Rastro.wsdl';

    const PACKAGE_SHAPE_BOX_PARCEL = 1;
    const PACKAGE_SHAPE_ROLLER_PRISM = 2;
    const PACKAGE_SHAPE_ENVELOPE = 3;

    const SERVICE_SEDEX_WITHOUT_CONTRACT = '40010';
    const SERVICE_SEDEX_WITHOUT_AGENCY_CONTRACT = '04014';
    const SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_1 = '40045';
    const SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_2 = '40126';
    const SERVICE_SEDEX_10_WITHOUT_CONTRACT = '40215';
    const SERVICE_SEDEX_TODAY_WITHOUT_CONTRACT = '40290';
    const SERVICE_SEDEX_WITH_CONTRACT_1 = '40096';
    const SERVICE_SEDEX_WITH_CONTRACT_2 = '40436';
    const SERVICE_SEDEX_WITH_CONTRACT_3 = '40444';
    const SERVICE_SEDEX_WITH_CONTRACT_4 = '40568';
    const SERVICE_SEDEX_WITH_CONTRACT_5 = '40606';
	const SERVICE_SEDEX_WITH_CONTRACT_AGENCY = '04162';
    const SERVICE_PAC_WITHOUT_CONTRACT = '41106';
    const SERVICE_PAC_WITHOUT_CONTRACT_AGENCY = '04510';
    const SERVICE_PAC_WITH_CONTRACT = '41068';
	const SERVICE_PAC_WITH_CONTRACT_AGENCY = '04669';

    const TRACKING_TYPE_LIST = 'L';
    const TRACKING_TYPE_INTERVAL = 'F';

    const TRACKING_RESULT_ALL = 'T';
    const TRACKING_RESULT_LAST = 'U';

    const EVENT_TYPE_BDE = 'BDE';
    const EVENT_TYPE_BDI = 'BDI';
    const EVENT_TYPE_BDR = 'BDR';
    const EVENT_TYPE_BLQ = 'BLQ';
    const EVENT_TYPE_CAR = 'CAR';
    const EVENT_TYPE_CD = 'CD';
    const EVENT_TYPE_CMR = 'CMR';
    const EVENT_TYPE_CMT = 'CMT';
    const EVENT_TYPE_CO = 'CO';
    const EVENT_TYPE_CUN = 'CUN';
    const EVENT_TYPE_DO = 'DO';
    const EVENT_TYPE_EST = 'EST';
    const EVENT_TYPE_FC = 'FC';
    const EVENT_TYPE_IDC = 'IDC';
    const EVENT_TYPE_IE = 'IE';
    const EVENT_TYPE_IT = 'IT';
    const EVENT_TYPE_LDI = 'LDI';
    const EVENT_TYPE_LDE = 'LDE';
    const EVENT_TYPE_OEC = 'OEC';
    const EVENT_TYPE_PAR = 'PAR';
    const EVENT_TYPE_PMT = 'PMT';
    const EVENT_TYPE_PO = 'PO';
    const EVENT_TYPE_RO = 'RO';
    const EVENT_TYPE_TR = 'TR';
    const EVENT_TYPE_TRI = 'TRI';

    const CALCULATION_TYPE_ONLY_PRICE = 'P';
    const CALCULATION_TYPE_ONLY_DELIVERY = 'Z';
    const CALCULATION_TYPE_ALL_PRICE = 'T';
    const CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE = 'PD';
    const CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE = 'ZD';
    const CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE = 'TD';

    const LANGUAGE_PORTUGUESE = '101';
    const LANGUAGE_ENGLISH = '102';

    /**
     * Contains the package shapes accepted.
     *
     * @var array
     * @static
     */
    protected static $packageShapes = array(
        self::PACKAGE_SHAPE_BOX_PARCEL,
        self::PACKAGE_SHAPE_ROLLER_PRISM,
        self::PACKAGE_SHAPE_ENVELOPE,
    );

    /**
     * Contains all the accepted delivery services/products.
     *
     * @var array
     * @static
     */
    protected static $services = array(
        self::SERVICE_SEDEX_WITHOUT_CONTRACT,
        self::SERVICE_SEDEX_WITHOUT_AGENCY_CONTRACT,
        self::SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_1,
        self::SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_2,
        self::SERVICE_SEDEX_10_WITHOUT_CONTRACT,
        self::SERVICE_SEDEX_TODAY_WITHOUT_CONTRACT,
        self::SERVICE_SEDEX_WITH_CONTRACT_1,
        self::SERVICE_SEDEX_WITH_CONTRACT_2,
        self::SERVICE_SEDEX_WITH_CONTRACT_3,
        self::SERVICE_SEDEX_WITH_CONTRACT_4,
        self::SERVICE_SEDEX_WITH_CONTRACT_5,
		self::SERVICE_SEDEX_WITH_CONTRACT_AGENCY,
        self::SERVICE_PAC_WITHOUT_CONTRACT,
        self::SERVICE_PAC_WITHOUT_CONTRACT_AGENCY,
        self::SERVICE_PAC_WITH_CONTRACT,
		self::SERVICE_PAC_WITH_CONTRACT_AGENCY
    );

    /**
     * Contains all the methods used in the Correios webservice to delivery and price calculations.
     *
     * @var array
     * @static
     */
    protected static $deliveryPriceMethods = array(
        Correios::CALCULATION_TYPE_ALL_PRICE => array(
            'consultation' => 'CalcPrecoPrazo',
            'return' => 'CalcPrecoPrazoResult'
        ),
        Correios::CALCULATION_TYPE_ONLY_DELIVERY => array(
            'consultation' => 'CalcPrazo',
            'return' => 'CalcPrazoResult'
        ),
        Correios::CALCULATION_TYPE_ONLY_PRICE => array(
            'consultation' => 'CalcPreco',
            'return' => 'CalcPrecoResult'
        ),
        Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE => array(
            'consultation' => 'CalcPrecoPrazoData',
            'return' => 'CalcPrecoPrazoDataResult'
        ),
        Correios::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE => array(
            'consultation' => 'CalcPrazoData',
            'return' => 'CalcPrazoDataResult'
        ),
        Correios::CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE => array(
            'consultation' => 'CalcPrecoData',
            'return' => 'CalcPrecoDataResult'
        )
    );

    /**
     * Contains all the accepted tracking types.
     *
     * @var array
     * @static
     */
    protected static $trackingTypes = array(
        self::TRACKING_TYPE_LIST,
        self::TRACKING_TYPE_INTERVAL,
    );

    /**
     * Contains all the accepted languages.
     *
     * @var array
     * @static
     */
    protected static $trackingLanguages = array(
        self::LANGUAGE_PORTUGUESE,
        self::LANGUAGE_ENGLISH
    );

    /**
     * Contains all the accepted tracking results.
     *
     * @var array
     * @static
     */
    protected static $trackingResults = array(
        self::TRACKING_RESULT_ALL,
        self::TRACKING_RESULT_LAST,
    );

    /**
     * Contains the list with the possible calculation types for prices and deliveries.
     *
     * @var array
     * @static
     */
    protected static $calculationTypes = array(
        self::CALCULATION_TYPE_ALL_PRICE,
        self::CALCULATION_TYPE_ONLY_PRICE,
        self::CALCULATION_TYPE_ONLY_DELIVERY,
        self::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE,
        self::CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE,
        self::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE,
    );

    /**
     * Contains all the event types.
     *
     * @var array
     * @static
     */
    protected static $eventTypes = array(
        self::EVENT_TYPE_BDE => 'Baixa de distribuição externa',
        self::EVENT_TYPE_BDI => 'Baixa de distribuição interna',
        self::EVENT_TYPE_BDR => 'Baixa corretiva',
        self::EVENT_TYPE_BLQ => 'Bloqueado',
        self::EVENT_TYPE_CAR => 'Conferência de lista de registro',
        self::EVENT_TYPE_CD => 'Conferência de nota de despacho',
        self::EVENT_TYPE_CMR => 'Conferência de lista de registro',
        self::EVENT_TYPE_CMT => 'Conferência de lista de trânsito',
        self::EVENT_TYPE_CO => 'Coleta de objetos',
        self::EVENT_TYPE_CUN => 'Conferência de lista de registro',
        self::EVENT_TYPE_DO => 'Expedição de nota de despacho',
        self::EVENT_TYPE_EST => 'Estorno',
        self::EVENT_TYPE_FC => 'Função complementar',
        self::EVENT_TYPE_IDC => 'Indenização de objetos',
        self::EVENT_TYPE_IE => 'Comunicação de irregularidade de expedição',
        self::EVENT_TYPE_IT => 'Passagem interna de objetos',
        self::EVENT_TYPE_LDI => 'Lista de distribuição interna',
        self::EVENT_TYPE_LDE => 'Lista de distribuição externa',
        self::EVENT_TYPE_OEC => 'Lista de objetos entregues ao carteiro',
        self::EVENT_TYPE_PAR => 'Conferência unidade internacional',
        self::EVENT_TYPE_PMT => 'Partida meio de transporte',
        self::EVENT_TYPE_PO => 'Postagem',
        self::EVENT_TYPE_RO => 'Expedição de lista de registro',
        self::EVENT_TYPE_TR => 'Trânsito',
        self::EVENT_TYPE_TRI => 'Trânsito',
    );

    /**
     * Contains the name of the services/products.
     *
     * @var array
     * @static
     */
    public static $serviceName = array(
        self::SERVICE_SEDEX_WITHOUT_CONTRACT => 'Sedex sem contrato',
        self::SERVICE_SEDEX_WITHOUT_AGENCY_CONTRACT => 'Sedex sem contrato agência',
        self::SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_1 => 'Sedex a Cobrar sem contrato',
        self::SERVICE_SEDEX_OUTSTANDING_PAYABLE_WITHOUT_CONTRACT_2 => 'Sedex a Cobrar com contrato',
        self::SERVICE_SEDEX_10_WITHOUT_CONTRACT => 'Sedex 10 sem contrato',
        self::SERVICE_SEDEX_TODAY_WITHOUT_CONTRACT => 'Sedex Hoje sem contrato',
        self::SERVICE_SEDEX_WITH_CONTRACT_1 => 'Sedex com contrato',
        self::SERVICE_SEDEX_WITH_CONTRACT_2 => 'Sedex com contrato',
        self::SERVICE_SEDEX_WITH_CONTRACT_3 => 'Sedex com contrato',
        self::SERVICE_SEDEX_WITH_CONTRACT_4 => 'Sedex com contrato',
        self::SERVICE_SEDEX_WITH_CONTRACT_5 => 'Sedex com contrato',
		self::SERVICE_SEDEX_WITH_CONTRACT_AGENCY => 'Sedex com contrato agência',
        self::SERVICE_PAC_WITHOUT_CONTRACT => 'PAC sem contrato',
        self::SERVICE_PAC_WITHOUT_CONTRACT_AGENCY => 'PAC sem contrato agência',
        self::SERVICE_PAC_WITH_CONTRACT => 'PAC com contrato',
		self::SERVICE_PAC_WITH_CONTRACT_AGENCY => 'PAC com contrato agência'
    );

    /**
     * Contains the return message list when a specific event occurs.
     *
     * @see http://www.correios.com.br/voce/acompanhar/rastreamento/atualizacaoSRO.cfm
     * @var array
     * @static
     */
    public static $trackingStatus = array(
        0 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_CD => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_CMT => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_CUN => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_DO => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_LDE => array(
                'message' => 'Objeto saiu para entrega ao remetente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_LDI => array(
                'message' => 'Objeto aguardando retirada no endereço indicado.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_OEC => array(
                'message' => 'Objeto saiu para entrega ao destinatário.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_PO => array(
                'message' => 'Objeto postado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_RO => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_TRI => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
        ),
        1 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto entregue ao destinatário.',
                'action' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
            ),
            Correios::EVENT_TYPE_BLQ => array(
                'message' => 'Entrega de objeto bloqueada a pedido do remetente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_CD => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_CO => array(
                'message' => 'Objeto coletado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_CUN => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_DO => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'Objeto será devolvido por solicitação do remetente.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_LDI => array(
                'message' => 'Objeto aguardando retirada no endereço indicado.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_OEC => array(
                'message' => 'Objeto saiu para entrega ao destinatário.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_PMT => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_PO => array(
                'message' => 'Objeto postado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_RO => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
        ),
        2 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_CD => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_DO => array(
                'message' => 'Objeto encaminhado para.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'Objeto com data de entrega agendada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_LDI => array(
                'message' => 'Objeto disponível para retirada em Caixa Postal.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
        ),
        3 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
            ),
            Correios::EVENT_TYPE_CD => array(
                'message' => 'Objeto recebido na Unidade dos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'Objeto mal encaminhado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_LDI => array(
                'message' => 'Objeto aguardando retirada no endereço indicado.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
        ),
        4 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
        ),
        5 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'Objeto devolvido aos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
        ),
        6 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
        ),
        7 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_FC => array(
                'message' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_IDC => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acompanhar.',
            ),
        ),
        8 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        9 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto não localizado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_EST => array(
                'message' => 'Favor desconsiderar a informação anterior.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_OEC => array(
                'message' => 'Objeto saiu para entrega ao destinatário.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_PO => array(
                'message' => 'Objeto postado após o horário limite da agência.',
                'action' => 'Acompanhar.',
            )
        ),
        10 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        12 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Remetente não retirou objeto na Unidade dos Correios.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        14 => array(
            Correios::EVENT_TYPE_LDI => array(
                'message' => 'Objeto aguardando retirada no endereço indicado.',
                'action' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
            ),
        ),
        15 => array(
            Correios::EVENT_TYPE_PAR => array(
                'message' => 'Objeto recebido em destino.',
                'action' => 'Acompanhar.',
            ),
        ),
        16 => array(
            Correios::EVENT_TYPE_PAR => array(
                'message' => 'Objeto recebido no Brasil.',
                'action' => 'Acompanhar.',
            ),
        ),
        17 => array(
            Correios::EVENT_TYPE_PAR => array(
                'message' => 'Objeto liberado pela alfândega.',
                'action' => 'Acompanhar.',
            ),
        ),
        18 => array(
            Correios::EVENT_TYPE_PAR => array(
                'message' => 'Objeto recebido na unidade de exportação.',
                'action' => 'Acompanhar.',
            ),
        ),
        19 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Endereço incorreto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        20 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar.',
            ),
        ),
        21 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        22 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto devolvido aos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto devolvido aos Correios.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto devolvido aos Correios.',
                'action' => 'Acompanhar.',
            ),
        ),
        23 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto devolvido ao remetente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto devolvido ao remetente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto devolvido ao remetente.',
                'action' => 'Acompanhar.',
            ),
        ),
        24 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto disponível para retirada em Caixa Postal.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto disponível para retirada em Caixa Postal.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto disponível para retirada em Caixa Postal.',
                'action' => 'Acompanhar.',
            ),
        ),
        25 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
                'action' => 'Acompanhar.',
            ),
        ),
        26 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Destinatário não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Destinatário não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Destinatário não retirou objeto na Unidade dos Correios.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        28 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto e/ou conteúdo avariado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto e/ou conteúdo avariado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto e/ou conteúdo avariado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        32 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto com data de entrega agendada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto com data de entrega agendada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto com data de entrega agendada.',
                'action' => 'Acompanhar.',
            ),
        ),
        33 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        34 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
                'action' => 'Acompanhar.',
            ),
        ),
        35 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar.',
            ),
        ),
        36 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Coleta ou entrega de objeto não efetuada.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        37 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        38 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto endereçado à empresa falida.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto endereçado à empresa falida.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto endereçado à empresa falida.',
                'action' => 'Acompanhar.',
            ),
        ),
        40 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        41 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'A entrega do objeto está condicionada à composição do lote.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'A entrega do objeto está condicionada à composição do lote.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'A entrega do objeto está condicionada à composição do lote.',
                'action' => 'Acompanhar.',
            ),
        ),
        42 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Lote de objetos incompleto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Lote de objetos incompleto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Lote de objetos incompleto.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        43 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        45 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto recebido na unidade de distribuição.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto recebido na unidade de distribuição.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto recebido na unidade de distribuição.',
                'action' => 'Acompanhar.',
            ),
        ),
        46 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Tentativa de entrega não efetuada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Tentativa de entrega não efetuada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Tentativa de entrega não efetuada.',
                'action' => 'Acompanhar.',
            ),
        ),
        47 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Saída para entrega cancelada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Saída para entrega cancelada.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Saída para entrega cancelada.',
                'action' => 'Acompanhar.',
            ),
        ),
        48 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        49 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        50 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        51 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        52 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto roubado.',
                'action' => 'Acionar atendimento dos Correios.',
            ),
        ),
        53 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto reimpresso e reenviado.',
                'action' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto reimpresso e reenviado.',
                'action' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto reimpresso e reenviado.',
                'action' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
            ),
        ),
        54 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
                'action' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
                'action' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
                'action' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
            ),
        ),
        55 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Solicitada revisão do tributo estabelecido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Solicitada revisão do tributo estabelecido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Solicitada revisão do tributo estabelecido.',
                'action' => 'Acompanhar.',
            ),
        ),
        56 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Declaração aduaneira ausente ou incorreta.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Declaração aduaneira ausente ou incorreta.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Declaração aduaneira ausente ou incorreta.',
                'action' => 'Acompanhar o retorno do objeto ao remetente.',
            ),
        ),
        57 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Revisão de tributo concluída - Objeto liberado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Revisão de tributo concluída - Objeto liberado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Revisão de tributo concluída - Objeto liberado.',
                'action' => 'Acompanhar.',
            ),
        ),
        58 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Revisão de tributo concluída - Tributo alterado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Revisão de tributo concluída - Tributo alterado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Revisão de tributo concluída - Tributo alterado.',
                'action' => 'Acompanhar.',
            ),
        ),
        59 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Revisão de tributo concluída - Tributo mantido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Revisão de tributo concluída - Tributo mantido.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Revisão de tributo concluída - Tributo mantido.',
                'action' => 'Acompanhar.',
            ),
        ),
        66 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Área com distribuição sujeita a prazo diferenciado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Área com distribuição sujeita a prazo diferenciado.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Área com distribuição sujeita a prazo diferenciado.',
                'action' => 'Acompanhar.',
            ),
        ),
        69 => array(
            Correios::EVENT_TYPE_BDE => array(
                'message' => 'Objeto com atraso na entrega.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDI => array(
                'message' => 'Objeto com atraso na entrega.',
                'action' => 'Acompanhar.',
            ),
            Correios::EVENT_TYPE_BDR => array(
                'message' => 'Objeto com atraso na entrega.',
                'action' => 'Acompanhar.',
            ),
        ),
    );

    /**
     * Contains the access username.
     *
     * @var string
     */
    private $username;

    /**
     * Contains the user password.
     *
     * @var string
     */
    private $password;

    /**
     * Creates an object.
     *
     * @param string $user Usuário.
     * @param string $password Senha.
     */
    public function __construct($user = '', $password = '') {
        $this->username = $user;
        $this->password = $password;
    }

    /**
     * Returns the username.
     *
     * @return string
     */
    protected function getUsername() {
        return $this->username;
    }

    /**
     * Returns the password.
     *
     * @return string
     */
    protected function getPassword() {
        return $this->password;
    }

    /**
     * Returns the parameters.
     *
     * @return array
     * @abstract
     */
    abstract protected function getParameters();

    /**
     * Do the process.
     *
     * @return boolean
     * @abstract
     */
    abstract public function process();
}
