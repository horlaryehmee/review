<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

add_action('rest_api_init', function () {

  //Get Meta Key
  function lottiefiles_get_meta_key()
  {
    $userID = get_current_user_id();
    if (lottiefiles_is_admin_user()) {
      return 'lottie_config_admin';
    } else {
      return 'lottie_config_-' . $userID;
    }
  }

  //Check user is Admin
  function lottiefiles_is_admin_user()
  {
    return current_user_can('manage_options');
  }

  //Permission callback for GET - requires authenticated user
  function lottiefiles_settings_read_permission()
  {
    return is_user_logged_in();
  }

  //Permission callback for POST/DELETE - requires edit_posts capability
  function lottiefiles_settings_write_permission()
  {
    return current_user_can('edit_posts');
  }

  function lottiefiles_getConfig($request)
  {
    $tokenGlobal = get_option('lottie_config_admin');

    if ($tokenGlobal) {
      $responseData = json_decode($tokenGlobal);
      $responseData->is_block_logged_in = true;
      if (lottiefiles_is_admin_user()) {
        return $responseData;
      } else {
        return lottiefiles_userData();
      }
    } else {
      return lottiefiles_userData();
    }
  }

  function lottiefiles_userData()
  {
    $metaKey = lottiefiles_get_meta_key();
    $userID = get_current_user_id();
    $userMeta = get_user_meta($userID, $metaKey);
    if ($userMeta) {
      $responseData = json_decode(array_values($userMeta)[0]);
      $responseData->is_block_logged_in = true;
      $responseData->switchAccount = false;
      return $responseData;
    } else {
      $data = ['is_block_logged_in' => false];
      return $data;
    }
  }

  function lottiefiles_addOption($request)
  {
    $metaKey = lottiefiles_get_meta_key();
    if (lottiefiles_is_admin_user()) {
      $tokenGlobal = get_option($metaKey);
      if ($tokenGlobal) {
        $params = $request->get_params();
        $jsonData = wp_json_encode($params);
        update_option($metaKey, $jsonData);
        return rest_ensure_response($params, 200);
      } else {
        $params = $request->get_params();
        $params['isAdmin'] = lottiefiles_is_admin_user();
        $jsonData = wp_json_encode($params);
        add_option($metaKey, $jsonData);
        return rest_ensure_response($params, 200);
      }
    } else {
      $params = $request->get_params();
      $params['switchAccount'] = false;
      $params['isAdmin'] = lottiefiles_is_admin_user();
      $userID = get_current_user_id();
      $jsonData = wp_json_encode($params);
      add_user_meta($userID, $metaKey, $jsonData);
      return rest_ensure_response($params, 200);
    }
  }

  function lottiefiles_deleteConfig($request)
  {
    $metaKey = lottiefiles_get_meta_key();
    if (lottiefiles_is_admin_user()) {
      delete_option($metaKey);
      return json_decode(get_option($metaKey));
    } else {
      $userID = get_current_user_id();
      return delete_user_meta($userID, $metaKey);
    }
  }

  function lottiefiles_isBlockLoggedIn($request)
  {
    return json_decode(get_option('lottie_config_admin'));
  }

  //Register route
  register_rest_route('lottiefiles/v1', '/settings/', [
    //Endpoint to get settings from
    [
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'lottiefiles_getConfig',
      'permission_callback' => 'lottiefiles_settings_read_permission',
    ],
    //Endpoint to update settings at
    [
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => 'lottiefiles_addOption',
      'permission_callback' => 'lottiefiles_settings_write_permission',
    ],
    //Endpoint to delete settings at
    [
      'methods' => WP_REST_Server::DELETABLE,
      'callback' => 'lottiefiles_deleteConfig',
      'permission_callback' => 'lottiefiles_settings_write_permission',
    ]
  ]);
});
