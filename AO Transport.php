<?php
/* Copyright (C) 2019 Kamalesh Srikanth <kamleshs@alertops.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. */
/**
 * AlertOps API Transport
 * @author Kamalesh Srikanth <kamleshs@alertops.com>
 * @license GPL
 * @package LibreNMS
 * @subpackage Alerts
 */
namespace LibreNMS\Alert\Transport;
use LibreNMS\Alert\Transport;
class AlertOps extends Transport
{
    public function deliverAlert($obj, $opts)
    {
        if ($obj['state'] == 0) {
            $obj['alert_status'] = 'close';
        } else {
            $obj['alert_status'] = 'open';
        }
        if (!empty($this->config)) {
            $opts['url'] = $this->config['AO-url'];
        }
        return $this->contactAlertOps($obj, $opts);
    }
    public function contactAlertOps($obj, $opts)
    {
        $url = $opts['url'];
        $curl = curl_init();
        set_curl_proxy($curl);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
        $ret  = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            var_dump("Error when sending post request to AlertOps. Response code: " . $code . " Response body: " . $ret);
            return false;
        }
        return true;
    }
    public static function configTemplate()
    {
        return [
            'config' => [
                [
                    'title' => 'Webhook URL',
                    'name' => 'AO-url',
                    'descr' => 'AlertOps Webhook URL',
                    'type' => 'text'
                ]
            ],
            'validation' => [
                'AO-url' => 'required|url'
            ]
        ];
    }
}


