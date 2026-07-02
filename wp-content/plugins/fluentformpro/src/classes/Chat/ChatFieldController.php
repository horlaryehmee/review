<?php

namespace FluentFormPro\classes\Chat;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Models\Form;
use FluentForm\App\Models\FormMeta;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Helpers\ArrayHelper;

/**
 *  Handling Chat Field Module.
 *
 * @since 5.1.5
 */
class ChatFieldController
{
    protected $optionKey = '_fluentform_openai_settings';
    protected $integrationKey = 'openai';
    protected $app = null;
    protected $settingsKey = 'open_ai_feed';

    public function __construct($app)
    {
        $this->app = $app;
        $this->boot();
    }

    public function boot()
    {
        $isEnabled = $this->isEnabled();

        if (!$isEnabled) {
            return;
        }

        $this->enableIntegration($isEnabled);

        $isApiEnabled = $this->isApiEnabled();

        if ($isApiEnabled) {
            $this->insertAllEditorShortcode();
        }

        add_filter('fluentform/global_settings_components', [$this, 'addGlobalMenu'], 11, 1);

        add_filter('fluentform/global_integration_settings_' . $this->integrationKey, [$this, 'getGlobalSettings'], 11, 1);

        add_filter('fluentform/global_integration_fields_' . $this->integrationKey, [$this, 'getGlobalFields'], 11, 1);

        add_action('fluentform/save_global_integration_settings_' . $this->integrationKey, [$this, 'saveGlobalSettings'], 11,1);

        add_filter('fluentform/global_notification_types', [$this, 'addNotificationType'], 11, 1);

        add_filter('fluentform/get_available_form_integrations', [$this, 'pushIntegration'], 11, 2);

        add_filter('fluentform/global_notification_feed_' . $this->settingsKey, [$this, 'setFeedAttributes'], 11, 2);

        add_filter('fluentform/get_integration_defaults_' . $this->integrationKey, [$this, 'getIntegrationDefaults'], 11, 2);

        add_filter('fluentform/get_integration_settings_fields_' . $this->integrationKey, [$this, 'getSettingsFields'], 11, 2);

        add_filter('fluentform/save_integration_settings_' . $this->integrationKey, [$this, 'setMetaKey'], 11, 2);

        add_filter('fluentform/get_integration_values_' . $this->integrationKey, [$this, 'prepareIntegrationFeed'], 11, 3);

        add_action('wp_ajax_fluentform_openai_chat_completion', [$this, 'chatCompletion'], 11, 0);

        add_action('wp_ajax_nopriv_fluentform_openai_chat_completion', [$this, 'chatCompletion'], 11, 0);

        $this->submissionMessageHandler();

        new ChatField();
    }

    public function enableIntegration($isEnabled)
    {
        add_filter('fluentform/global_addons', function($addOns) use ($isEnabled) {
            $addOns[$this->integrationKey] = [
                'title'       => 'OpenAI ChatGPT Integration',
                'description' => __('Connect OpenAI ChatGPT Integration with Fluent Forms', 'fluentformpro'),
                'logo'        => fluentFormMix('img/integrations/openai.png'),
                'enabled'     => ($isEnabled) ? 'yes' : 'no',
                'config_url'  => admin_url('admin.php?page=fluent_forms_settings#general-openai-settings'),
                'category'    => '', //Category : All
            ];

            return $addOns;
        }, 9);
    }

    public function addGlobalMenu($setting)
    {
        $setting[$this->integrationKey] = [
            'hash'         => 'general-' . $this->integrationKey . '-settings',
            'component'    => 'general-integration-settings',
            'settings_key' => $this->integrationKey,
            'title'        => 'OpenAI ChatGPT Integration',
        ];
        return $setting;
    }

    public function getGlobalSettings($settings)
    {
        $globalSettings = get_option($this->optionKey);
        if (!$globalSettings) {
            $globalSettings = [];
        }
        $defaults = [
            'access_token' => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'             => fluentFormMix('img/integrations/openai.png'),
            'menu_title'       => __('OpenAI ChatGPT Integration', 'fluentformpro'),
            'menu_description' => __('The OpenAI API can be applied to chat directly with Chat GPT within fluent forms.',
                'fluentformpro'),
            'valid_message'    => __('Your OpenAI connection is valid', 'fluentformpro'),
            'invalid_message'  => __('Your OpenAI connection is not valid', 'fluentformpro'),
            'save_button_text' => __('Verify OpenAI', 'fluentformpro'),
            'fields'           => [
                'button_link'  => [
                    'type'      => 'link',
                    'link_text' => __('Get OpenAI API Keys', 'fluentformpro'),
                    'link'      => 'https://platform.openai.com/account/api-keys',
                    'target'    => '_blank',
                    'tips'      => __('Please click on this link get API keys from OpenAI.', 'fluentformpro'),
                ],
                'access_token' => [
                    'type'        => 'password',
                    'placeholder' => __('API Keys', 'fluentformpro'),
                    'label_tips'  => __("Please find API Keys by clicking 'Get OpenAI API Keys' Button then paste it here",
                        'fluentformpro'),
                    'label'       => __('Access Code', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'    => true,
            'discard_settings' => [
                'section_description' => __('Your OpenAI integration is up and running', 'fluentformpro'),
                'button_text'         => __('Disconnect OpenAI', 'fluentformpro'),
                'data'                => [
                    'access_token' => ''
                ],
                'show_verify'         => true
            ]
        ];
    }

    public function saveGlobalSettings($settings)
    {
        $token = $settings['access_token'];
        if (empty($token)) {
            $integrationSettings = [
                'access_token' => '',
                'status'       => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings, 'no');
            wp_send_json_success([
                'message' => __('Your settings has been updated', 'fluentformpro'),
                'status'  => false
            ], 200);
        }

        // Verify API key now
        try {
            $isAuth = $this->isAuthenticated($token);

            if ($isAuth && !is_wp_error($isAuth)) {
                $token = [
                    'status'       => true,
                    'access_token' => $settings['access_token']
                ];
            } else {
                throw new \Exception($isAuth->get_error_message(), $isAuth->get_error_code());
            }

            update_option($this->optionKey, $token, 'no');
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 400);
        }

        wp_send_json_success([
            'message' => __('Your Open AI API key has been verified and successfully set', 'fluentformpro'),
            'status'  => true
        ], 200);
    }

    public function addNotificationType($types)
    {
        $types[] = $this->settingsKey;
        return $types;
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => 'OpenAI Chat GPT',
            'logo'                  => fluentFormMix('img/integrations/openai.png'),
            'is_active'             => $this->isEnabled(),
            'configure_title'       => __('Configuration required!', 'fluentformpro'),
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-openai-settings'),
            'configure_message'     => __('OpenAI is not configured yet! Please configure your OpenAI api first',
                'fluentformpro'),
            'configure_button_text' => __('Set OpenAI API', 'fluentformpro')
        ];

        return $integrations;
    }

    public function setFeedAttributes($feed, $formId)
    {
        $feed['provider'] = $this->integrationKey;
        $feed['provider_logo'] = fluentFormMix('img/integrations/openai.png');
        return $feed;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'         => '',
            'role'         => '',
            'prompt_field' => '',
            'conditionals' => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'      => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields'              => [
                [
                    'key'         => 'name',
                    'label'       => __('Feed Name', 'fluentformpro'),
                    'required'    => true,
                    'placeholder' => __('Your Feed Name', 'fluentformpro'),
                    'component'   => 'text'
                ],
                [
                    'key'       => 'role',
                    'label'     => __('Select Role', 'fluentformpro'),
                    'tips'      => __('Select how AI gonna behave', 'fluentformpro'),
                    'required'  => true,
                    'component' => 'select',
                    'options'   => [
                        'system'    => __('System', 'fluentformpro'),
                        'assistant' => __('Assistant', 'fluentformpro'),
                        'user'      => __('User', 'fluentformpro')
                    ]
                ],
                [
                    'key'         => 'prompt_field',
                    'label'       => __('Write Query', 'fluentformpro'),
                    'placeholder' => __('Write your query to get Open AI generated result', 'fluentformpro'),
                    'tips'        => __('Write your query to get Open AI generated result', 'fluentformpro'),
                    'required'    => true,
                    'component'   => 'value_textarea',
                ],
                [
                    'require_list' => false,
                    'key'          => 'conditionals',
                    'label'        => __('Conditional Logics', 'fluentformpro'),
                    'tips'         => __('Allow this integration conditionally based on your submission values',
                        'fluentformpro'),
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'   => false,
                    'key'            => 'enabled',
                    'label'          => __('Status', 'fluentformpro'),
                    'component'      => 'checkbox-single',
                    'checkbox_label' => __('Enable this feed', 'fluentformpro')
                ]
            ],
            'button_require_list' => false,
            'integration_title'   => 'OpenAI ChatGPT'
        ];
    }

    public function setMetaKey($data)
    {
        $data['meta_key'] = $this->settingsKey;
        return $data;
    }

    public function prepareIntegrationFeed($setting, $feed, $formId)
    {
        $defaults = $this->getIntegrationDefaults([], $formId);

        foreach ($setting as $settingKey => $settingValue) {
            if ('true' == $settingValue) {
                $setting[$settingKey] = true;
            } elseif ('false' == $settingValue) {
                $setting[$settingKey] = false;
            } elseif ('conditionals' == $settingKey) {
                if ('true' == $settingValue['status']) {
                    $settingValue['status'] = true;
                } elseif ('false' == $settingValue['status']) {
                    $settingValue['status'] = false;
                }
                $setting['conditionals'] = $settingValue;
            }
        }

        if (!empty($setting['list_id'])) {
            $setting['list_id'] = (string)$setting['list_id'];
        }

        return wp_parse_args($setting, $defaults);
    }

    private function isEnabled()
    {
        $globalModules = get_option('fluentform_global_modules_status');
        $openAiModule = ArrayHelper::get($globalModules, $this->integrationKey);
        if ($openAiModule == 'yes') {
            return true;
        }
        return false;
    }

    private function makeRequest($token, $args = [])
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        ];

        $bodyArgs = [
            "model"    => "gpt-3.5-turbo",
            "messages" => [
                $args ?: [
                    "role"    => "system",
                    "content" => "You are a helpful assistant."
                ]
            ]
        ];

        add_filter('http_request_timeout', function($timeout) {
            return 60; // Set timeout to 60 seconds
        });

        $request = wp_remote_post($url, [
            'headers' => $headers,
            'body'    => json_encode($bodyArgs)
        ]);

        if (did_filter('http_request_timeout')) {
            add_filter('http_request_timeout', function($timeout) {
                return 5; // Set timeout to original 5 seconds
            });
        }

        if (is_wp_error($request)) {
            $message = $request->get_error_message();
            return new \WP_Error(423, $message);
        }

        $body = json_decode(wp_remote_retrieve_body($request), true);
        $code = wp_remote_retrieve_response_code($request);

        if ($code !== 200) {
            $error = __('Something went wrong.', 'fluentformpro');
            if (isset($body['error']['message'])) {
                $error = __($body['error']['message'], 'fluentformpro');
            }
            return new \WP_Error(423, $error);
        }

        return $body;
    }

    private function isAuthenticated($token)
    {
        $result = $this->makeRequest($token);
        if (is_wp_error($result)) {
            return $result;
        }
        return isset($result['id']);
    }

    private function isApiEnabled()
    {
        $settings = get_option($this->optionKey);
        if (!$settings || empty($settings['status'])) {
            $settings = [
                'access_token' => '',
                'status' => false,
            ];
        }
        return ArrayHelper::get($settings, 'status');
    }

    public function chatCompletion()
    {
        $request = $this->app->request->get();
        $formId = ArrayHelper::get($request, 'form_id', '');
        $form = Form::find($formId);
        $fields = ArrayHelper::get(json_decode($form->form_fields, true), 'fields');
        $role = '';
        $content = ArrayHelper::get($request, 'content');
        $failedMessage = '';

        foreach ($fields as $field) {
            if (ArrayHelper::get($field, 'element') == 'chat') {
                $role = ArrayHelper::get($field, 'settings.open_ai_role');
                $content = $content ?: ArrayHelper::get($field, 'settings.open_ai_content');
                $failedMessage = ArrayHelper::get($field, 'settings.failed_message');
            }
        }

        $args = [
            "role"    => $role,
            "content" => $content
        ];

        $token = ArrayHelper::get(get_option($this->optionKey), 'access_token');

        $result = $this->makeRequest($token, $args);

        if (is_wp_error($result)) {
            wp_send_json_error($failedMessage, 422);
        }

        wp_send_json_success($result, 200);
    }

    private function getFeeds($formId = '')
    {
        if (!$formId) {
            $request = $this->app->request->get();
            $formId = ArrayHelper::get($request, 'form_id');
        }
        $feeds = [];
        if ($formId) {
            $feeds = FormMeta::when($formId, function($q) use ($formId) {
                return $q->where('form_id', $formId);
            })->where('meta_key', $this->settingsKey)->get()->toArray();
        }

        return $feeds;
    }

    public function insertAllEditorShortcode()
    {
        add_filter('fluentform/all_editor_shortcodes', function($data) {
            $feeds = $this->getFeeds();

            if (!$feeds) {
                return $data;
            }

            $openAiShortCodesContainer = [
                'title'     => __('Open AI', 'fluentformpro'),
                'shortcodes' => []
            ];

            foreach ($feeds as $feed) {
                $value = json_decode(ArrayHelper::get($feed, 'value'), true);
                if (ArrayHelper::get($value, 'enabled') == 'false') {
                    continue;
                }
                $feedId = ArrayHelper::get($feed, 'id');
                $formId = ArrayHelper::get($feed, 'form_id');
                $openAiShortCodesContainer['shortcodes']['{open_ai_response_'. $formId . '_' . $feedId . '}'] = __('Open AI Response', 'fluentformpro');
            }

            $data[] = $openAiShortCodesContainer;

            return $data;
        }, 10, 1);
    }

    public function submissionMessageHandler()
    {
        $feeds = $this->getFeeds();

        if (!$feeds) {
            return;
        }

        foreach ($feeds as $feed) {
            $value = json_decode(ArrayHelper::get($feed, 'value'), true);
            if (ArrayHelper::get($value, 'enabled') == 'false') {
                continue;
            }
            $feedId = ArrayHelper::get($feed, 'id');
            $formId = ArrayHelper::get($feed, 'form_id');
            $role = ArrayHelper::get($value, 'role');
            $content = ArrayHelper::get($value, 'prompt_field');

            add_filter('fluentform/shortcode_parser_callback_open_ai_response_' . $formId . '_' . $feedId,
            function($value, $parser) use ($feed, $role, $content, $formId) {
                $submission = $parser::getEntry();
                $submittedData = \json_decode($submission->response, true);
                $submissionId = $submission->id;
                $form = $parser::getForm();

                $token = ArrayHelper::get(get_option($this->optionKey), 'access_token');

                $content = ShortCodeParser::parse(
                    $content,
                    $submissionId,
                    $submittedData,
                    $form,
                    false,
                    true
                );

                $args = [
                    "role"    => $role,
                    "content" => $content
                ];

                $result = $this->makeRequest($token, $args);

                return trim(ArrayHelper::get($result, 'choices.0.message.content'), '"');

            }, 11, 2);
        }
    }
}
