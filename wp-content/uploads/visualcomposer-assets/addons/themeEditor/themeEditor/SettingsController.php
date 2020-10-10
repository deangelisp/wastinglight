<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Options;
use VisualComposer\Helpers\Frontend;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Traits\WpFiltersActions;
use VisualComposer\Modules\Settings\Traits\Fields;
use VisualComposer\Helpers\PostType;
use VisualComposer\Modules\Settings\Traits\Page;
use VisualComposer\Modules\Settings\Traits\SubMenu;

class SettingsController extends Container implements Module
{
    use Page;
    use SubMenu;
    use Fields;
    use WpFiltersActions;
    use EventsFilters;

    protected $slug = 'vcv-headers-footers';

    /*
     * @var string
     */
    protected $templatePath = 'settings/pages/index';

    /**
     * General constructor.
     */
    public function __construct()
    {
        $this->optionSlug = $this->optionGroup = $this->slug;

        $this->wpAddAction('admin_init', 'buildPage');
        $this->wpAddAction('admin_menu', 'addPage', 3);
        $this->wpAddFilter('submenu_file', 'subMenuHighlight');
        $this->wpAddAction('admin_head', 'addCss');

        $this->addEvent('vcv:system:factory:reset', 'unsetOptions');
    }

    protected function beforeRender()
    {
        $urlHelper = vchelper('Url');
        wp_register_style(
            'vcv:wpVcSettings:style',
            $urlHelper->to('public/dist/wpVcSettings.bundle.css'),
            [],
            VCV_VERSION
        );
        wp_enqueue_style('vcv:wpVcSettings:style');

        wp_register_script(
            'vcv:wpVcSettings:script',
            $urlHelper->to('public/dist/wpVcSettings.bundle.js'),
            ['vcv:assets:vendor:script'],
            VCV_VERSION
        );
        wp_enqueue_script('vcv:wpVcSettings:script');
        wp_enqueue_script('vcv:assets:runtime:script');
    }

    /**
     * @throws \Exception
     */
    protected function addPage()
    {
        $page = [
            'slug' => $this->getSlug(),
            'title' => __('Headers and Footers', 'visualcomposer'),
            'layout' => 'dashboard-tab-content-standalone',
            'capability' => 'manage_options',
            'isDashboardPage' => true,
        ];
        $this->addSubmenuPage($page);
    }

    /**
     * @param $submenuFile
     *
     * @return string
     */
    protected function subMenuHighlight($submenuFile)
    {
        $screen = get_current_screen();
        if (strpos($screen->id, $this->slug)) {
            $submenuFile = 'vcv-settings';
        }

        return $submenuFile;
    }

    /**
     *  Hide the submenu section in main menu
     */
    protected function addCss()
    {
        echo vcaddonview(
            'layouts/headers-footers-settings',
            [
                'addon' => 'themeEditor',
            ]
        );
    }

    /**
     * @param \VisualComposer\Helpers\Options $optionsHelper
     * @param \VisualComposer\Helpers\Frontend $frontendHelper
     *
     * @throws \ReflectionException
     */
    protected function buildPage(Options $optionsHelper, PostType $postTypeHelper, Frontend $frontendHelper)
    {
        /**
         * Main section
         */
        $this->addSection(
            [
                'page' => $this->slug,
                'slug' => 'headers-footers-override',
            ]
        );

        $enabledOptions = [
            ['id' => 'allSite', 'title' => __('Apply custom header and footer (all site)', 'visualcomposer')],
            [
                'id' => 'customPostType',
                'title' => __('Apply custom header and footer (per post type)', 'visualcomposer'),
            ],
        ];

        $headerFooterSettings = $optionsHelper->get('headerFooterSettings');
        $fieldCallback = function () use ($enabledOptions, $headerFooterSettings) {
            $args = [
                'enabledOptions' => $enabledOptions,
                'name' => 'vcv-headerFooterSettings',
                'value' => $headerFooterSettings,
                'emptyTitle' => __('Use theme default', 'visualcomposer'),
                'description' => __(
                    'All settings can be overwritten for specific pages in Visual Composer on-page settings',
                    'visualcomposer'
                ),
            ];
            echo vcview(
                'settings/fields/dropdown',
                $args
            );
        };

        /**
         * All site headers and footers section
         */
        $this->addField(
            [
                'page' => $this->slug,
                'name' => 'headerFooterSettings',
                'id' => 'vcv-headers-footers-override',
                'slug' => 'headers-footers-override',
                'fieldCallback' => $fieldCallback,
                'args' => [
                    'class' => 'vcv-no-title',
                ],
            ]
        );

        $sectionCallbackAllSite = function () {
            echo sprintf(
                '<p class="description">%s</p>',
                esc_html__('Specify custom Visual Composer header and footer for the whole site.', 'visualcomposer')
            );
        };

        $this->addSection(
            [
                'page' => $this->slug,
                'title' => __('All Site', 'visualcomposer'),
                'slug' => 'headers-footers-all-site',
                'callback' => $sectionCallbackAllSite,
                'vcv-args' => [
                    'class' => 'vcv-hidden',
                    'parent' => 'headers-footers-override',
                ],
            ]
        );

        $availableHeaders = $this->getPosts(['vcv_headers'], $frontendHelper);
        $selectedAllHeader = (int)$optionsHelper->get('headerFooterSettingsAllHeader');

        $fieldCallbackAllSiteHeader = function () use ($availableHeaders, $selectedAllHeader) {
            $args = [
                'enabledOptions' => $availableHeaders,
                'name' => 'vcv-headerFooterSettingsAllHeader',
                'value' => $selectedAllHeader,
                'emptyTitle' => __('Select Header', 'visualcomposer'),
                'dataTitle' => __('header template', 'visualcomposer'),
                'class' => 'vcv-edit-link-selector',
            ];
            echo vcview(
                'settings/fields/dropdown',
                $args
            );
        };
        $this->addField(
            [
                'page' => $this->slug,
                'title' => __('Header', 'visualcomposer'),
                'name' => 'headerFooterSettingsAllHeader',
                'id' => 'vcv-headers-footers-all-header',
                'slug' => 'headers-footers-all-site',
                'fieldCallback' => $fieldCallbackAllSiteHeader,
            ]
        );

        $availableFooters = $this->getPosts(['vcv_footers'], $frontendHelper);
        $selectedAllFooter = (int)$optionsHelper->get('headerFooterSettingsAllFooter');

        $fieldCallbackAllSiteFooter = function () use ($availableFooters, $selectedAllFooter) {
            $args = [
                'enabledOptions' => $availableFooters,
                'name' => 'vcv-headerFooterSettingsAllFooter',
                'value' => $selectedAllFooter,
                'emptyTitle' => __('Select Footer', 'visualcomposer'),
                'dataTitle' => __('footer template', 'visualcomposer'),
                'class' => 'vcv-edit-link-selector',
            ];
            echo vcview(
                'settings/fields/dropdown',
                $args
            );
        };
        $this->addField(
            [
                'page' => $this->slug,
                'title' => __('Footer', 'visualcomposer'),
                'name' => 'headerFooterSettingsAllFooter',
                'id' => 'vcv-headers-footers-all-footer',
                'slug' => 'headers-footers-all-site',
                'fieldCallback' => $fieldCallbackAllSiteFooter,
            ]
        );

        /**
         * Separate post types and page types headers and footers section
         */
        $this->addSection(
            [
                'page' => $this->slug,
                'slug' => 'headers-footers-separate-post-types',
                'vcv-args' => [
                    'class' => 'vcv-hidden',
                    'parent' => 'headers-footers-override',
                ],
            ]
        );

        /**
         * Separate post types
         */
        $enabledPostTypes = $postTypeHelper->getPostTypes(['attachment']);
        foreach ($enabledPostTypes as $postType) {
            $sectionCallback = function () use ($postType) {
                echo sprintf(
                    __('Define header and footer for %s.'),
                    $postType['label']
                );
            };

            $this->addSection(
                [
                    'page' => $this->slug,
                    'title' => $postType['label'],
                    'slug' => 'headers-footers-separate-post-type-' . $postType['value'],
                    'callback' => $sectionCallback,
                    'vcv-args' => [
                        'parent' => 'headers-footers-separate-post-types',
                    ],
                ]
            );

            $separateOptionPostType = (array)$optionsHelper->get(
                'headerFooterSettingsSeparatePostType-' . $postType['value']
            );
            $fieldCallbackSeparateOption = function () use ($separateOptionPostType, $postType) {
                $args = [
                    'isEnabled' => in_array('headers-footers-separate-' . $postType['value'], $separateOptionPostType),
                    'name' => 'vcv-headerFooterSettingsSeparatePostType-' . $postType['value'],
                    'value' => 'headers-footers-separate-' . $postType['value'],
                    'title' => esc_html__('Use custom headers and footers on the site.', 'visualcomposer'),
                ];
                echo vcview(
                    'settings/fields/toggle',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'name' => 'headerFooterSettingsSeparatePostType-' . $postType['value'],
                    'id' => 'vcv-headers-footers-separate-' . $postType['value'],
                    'slug' => 'headers-footers-separate-post-type-' . $postType['value'],
                    'fieldCallback' => $fieldCallbackSeparateOption,
                    'args' => [
                        'class' => 'vcv-no-title',
                    ],
                ]
            );

            $selectedSeparateHeader = (int)$optionsHelper->get(
                'headerFooterSettingsSeparatePostTypeHeader-' . $postType['value']
            );
            $fieldCallback = function () use ($availableHeaders, $selectedSeparateHeader, $postType) {
                $args = [
                    'enabledOptions' => $availableHeaders,
                    'name' => 'vcv-headerFooterSettingsSeparatePostTypeHeader-' . $postType['value'],
                    'value' => $selectedSeparateHeader,
                    'emptyTitle' => __('Select Header', 'visualcomposer'),
                    'dataTitle' => __('header template', 'visualcomposer'),
                    'class' => 'vcv-edit-link-selector',
                ];
                echo vcview(
                    'settings/fields/dropdown',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'title' => __('Header', 'visualcomposer'),
                    'name' => 'headerFooterSettingsSeparatePostTypeHeader-' . $postType['value'],
                    'id' => 'vcv-header-footer-settings-separate-header-' . $postType['value'],
                    'slug' => 'headers-footers-separate-post-type-' . $postType['value'],
                    'fieldCallback' => $fieldCallback,
                ]
            );

            $selectedSeparateFooter = (int)$optionsHelper->get(
                'headerFooterSettingsSeparatePostTypeFooter-' . $postType['value']
            );
            $fieldCallback = function () use ($availableFooters, $selectedSeparateFooter, $postType) {
                $args = [
                    'enabledOptions' => $availableFooters,
                    'name' => 'vcv-headerFooterSettingsSeparatePostTypeFooter-' . $postType['value'],
                    'value' => $selectedSeparateFooter,
                    'emptyTitle' => __('Select Footer', 'visualcomposer'),
                    'dataTitle' => __('footer template', 'visualcomposer'),
                    'class' => 'vcv-edit-link-selector',
                ];
                echo vcview(
                    'settings/fields/dropdown',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'title' => __('Footer', 'visualcomposer'),
                    'name' => 'headerFooterSettingsSeparatePostTypeFooter-' . $postType['value'],
                    'id' => 'vcv-header-footer-settings-separate-footer-' . $postType['value'],
                    'slug' => 'headers-footers-separate-post-type-' . $postType['value'],
                    'fieldCallback' => $fieldCallback,
                ]
            );
        }

        /**
         * Separate page types
         */

        $specificPages = [
            [
                'title' => __('Front Page', 'visualcomposer'),
                'name' => 'frontPage',
            ],
            [
                'title' => __('Post Listing Page', 'visualcomposer'),
                'name' => 'postPage',
            ],
            [
                'title' => __('Post Archive Page', 'visualcomposer'),
                'name' => 'archive',
            ],
            [
                'title' => __('Categories', 'visualcomposer'),
                'name' => 'category',
            ],
            [
                'title' => __('Authors', 'visualcomposer'),
                'name' => 'author',
            ],
            [
                'title' => __('Search', 'visualcomposer'),
                'name' => 'search',
            ],
            [
                'title' => __('404 Page', 'visualcomposer'),
                'name' => 'notFound',
            ],
        ];

        $specificPages[] = [];
        $specificPages = vcfilter('vcv:themeEditor:settingsController:addPages', $specificPages);
        foreach ($specificPages as $pageType) {
            if (!isset($pageType['name'])) {
                continue;
            }
            $pageType['slug'] = 'headers-footers-page-type-' . $pageType['name'];
            $pageType['optionKey'] = 'headerFooterSettingsPageType-' . $pageType['name'];
            $pageType['optionKeyHeader'] = 'headerFooterSettingsPageTypeHeader-' . $pageType['name'];
            $pageType['optionKeyFooter'] = 'headerFooterSettingsPageTypeFooter-' . $pageType['name'];

            $sectionCallback = function () use ($pageType) {
                echo sprintf(
                    '<p class="description">%s</p>',
                    'Define header and footer for ' . $pageType['title']
                );
            };
            $this->addSection(
                [
                    'page' => $this->slug,
                    'title' => $pageType['title'],
                    'slug' => $pageType['slug'],
                    'callback' => $sectionCallback,
                    'vcv-args' => [
                        'parent' => 'headers-footers-separate-post-types',
                    ],
                ]
            );

            $separateOptionPageType = (array)$optionsHelper->get($pageType['optionKey']);
            $fieldCallbackOption = function () use ($separateOptionPageType, $pageType) {
                $args = [
                    'isEnabled' => in_array($pageType['slug'], $separateOptionPageType, true),
                    'name' => 'vcv-' . $pageType['optionKey'],
                    'value' => $pageType['slug'],
                    'title' => esc_html__('Use custom headers and footers on the site.', 'visualcomposer'),
                    'class' => 'vcv-edit-link-selector',
                ];
                echo vcview(
                    'settings/fields/toggle',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'name' => $pageType['optionKey'],
                    'id' => 'vcv-' . $pageType['slug'],
                    'slug' => $pageType['slug'],
                    'fieldCallback' => $fieldCallbackOption,
                    'args' => [
                        'class' => 'vcv-no-title',
                    ],
                ]
            );

            $selectedHeader = (int)$optionsHelper->get($pageType['optionKeyHeader']);
            $fieldCallback = function () use ($availableHeaders, $selectedHeader, $pageType) {
                $args = [
                    'enabledOptions' => $availableHeaders,
                    'name' => 'vcv-' . $pageType['optionKeyHeader'],
                    'value' => $selectedHeader,
                    'emptyTitle' => __('Select Header', 'visualcomposer'),
                    'dataTitle' => __('header template', 'visualcomposer'),
                    'class' => 'vcv-edit-link-selector',
                ];
                echo vcview(
                    'settings/fields/dropdown',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'title' => __('Header', 'visualcomposer'),
                    'name' => $pageType['optionKeyHeader'],
                    'id' => 'vcv-' . $pageType['slug'] . '-header',
                    'slug' => $pageType['slug'],
                    'fieldCallback' => $fieldCallback,
                ]
            );

            $selectedFooter = (int)$optionsHelper->get($pageType['optionKeyFooter']);
            $fieldCallback = function () use ($availableFooters, $selectedFooter, $pageType) {
                $args = [
                    'enabledOptions' => $availableFooters,
                    'name' => 'vcv-' . $pageType['optionKeyFooter'],
                    'value' => $selectedFooter,
                    'emptyTitle' => __('Select Footer', 'visualcomposer'),
                    'dataTitle' => __('footer template', 'visualcomposer'),
                    'class' => 'vcv-edit-link-selector',
                ];
                echo vcview(
                    'settings/fields/dropdown',
                    $args
                );
            };

            $this->addField(
                [
                    'page' => $this->slug,
                    'title' => __('Footer', 'visualcomposer'),
                    'name' => $pageType['optionKeyFooter'],
                    'id' => 'vcv-' . $pageType['slug'] . '-footer',
                    'slug' => $pageType['slug'],
                    'fieldCallback' => $fieldCallback,
                ]
            );
        }
    }

    /**
     * @param $postType
     * @param \VisualComposer\Helpers\Frontend $frontendHelper
     *
     * @return array
     */
    protected function getPosts($postType, $frontendHelper)
    {
        $args = [
            'numberposts' => -1,
            'post_type' => $postType,
            'orderby' => 'title',
            'order' => 'ASC',
        ];

        $availablePosts = [];
        $posts = get_posts($args);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $postData = [];
                $postData['id'] = $post->ID;
                // @codingStandardsIgnoreLine
                $postData['title'] = $post->post_title;
                $postData['url'] = $frontendHelper->getFrontendUrl($post->ID);
                $availablePosts[] = $postData;
            }
        }

        return $availablePosts;
    }

    /**
     * @param \VisualComposer\Helpers\Options $optionsHelper
     * @param \VisualComposer\Helpers\PostType $postTypeHelper
     */
    protected function unsetOptions(Options $optionsHelper, PostType $postTypeHelper)
    {
        $optionsHelper->delete('headerFooterSettings');
        $optionsHelper->delete('headerFooterSettingsAllHeader');
        $optionsHelper->delete('headerFooterSettingsAllFooter');
        $optionsHelper->delete('headerFooterSettingsSeparate');
        $enabledPostTypes = $postTypeHelper->getPostTypes(['attachment']);
        if (!empty($enabledPostTypes)) {
            foreach ($enabledPostTypes as $postType) {
                $optionsHelper->delete('headerFooterSettingsSeparateHeader-' . $postType['value']);
                $optionsHelper->delete('headerFooterSettingsSeparateFooter-' . $postType['value']);
            }
        }
    }
}
