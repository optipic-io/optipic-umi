<?php

use UmiCms\Service;

class OptipicAdmin {

    use baseModuleAdmin;
    /**
     * @var optipic $module
     */
    public $module;

    /**
     * Возвращает настройки модуля.
     * Если передан ключевой параметр $_REQUEST['param0'] = do,
     * то сохраняет настройки.
     * @throws coreException
     */
    public function config() {

        $moduleName = $this->module->getModuleName();
        $regEdit = Service::Registry();
        $params = [
            'config' => [
                'bool:autoreplace_active' => true,
                'string:site_id' => '',
                'text:domains' => '',
                'text:exclusions_url' => '',
                'text:whitelist_img_urls' => '',
                'text:srcset_attrs' => '',
                //'string:cdn_domain' => 'cdn.optipic.io',
            ]
        ];

        if ($this->isSaveMode()) {
            $params = $this->expectParams($params);
            $regEdit->set('//modules/'.$moduleName.'/autoreplace_active', $params['config']['bool:autoreplace_active']);
            $regEdit->set('//modules/'.$moduleName.'/site_id', $params['config']['string:site_id']);
            $regEdit->set('//modules/'.$moduleName.'/domains', $params['config']['text:domains']);
            $regEdit->set('//modules/'.$moduleName.'/exclusions_url', $params['config']['text:exclusions_url']);
            $regEdit->set('//modules/'.$moduleName.'/whitelist_img_urls', $params['config']['text:whitelist_img_urls']);
            $regEdit->set('//modules/'.$moduleName.'/srcset_attrs', $params['config']['text:srcset_attrs']);
            //$regEdit->set('//modules/'.$moduleName.'/cdn_domain', $params['config']['string:cdn_domain']);
            $this->chooseRedirect();
        }

        $params['config']['bool:autoreplace_active'] = (bool) $regEdit->get('//modules/'.$moduleName.'/autoreplace_active');
        $params['config']['string:site_id'] = (string) $regEdit->get('//modules/'.$moduleName.'/site_id');
        $params['config']['text:domains'] = (string) $regEdit->get('//modules/'.$moduleName.'/domains');
        $params['config']['text:exclusions_url'] = (string) $regEdit->get('//modules/'.$moduleName.'/exclusions_url');
        $params['config']['text:whitelist_img_urls'] = (string) $regEdit->get('//modules/'.$moduleName.'/whitelist_img_urls');
        $params['config']['text:srcset_attrs'] = (string) $regEdit->get('//modules/'.$moduleName.'/srcset_attrs');
        //$params['config']['string:cdn_domain'] = (string) $regEdit->get('//modules/'.$moduleName.'/cdn_domain');

        $this->setConfigResult($params);

    }

}