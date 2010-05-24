<?php
class PagesController extends AppController {

    var $name = 'Pages';
    var $helpers = array('Html', 'Form', 'Tree');
    var $components = array('Email');
    var $paginate = array(
            'limit' => 50,
            'order' => 'Page.lft asc');
    var $allowedActions = array('index', 'homepage', 'view', 'display');

    function beforeFilter()
    {
        parent::beforeFilter();

        if(isset($this->params['admin']) && $this->params['admin']) {
            $this->set('activemenu_for_layout', 'website');
        }

    }

    /*
     * @param mixed $pageRef id o slug della pagina
     */
    function index($pageRef = null) {
    if(!$pageRef)
        $this->setAction('homepage');
    else
        $this->setAction('view', $pageRef);
    }

    /*
     * Visualizza la prima pagina attiva della lista
     */
    function homepage()
    {
        $page = $this->Page->find('first', array(
            'conditions'=>array('Page.active'=>1),
            'order'=>'lft asc'));
        $this->pageTitle = $page['Page']['title'];
        $this->metatags_for_layout = array(
            'description' => $page['Page']['meta_description'],
            'keywords' => $page['Page']['meta_keywords']
            );
        $this->set('page', $page);
        $this->set('pageSlug', $page['Page']['slug']);
        
        $this->render('homepage');
    }

    /*
     * @param mixed $pageRef id o slug della pagina richiesta
     */
    function view($pageRef = null)
    {
        if (is_null($pageRef))
        {
            $this->Session->setFlash(__('Invalid Page.', true));
            $this->redirect(array('action'=>'index'));
        }
        
        if(!is_numeric($pageRef))
        {
            $page = $this->Page->find(array('Page.slug' => $pageRef));
        }
        else
        {
            $page = $this->Page->find(array('Page.id' => $pageRef));
        }

        // se non esiste la pagina dinamica, provo a visualizzare la pagina statica
        if(empty($page))
        {
            if(isset($this->params['language']))
                $this->setAction('display', $this->params['language'], $pageRef);
            else
                $this->setAction('display', $pageRef);
            return;
        }

        if($page['Page']['active'] == 0)
        {
            //pagina disattivata
            $this->Session->setFlash(__('Invalid Page.', true));
            $this->redirect(array('action'=>'index'));
        }

        //se skip_to_first_child è impostato, faccio redirect alla prima sottopagina
        if($page['Page']['skip_to_first_child'] == 1)
        {
            $targetPageConditions = array_merge(
                    $this->Page->findActive(true),
                    array(
                        'Page.lft > ' => $page['Page']['lft'],
                        'Page.rght < ' => $page['Page']['rght']
                        ));
            $targetPageSlug = $this->Page->field('slug', $targetPageConditions, 'lft asc');

            if($targetPageSlug)
            {
                $this->redirect(array('controller'=>'pages', 'action'=>'view', $targetPageSlug));
            }
        }

        //se è impostato un link, faccio il redirect
        if(!empty($page['Page']['link_to_front']))
        {
            $this->redirect($page['Page']['link_to_front']);
        }

        $this->pageTitle = $page['Page']['title'];
        $this->metatags_for_layout = array(
            'description' => $page['Page']['meta_description'],
            'keywords' => $page['Page']['meta_keywords']
            );
        $this->set('page', $page);
        $this->set('pageSlug', $page['Page']['slug']);
    }

    function display() {
        $path = func_get_args();

        if (!count($path)) {
            $this->redirect('/');
        }
        $count = count($path);
        $page = $subpage = $title = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title'));
        $this->render(join('/', $path));
    }

    function admin_toggle_active($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid Page.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Page->toggle_active($id);
        $this->redirect(array('action'=>'index'));
    }

    function admin_set_firstpage($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid Page.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Page->set_firstpage($id);
        $this->redirect(array('action'=>'index'));
    }

    function admin_index() {
        $this->Page->recursive = 0;
        $this->set('pages', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid Page.', true));
                $this->redirect(array('action'=>'index'));
        }
        $this->setAction('view', $id);
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Page->create();
            if ($this->Page->save($this->data))
            {
                $this->Session->setFlash(__('The Page has been saved', true));
                if(!isset($this->params['form']['action_edit']))
                {
                    $this->redirect(array('action'=>'index'));
                }
                else
                {
                    $id = $this->Page->id;
                    $this->redirect(array('action'=>'edit', $id));
                }
            } else
            {
                $this->Session->setFlash(__('The Page could not be saved. Please, try again.', true));
            }
        }
        $pages = $this->Page->generatetreelist(array(), '{n}.Page.id', '{n}.Page.title', ' - ');


        $this->set(compact('pages'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data))
        {
            $this->Session->setFlash(__('Invalid Page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data))
        {
            if ($this->Page->save($this->data))
            {
                $this->Session->setFlash(__('The Page has been saved', true));
                if(!isset($this->params['form']['action_edit']))
                {
                    $this->redirect(array('action'=>'index'));
                }
            } else
            {
                $this->Session->setFlash(__('The Page could not be saved. Please, try again.', true));
            }
        }
        
        if(is_numeric($id))
            $this->data = $this->Page->find(array('Page.id'=>$id));
        else
            $this->data = $this->Page->find(array('Page.slug'=>$id));
        
        $pages = $this->Page->generatetreelist(array(
            'not' => array('and' =>array(
                'Page.lft >=' => $this->data['Page']['lft'],
                'Page.rght <=' => $this->data['Page']['rght']
            ))),
            '{n}.Page.id', '{n}.Page.title', ' - ');

        $this->set(compact('pages'));
    }

    function admin_delete($id = null) {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for Page', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Page->delete($id))
        {
            $this->Session->setFlash(__('Page deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

    function admin_up($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for Page', true));
        }
        $this->Page->moveup($id);
        $this->redirect(array('action'=>'index'));
    }
    function admin_down($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for Page', true));
        }
        $this->Page->movedown($id);
        $this->redirect(array('action'=>'index'));
    }
}
?>