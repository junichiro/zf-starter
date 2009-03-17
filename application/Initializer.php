<?php
/**
 * My new Zend Framework project
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Request/Abstract.php';
require_once 'Zend/Controller/Action/HelperBroker.php';

/**
 *
 * Initializes configuration depndeing on the type of environment
 * (test, development, production, etc.)
 *
 * This can be used to configure environment variables, databases,
 * layouts, routers, helpers and more
 *
 */
class Initializer extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_Config
     */
    protected static $_config;

    /**
     * @var string Current environment
     */
    protected $_env;

    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * @var string Path to application root
     */
    protected $_root;

    /**
     * Constructor
     *
     * Initialize environment, root path, and configuration.
     *
     * @param  string $env
     * @param  string|null $root
     * @return void
     */
    public function __construct($env, $root = null)
    {
        $this->_setEnv($env);
        if (null === $root) {
            $root = realpath(dirname(__FILE__) . '/../');
        }
        $this->_root = $root;

        $this->initPhpConfig();

        $this->_front = Zend_Controller_Front::getInstance();

        // set the test environment parameters
        if ($env == 'test') {
            // Enable all errors so we'll know when something goes wrong.
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_startup_errors', 1);
            ini_set('display_errors', 1);

            $this->_front->throwExceptions(true);
        }

    }

    /**
     * Initialize environment
     *
     * @param  string $env
     * @return void
     */
    protected function _setEnv($env)
    {
        $this->_env = $env;
    }

    /**
     * Initialize Data bases
     *
     * @return void
     */
    public function initPhpConfig()
    {

    }

    /**
     * Route startup
     *
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->initEnv();
        $this->initLocale();
        $this->initDb();
        $this->initHelpers();
        $this->initPlugins();
        $this->initRoutes();
        $this->initControllers();
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->initView($request->getModuleName());
    }

    /**
     * Initialize core config
     *
     * @return void
     */
    public function initEnv()
    {
        $e3_loader = new E3_Config($this->_env);
        Zend_Registry::set('loader', $e3_loader);
        Zend_Registry::set('env',    $e3_loader->load('env'));
        return $this;
    }

    /**
     * Initialize data bases
     *
     * @return void
     */
    public function initDb()
    {
        $e3_loader = new E3_Config($this->_env);
        $config = $e3_loader->load('database');
        $db     = Zend_Db::factory($config->db);
        $db->setFetchMode(Zend_Db::FETCH_ASSOC);
#        $db->query('SET NAMES UTF8');
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        return $this;
    }

    /**
     * Initialize action helpers
     *
     * @return void
     */
    public function initHelpers()
    {
        // register the default action helpers
        Zend_Controller_Action_HelperBroker::addPath('../application/default/helpers', 'Zend_Controller_Action_Helper');
        Zend_Controller_Action_HelperBroker::addPath('../application/api/helpers', 'Zend_Controller_Action_Helper');
    }

    /**
     * Initialize view
     *
     * @return void
     */
    public function initView($module)
    {

        // ** Set the document type **
        $documentType = new Zend_View_Helper_Doctype();
        $documentType->doctype('XHTML1_TRANSITIONAL');

        // Bootstrap layouts
        Zend_Layout::startMvc(array(
                                    'layoutPath' => $this->_root .  '/application/'.$module.'/views/layouts',
                                    'layout'     => 'main'
                                    ));
    }

    /**
     * Initialize plugins
     *
     * @return void
     */
    public function initPlugins()
    {

    }

    /**
     * Initialize routes
     *
     * @return void
     */
    public function initRoutes()
    {
    }

    /**
     * Initialize locale
     *
     * @return void
     */
    public function initLocale()
    {
        $locale = new Zend_Locale;
        $locale->setLocale('ja_JP');
        return $this;
    }

    /**
     * Initialize Controller paths
     *
     * @return void
     */
    public function initControllers()
    {
        $this->_front->addControllerDirectory($this->_root . '/application/default/controllers', 'default');
        $this->_front->addControllerDirectory($this->_root . '/application/api/controllers',     'api');
    }
}
?>
