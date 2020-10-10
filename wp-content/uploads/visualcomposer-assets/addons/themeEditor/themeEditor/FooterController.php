<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
require_once('PostTypeController.php');

use VisualComposer\Framework\Illuminate\Support\Module;

class FooterController extends PostTypeController implements Module
{
    /**
     * @var string
     */
    protected $postType = 'vcv_footers';

    protected $postNameSlug = 'Footer';

    public function __construct()
    {
        $this->postNameSingular = __('Footer', 'visualcomposer');
        $this->postNamePlural = __('Footers', 'visualcomposer');
        add_shortcode(
            'vcv_layouts_footer',
            function ($atts, $content, $tag) {
                if (!empty($atts) && !empty($atts['id']) && $atts['id'] !== 'none') {
                    $requestHelper = vchelper('Request');
                    $frontendHelper = vchelper('Frontend');
                    $sourceFooter = $requestHelper->input('vcv-footer');
                    if ($sourceFooter && $frontendHelper->isPageEditable()) {
                        $atts['id'] = $sourceFooter;
                    }

                    $defaultValues = ['default', 'defaultGlobal', 'defaultLayout'];
                    if (in_array($atts['id'], $defaultValues)) {
                        $footerId = '';
                        if ($atts['id'] === 'defaultGlobal') {
                            $globalTemplateData = vcapp('\themeEditor\themeEditor\LayoutController')->getGlobalTemplatePartData('footer');
                            $footerId = $globalTemplateData['sourceId'];
                        } elseif ($atts['id'] === 'defaultLayout') {
                            $layoutId = $requestHelper->input('vcv-template');
                            $footerId = get_post_meta($layoutId, '_' . VCV_PREFIX . 'FooterTemplateId', true);
                        }

                        return vchelper('Frontend')->renderContent($footerId);

                        // TOOD: NOTE: We cannot render "theme default" footer/header
                    } elseif (is_numeric($atts['id'])) {
                        return vchelper('Frontend')->renderContent($atts['id']);
                    }
                }

                return '';
            }
        );
        parent::__construct();

        $this->wpAddAction('get_footer', 'getFooter');
    }

    /**
     * @param $name
     *
     * To replace the footer
     *
     * @param \themeEditor\themeEditor\LayoutController $layoutController
     *
     */
    protected function getFooter($name, LayoutController $layoutController)
    {
        $templateData = $layoutController->getTemplatePartId('footer');
        $sourceId = $templateData['sourceId'];

        if (!$templateData['replaceTemplate']) {
            return;
        }

        echo vcaddonview(
            'layouts/vcv-custom-footer',
            [
                'addon' => 'themeEditor',
                'sourceId' => $sourceId,
                'part' => __('Footer', 'visualcomposer'),
            ]
        );

        $templates = [];
        if ($name) {
            $templates[] = 'footer-' . $name . '.php';
        }
        $templates[] = 'footer.php';

        $this->extractTemplate($templates);
    }
}
