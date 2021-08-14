<?php

use UmiCms\Service;

class optipic extends def_module {

    const MODULE_NAME = 'optipic';

    /**
     * Конструктор
     */
    public function __construct() {
        parent::__construct();

        // В зависимости от режима работы системы
        if (cmsController::getInstance()->getCurrentMode() == "admin") {
            // Создаем вкладки административной панели
            $this->initTabs();
            // Подключаем классы функционала административной панели
            $this->includeAdminClasses();
        } else {
            // Подключаем классы клиентского функционала
            $this->includeGuestClasses();
        }

        $this->includeCommonClasses();
    }

    public function getModuleName(){
        return self::MODULE_NAME;
    }

    /**
     * Создает вкладки административной панели модуля
     */
    protected function initTabs() {
        $configTabs = $this->getConfigTabs();

//        if ($configTabs instanceof iAdminModuleTabs) {
//            $configTabs->add("config");
//        }

        $commonTabs = $this->getCommonTabs();

        if ($commonTabs instanceof iAdminModuleTabs) {
            $commonTabs->add('config');
//            $commonTabs->add('pages');
//            $commonTabs->add('objects');
        }
    }

    /**
     * Подключает классы функционала административной панели
     */
    protected function includeAdminClasses() {
        $this->__loadLib("admin.php");
        $this->__implement("OptipicAdmin");

        $this->loadAdminExtension();

        $this->__loadLib("customAdmin.php");
        $this->__implement("OptipicCustomAdmin", true);
    }

    /**
     * Подключает классы функционала клиентской части
     */
    protected function includeGuestClasses() {
        $this->__loadLib("macros.php");
        $this->__implement("OptipicMacros");

        $this->loadSiteExtension();

        $this->__loadLib("customMacros.php");
        $this->__implement("OptipicCustomMacros", true);

        $this->__loadLib("ImgUrlConverter.php");
        $this->__implement("ImgUrlConverter");

        $this->__loadLib("handlers.php");
        $this->__implement("OptipicHandlers");
    }

    /**
     * Подключает общие классы функционала
     */
    protected function includeCommonClasses() {
        $this->loadCommonExtension();
        $this->loadTemplateCustoms();
    }

    private function getSettings() {

        $regEdit = Service::Registry();
        $autoreplaceActive = (bool) $regEdit->get('//modules/'.self::MODULE_NAME.'/autoreplace_active');
        $siteId = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/site_id');
        $domains = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/domains');
        $exclusionsUrl = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/exclusions_url');
        $whitelistImgUrls = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/whitelist_img_urls');
        $srcsetAttrs = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/srcset_attrs');
        $cdnDomain = (string) $regEdit->get('//modules/'.self::MODULE_NAME.'/cdn_domain');

        return array(
            'autoreplace_active' => $autoreplaceActive,
            'site_id' => $siteId,
            'domains' => $domains,
            'exclusions_url' => $exclusionsUrl,
            'whitelist_img_urls' => $whitelistImgUrls,
            'srcset_attrs' => $srcsetAttrs,
            'cdn_domain' => $cdnDomain,
        );
    }

    public function changeContent($content) {

        $settings = $this->getSettings();

        if($settings['autoreplace_active'] && $settings['site_id']) {
            \optipic\cdn\ImgUrlConverter::loadConfig($settings);
            $content = \optipic\cdn\ImgUrlConverter::convertHtml($content);
        }

        return $content;
    }
};