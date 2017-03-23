<?php

class ControllerFBStoreCategory extends Controller {

    private $moduleName = 'FBStore';
    private $moduleNameSmall = 'fbstore';
    private $moduleData_module = 'fbstore_module';
    private $moduleModel = 'model_module_fbstore';
    private $limit = 9;
    private $width = '150';
    private $height = '150';

    public function index() {
        $this->load->model('fbstore/fbstore');

        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->load->language('fbstore/fbstore');

        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_categories_header'] = $this->language->get('text_categories_header');
        $data['text_cat_total_products'] = $this->language->get('text_cat_total_products');
        $data['text_all_products_category'] = $this->language->get('text_all_products_category');
        $data['text_error_head'] = $this->language->get('text_error_head');

        if (isset($this->request->get['search'])) {
            $data['search'] = $this->request->get['search'];
        } else {
            $data['search'] = '';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['page'] = $page;

        $limit = $this->getSettings('limit');

        if(!isset($limit) || $limit === false){
            $limit = $this->limit;
        }
        
        $this->height = $this->getSettings('imageHeight');

        if(empty($this->height) || $this->height === false){
             $this->height = '150';
        }

        $this->width = $this->getSettings('imageWidth'); 

        if(empty($this->width) || $this->width === false){
             $this->width = '150';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_fbstore_fbstore->link('fbstore/index')
        );

        if (isset($this->request->get['cat_id'])) {

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $path = '';

            $parts = explode('_', (string) $this->request->get['cat_id']);
            $category_id = (int) array_pop($parts);
            $data['cat_id'] = $category_id;
            $path = $category_id;

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int) $path_id;
                } else {
                    $path = (int) $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->model_fbstore_fbstore->link('fbstore/category', 'cat_id=' . $path_id . $url)
                    );
                }
            }
        } else {
            $this->response->redirect($this->model_fbstore_fbstore->link('fbstore/error/not_found'));
        }

        $this->getCategories($data, $category_id, $path);

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->model_fbstore_fbstore->link('fbstore/category', 'cat_id=' . $category_id . $url)
            );

            $data['heading_title'] = $category_info['name'];
            $data['text_refine'] = $this->language->get('text_refine');
            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');
            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');
            $data['category_name'] = $category_info['name'];

            $filter_data = array(
                'filter_category_id' => $category_id,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );
            
            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

            $data['loadMore']  = ($product_total - $limit > 0) ? true : false;

            $results = $this->model_catalog_product->getProducts($filter_data);
            
            $data['products'] = false;
            if ($results) {
                foreach ($results as $result) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->width, $this->height);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->width, $this->height);
                    }
                    
                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $price = false;
                    }
                    
                    if ((float) $result['special']) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $special = false;
                    }
                    
                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                    } else {
                        $tax = false;
                    }
                    
                    if ($this->config->get('config_review_status')) {
                        $rating = $result['rating'];
                    } else {
                        $rating = false;
                    }
                    
                    $data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'thumb' => $image,
                        'name' => $result['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->model_fbstore_fbstore->getImageConfigs('product_description_length')) . '..',
                        'price' => $price,
                        'special' => $special,
                        'tax' => $tax,
                        'rating' => $rating,
                        'href' => $this->model_fbstore_fbstore->link('fbstore/product/index', 'cat_id=' . $this->request->get['cat_id'] . '&prod_id=' . $result['product_id'], true)
                    );
                }
            }

            //PAGINATION

            $url_page = $this->model_fbstore_fbstore->link('fbstore/category', $this->getUrl(array('page')) . '&page={page}'); 
            $data['pagination'] = $this->model_fbstore_fbstore->pagination($product_total, $page, $limit, $url_page);

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            
            $data['footer'] = $this->load->controller('fbstore/common/footer');
            $data['header'] = $this->load->controller('fbstore/common/header');
            
            $this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/index', $data));
        } else {
            
            $url = '';
            
            if (isset($this->request->get['cat_id'])) {
                $url .= '&cat_id=' . $this->request->get['cat_id'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->model_fbstore_fbstore->link('fbstore/category', $url)
            );
            
            $this->document->setTitle($this->language->get('text_error'));
            
            $data['heading_title'] = $this->language->get('text_error');
            $data['text_error'] = $this->language->get('text_error');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['continue'] = $this->model_fbstore_fbstore->link('fbstore/index');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');


            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');


            $data['footer'] = $this->load->controller('fbstore/common/footer');
            $data['header'] = $this->load->controller('fbstore/common/header');
            
            $this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/error/not_found', $data));
        }
    }

    public function getJSONPaginationProducts(){

        $this->load->model('fbstore/fbstore');

        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        if (isset($this->request->post['page'])) {
            $page = $this->request->post['page'];
        } else {
            $page = 1;
        }

        $limit = $this->limit;

        $category_id = $this->request->post['cat_id'];

        $filter_data = array(
                'filter_category_id' => $category_id,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
        );

            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);
            $results = $this->model_catalog_product->getProducts($filter_data);
            
            $products = false;
            if ($results) {
                foreach ($results as $result) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->width, $this->height);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->width, $this->height);
                    }
                    
                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $price = false;
                    }
                    
                    if ((float) $result['special']) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $special = false;
                    }
                    
                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                    } else {
                        $tax = false;
                    }
                    
                    if ($this->config->get('config_review_status')) {
                        $rating = $result['rating'];
                    } else {
                        $rating = false;
                    }
                    
                    $products[] = array(
                        'product_id' => $result['product_id'],
                        'thumb' => $image,
                        'name' => $result['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->model_fbstore_fbstore->getImageConfigs('product_description_length')) . '..',
                        'price' => $price,
                        'special' => $special,
                        'tax' => $tax,
                        'rating' => $rating,
                        'href' => $this->model_fbstore_fbstore->link('fbstore/product/index', 'cat_id=' . $category_id . '&prod_id=' . $result['product_id'], true)
                    );
                }
            } 

            
            $filter_data = array(
                'filter_category_id' => $category_id,
                'start' => ($page) * $limit,
                'limit' => 1
            );

            $resultsNext = $this->model_catalog_product->getProducts($filter_data);
            $preloadProducts = false;
            if ($resultsNext) {
                $preloadProducts = true;
            }
            $data['products'] = $products;
            $data['ifNext'] =  $preloadProducts;


            $dataJSON = json_encode($data);
            echo $dataJSON;
    }

    public function getPageID() {
        if (isset($this->request->get['page_id'])) {
            setcookie("page_id", $this->request->get['page_id'], time() + 3600);
            $page_id = $this->request->get['page_id'];
        } elseif (isset($_COOKIE['page_id'])) {
            $page_id = $_COOKIE['page_id'];
        } else {
            exit;
        }
        
        return $page_id;
    }

    public function getSettings($field) {
        $settings = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE setting LIKE '%" . $this->getPageID() . "%' limit 1")->row; //_'.$this->request->post['page_id'].'"'

        if(version_compare(VERSION, '2.1.0.0', "<")) {
            $settings = unserialize($settings['setting']);
        } else {
            $settings = json_decode($settings['setting'], true);
        }

        if($settings['store_id'] != $this->config->get('config_store_id')){
            return false;
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

    private function getCategories(&$data, $cat_id) {
        $this->load->model('fbstore/fbstore');
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        
        $categoriesData = $this->getDesiredCatIDs();
        $this->load->model('catalog/category');
        $data['categories'] = array();
        
        //if(in_array($cat_id, $categoriesData)){
            
        $cats = $this->model_catalog_category->getCategories($cat_id);
        
        foreach ($cats as $value) {
            $data['categories'][] = array(
                'name' => $value['name'],
                'category_id' => $value['category_id'],
                'href' => $this->model_fbstore_fbstore->link('fbstore/category', '&cat_id=' . $this->request->get['cat_id'] . '_' . $value['category_id']),
                'thumb' => (!empty($value['image'])) ? $this->model_tool_image->resize($value['image'], $this->width, $this->height) : $this->getFirstProductThumb($value['category_id']),
                'total' => $this->model_catalog_product->getTotalProducts(
                        array('filter_category_id' => $value['category_id'], 'filter_sub_category' => true))
            );
        }
        
        return;
        //}
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
