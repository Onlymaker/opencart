<?php

class ControllerFBStoreCommonHeader extends Controller {


    public function index() {
        header_remove("X-Frame-Options");
        header("Access-Control-Allow-Origin: *");
        $this->load->model('fbstore/fbstore');

        $this->config->load('isenselabs/facebookstore');

        $this->document->addScript('catalog/view/javascript/fbstore.js');
        
        $this->load->language('fbstore/fbstore');

        if(!isset($_SESSION['fbstore_checkout'])){
            $_SESSION['fbstore_checkout'] = true;
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_go_store_button'] = $this->language->get('text_go_store_button');

        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
            //exit('Facebook Require SSL Certificate');
            //$this->response->redirect($this->url->link('fbstore/error/not_found'));
        }

        if (isset($this->request->get['search'])) {
            $data['search'] = $this->request->get['search'];
        } else {
            $data['search'] = '';
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        $data['base'] = $server . 'index.php?route=fbstore/index';
        $data['search_url'] = $server . 'index.php?route=fbstore/search';
        $data['StoreUrl'] = $server;
        $data['language'] = $this->languageController();
        $data['currency'] = $this->currencyController();
        $data['search'] = $this->load->controller('fbstore/common/search');
        $data['cart'] = $this->cartController();

        return $this->model_fbstore_fbstore->getOutput('fbstore/common/header', $data);
    }

    private function currencyController() {

        $this->load->model('fbstore/fbstore');

        $this->load->language('common/currency');

        $data['text_currency'] = $this->language->get('text_currency');

        $data['action'] = $this->model_fbstore_fbstore->link('fbstore/common/header/currency', '', $this->request->server['HTTPS']);

        $data['code'] = $this->session->data['currency'];

        $this->load->model('localisation/currency');

        $data['currencies'] = array();

        $results = $this->model_localisation_currency->getCurrencies();

        foreach ($results as $result) {
            if ($result['status']) {
                $data['currencies'][] = array(
                    'title' => $result['title'],
                    'code' => $result['code'],
                    'symbol_left' => $result['symbol_left'],
                    'symbol_right' => $result['symbol_right']
                );
            }
        }

        if (!isset($this->request->get['route'])) {
            $data['redirect'] = $this->model_fbstore_fbstore->link('fbstore/index');
        } else {
            $url_data = $this->request->get;

            unset($url_data['_route_']);

            $route = $url_data['route'];

            unset($url_data['route']);

            $url = '';

            if ($url_data) {
                $url = '&' . urldecode(http_build_query($url_data, '', '&'));
            }

            $data['redirect'] = $this->model_fbstore_fbstore->link($route, $url, $this->request->server['HTTPS']);
        }

        return $this->model_fbstore_fbstore->getOutput('fbstore/common/currency', $data);
    }

    public function currency() {
         $this->load->model('fbstore/fbstore');
        if (isset($this->request->post['code'])) {
            $this->session->data['currency'] = $this->request->post['code'];

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
        }

        if (isset($this->request->post['redirect'])) {
            $this->response->redirect($this->request->post['redirect']);
        } else {
            $this->response->redirect($this->model_fbstore_fbstore->link('fbstore/index'));
        }
    }

    private function cartController() {
        $this->load->model('fbstore/fbstore');

        $this->load->language('common/cart');

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes' => &$taxes,
            'total' => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model($this->config->get('fbstore_total') . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    if(version_compare(VERSION, '2.2.0.0', '<')) {
                        $this->{$this->config->get('fbstore_total_model').'_' . $result['code']}->getTotal($total_data, $total, $taxes);
                    } else {
                        $this->{$this->config->get('fbstore_total_model').'_' . $result['code']}->getTotal($total_data);
                    }
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
        $data['text_loading'] = $this->language->get('text_loading');

        $data['cart'] = $this->model_fbstore_fbstore->link('fbstore/fbcheckout/cart');

        return $this->model_fbstore_fbstore->getOutput('fbstore/common/cart', $data);
    }

    public function cart() {
        $this->response->setOutput($this->index());
    }

    private function languageController() {
        $this->load->model('fbstore/fbstore');
        $this->load->language('common/language');

        $data['text_language'] = $this->language->get('text_language');

        $data['action'] = $this->model_fbstore_fbstore->link('fbstore/common/header/language', '', $this->request->server['HTTPS']);

        $data['code'] = $this->session->data['language'];

        $this->load->model('localisation/language');

        $data['languages'] = array();

        $results = $this->model_localisation_language->getLanguages();

        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = array(
                    'name' => $result['name'],
                    'code' => $result['code'],
                    'flag_url' =>  version_compare(VERSION, '2.2.0.0', "<") ? 'image/flags/' . $result['image'] : 'catalog/language/' . $result['code'] . '/' . $result['code'] . '.png'
                );
            }
        }

        if (!isset($this->request->get['route'])) {
            $data['redirect'] = $this->model_fbstore_fbstore->link('fbstore/index');
        } else {
            $url_data = $this->request->get;

            $route = $url_data['route'];

            unset($url_data['route']);

            $url = '';

            if ($url_data) {
                $url = '&' . urldecode(http_build_query($url_data, '', '&'));
            }

            $data['redirect'] = $this->model_fbstore_fbstore->link($route, $url, $this->request->server['HTTPS']);
        }

        return $this->model_fbstore_fbstore->getOutput('fbstore/common/language', $data);
    }

    public function language() {
         $this->load->model('fbstore/fbstore');
        if (isset($this->request->post['code'])) {
            $this->session->data['language'] = $this->request->post['code'];
        }

        if (isset($this->request->post['redirect'])) {
            $this->response->redirect($this->request->post['redirect']);
        } else {
            $this->response->redirect($this->model_fbstore_fbstore->link('fbstore/index'));
        }
    }

}
