<?php

class ControllerFBStoreIndex extends Controller {

    // Module Unifier
    private $data = array();
    private $moduleName = 'FBStore';
    private $moduleNameSmall = 'fbstore';
    private $moduleData_module = 'fbstore_module';
    private $moduleModel = 'model_module_fbstore';
    private $width = '150';
    private $height = '150';

    // Module Unifier
    public function getPageID() {
        
        if (isset($this->request->get['page_id'])) {
            setcookie("page_id", $this->request->get['page_id'], time() + 3600);
            $page_id = $this->request->get['page_id'];
        } elseif (isset($_COOKIE['page_id'])) {
            $page_id = $_COOKIE['page_id'];
        } else {
            exit('error');
        }
        
        return $page_id;
    }

    public function index() {
$this->load->model('fbstore/fbstore');
        
        $this->load->language('fbstore/fbstore');
        
        $data = '';
        
        if (isset($this->request->get['search'])) {
            $data['search'] = $this->request->get['search'];
        } else {
            $data['search'] = '';
        }
        $data['breadcrumbs'] = array();

        $this->height = $this->getSettings('imageHeight');

        if(empty($this->height) || $this->height === false){
             $this->height = '150';
        }
        
        $this->width = $this->getSettings('imageWidth');

        if(empty($this->width) || $this->width === false){
             $this->width = '150';
        }


        $this->getCategory($data);

        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_categories_header'] = $this->language->get('text_categories_header');
        $data['text_cat_total_products'] = $this->language->get('text_cat_total_products');
        $data['text_error_head'] = $this->language->get('text_error_head');
        
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');

        $data['footer'] = $this->load->controller('fbstore/common/footer');
        $data['header'] = $this->load->controller('fbstore/common/header');
        
        $this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/index', $data));
    }

    public function getSettings($field) {
        $settings = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE setting LIKE '%" . $this->getPageID() . "%' limit 1")->row; //_'.$this->request->post['page_id'].'"'

        if(version_compare(VERSION, '2.1.0.0', "<")) {
            $settings = unserialize($settings['setting']);
        } else {
            $settings = json_decode($settings['setting'], true);
        }

        if (!isset($settings[$field])) {
            return false;
        }

        return $settings[$field];

    }

    public function getDesiredCatIDs() {
        $categories = $this->getSettings('categories');
        
        if($categories == false ) return false;
            
        $data = array_keys($categories);
        return $data;
    }

    private function getCategory(&$data) {
        $this->load->model('fbstore/fbstore');
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        
        $categoriesData = $this->getDesiredCatIDs();
        
        $this->load->model('catalog/category');
        
        $data['categories'] = array();
        
        $data['text_error_head'] = $this->language->get('text_error_head');

        //if($categoriesData === false) {$data['categories'] = array(); return;}

         if($categoriesData === false){
            $cats = $this->model_catalog_category->getCategories(0);
            foreach ($cats as $value) {
                  $data['categories'][] = array(
                  'name'     => $value['name'],
                  'category_id' => $value['category_id'],
                  'href'  => $this->model_fbstore_fbstore->link('fbstore/category', '&cat_id=' . $value['category_id']),
                  'thumb' => (!empty($value['image'])) ? $this->model_tool_image->resize($value['image'], $this->width, $this->height) : $this->getFirstProductThumb($value['category_id']),
                  'total' => $this->model_catalog_product->getTotalProducts(
                  array('filter_category_id'  => $value['category_id'],'filter_sub_category' => true))
                  );
             }
            return;
          } 

        foreach ($categoriesData as $value) {
            $cat = $this->model_catalog_category->getCategory($value);
            $data['categories'][] = array(
                'name' => $cat['name'],
                'category_id' => $cat['category_id'],
                'href' => $this->model_fbstore_fbstore->link('fbstore/category', '&cat_id=' . $cat['category_id']),
                'thumb' => (!empty($cat['image'])) ? $this->model_tool_image->resize($cat['image'], $this->width, $this->height) : $this->getFirstProductThumb($cat['category_id']),
                'total' => $this->model_catalog_product->getTotalProducts(
                        array('filter_category_id' => $cat['category_id'], 'filter_sub_category' => true))
            );
        }
    }

    private function getFirstProductThumb($cat_id) {
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        $filter_data = array(
            'filter_category_id' => $cat_id,
            'filter_sub_category' => true,
            'limit' => 1,
            'start' => 0
        );
        $results = $this->model_catalog_product->getProducts($filter_data);
        foreach ($results as $key => $value) {
            if (!empty($value['image'])) {
                return $this->model_tool_image->resize($value['image'], $this->width, $this->height);
            } else {
                return $this->model_tool_image->resize('placeholder.png', $this->width, $this->height);
            }
        }
        return $this->model_tool_image->resize('placeholder.png', $this->width, $this->height);
    }

    private function getUrl($excludeArray) {
        $url = '';
        foreach ($_GET as $key => $value) {
            $found = false;
            foreach ($excludeArray as $exclude) {
                if ($key == $exclude || $key == 'route')
                    $found = true;
            }
            if (!$found)
                $url .= "&$key=$value";
        }
        return $url;
    }

}
