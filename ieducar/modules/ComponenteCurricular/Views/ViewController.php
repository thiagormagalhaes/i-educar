<?php

require_once 'Core/Controller/Page/ViewController.php';
require_once 'ComponenteCurricular/Model/ComponenteDataMapper.php';
require_once 'include/pmieducar/geral.inc.php';

class ViewController extends Core_Controller_Page_ViewController
{
    protected $_dataMapper = 'ComponenteCurricular_Model_ComponenteDataMapper';

    protected $_titulo = 'Detalhes de área de conhecimento';

    protected $_processoAp = 946;

    protected $_tableMap = [
        'Nome' => 'nome',
        'Abreviatura' => 'abreviatura',
        'Base curricular' => 'tipo_base',
        'Área conhecimento' => 'area_conhecimento'
    ];

    /**
     * Construtor.
     */
    public function __construct()
    {
        @session_start();
        $pessoa_logada = $_SESSION['id_pessoa'];
        @session_write_close();

        $obj_permissao = new clsPermissoes();

        if ($obj_permissao->permissao_cadastra(946, $pessoa_logada, 7)) {
            $this->addBotao('Configurar anos escolares', 'ano?cid=' . $_GET['id']);
        }
    }

    protected function _preRender()
    {
        parent::_preRender();

        Portabilis_View_Helper_Application::loadStylesheet($this, 'intranet/styles/localizacaoSistema.css');

        $localizacao = new LocalizacaoSistema();

        $localizacao->entradaCaminhos([
            $_SERVER['SERVER_NAME'].'/intranet' => 'In&iacute;cio',
            'educar_index.php' => 'Escola',
            '' => 'Detalhe do componente curricular'
        ]);

        $this->enviaLocalizacao($localizacao->montar());
    }

    public function setUrlCancelar(CoreExt_Entity $entry)
    {
        $this->url_cancelar = 'intranet/educar_componente_curricular_lst.php';
    }
}
