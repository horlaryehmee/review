<?php

use WPSocialReviews\App\Services\Platforms\Reviews\Helper;
use WPSocialReviews\Framework\Support\Arr;

extract($business_info);
extract($template_meta);
$meta_platform = Arr::get($template_meta, 'platform');

$total_platforms = count($meta_platform);
$total_business = isset($total_business) ? $total_business : null;

$platform_name_class = Helper::platformDynamicClassName($business_info);

$wrapperClass = ($template_meta['templateType'] === 'badge' || $template_meta['templateType'] === 'notification') ? 'wpsr-display-block' : '';
$html          = '';

$add_custom_war_btn_url = Arr::get($template_meta, 'add_custom_war_btn_url');
$war_btn_source = Arr::get($template_meta, 'war_btn_source');
$war_btn_source_custom_url = Arr::get($template_meta, 'war_btn_source_custom_url');
$war_btn_open_in_new_window = Arr::get($template_meta, 'war_btn_open_in_new_window');
$war_btn_source_form_shortcode_id = Arr::get($template_meta, 'war_btn_source_form_shortcode_id');

$addFormClass = '';
if(defined('FLUENTFORM') && $add_custom_war_btn_url === 'true' && $war_btn_source === 'form_id' && !empty($war_btn_source_form_shortcode_id)){
    $url = '#';
    $addFormClass = 'wpsr-reviews-form-popup-trigger';

    $html .= '<div class="wpsr-reviews-form-popup-overlay">';
    $html .= '<div class="wpsr-reviews-form-popup-box-wraper">';
    $html .= '<div class="wpsr-reviews-form-popup-box-wraper-inner">';

    $html .= '<a class="wpsr-popup-close" href="#">
    <svg viewBox="0 0 16 16" style="fill: rgb(255, 255, 255);">
       <path d="M3.426 2.024l.094.083L8 6.586l4.48-4.479a1 1 0 011.497 1.32l-.083.095L9.414 8l4.48 4.478a1 1 0 01-1.32 1.498l-.094-.083L8 9.413l-4.48 4.48a1 1 0 01-1.497-1.32l.083-.095L6.585 8 2.106 3.522a1 1 0 011.32-1.498z">
       </path>
    </svg>
    </a>';
    $html .= do_shortcode('[fluentform id="'.esc_attr($war_btn_source_form_shortcode_id).'"]');
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
}

$html .= '<div class="wpsr-business-info-right">';

if ((!empty($platforms) && is_array($platforms))) {
    $html .= '<div class="wpsr-write-review-modal-wrapper">';

    if (method_exists(Helper::class, 'getValidPlatforms')) {
        $validPlatforms = Helper::getValidPlatforms($platforms);
    } else {
        $validPlatforms = Arr::get($platforms, '0');
    }

    if($add_custom_war_btn_url === 'true'){
        $war_btn_source_custom_url = $war_btn_source_custom_url && $war_btn_source === 'custom_url' ? $war_btn_source_custom_url : '#';
        $war_btn_target = $war_btn_open_in_new_window === 'true' ? '_blank' : '_self';
        $html .= '<a target="'.esc_attr($war_btn_target).'" class="wpsr-write-review '.esc_attr($addFormClass).'" href="' . esc_url($war_btn_source_custom_url) . '">'.$custom_write_review_text. '</a>';
    }

    if ($add_custom_war_btn_url === 'false' && $total_business === 1 && $validPlatforms) {
        $url = $validPlatforms['url'];
        $html .= '<a target="_blank" class="wpsr-write-review" href="' . esc_url($url) . '">' . $custom_write_review_text . '</a>';
    }

    if($add_custom_war_btn_url === 'false' && $total_business > 1) {
        $html .= '<a href="#" class="wpsr-write-review wpsr-write-review-modal-btn" aria-label="'.esc_attr($custom_write_review_text).'">' . $custom_write_review_text . '</a>';

        $html .= '<div class="wpsr-write-review-modal">';
        $html .= '<p>' . Arr::get($translations, 'leave_a_review') ?: __('Where would you like to leave a review?', 'wp-social-ninja-pro') . '</p>';

        $html .= '<div class="wpsr-business-info-paltforms-url">';
        foreach ($platforms as $index => $platform) {
            if (!empty(Arr::get($platform, 'url'))) {
                $html .= '<a class="'.esc_attr($platform['platform_name']).'"  href="' . esc_url($platform['url']) . '" target="_blank" aria-label="' . esc_attr($platform['name']) . '">';
                if (!Helper::is_tp($platform['platform_name']) || (Helper::is_tp($platform['platform_name']) && $template_meta['display_tp_brand'] === 'true')) {
                    $icon_small = Helper::platformIcon($platform['platform_name'], 'small');
                    if (Arr::get($platform, 'product_url')) {
                        $icon_small = Arr::get($platform, 'product_url');
                    }
                    
                    if (!empty($icon_small)) {
                        $html .= '<img class="wpsr-business-info-war-btn-icon" src="' . esc_url($icon_small) . '" alt="' . esc_attr($platform['platform_name']) . '">';
                    }
                }

                $html .= '<div class="wpsr-paltforms-url">';
                $html .= '<span class="wpsr-platform">' . $platform['name'] . '</span>';
                $html .= '<span class="wpsr-url">' . $platform['url'] . '</span>';
                $html .= '</div>';
                $html .= '</a>';
            }
        }
        $html .= '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
}
$html .= '</div>';
echo $html;