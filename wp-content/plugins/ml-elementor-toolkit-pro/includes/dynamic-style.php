<?php

namespace ML_Elementor_Toolkit;

// This code is taken from the Ele custom skin plugin.

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Dynamic_Style
{
    public function __construct()
    {
        add_action('elementor/frontend/section/before_render', [$this, 'set_dynamic_style']);
        add_action('elementor/frontend/column/before_render', [$this, 'set_dynamic_style']);
        add_action('elementor/frontend/widget/before_render', [$this, 'set_dynamic_style']);
    }

    private function clean_selector_value($values)
    {
        $interest = ["url"];
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (in_array($key, $interest)) {
                    return $value;
                }
            }
        }
        return $values;
    }

    private function parse_selector($selector, $wrapper, $value)
    {
        $clean_value = $this->clean_selector_value($value);
        $selector = str_replace("{{WRAPPER}}", $wrapper, $selector);
        $selector = str_replace(["{{VALUE}}", "{{URL}}", "{{UNIT}}"], $clean_value, $selector);
        return $selector;
    }

    private function find_url_type($values)
    {
        $interest = ["url"];
        $keys = [];
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (isset($value["type"]) && $value["type"] == "url") $keys[] =  $key;
            }
        }
        return $keys;
    }
    /* peopele keep getting errors from url types */
    private function remove_url_type(&$array)
    {
        $keys = $this->find_url_type($array);
        foreach ($keys as $key) {
            $this->recursive_unset($array, $key);
        }
    }

    private function recursive_unset(&$array, $unwanted_key)
    {
        unset($array[$unwanted_key]);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursive_unset($value, $unwanted_key);
            }
        }
    }


    // dynamic style for elements
    public function set_dynamic_style(\Elementor\Element_Base $element)
    {

        global $yw_render_preview_cards;
        if (!$yw_render_preview_cards && $yw_render_preview_cards > 0) {
            return;
        } // only act inside loop

        $PostID = get_the_ID();
        $LoopID = $yw_render_preview_cards;

        $ElementID = $element->get_ID();
        $dynamic_settings = $element->get_settings('__dynamic__');
        $all_controls = $element->get_controls();

        $all_controls = isset($all_controls) ? $all_controls : [];
        $dynamic_settings = isset($dynamic_settings) ? $dynamic_settings : [];
        $controls = array_intersect_key($all_controls, $dynamic_settings);
        $this->remove_url_type($controls); //we don't need the link options
        $settings = $element->parse_dynamic_settings($dynamic_settings, $controls); // @ <- dirty fix for that fugly controls-stack.php  Illegal string offset 'url' error

        $ECS_css = "";
        $element_wrapper = ".yw-post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}";

        foreach ($controls as $key => $control) {
            if (isset($control["selectors"])) {
                foreach ($control["selectors"] as $selector => $rules) {
                    if (isset($settings[$key])) {
                        $ECS_css .= $this->parse_selector($selector . "{" . $rules . "}", $element_wrapper, $settings[$key]);
                    }
                }
            }
        }


        echo $ECS_css ? "<style>" . $ECS_css . "</style>" : "";
        /* end custom css*/
    }
}

$yw_dynamic_style = new Dynamic_Style();
