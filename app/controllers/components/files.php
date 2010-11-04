<?php
class FilesComponent extends Object
{

    var $controller; 
    
    function saveAs($fileData, $fileName = null, $folder = null, $rename = true)
    {
    	if(is_null($fileName )) $fileName = $fileData['name'];
    	if(is_null($folder)) $folder = WWW_ROOT . 'documents'.DS.'image'.DS;
    	if(!is_dir($folder)) trigger_error('La cartella di destinazione non esiste!', E_USER_WARNING);
    	
    	if (is_writable($folder)) 
    	{
            if (is_uploaded_file($fileData['tmp_name'])) 
            {
                if($rename === true && is_file($folder.$fileName)) $fileName = $this->newName($folder, $fileName);
                
            	if(copy($fileData['tmp_name'], $folder.$fileName))
                	return $fileName;
                else
                {
                	trigger_error('Errore nella copia del file', E_USER_WARNING);
                	return false;
                }
            }
            else
            {
                trigger_error('Errore nel caricamento del file', E_USER_WARNING);
            	return false;            	
            }
        }
        else
        {
            trigger_error('La cartella di destinazione non è accessibile in scrittura', E_USER_WARNING);
        	return false;        	
        }
    }
    
    function newName($folder, $fileName)
    {
    	//elimino gli spazi bianchi
    	//$fileName = str_replace(' ', '_', $fileName);
        $fileParts = explode('.', $fileName);
        foreach($fileParts as $n=>$filePart)
        {
            $fileParts[$n] = Inflector::slug($filePart);
        }
        $fileName = implode('.', $fileParts);
        
    	
    	if(preg_match('/([0-9]+)([.][a-zA-Z0-9]{3,})$/', $fileName, $matches))
    	{
	    	//il file è numerato (nome123.ext)
    		$fileName = preg_replace('/'.$matches[count($matches)-2].'/', ((int)$matches[count($matches)-2])+1, $fileName);
    	}
    	else
    	{
    		//il file non è numerato (nome.ext): lo numero io
    		$matches = explode('.', $fileName);
    		$matches[count($matches)-2] .= '1';
    		$fileName = implode('.', $matches);
    	}
    	//controllo ricorsivo -> serve per assicurarsi di non sovrascrivere altri files
    	if(is_file($folder.$fileName))
    	{
    		return $this->newName($folder, $fileName);
    	}
    	else return $fileName;
    }
    
    function delete($fileName)
    {
        if (unlink($fileName))
        {
            return true;
        }
        else
        {
            trigger_error('Non sono in grado di cancellare il file', E_USER_WARNING);
        	return false;
        }
    }
}

/*
USAGE

if ($_FILES['imageFile'])
{
    $this->Files->saveAs('imageFile', $imgId, WWW_ROOT . 'folder/subfolder/');
}

Where 'imageFile' is the name of the file field. Remember WWW_ROOT is a constant with the complete path to webroot folder.

remember to put enctype="multipart/form-data" in the form.
for example:

<form action="/" method="post" enctype="multipart/form-data">
<?php echo $html->file('imageFile') ?>
</form>

*/