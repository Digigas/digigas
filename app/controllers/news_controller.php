<?php
class NewsController extends AppController
{

    var $name = 'News';
    var $helpers = array('Html', 'Form', 'UserComment', 'Rss');
	var $components = array('UserComment');
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
        $conditions =  array();
        if(!$categoria)
        {
            $this->News->Newscategory->recursive = 1;
            $categorie = $this->News->Newscategory->find('all', array('conditions'=>array('active'=>1)));
            $this->set('categorie', $categorie);
            $conditions[] = $this->News->findActive(true);
        }
        else
        {
            $this->News->recursive = 1;
            if(is_numeric($categoria)) 
            {
                $conditions[] = array('newscategory_id'=>$categoria);
            }
            else 
            {
                $newscategory_id = $this->News->Newscategory->find('first',
                array(
                    'fields' => array('id'),
                    'conditions' => array('Newscategory.slug' => $categoria),
                    'contain' => array()
                ));
                $conditions[] = array('newscategory_id'=>$newscategory_id['Newscategory']['id']);
            }
            $conditions[] = $this->News->findActive(true);
        }
        $this->paginate = array(
            'conditions'=>$conditions, 
            'recursive' => 3,
            'limit'=>5,  
            'order'=>array('News.date_on desc , News.created desc, News.id desc'),
            'contain' => array('Newscategory.id',  'Newscategory.name')
        );
        
        $news = $this->paginate();
        
        foreach($news as $key => $new)
        {
            $news[$key]['Comment']['count'] = $this->News->find('count', array('recursive' => 0, 'conditions' => array('News.parent_id' => $new['News']['id'])));
        }
        
        $this->set('news', $news);
        $this->set('title_for_layout', __('News', true).' - '.Configure::read('GAS.name'));
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
        $news = $this->News->find('first', array (
            'conditions'=>$conditions, 
            'contain' => array(
                'User',
                'Newscategory'
			)));
        if($news['News']['active'] != '1')
        {
            $this->Session->setFlash(__('News non disponibile', true));
            $this->redirect(array('action'=>'index'));
        }

		$this->paginate = array('Comment' => array(
			'conditions' => array('Comment.model' => 'News', 'Comment.item_id' => $news['News']['id'], 'Comment.active' => 1),
			'order' => array('Comment.created ASC'),
			'contain' => array('User.fullname')
		));
		$comments = $this->paginate($this->News->Comment);

        $this->set(compact('news', 'comments'));
        $this->set('title_for_layout', $news['News']['title'].' - '.Configure::read('GAS.name'));
    }

	function rss($categoria = false) {
		$conditions =  array();
        if(!$categoria)
        {
            $conditions[] = $this->News->findActive(true);
        }
        else
        {
            $this->News->recursive = 1;
            if(is_numeric($categoria))
            {
                $conditions[] = array('newscategory_id'=>$categoria);
            }
            else
            {
                $newscategory_id = $this->News->Newscategory->find('first',
                array(
                    'fields' => array('id'),
                    'conditions' => array('Newscategory.slug' => $categoria),
                    'contain' => array()
                ));
                $conditions[] = array('newscategory_id'=>$newscategory_id['Newscategory']['id']);
            }
            $conditions[] = $this->News->findActive(true);
        }

        $news = $this->News->find('all', array(
			'conditions'=>$conditions,
            'limit'=>50,
            'order'=>array('News.date_on desc , News.created desc, News.id desc'),
            'contain' => array('User.fullname')
		));

        $this->set('news', $news);

		Configure::write('debug', 0);
		$this->render('rss', 'rss/default');
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
            $user_id = $this->Session->read('Auth.User.id');
            if(isset($user_id))
                $this->data['News']['user_id'] = $user_id;
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