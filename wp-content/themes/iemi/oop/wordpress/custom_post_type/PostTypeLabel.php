<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostTypeLabel
 *
 * @author USUARIO
 */
require (dirname(__FILE__).'/../Label.php');
class PostTypeLabel extends Label{
    
    //put your code here               
    private $singularName='singular_name';
    private $addNew='add_new';
    private $allItem='all_items';
    private $addNewItem='add_new_item';
    private $editItem='edit_item';
    private $newItem='new_item';
    private $viewItem='view_item';
    private $searchItems='search_items';
    private $nofFound='not_found';
    private $notFoundInTrash='not_found_in_trash';
    private $parentItemColon='parent_item_colon';
    private $menuName='menu_name';
    
    /**
    * Gets the singularName
    */
    public function getSingularName() {
            return $this->singularName;
    }
    /**
    * Sets the singularName
    * 
    * $val	mixed	Sets the property
    */
    public function setSingularName($val) {
            $this->singularName = $val;
            $this->addLabelType('singular_name', $value);
    }
    /**
    * Gets the addNew
    */
    public function getAddNew() {
            return $this->addNew;
    }
    /**
    * Sets the addNew
    * 
    * $val	mixed	Sets the property
    */
    public function setAddNew($val) {
            $this->addNew = $val;
            $this->addLabelType('add_new', $value);
    }
    /**
    * Gets the allItem
    */
    public function getAllItem() {
            return $this->allItem;
    }
    /**
    * Sets the allItem
    * 
    * $val	mixed	Sets the property
    */
    public function setAllItem($val) {
            $this->allItem = $val;
            $this->addLabelType('all_item', $value);
    }
    /**
    * Gets the addNewItem
    */
    public function getAddNewItem() {
            return $this->addNewItem;
    }
    /**
    * Sets the addNewItem
    * 
    * $val	mixed	Sets the property
    */
    public function setAddNewItem($val) {
            $this->addNewItem = $val;
            $this->addLabelType('add_new_item', $value);
    }
    /**
    * Gets the editItem
    */
    public function getEditItem() {
            return $this->editItem;
    }
    /**
    * Sets the editItem
    * 
    * $val	mixed	Sets the property
    */
    public function setEditItem($val) {
            $this->editItem = $val;
            $this->addLabelType('edit_item', $value);
    }
    /**
    * Gets the newItem
    */
    public function getNewItem() {
            return $this->newItem;
    }
    /**
    * Sets the newItem
    * 
    * $val	mixed	Sets the property
    */
    public function setNewItem($val) {
            $this->newItem = $val;
            $this->addLabelType('new_item', $value);
    }
    /**
    * Gets the  viewItem
    */
    public function getViewItem() {
            return $this->viewItem;
    }
    /**
    * Sets the  viewItem
    * 
    * $val	mixed	Sets the property
    */
    public function setViewItem($val) {
            $this->viewItem = $val;
            $this->addLabelType('view_item', $value);
    }
    /**
    * Gets the searchItems
    */
    public function getSearchItems() {
            return $this->searchItems;
    }
    /**
    * Sets the searchItems
    * 
    * $val	mixed	Sets the property
    */
    public function setSearchItems($val) {
            $this->searchItems = $val;
            $this->addLabelType('search_items', $value);
    }
    /**
    * Gets the nofFound
    */
    public function getNofFound() {
            return $this->nofFound;
    }
    /**
    * Sets the nofFound
    * 
    * $val	mixed	Sets the property
    */
    public function setNofFound($val) {
            $this->nofFound = $val;
            $this->addLabelType('not_found', $value);
    }
    /**
    * Gets the  notFoundInTrash
    */
    public function getNotFoundInTrash() {
            return $this->notFoundInTrash;
    }
    /**
    * Sets the  notFoundInTrash
    * 
    * $val	mixed	Sets the property
    */
    public function setNotFoundInTrash($val) {
            $this-> notFoundInTrash = $val;
            $this->addLabelType('not_found_in_trash', $value);
    }
    /**
    * Gets the parentItemColon
    */
    public function getParentItemColon() {
            return $this->parentItemColon;
    }
    /**
    * Sets the parentItemColon
    * 
    * $val	mixed	Sets the property
    */
    public function setParentItemColon($val) {
            $this->parentItemColon = $val;
            $this->addLabelType('parent_item_colon', $value);
    }
    /**
    * Gets the menuName
    */
    public function getMenuName() {
            return $this->menuName;
    }
    /**
    * Sets the menuName
    * 
    * $val	mixed	Sets the property
    */
    public function setMenuName($val) {
            $this->menuName = $val;
            $this->addLabelType('menu_name', $value);
    }

    
}

?>
