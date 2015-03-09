<?php

namespace hmayer\Query;

/**
 * Description of Telein
 *
 * @author mayer
 */
class Telein
{
    public static $serverCount = 0;

    public static function getOperator($msisdn)
    {
        $servers = \hmayer\Config\Settings::getValue('servers');
        if (self::$serverCount == count($servers)) {
            return false;
        }
        $curl = new \hmayer\Http\Curl();
        if (\hmayer\Config\Settings::getValue('query') === 'operator') {
            $curl->setUrl($servers[self::$serverCount] . '/sistema/consulta_resumida.php');
        } else {
            $curl->setUrl($servers[self::$serverCount] . '/sistema/consulta_detalhada.php');
        }
        $params = array(
            "chave" => \hmayer\Config\Settings::getValue('key'),
            "numero" => $msisdn,
        );
        $curl->setParameters($params);
        $output = $curl->doGet();
        if ($output !== false) {
            return new Operator($output);
        } else {
            self::$serverCount++;
            $this->getOperator($msisdn);
        }
    }
}
