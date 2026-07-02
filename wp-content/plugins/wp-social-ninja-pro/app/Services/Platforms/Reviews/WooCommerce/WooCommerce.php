<?php

namespace WPSocialReviewsPro\App\Services\Platforms\Reviews\WooCommerce;

use WPSocialReviews\App\Services\Platforms\Reviews\BaseReview;
use WPSocialReviews\App\Services\Platforms\Reviews\Helper as ReviewsHelper;
use WPSocialReviews\Framework\Support\Arr;

if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce extends BaseReview
{
    private $productId = null;
    public function __construct()
    {
        parent::__construct(
            'woocommerce',
            'wpsr_reviews_woocommerce_settings',
            'wpsr_woocommerce_reviews_update'
        );
        if(class_exists('\WPSocialReviews\App\Services\Platforms\ReviewImageOptimizationHandler')){
            (new \WPSocialReviews\App\Services\Platforms\ReviewImageOptimizationHandler($this->platform))->registerHooks();
        }
    }

    public function pushValidPlatform($platforms)
    {
        $settings    = $this->getApiSettings();
        if (!isset($settings['data']) && sizeof($settings) > 0) {
            $platforms['woocommerce'] = __('WooCommerce', 'wp-social-ninja-pro');
        }
        return $platforms;
    }

    public function handleCredentialSave($settings = array())
    {
        $sourceId = $settings['source_id'];
        try {
            $businessInfo = $this->verifyCredential($sourceId);
            $message = ReviewsHelper::getNotificationMessage($businessInfo, $this->productId);

            if (Arr::get($businessInfo, 'total_fetched_reviews') && Arr::get($businessInfo, 'total_fetched_reviews') > 0) {
                unset($businessInfo['total_fetched_reviews']);
                update_option('wpsr_reviews_'.$this->platform.'_business_info', $businessInfo, 'no');
            }

            wp_send_json_success([
                'message'       => $message,
                'business_info' => $businessInfo
            ], 200);
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 423);
        }
    }

    /**
     * @throws \Exception
     */
    public function verifyCredential($sourceId)
    {
        if (empty($sourceId)) {
            throw new \Exception(__('Please provide a valid product id!!', 'wp-social-ninja-pro'));
        }

        $this->productId = $sourceId;
        $product = wc_get_product($sourceId);

        $products_data = [];

        $product_id = $product->get_id();

        $products_data['product_name']   = $product->get_name();
        $products_data['average_rating'] = (float) $product->get_average_rating();
        $products_data['total_rating']   = (int) $product->get_rating_count();

        foreach( get_approved_comments( $product_id ) as $review ) {

            if( $review->comment_type === 'review' ) {
                $comment_id = (int) $review->comment_ID;
                $comment_rating = (int) get_comment_meta( $comment_id, 'rating', true );

                $products_data['reviews'][] = [
                    'review_id'       => $review->comment_ID,
                    'reviewer_name'   => $review->comment_author,
                    'review_date'     => strtotime($review->comment_date),
                    'review_text'     => $review->comment_content,
                    'review_rating'   => $comment_rating,
                    'reviewer_email'  => $review->comment_author_email,
                    'fields'          => array(
                        'product_name' => get_the_title($product_id),
                        'product_thumbnail' => wp_get_attachment_image_src(get_post_thumbnail_id($product_id), [100, 100], false)
                    )
                ];
            }
        }

        if(!isset($products_data['reviews'])) {
            throw new \Exception(__('No reviews found for this product!', 'wp-social-ninja-pro'));
        }

        $total_reviews = count($products_data['reviews']);
        $products_data['total_rating'] = $total_reviews;
        $business_info = $this->saveBusinessInfo($products_data);

        if (isset($products_data['reviews']) && $total_reviews > 0) {
            $this->saveApiSettings([
                'api_key'       => '93af975a-f01f-4de8-9507-432c74255d38',
                'place_id'      => $sourceId,
                'url_value'     => '',//$businessUrl
            ]);

            $this->syncRemoteReviews($products_data['reviews']);

            update_option('wpsr_reviews_'.$this->platform.'_business_info', $business_info, 'no');

            $business_info['total_fetched_reviews'] = $total_reviews;
            return $business_info;
        } else {
             throw new \Exception(__('No reviews Found!', 'wp-social-ninja-pro'));
        }
    }

    public function formatData($review, $index)
    {
        $dateTime = Arr::get($review, 'review_date');
        $reviewerEmail = Arr::get($review, 'reviewer_email');
        $reviewDate = date('Y-m-d H:i:', $dateTime);

        return [
            'platform_name' => $this->platform,
            'source_id'     => $this->productId,
            'review_id'     => Arr::get($review, 'review_id'),
            'reviewer_name' => Arr::get($review, 'reviewer_name'),
            'review_title'  => $this->platform . '_' . ($index + 1),
            'reviewer_url'  => '',
            'reviewer_img'  => $reviewerEmail ? get_avatar_url($reviewerEmail) : '',
            'reviewer_text' => Arr::get($review, 'review_text', ''),
            'rating'        => (int)Arr::get($review, 'review_rating'),
            'review_time'   => $reviewDate,
            'fields'        => json_encode(Arr::get($review, 'fields')),
            'review_approved' => 1,
            'updated_at'    => date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s')
        ];
    }

    public function getAllProducts()
    {
        $args = array(
            'post_type'   => 'product',
            'numberposts' => -1,
            'post_status' => 'publish'
        );

        return get_posts($args);
    }

    public function getAdditionalInfo()
    {
        return $this->getAllProducts();
    }

    public function saveBusinessInfo($reviewData)
    {
        $businessInfo  = [];
        $infos         = $this->getBusinessInfo();

        $businessInfo['place_id']       = $this->productId;
        $businessInfo['name']           = Arr::get($reviewData, 'product_name', '');
        $businessInfo['url']            = get_the_permalink($this->productId).'#reviews';
        $businessInfo['address']        = '';
        $businessInfo['average_rating'] = Arr::get($reviewData, 'average_rating');
        $businessInfo['total_rating']   = Arr::get($reviewData, 'total_rating');
        $businessInfo['phone']          = '';
        $businessInfo['platform_name']  = $this->platform;
        $infos[$this->productId]        = $businessInfo;

        return $infos;
    }

    public function getBusinessInfo($data = array())
    {
        return get_option('wpsr_reviews_'.$this->platform.'_business_info');
    }

    public function saveApiSettings($settings)
    {
        $apiKey       = $settings['api_key'];
        $placeId      = $settings['place_id'];
        $businessUrl  = $settings['url_value'];

        $apiSettings  = $this->getApiSettings();

        if(isset($apiSettings['data']) && !$apiSettings['data']) {
            $apiSettings = [];
        }

        if ($apiKey && $placeId){
            $apiSettings[$placeId]['api_key']       = $apiKey;
            $apiSettings[$placeId]['place_id']      = $placeId;
            $apiSettings[$placeId]['url_value']     = $businessUrl;
        }
        return update_option($this->optionKey, $apiSettings, 'no');
    }

    public function getApiSettings()
    {
        $settings = get_option($this->optionKey);
        if (!$settings) {
            $settings = [
                'api_key'   => '',
                'place_id'  => '',
                'url_value' => '',
                'data'      => false,
            ];
        }

        return $settings;
    }

    public function manuallySyncReviews($credentials)
    {
        $settings = get_option($this->optionKey);

        if (!empty($settings) && is_array($settings)) {
            $sourceId  = Arr::get($credentials, 'place_id', '');
            if($sourceId){
                try {
                    $this->verifyCredential($sourceId);
                } catch (\Exception $exception){
                    error_log($exception->getMessage());
                }

                wp_send_json_success([
                    'message'  => __('Reviews synced successfully!', 'wp-social-ninja-pro')
                ]);
            }
        }
    }

    public function doCronEvent()
    {
        $expiredCaches = $this->cacheHandler->getExpiredCaches();
        if(!$expiredCaches) {
            return false;
        }

        $settings     = get_option($this->optionKey);
        if (!empty($settings) && is_array($settings)) {
            foreach ($settings as $setting) {
                $sourceId  = Arr::get($setting, 'place_id', '');
                if (in_array($sourceId, $expiredCaches)) {
                    if($sourceId){
                        try {
                            $this->verifyCredential($sourceId);
                        } catch (\Exception $exception){
                            error_log($exception->getMessage());
                        }
                    }

                    $this->cacheHandler->createCache('wpsr_reviews_' . $this->platform . '_business_info_' . $sourceId, $sourceId);
                }
            }
        }
    }

    public function clearVerificationConfigs($userId)
    {
        
    }
}