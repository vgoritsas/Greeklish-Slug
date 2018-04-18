<?php
/*
 * @author Evanggelos L. Goritsas <vgoritsas@gmail.com> Nextpointer Team.
 * @copyright  2018
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once 'helpers/Slug.php';

class Np_GreeklishSlug extends Module
{


    public static $executed = false;
	
	
    public function __construct()
    {
        $this->name = 'np_greeklishslug';
        $this->version = '1.0.0';
        $this->author = 'Evanggelos L. Goritsas';
        $this->need_instance = 0;

        $this->bootstrap = true;


        $this->displayName = $this->l('Np Greeklish Slug', array(), 'Modules.NpGreeklishUrl.Admin');
        $this->description = $this->l('Automatically create a greeklish Slug from the product name', array(), 'Modules.NpGreeklishUrl.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
        parent::__construct();
       
    
    }

	
	public function install(){
        return parent::install() &&
        $this->registerHook('actionProductSave');
	}

	public function uninstall()
	{
		return parent::uninstall();
	}


    public function hookActionProductSave($params){

        $executed = self::$executed;
        if($executed == true){
            return;
        }

        self::$executed = true;

        $product = $params['product'];
        if(class_exists('Slug')){
            $slug = new Slug();
        }

        foreach ($product->name as $key => $pr){
            if(key_exists($key, $product->link_rewrite))
            {
                $product->link_rewrite[$key] = $slug->createSlug($pr);
            }
        }
        $product->save();
    }


   

}