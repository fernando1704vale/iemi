<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Label
 *
 * @author USUARIO
 */
class Label {
    //put your code here
    
    private $name;
    protected $labels = array();
    
    
    public function addLabelType($labelType,$value){
        $labels = $this->getLabels();        
        $labels[$labelType]=$value;
    }
    
    /**
    * Gets the name
    */
    public function getName() {
            return $this->name;
    }
    /**
    * Sets the name
    * 
    * $val	mixed	Sets the property
    */
    public function setName($val) {
            $this->name = $val;
            $this->addLabelType('name', $value);
    }
    
       
    /**
    * Gets the labels
    */
    public function getLabels() {
            return $this->labels;
    }
    /**
    * Sets the labels
    * 
    * $val	mixed	Sets the property
    */
    public function setLabels($val) {
            $this->labels = $val;
    }


  /*  
'name'
'singular_name'
'menu_name'
'all_items'
'edit_item'
'add_new_item'
'update_item'
'new_item_name'
'parent_item'
'parent_item_colon'
'search_items'
'popular_items'
'separate_items_with_commas'
'add_or_remove_items'
'choose_from_most_used'
        
        
*/

    
}

?>
