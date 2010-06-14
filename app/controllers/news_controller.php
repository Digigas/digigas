<?php
class NewsController extends AppController
{

    var $name = 'News';
    var $helpers = array('Html', 'Form');
    var $paginate = array('order'=>array('News.date_on desc, News.created desc, News.id desc'));

    function beforeFilter()
    {
        $this->set('activemenu_for_layout', 'tools');
        return parent::beforeFilter();
    }
    
    function index($categoria = false) {
        $this->setAction('category', $categoria);
    }
    /*
     * @param int $categoria Id della categoria
     */
    function category($categoria = false)
    {
        if(!$categoria)
        {
            $this->News->Newscategory->recursive = 1;
            $categorie = $this->News->Newscategory->find('all', array('conditions'=>array('active'=>1)));
            $this->set('categorie', $categorie);
            $this->pageTitle = __('All news', true);
            $news = $this->paginate();
            $this->set('news', $news);
        }
        else
        {
            $this->News->recursive = 1;
            if(is_numeric($categoria)) {
                $conditions = array('newscategory_id'=>$categoria);
            } else {
                $newscategory_id = $this->News->Newscategory->find('first',
                    array(
                        'fields' => array('id'),
                        'conditions' => array('Newscategory.slug' => $categoria),
                        'contain' => array()
                    ));
                $conditions = array('newscategory_id'=>$newscategory_id['Newscategory']['id']);
            }
            $conditions[] = $this->News->findActive(true);
            $this->paginate = array('conditions'=>$conditions, 'limit'=>5, 'order'=>array('News.date_on desc , News.created desc, News.id desc'));
            $news = $this->paginate();
            $this->set('news', $news);
            $this->pageTitle = __('News', true);
        }
    }

    /*
     * @param mixed $ref id o slug della news
     */
    function view($ref = false)
    {
        if (!$ref)
        {
            $this->Session->setFlash(__('Invalid News.', true));
            $this->redirect(array('action'=>'index'));
        }

        if(is_numeric($ref))
        {
            $conditions = array('News.id'=>$ref);
        }
        else
        {
            $conditions = array('News.slug'=>$ref);
        }
        $conditions[] = $this->News->findActive(true);
        $news = $this->News->find('first', array('conditions'=>$conditions));
        if($news['News']['active'] != '1')
        {
            $this->Session->setFlash(__('News non disponibile', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->set('news', $news);
        $this->pageTitle = __('News', true).' // '.$news['News']['title'];
    }

    function admin_index()
    {
        $this->News->recursive = 0;
        $this->set('news', $this->paginate());
        $categories = $this->News->Newscategory->find('list');
        $this->set(compact('categories'));
    }

    function admin_add()
    {
        if (!empty($this->data))
        {
            $this->News->create();
            if ($this->News->save($this->data))
            {
                $this->Session->setFlash(__('The News has been saved', true));
                if(!isset($this->params['form']['action_edit']))
                {
                    $this->redirect(array('action'=>'index'));
                }
                else
                {
                    $id = $this->News->id;
                    $this->redirect(array('action'=>'edit', $id));
                }
            }
            else
            {
                $this->Session->setFlash(__('The News could not be saved. Please, try again.', true));
            }
        }
        //$newscategories = $this->News->Newscategory->find('list');
        $newscategories = $this->News->Newscategory->generatetreelist(array(), '{n}.Newscategory.id', '{n}.Newscategory.name', ' - ');
        //deve esistere almeno una categoria per creare delle news
        if(empty($newscategories))
        {
            $this->Session->setFlash('Prima di creare una news devi aver creato almeno una categoria');
            $this->redirect(array('controller'=>'newscategories', 'action'=>'add'));
        }

        $this->set(compact('newscategories'));
    }

    function admin_edit($id = null)
    {
        if (!$id && empty($this->data))
        {
            $this->Session->setFlash(__('Invalid News', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data))
        {
            if ($this->News->save($this->data))
            {
                $this->Session->setFlash(__('The News has been saved', true));
                if(!isset($this->params['form']['action_edit']))
                {
                    $this->redirect(array('action'=>'index'));
                }
            }
            else
            {
                $this->Session->setFlash(__('The News could not be saved. Please, try again.', true));
            }
        }

        $this->data = $this->News->read(null, $id);
        //$newscategories = $this->News->Newscategory->find('list');
        $newscategories = $this->News->Newscategory->generatetreelist(array(), '{n}.Newscategory.id', '{n}.Newscategory.name', ' - ');

        $this->set(compact('newscategories'));
    }

    function admin_delete($id = null)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for News', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->News->delete($id))
        {
            $this->Session->setFlash(__('News deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }
    function admin_toggle_active($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid News.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->News->toggle_active($id);
        $this->redirect(array('action'=>'index'));
    }

}
?>