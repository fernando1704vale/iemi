<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of links
 *
 * @author USUARIO
 */
class links {
    //put your code here
    
    /**
     * ID da página de Contato 
     */
    const CONTACT_ID=15;
    
    
    
    /**
     * Clase que funciona como um media dispatcher 
     */
    const MEDIA_DISPATCHER_FILE='timthumb.php';
    
    /**
     * Nome da pasta onde ficam os arquivos fonte da Origgami 
     */
    const CORE_DIRECTORY='oop';
    
    /**
     * Pega a URL da pagina de contato especificando já um assunto
     * @param type $subjectID 1 para dúvida. 2 para orçamento. Para saber todos os tipos de assunto, basta chamar a função "forms::getContactSubjects()"
     * @see forms::getContactSubjects()
     */
    public static function getContactURL($subjectID=1){
        return get_permalink(self::CONTACT_ID)."?".query_string::CONTACT_SUBJECT."=".$subjectID;
    }
    
    /**
     * Pega o endereço do Media Dispatcher 
     */
    public static function getMediaDispatcherURL(){
        return self::getTemplateCoreDirectoryURL().self::MEDIA_DISPATCHER_FILE;
    }
    
    /**
     * Retorna o endereço do diretório dos arquivos fonte da Origgami
     */
    public static function getTemplateCoreDirectoryURL(){
        return get_template_directory_uri().'/'.links::CORE_DIRECTORY.'/';               
    }
    
    //public static function 
}

class query_string{
    const CONTACT_SUBJECT="subject";
}

?>
