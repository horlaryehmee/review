<?php

namespace WPSocialReviewsPro\App\Hooks\Handlers;

use WPSocialReviews\App\Services\Platforms\Reviews\Helper;
use WPSocialReviews\Framework\Support\Arr;
use WPSocialReviewsPro\App\Traits\LoadView;

class ReviewsTemplateHandlerPro
{
    use LoadView;

    public function airbnbReviewsLimitEndPoint()
    {
        return 100;
    }

    public function adminAppVars($vars)
    {
        $vars['assets_url_pro'] = WPSOCIALREVIEWS_PRO_URL . 'assets/images/';
        return $vars;
    }

    public function pushPlatforms($platforms)
    {
        $platforms['testimonial'] = __('Testimonial', 'wp-social-ninja-pro');
        return $platforms;
    }

    public function addReviewsTemplate($template, $reviews, $template_meta, $business_info = [])
    {
        $templateMapping = [
            'grid6' => 'reviews-templates/template6',
            'grid7' => 'reviews-templates/template7',
            'grid8' => 'reviews-templates/template8',
            'grid9' => 'reviews-templates/template9',
            'testimonial1' => 'testimonial-templates/testimonial1',
            'testimonial2' => 'testimonial-templates/testimonial2',
        ];

        if (!isset($templateMapping[$template])) {
            return __('No templates found!! Please save template and try again', 'wp-social-ninja-pro');
        }

        return $this->loadView($templateMapping[$template], array(
            'reviews'       => $reviews,
            'template_meta' => $template_meta,
            'business_info' => $business_info
        ));
    }

    public function renderReviewsTemplateBusinessInfo($reviews = [], $business_info = [], $template_meta = [], $templateId = null, $translations = [])
    {
        $platforms = Arr::get($business_info, 'platforms');
        if ((isset($template_meta['show_header']) && $template_meta['show_header'] === 'true') && !empty($business_info) && defined('WPSOCIALREVIEWS_PRO') && $platforms) {
            $platformNames = array_column($business_info['platforms'], 'platform_name');
            $isBooking = false;
            if(in_array('booking.com', $platformNames)) {
                if(count(array_unique($platformNames)) === 1 && end($platformNames) === 'booking.com') {
                    $isBooking = true;
                }
            }

            // Add custom business info if custom platform exists
           // $business_info = Helper::addCustomBusinessInfo($business_info, $template_meta);

            echo $this->loadView('reviews-templates/business_info', array(
                'reviews'       => $reviews,
                'business_info' => $business_info,
                'template_meta' => $template_meta,
                'isBooking'     => $isBooking,
                'templateId'    => $templateId,
                'translations'  => $translations
            ));
        }
    }

    public function renderReviewsWriteaReviewBtn($template_meta = [], $templateType = '', $business_info = [], $templateId = null, $translations = [])
    {
        if(!Arr::get($template_meta, 'display_header_write_review', true)) {
            return;
        }
        $html = $this->loadView('reviews-templates/write-a-review-btn', array(
            'templateId'    => $templateId,
            'template_meta' => $template_meta,
            'templateType'  => $templateType,
            'business_info' => $business_info,
            'translations'  => $translations
        ));
        echo $html;
    }

    public function addReviewsBadgeTemplate($templateId = null, $templateType = '', $business_info = [], $badge_settings = [])
    {
        return $this->loadView('reviews-templates/badge1', array(
            'templateId'     => $templateId,
            'templateType'   => $templateType,
            'business_info'  => $business_info,
            'badge_settings' => $badge_settings
        ));
    }

    public function addReviewsNotificationTemplate($templateId, $templateMeta, $reviews)
    {
        return $this->loadView('reviews-templates/notification', array(
            'templateId'     => $templateId,
            'templateMeta'   => $templateMeta,
            'reviews'        => $reviews
        ));
    }


    public function renderAuthorPosition($template_meta, $reviews)
    {
        if (Arr::get($template_meta, 'author_position') !== 'true' && Arr::get($template_meta, 'author_company_name') !== 'true') {
            return;
        }
        if (Arr::get($reviews, 'fields')){
            $author_position = Arr::get($reviews, 'fields.author_position', '');
            $author_company = Arr::get($reviews, 'fields.author_company', '');
            ?>
            <span class="wpsr-reviewer-position">
            <?php
            if (Arr::get($template_meta, 'author_position') === 'true' && $author_position) {
                echo esc_html($author_position);
            }
            if (Arr::get($template_meta, 'author_company_name') === 'true' && $author_company) {
                echo esc_html('@'.$author_company);
            }
            ?>
        </span>
            <?php
        }
    }

    public function renderAuthorWebsiteLogo($template_meta, $reviews)
    {
        if (Arr::get($template_meta, 'website_logo') !== 'true') {
            return;
        }
        if (Arr::get($reviews, 'fields')){
            $author_website_url = Arr::get($reviews, 'fields.author_website_url', '');
            $author_website_logo = Arr::get($reviews, 'fields.author_website_logo', '');
            $author_company = Arr::get($reviews, 'fields.author_company', '');
            if(!$author_website_logo){
                return false;
            }
            ?>
            <div class="wpsr-author-website-logo-wrapper">
                <a class="wpsr-author-website-logo-url" href="<?php echo esc_url($author_website_url); ?>" target="_blank">
                    <img class="wpsr-author-website-logo" src="<?php echo esc_url($author_website_logo); ?>" alt="<?php echo esc_attr($author_company); ?>">
                </a>
            </div>
            <?php
        }
    }

    /**
     *
     * Render Total Reviews HTML on AI Summary Card
     *
     * @param $cusom_number_of_reviews_text
     * @param $total_rating
     * @param $review
     *
     * @since 3.1
     *
     **/

    public function addTotalReviewsToAISummaryCard($total_rating, $custom_number_of_reviews_text, $review)
    {
        if ($review->category === 'ai_summary') {
            echo '<div class="wpsr-total-reviews-for-ai-summary-card">' .
                str_replace(
                    '{total_reviews}',
                    '<span>' . esc_html(number_format($total_rating, 0)) . '</span>',
                    esc_html($custom_number_of_reviews_text)
                )
                . '</div>';
        }

    }
}