<?php
class ControllerFBStoreSearch extends Controller {
    private $limit = 9;

    public function index() {
$this->load->model('fbstore/fbstore');
        $this->load->language('fbstore/fbstore');
        
        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_search_criteria'] = $this->language->get('text_search_criteria');
        $data['text_error_head'] = $this->language->get('text_error_head');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        if (isset($this->request->get['search'])) {
            $data['search'] = $this->request->get['search'];
        } else {
            $this->response->redirect($this->model_fbstore_fbstore->link('fbstore/index', true));
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_fbstore_fbstore->link('fbstore/index')
        );
        
        $url = '';
        
        if (isset($this->request->get['search'])) {
            $url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['tag'])) {
            $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['description'])) {
            $url .= '&description=' . $this->request->get['description'];
        }
        if (isset($this->request->get['category_id'])) {
            $url .= '&category_id=' . $this->request->get['category_id'];
        }
        
        if (isset($this->request->get['sub_category'])) {
            $url .= '&sub_category=' . $this->request->get['sub_category'];
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
            'text' => 'Search',
            'href' => $this->model_fbstore_fbstore->link('fbstore/search', $url)
        );
        
        
        $limit = $this->limit; //TODO ADMIN LIMIT MAYBE NEXT RELEASE

        
        $category_id = $this->getDesiredCatIDs();
        
        $data['categories'] = array();
        $data['limit'] = $limit;
        $data['category_name'] = 'Search';
        
        $filter_data = array(
            'filter_name' => $data['search'],
            'filter_category_id' => $category_id,
            'filter_sub_category' => true,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        
        $product_total = 0;
        
        $data['products'] = $this->getProducts($filter_data, $product_total, $url);
        
        //PAGINATION
        $url_page = $this->model_fbstore_fbstore->link('fbstore/search', $this->getUrl(array('page')) . '&page={page}');
        $data['pagination'] = $this->model_fbstore_fbstore->pagination($product_total, $page, $limit, $url_page);

        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
        

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');

        $data['footer'] = $this->load->controller('fbstore/common/footer');
        $data['header'] = $this->load->controller('fbstore/common/header');
        
        

        
        $this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/search', $data));
        
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

    public function getDesiredCatIDs() {
        
        $settings = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE setting LIKE '%" . $this->getPageID() . "%' limit 1")->row; //_'.$this->request->post['page_id'].'"'
        
        $settings = json_decode($settings['setting'], true);
        
        if (!isset($settings['categories'])) {
            return false;
        }
        
        $data = array_keys($settings['categories']);
        
        return $data;
    }

    private function getProducts($filter_data, &$product_total, $url) {
        
        $this->load->model('fbstore/fbstore');
        $this->load->model('tool/image');
        
        $product_total = $this->model_fbstore_fbstore->getTotalProducts($filter_data);
        
        $results = $this->model_fbstore_fbstore->getProducts($filter_data);
        
        $products = array();
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 180, 150);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 180, 150);
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
                    'href' => $this->model_fbstore_fbstore->link('fbstore/product/index', 'prod_id=' . $result['product_id'] . $url, true)
                );
            }
        }
        
        return $products;
    }
}
?>