<?php
class FilemanagerController extends AppController
{
    var $name = "Filemanager";
    var $uses = array();
    var $docs_dir = 'documents';
    var $helpers = array('Image');
    var $components = array('Files');

    function __construct() {
        parent::__construct();
        $this->docs_path = WWW_ROOT.$this->docs_dir;
	}

    function beforeFilter()
	{

        if ($this->action == 'admin_swfupload') {
            $this->Session->id($this->params['named']['session']);
            $this->Session->start();
        }

        $this->set('activemenu_for_layout', 'tools');
		$this->set('title_for_layout', __('Filemanager', true));

        parent::beforeFilter();

    }
    
    function admin_index($dir = '')
    {
        if(!empty($dir))
        {
            $args = func_get_args();
            foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
            $dir = implode(DS, $args);
        }

        $_root_dir = new Folder($this->docs_path.DS.$dir);
        $resources = $_root_dir->read(true, true);

        //abbandonata, serviva per l'elenco di tutte le cartelle…
//        $dir_tree = $_root_dir->tree($this->docs_path, true, 'dir');
//        $this->set('dir_tree', $dir_tree);

        $this->set('docs_dir', $this->docs_dir);
        $this->set('dir',  $dir);
        $this->set(compact('resources'));
    }


    function admin_rename($dir)
    {
        if(!empty($dir))
        {
            $args = func_get_args();
            foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
            $dir = implode('/', $args);
        }
        
        $old_file = trim($_POST['id']);
        $new_file = trim($_POST['value']);
        
        if(!is_dir($this->docs_path.DS.$dir.DS.$_POST['id']) && is_file($this->docs_path.DS.$dir.DS.$_POST['id']))
        {
            //la risorsa è un file
            $type = 'file'; //imposto la variabile da passare alla view
            $old_file_info = pathinfo($_POST['id']);
            $old_file_ext = $old_file_info['extension'];

            $new_file_info = pathinfo($_POST['value']);
            if(isset($new_file_info['extension']))
            {
                $new_file_ext = $new_file_info['extension'];
            }
            else
            {
                $new_file_ext = $old_file_ext;
                $new_file_info['extension'] = $new_file_ext;
                $new_file_info["basename"] .= '.'.$new_file_ext;
            }
            
            //se l'estensione non coincide, aggiungo l'estensione originale
            if($old_file_ext != $new_file_ext)
            {
                $new_file_ext = $old_file_ext;
            }

            $new_file_name = substr($new_file_info["basename"],0 ,strlen($new_file_info["basename"]) - (strlen($new_file_info["extension"]) + 1) );
            $new_file_name = Inflector::slug($new_file_name);
            $new_file = $new_file_name.'.'.$new_file_ext;
        }
        else
        {
            //la risorsa è una directory
            $type = 'folder'; //imposto la variabile da passare alla view
            $new_file = Inflector::slug($new_file);
        }

        Configure::write('debug', 0);
        $this->layout = false;

        if(is_dir($this->docs_path.DS.$dir.DS.$new_file) || is_file($this->docs_path.DS.$dir.DS.$new_file))
        {
            //il file o la cartella esiste già
            $new_file = $old_file;
        }
        else
        {
            //ok, procedi e rinomina
           rename($this->docs_path.DS.$dir.DS.$old_file, $this->docs_path.DS.$dir.DS.$new_file);
        }

        $this->set('docs_dir', $this->docs_dir);
        $this->set('dir',  $dir);
        $this->set('new_file', $new_file);
        $this->set('type', $type);
    }

    function admin_delete($file = '')
    {
        $args = func_get_args();
        $file = $this->_argsToFilePath($args);
        $file = new File($file);
        if($file->delete())
        {
            $this->Session->setFlash(__('Il file '.$file->name().' è stato eliminato', true));
        }
        else
        {
            $this->Session->setFlash(__('Il file '.$file->name().' non è stato eliminato a casua di un errore', true));
        }
        $this->redirect($this->referer());
    }

    function admin_delete_dir($file = '')
    {
        $args = func_get_args();
        foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
        $file = implode(DS, $args);
        $file = $this->docs_path.DS.$file;
        $folder = new Folder($file);

        if(!is_dir($file))
        {
            $this->Session->setFlash(__('La cartella non esiste', true));
        }
        else
        {
            if($folder->delete())
            {
                $this->Session->setFlash(__('La cartella è stata eliminata', true));
            }
            else
            {
                $this->Session->setFlash(__('La cartella non è stata eliminata a casua di un errore', true));
            }
        }
        $this->redirect($this->referer());
    }

    function admin_create()
    {
        if(!empty($this->data))
        {
            $this->data['Filemanager']['name'] = Inflector::slug($this->data['Filemanager']['name']);
            $newFolder = new Folder($this->docs_path.DS.$this->data['Filemanager']['path'].DS.$this->data['Filemanager']['name'], true);
            if($newFolder)
            {
                $this->Session->setFlash('La cartella '.$this->data['Filemanager']['name'].' è stata creata');
                $this->redirect($this->referer());
            }
            else
            {
                $this->Session->setFlash('La cartella '.$this->data['Filemanager']['name'].' non è stata creata');
                $this->redirect($this->referer());
            }
        }
    }

    function admin_upload()
    {
        if(!empty($this->data))
        {
            if($this->Files->saveAs($this->data['Filemanager']['file'], null, $this->docs_path.DS.$this->data['Filemanager']['path'].DS))
            {
                $this->Session->setFlash('Il file è stato caricato');
                $this->redirect($this->referer());
            }
            else
            {
                $this->Session->setFlash('Il file non è stato caricato a causa di un errore');
                $this->redirect($this->referer());
            }
        }
    }

    function admin_swfupload($dir = null)
    {
        if(!empty($dir))
        {
            $args = func_get_args();
            foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
            $dir = implode('/', $args);
            $dir = $dir.DS;
        }

        if(!empty($this->params['form']['Filedata']))
        {
            if(!$this->Files->saveAs($this->params['form']['Filedata'], null, $this->docs_path.DS.$dir))
            {
                $this->log('Error on file '.$this->params['form']['Filedata'], 'swfupload');
            }
        }
        
        Configure::write('debug', 0);
        $this->layout = 'ajax';

        echo '1';
        exit();
    }

    function _urldecode($arg)
    {
        return urldecode($arg);
    }

    function _argsToFilePath($args)
    {
        if(!is_array($args))
        {
            $args = func_get_args();
        }
        foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
        $file = $this->docs_path.DS.implode(DS, $args);
        return $file;
    }

    function admin_ckselect($dir = '')
    {
        if(!empty($dir))
        {
            $args = func_get_args();
            foreach($args as $n=>$arg){$args[$n] = $this->_urldecode($arg);}
            $dir = implode('/', $args);
        }
        
        $_root_dir = new Folder($this->docs_path.DS.$dir);
        $resources = $_root_dir->read(true, true);
        $dir_tree = $_root_dir->tree($this->docs_path, true, 'dir');
        foreach($dir_tree as $n=>$node)
        {
            $dir_tree[$n] = substr($node, strlen($this->docs_path));
        }

        $getstring = '?CKEditor='.$this->params['url']['CKEditor'].
            '&CKEditorFuncNum='.$this->params['url']['CKEditorFuncNum'].
            '&langCode='.$this->params['url']['langCode'];
        $ckeditorfuncnum = $this->params['url']['CKEditorFuncNum'];

        $this->set('docs_dir', $this->docs_dir);
        $this->set('dir',  $dir);
        $this->set('dir_tree', $dir_tree);
        $this->set(compact('resources', 'getstring', 'ckeditorfuncnum'));
        $this->pageTitle = __('Select a file', true);
        $this->layout = 'ckselect';
    }

    function admin_rotate_ccw($file)
    {
        $args = func_get_args();
        $file = $this->_argsToFilePath($args);

        $this->_rotate($file, 'CCW');
        
        $this->redirect($this->referer());
    }
    function admin_rotate_cw($file)
    {
        $args = func_get_args();
        $file = $this->_argsToFilePath($args);

        $this->_rotate($file, 'CW');

        $this->redirect($this->referer());
    }

    function _rotate($fileName, $direction)
    {
        App::import('Vendor', 'PhpThumbFactory', array('file' => 'phpthumb'.DS.'ThumbLib.inc.php'));
        //debug($fileName);
        
        $file = PhpThumbFactory::create($fileName);

        $file->rotateImage($direction);

        $file->save($fileName);
        
        return true;
    }

}

?>