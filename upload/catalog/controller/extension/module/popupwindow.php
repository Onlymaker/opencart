<?php
class ControllerExtensionModulePopupWindow extends Controller
{
    // Module Unifier
    private $moduleName;
    private $moduleNameSmall;
    private $modulePath;
    private $callModel;
    private $moduleModel;
    private $data = array();
    // Module Unifier
    
    public function __construct($registry)
    {
        parent::__construct($registry);
        
        $this->config->load('isenselabs/popupwindow');
        
        /* OC version-specific declarations - Begin */
        $this->moduleName      = $this->config->get('popupwindow_name');
        $this->moduleNameSmall = $this->config->get('popupwindow_name_small');
        $this->modulePath      = $this->config->get('popupwindow_path');
        /* OC version-specific declarations - End */
        
        /* Module-specific declarations - Begin */
        $this->load->language($this->modulePath);
        $this->load->model($this->modulePath);
        $this->callModel   = $this->config->get('popupwindow_model_call');
        $this->moduleModel = $this->{$this->callModel};
        /* Module-specific declarations - End */
        
        /* Module-specific loaders - Begin */
        $this->load->model('setting/setting');
        $this->load->model('localisation/language');
        $this->load->model('catalog/product');
        /* Module-specific loaders - End */
    }
    
    public function index($setting)
    {
        
        $this->data['url'] = preg_replace('/https?\:/', '', $this->url->link($this->modulePath . "/getPopup", "", "SSL"));
        
        $this->data['updateImpressionsURL'] = htmlspecialchars_decode($this->url->link($this->modulePath . '/updateImpressions', '', 'SSL'));
        if (file_exists(DIR_TEMPLATE . $this->getConfigTemplate() . '/stylesheet/' . $this->moduleNameSmall . '/animate.css')) {
            $this->document->addStyle('catalog/view/theme/' . $this->getConfigTemplate() . '/stylesheet/' . $this->moduleNameSmall . '/animate.css');
        } else {
            $this->document->addStyle('catalog/view/theme/default/stylesheet/' . $this->moduleNameSmall . '/animate.css');
        }
        
        $this->document->addStyle('catalog/view/javascript/jquery/fancybox/jquery.fancybox.css');
        $this->document->addScript('catalog/view/javascript/jquery/fancybox/jquery.fancybox.js');
        
        if (file_exists(DIR_TEMPLATE . $this->getConfigTemplate() . '/stylesheet/' . $this->moduleNameSmall . '/popupwindow.css')) {
            $this->document->addStyle('catalog/view/theme/' . $this->getConfigTemplate() . '/stylesheet/' . $this->moduleNameSmall . '/popupwindow.css');
        } else {
            $this->document->addStyle('catalog/view/theme/default/stylesheet/' . $this->moduleNameSmall . '/popupwindow.css');
        }
        
        $settings = $this->config->get($this->moduleNameSmall);
        
        $this->data['custom_css'] = '';
        
        if (!empty($settings[$this->moduleName])) {
            foreach ($settings[$this->moduleName] as $popup) {
                $this->data['custom_css'] .= $popup['custom_css'];
            }
        }
        
        if (version_compare(VERSION, '2.2.0.0', "<")) {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/' . $this->modulePath . '.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/' . $this->modulePath . '.tpl', $this->data);
            } else {
                return $this->load->view('default/template/' . $this->modulePath . '.tpl', $this->data);
            }
        } else {
            return $this->load->view($this->modulePath, $this->data);
        }
    }
    
    public function updateImpressions()
    {
        if (isset($this->request->get['popup_id'])) {
            $this->moduleModel->updateImpressions($this->request->get['popup_id']);
        }
    }
    
    protected function showPopup($popup_id)
    {
        if (!isset($this->session->data['popups_repeat']) || !in_array($popup_id, $this->session->data['popups_repeat'])) {
            $this->session->data['popups_repeat'][] = $popup_id;
            return true;
        } else {
            return false;
        }
    }
    
    public function cookieCheck($days, $popup_id)
    {
        if (!isset($_COOKIE["popupwindow" . $popup_id])) {
            setcookie("popupwindow" . $popup_id, true, time() + 3600 * 24 * $days);
            return true;
        } else {
            return false;
        }
    }
    
    public function checkCustomerGroup($popup)
    {
        $popup_customer_group = !empty($popup['customerGroups']) ? $popup['customerGroups'] : array();
        $customer_group_id    = !is_null($this->customer->getGroupId()) ? $this->customer->getGroupId() : 0;
        return array_key_exists($customer_group_id, $popup_customer_group);
    }
    
    public function timeIsBetween($from, $to, $enabled)
    {
        $date = 'now';
        $date = is_int($date) ? $date : strtotime($date); // convert non timestamps
        $from = is_int($from) ? $from : strtotime($from); // ..
        $to   = is_int($to) ? $to : strtotime($to);
        if ($enabled == "0") {
            return true;
        } else {
            return ($date > $from) && ($date < $to); // extra parens for clarity
        }
    }
    
    private function checkRepeatConditions($popup)
    {
        
        return ($popup['repeat'] == 0) || ($popup['repeat'] == 1 && $this->showPopup($popup['id'], $popup['repeat'])) || ($popup['repeat'] == 2 && $this->cookieCheck($popup['days'], $popup['id']));
    }
    
    private function isHome($uri)
    {
        $parsedURI = parse_url($uri);
        if ((strcmp(HTTP_SERVER, $uri) === 0) || (strcmp(HTTPS_SERVER, $uri) === 0) || (isset($parsedURI['query']) && $parsedURI['query'] == 'route=common/home') || (!isset($parsedURI['query']) && $parsedURI['path'] == '/')) {
            return true;
        } else {
            return false;
        }
    }
    
    function checkDateRange($start_date, $end_date)
    {
        // Convert to timestamp
        $start_ts   = strtotime($start_date);
        $end_ts     = strtotime($end_date);
        $current_ts = strtotime(date("Y-m-d"));
        
        // Check if current date is between start & end
        return (($current_ts >= $start_ts) && ($current_ts <= $end_ts));
    }
    
    public function getPopup()
    {
        header('Access-Control-Allow-Origin: *');
        $date = date('H:i', time());
        
        $data = $this->config->get('popupwindow');
        if (isset($_GET['uri'])) {
            $uri = $_GET['uri'];
        } else {
            $uri = "";
        }
        
        $uri = htmlspecialchars_decode((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_GET['uri']);
        
        if (!isset($this->session->data['popups_repeat'])) {
            $this->session->data['popups_repeat'] = array();
        }
        
        $json = array();
        
        foreach ($data['PopupWindow'] as $popup) {
            
            if ($popup['Enabled'] == "yes" && $this->checkCustomerGroup($popup)) {
                if ($popup['method'] == "0") { // On Homepage method
                    if (empty($popup['date_interval']) || $this->checkDateRange($popup['start_date'], $popup['end_date'])) {
                        if ($this->timeIsBetween($popup['start_time'], $popup['end_time'], $popup['time_interval'])) {
                            if ($this->isHome($uri)) {
                                
                                if ($this->checkRepeatConditions($popup)) {
                                    
                                    $temp['match']           = true;
                                    $temp['popup_id']        = $popup['id'];
                                    $temp['content_type']    = $popup['content_type'];
                                    $temp['content']         = $popup['content_type'] == 'html' ? html_entity_decode($popup['content'][$this->config->get('config_language_id')]) : '';
                                    $temp['video_href']      = $popup['content_type'] == 'youtube' ? $popup['video_link'] : '';
                                    $temp['width']           = $popup['width'];
                                    $temp['height']          = $popup['height'];
                                    $temp['event']           = $popup['event'];
                                    $temp['show_on_mobile']  = $popup['show_on_mobile'];
                                    $temp['show_on_desktop'] = $popup['show_on_desktop'];
                                    if ($popup['event'] == 4) {
                                        $temp['percentage_value'] = $popup['scroll_percentage'];
                                    }
                                    //fancybox options
                                    $temp['aspect_ratio'] = $popup['aspect_ratio'];
                                    $temp['auto_resize']  = $popup['auto_resize'];
                                    
                                    $temp['seconds']         = $popup['seconds'];
                                    $temp['close_after']     = $popup['close_after'];
                                    $temp['animation']       = $popup['animation'];
                                    $temp['prevent_closing'] = $popup['prevent_closing'];
                                    $temp['custom_css']      = $popup['custom_css'];
                                    $json[]                  = $temp;
                                }
                            }
                        }
                    }
                }
                
                if ($popup['method'] == "1") { // All pages method
                    if (empty($popup['date_interval']) || $this->checkDateRange($popup['start_date'], $popup['end_date'])) {
                        if ($this->timeIsBetween($popup['start_time'], $popup['end_time'], $popup['time_interval'])) {
                            $excludedURLs = array();
                            $excludedURLs = array_map("urldecode", preg_split("/\\r\\n|\\r|\\n/", html_entity_decode($popup['excluded_urls'])));
                            if (($this->checkRepeatConditions($popup)) && !in_array($uri, $excludedURLs)) {
                                $temp['match']           = true;
                                $temp['popup_id']        = $popup['id'];
                                $temp['content_type']    = $popup['content_type'];
                                $temp['content']         = $popup['content_type'] == 'html' ? html_entity_decode($popup['content'][$this->config->get('config_language_id')]) : '';
                                $temp['video_href']      = $popup['content_type'] == 'youtube' ? $popup['video_link'] : '';
                                $temp['width']           = $popup['width'];
                                $temp['height']          = $popup['height'];
                                $temp['event']           = $popup['event'];
                                $temp['show_on_mobile']  = $popup['show_on_mobile'];
                                $temp['show_on_desktop'] = $popup['show_on_desktop'];
                                if ($popup['event'] == 4) {
                                    $temp['percentage_value'] = $popup['scroll_percentage'];
                                }
                                //fancybox options
                                $temp['aspect_ratio'] = $popup['aspect_ratio'];
                                $temp['auto_resize']  = $popup['auto_resize'];
                                
                                $temp['seconds']         = $popup['seconds'];
                                $temp['close_after']     = $popup['close_after'];
                                $temp['animation']       = $popup['animation'];
                                $temp['prevent_closing'] = $popup['prevent_closing'];
                                $temp['custom_css']      = $popup['custom_css'];
                                $json[]                  = $temp;
                            }
                        }
                    }
                }
                
                if ($popup['method'] == "2") { // Specific URLs method
                    if (empty($popup['date_interval']) || $this->checkDateRange($popup['start_date'], $popup['end_date'])) {
                        if ($this->timeIsBetween($popup['start_time'], $popup['end_time'], $popup['time_interval'])) {
                            $URLs         = array();
                            $URLs         = array_map("urldecode", preg_split("/\\r\\n|\\r|\\n/", html_entity_decode($popup['url'])));
                            $popup['url'] = htmlspecialchars_decode($popup['url']);
                            foreach ($URLs as $url) {
                                if (!empty($url) && strpos($uri, $url) !== false) {
                                    if ($this->checkRepeatConditions($popup)) {
                                        $temp['match']           = true;
                                        $temp['popup_id']        = $popup['id'];
                                        $temp['content_type']    = $popup['content_type'];
                                        $temp['content']         = $popup['content_type'] == 'html' ? html_entity_decode($popup['content'][$this->config->get('config_language_id')]) : '';
                                        $temp['video_href']      = $popup['content_type'] == 'youtube' ? $popup['video_link'] : '';
                                        $temp['width']           = $popup['width'];
                                        $temp['height']          = $popup['height'];
                                        $temp['event']           = $popup['event'];
                                        $temp['show_on_mobile']  = $popup['show_on_mobile'];
                                        $temp['show_on_desktop'] = $popup['show_on_desktop'];
                                        if ($popup['event'] == 4) {
                                            $temp['percentage_value'] = $popup['scroll_percentage'];
                                        }
                                        //fancybox options
                                        $temp['aspect_ratio'] = $popup['aspect_ratio'];
                                        $temp['auto_resize']  = $popup['auto_resize'];
                                        
                                        $temp['seconds']         = $popup['seconds'];
                                        $temp['close_after']     = $popup['close_after'];
                                        $temp['animation']       = $popup['animation'];
                                        $temp['prevent_closing'] = $popup['prevent_closing'];
                                        $temp['custom_css']      = $popup['custom_css'];
                                        $json[]                  = $temp;
                                    }
                                }
                            }
                        }
                    }
                }
                
                if ($popup['method'] == "3") { // CSS Selector method
                    if (empty($popup['date_interval']) || $this->checkDateRange($popup['start_date'], $popup['end_date'])) {
                        if ($this->timeIsBetween($popup['start_time'], $popup['end_time'], $popup['time_interval'])) {
                            if ($this->checkRepeatConditions($popup)) {
                                $temp['match']           = true;
                                $temp['popup_id']        = $popup['id'];
                                $temp['content_type']    = $popup['content_type'];
                                $temp['content']         = $popup['content_type'] == 'html' ? html_entity_decode($popup['content'][$this->config->get('config_language_id')]) : '';
                                $temp['video_href']      = $popup['content_type'] == 'youtube' ? $popup['video_link'] : '';
                                $temp['width']           = $popup['width'];
                                $temp['height']          = $popup['height'];
                                $temp['event']           = 5;
                                $temp['show_on_mobile']  = $popup['show_on_mobile'];
                                $temp['show_on_desktop'] = $popup['show_on_desktop'];
                                //fancybox options
                                $temp['aspect_ratio']    = $popup['aspect_ratio'];
                                $temp['auto_resize']     = $popup['auto_resize'];
                                
                                $temp['seconds']         = $popup['seconds'];
                                $temp['close_after']     = $popup['close_after'];
                                $temp['css_selector']    = $popup['css_selector'];
                                $temp['animation']       = $popup['animation'];
                                $temp['prevent_closing'] = $popup['prevent_closing'];
                                $temp['custom_css']      = $popup['custom_css'];
                                $json[]                  = $temp;
                            }
                        }
                    }
                }
            }
            
        }
        
        
        $this->response->setOutput(json_encode($json));
    }
    
    private function getConfigTemplate()
    {
        if (version_compare(VERSION, '2.2.0.0', '<')) {
            return $this->config->get('config_template');
        } else {
            return $this->config->get($this->config->get('config_theme') . '_directory');
        }
    }
    
}
