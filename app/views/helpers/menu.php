<?php
/**
 * Menu Helper
 *
 * stampa il menu con varie opzioni
 *
 * echo $menu->render();
 * echo $menu->view();
 *
 * // tutte le opzioni sono facoltative
 *
 * echo $menu->render(array(
 *      'startPage' => 'slug/id della pagina',
 *      'startDepth' => int, funziona solo in combinazione con startPage, altrimenti viene ignorato,
 *          stampa il menu a partire dal livello specificato,
 *          altera il parametro startPage secondo questa regola:
 *              - se depth di startPage è superiore, ricerca startPage nel ramo ascendente,
 *              - se depth di startPage è inferiore, ricerca startPage nel PRIMO ramo discendente
 *      'levels' => numero di livelli da stampare,
 *      'homeLink' => string/false, stampa un link a '/' usando string come testo del link,
 *      'activeItem' => string/null, url della voce di menu da rendere attiva,
 *          se NULL: quella che ha come link l'attuale url,
 *          altrimenti STRING rappresenta l'url della voce di menu attiva
 *      'activeClass' => 'active' valore dell'attributo class del link
 *      'activeConditions' => array('menuable' => 1, 'condition' => 'value')
 *          aggiunge conditions alla query con cui seleziona gli elementi del menu
 * ));
 *
 * ----------------------------------
 * ESEMPI
 * ----------------------------------
 *
 * - menu principale, un solo livello:
 * echo $menu->render(array('levels' => 1));
 *
 * - sottomenu della pagina attuale:
 * echo $menu->render(array(
        'levels' => 1,
        'startPage' => $page['Page']['id'],
        'startDepth' => ($page['Page']['depth'] +1)
    ));
 *
 * - menu pagine fratelli della pagina attuale:
 * echo $menu->render(array(
        'levels' => 1,
        'startPage' => $page['Page']['id'],
        'startDepth' => $page['Page']['depth']
    ));
 */
class MenuHelper extends AppHelper {

    /*
     * Configurazione di default
    */
    var $defaults = array(
        'startPage' => false,
        'startDepth' => false,
        'levels' => 0,
        'homeLink' => false,
        'activeItem' => null,
        'activeClass' => 'active',
        'renderElement' => false,
        'activeConditions' => array('menuable'=>1)
    );

    /*
     * ---------------------------------------------
     * variabili ad uso interno
     * ---------------------------------------------
    */

    /*
     * Pagina iniziale, ovvero il ramo di menu che si vuole stampare
    */
    var $startPage;

    /*
     * Forza il menu a partire da un certo livello, se utilizzi $startPage insieme a $startDepth,
     * renderizza il ramo contenente $startPage a partie dal livello $startDepth
    */
    var $startDepth;

    /*
     * Indica di quanti livelli sarà il menu
     * 0 = tutti i livelli, altrimenti il numero di livelli da stampare
    */
    var $levels;

    /*
     * Se vuoi stampare un link alla homepage all'inizio del menu, imposta a true
     * @string $homeLink
    */
    var $homeLink;

    /*
     * voce attiva, dovrebbe essere in grado di selezionare l'intero ramo
    */
    var $activeItem;

    /*
     * classe (intesa come attributo html) dell'elemento selezionato (activeElement)
    */
    var $activeClass;

    /*
     * @mixed $renderElement string/false Se impostato diversamente da false,
     *  per ogni voce di menu renderizza un element con il nome della variabile.
     *  L'element contiene i dati del link nella variabile $data
    */
    var $renderElement;

    /*
     *
    */
    var $activeConditions;

    /*
     *
    */
    var $_startPageData = array();

    /*
     *
    */
    var $helpers = array('Html', 'Tree');

    /*
     *
    */
    function setup($options = array()) {
        $this->Page = ClassRegistry::init('Page');

        $options = am($this->defaults, $options);

        foreach($options as $var => $value) {
            $this->{$var} = $value;
        }

        if($this->activeItem == null) {
            $this->activeItem = $this->url();
        }

        $this->activeConditions = am($this->Page->findActive(true), $this->activeConditions);

        if(false != (bool)$this->startDepth) {
            $this->startDepth -= 1;
        }

        $this->_startPageData = $this->_getStartPageData();
    }

    /*
     * esattamente la stessa cosa di render()
    */
    function view($options = array()) {
        return $this->render($options);
    }

    /*
     * metodo principale con cui viene chiamato questo helper, fa tutto lui: setup, query e render
    */
    function render($options = array()) {

        $this->setup($options);

        $elements = $this->getElements();

        if(count($elements) > 0) {
            return $this->renderElements($elements);
        }
        else {
            return '';
        }
    }

    /*
     * Se hai già l'array degli elements, questa funzione renderizza il menu
    */
    function renderElements($elements = array()) {

        //verifico se è impostata la variabile renderElement
        if($this->renderElement) {
            //imposto l'element per Tree helper
            return $this->output(
                $this->Tree->generate(
                $elements,
                array('model'=>'Page', 'alias'=>'menu', 'element'=>$this->renderElement)
                )
            );
        } else {
            //imposto la callback per Tree helper
            return $this->output(
                $this->Tree->generate(
                $elements,
                array('model'=>'Page', 'alias'=>'menu', 'callback'=>array(&$this, 'renderElement'))
                )
            );
        }
    }

    /**
     * funzione chiamata dall'helper Tree se $this->renderElement == false
     */
    function renderElement($data) {
        $class = null;
        if(empty($data['data']['Page']['link_to_front'])) {

            //verifico se la voce corrente è attiva
            if(Router::url(array('controller'=>'pages', 'action'=>'view', $data['data']['Page']['slug'], 'language'=>Configure::read('Config.language'), 'plugin' =>null)) == $this->activeItem) {
                $class = array('class' => $this->activeClass);
            }
            return $this->Html->link($data['data']['Page']['menu'], array('controller'=>'pages', 'action'=>'view', $data['data']['Page']['slug'], 'language'=>Configure::read('Config.language'), 'plugin' =>null), $class);

        } else {

            //verifico se la voce corrente è attiva
            if(Router::url($data['data']['Page']['link_to_front']) == $this->activeItem) {
                $class = array('class' => $this->activeClass);
            }
            return $this->Html->link($data['data']['Page']['menu'], $data['data']['Page']['link_to_front'], $class);
        }
    }

    /*
     *
    */
    function getElements() {

        // in caso di menu parziale, costruisco la query solo per gli elementi discendenti di startPage
        if($this->startPage) {
            $this->activeConditions['and'] = am($this->activeConditions['and'], array(
                'Page.lft > ' => $this->_startPageData['Page']['lft'],
                'Page.rght < ' => $this->_startPageData['Page']['rght']
            ));
        };

        // stampo solo un certo numero di livelli
        if($this->levels > 0) {
            if(false == $this->startPage) {
                $this->activeConditions[] = array(
                    'Page.depth >= ' => (int)$this->_startPageData['Page']['depth'],
                    'Page.depth < ' => ((int)$this->_startPageData['Page']['depth'] + $this->levels));
            }
            else {
                $this->activeConditions[] = array(
                    'Page.depth > ' => (int)$this->_startPageData['Page']['depth'],
                    'Page.depth <= ' => ((int)$this->_startPageData['Page']['depth'] + $this->levels));
            }
        }

        // la vera query ---------------------------------
        $elements = $this->Page->find('threaded', array(
            'conditions'=>$this->activeConditions,
            'fields' => array('id', 'parent_id', 'slug', 'menu', 'link_to_front'),
            'order' => 'lft ASC'
            ));
        // -----------------------------------------------

        // imposto il link home, se c'è nelle opzioni
        if($this->homeLink) {
            array_unshift($elements, array('Page' => array('menu' => $this->homeLink, 'link_to_front' => '/')));
        }

        return $elements;
    }

    function _getStartPageData() {
        $_startPageData = array();
        switch($this->startPage) {

            //purtroppo is_numeric(false) restituisce true :-(
            case false:
                $_startPageData = array('Page' => array('depth' => 0));
                break;

            case (is_numeric($this->startPage)):
                $_startPageData = $this->Page->find('first', array(
                    'conditions' => array('Page.id' => $this->startPage),
                    'fields' => array('id', 'parent_id', 'depth', 'lft', 'rght'),
                    'recursive' => -1));
                break;

            case (is_string($this->startPage)):
                $_startPageData = $this->Page->find('first', array(
                    'conditions' => array(
                        'or' => array(
                            'Page.slug' => $this->startPage,
                            'Page.link_to_front' => $this->startPage
                        )),
                    'fields' => array('id', 'parent_id', 'depth', 'lft', 'rght'),
                    'recursive' => -1));
                break;

            default:
                $_startPageData = array('Page' => array('depth' => 0));
                break;
        }

        if(false !== $this->startDepth
            && $_startPageData['Page']['depth'] != $this->startDepth
            && false !== $this->startPage) {
            $_startPageData = $this->Page->find('first', array(
                'conditions' => array(
                    'or' => array(
                        array(
                            'lft < ' => $_startPageData['Page']['lft'],
                            'rght > ' => $_startPageData['Page']['rght']
                        ),
                        array(
                            'lft > ' => $_startPageData['Page']['lft'],
                            'rght < ' => $_startPageData['Page']['rght']
                        )
                    ),
                    'depth' => $this->startDepth
                ),
                'order' => array('Page.lft asc'),
                'fields' => array('id', 'parent_id', 'depth', 'lft', 'rght'),
                'recursive' => -1
            ));
        }

        return $_startPageData;
    }
}