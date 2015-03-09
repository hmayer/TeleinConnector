<?php

namespace hmayer\Http;

/**
 * Curl interface to Telein webservice
 *
 * @author mayer
 */
class Curl
{

    private $curlHandler = null;
    private $url = "";
    private $params = array();

    public function __construct()
    {
        if (!extension_loaded("curl")) {
            throw new CurlException("Module curl does't loaded!");
            exit();
        } else {
            $this->curlHandler = curl_init();
        }
    }

    public function setUrl($url = "")
    {
        $this->url = $url;
    }

    public function setParameters(Array $params)
    {
        if (!is_array($params)) {
            throw new CurlException("setParameters requires an array");
        } else {
            $this->params = $params;
        }
    }

    public function getUrl()
    {
        $encoded = array();
        foreach ($this->params as $key => $value) {
            $encoded[] = urlencode($key) . '=' . urlencode($value);
        }
        $url = $this->url . '?' . join('&', $encoded);
        return $url;
    }

    public function doGet()
    {
        curl_setopt($this->curlHandler, CURLOPT_URL, $this->getUrl());
        curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curlHandler, CURLOPT_CONNECTTIMEOUT_MS, \hmayer\Config\Settings::getValue('connect_timeout'));
        curl_setopt($this->curlHandler, CURLOPT_TIMEOUT_MS, \hmayer\Config\Settings::getValue('timeout'));
        $output = curl_exec($this->curlHandler);
        if (curl_errno($this->curlHandler) !== 0) {
            print "erro:" . curl_error($this->curlHandler);
            return false;
        } else {
            return $output;
        }
    }

}
