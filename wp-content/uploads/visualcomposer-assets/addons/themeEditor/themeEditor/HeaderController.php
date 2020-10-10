<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
require_once('PostTypeController.php');

use VisualComposer\Framework\Illuminate\Support\Module;

class HeaderController extends PostTypeController implements Module
{
    /**
     * @var string
     */
    protected $postType = 'vcv_headers';

    protected $postNameSlug = 'Header';

    public function __construct()
    {
        $this->postNameSingular = __('Header', 'visualcomposer');
        $this->postNamePlural = __('Headers', 'visualcomposer');
        add_shortcode(
            'vcv_layouts_header',
            function ($atts, $content, $tag) {
                if (!empty($atts) && !empty($atts['id']) && $atts['id'] !== 'none') {
                    $requestHelper = vchelper('Request');
                    $frontendHelper = vchelper('Frontend');
                    $sourceHeader = $requestHelper->input('vcv-header');
                    if ($sourceHeader && $frontendHelper->isPageEditable()) {
                        $atts['id'] = $sourceHeader;
                    }

                    $defaultValues = ['default', 'defaultGlobal', 'defaultLayout'];
                    if (in_array($atts['id'], $defaultValues)) {
                        $headerId = '';
                        if ($atts['id'] === 'defaultGlobal') {
                            $globalTemplateData = vcapp('\themeEditor\themeEditor\LayoutController')->getGlobalTemplatePartData('header');
                            $headerId = $globalTemplateData['sourceId'];
                        } elseif ($atts['id'] === 'defaultLayout') {
                            $layoutId = $requestHelper->input('vcv-template');
                            $headerId = get_post_meta($layoutId, '_' . VCV_PREFIX . 'HeaderTemplateId', true);
                        }

                        return vchelper('Frontend')->renderContent($headerId);

                        // TOOD: NOTE: We cannot render "theme default" footer/header
                        // Check also FooterController.php
                    } elseif (is_numeric($atts['id'])) {
                        return vchelper('Frontend')->renderContent($atts['id']);
                    }
                }

                return '';
            }
        );
        parent::__construct();

        $this->wpAddAction('get_header', 'getHeader');
    }

    /**
     * @param $name
     *
     * To replace the header
     *
     * @param \themeEditor\themeEditor\LayoutController $layoutController
     */
    protected function getHeader($name, LayoutController $layoutController)
    {
        $templateData = $layoutController->getTemplatePartId('header');
        $sourceId = $templateData['sourceId'];

        if (!$templateData['replaceTemplate']) {
            return;
        }

        echo vcaddonview(
            'layouts/vcv-custom-header',
            [
                'addon' => 'themeEditor',
                'sourceId' => $sourceId,
                'part' => __('Header', 'visualcomposer'),
            ]
        );

        $templates = [];
        if ($name) {
            $templates[] = 'header-' . $name . '.php';
        }
        $templates[] = 'header.php';

        remove_all_actions('wp_head'); // skip multiple execution
        $this->extractTemplate($templates);
    }
}
