<?php

namespace Core;

class Form
{
    public static function input($label, $id, $value, $inputAttrs = [], $wrapperAttrs = [], $errors = [])
    {
        $wrapperString = self::processAttributes($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttributes($inputAttrs);
        $errorMessage = array_key_exists($id, $errors) ? $errors[$id] : '';
        
        $html = "<div {$wrapperString}>";
        $html .= "<label for='{$id}'>{$label}</label>";
        $html .= "<input id='{$id}' name='{$id}' value='{$value}' {$inputAttrs}>";
        $html .= "<div class='invalid-feedback'>{$errorMessage}</div>";
        $html .= "</div>";

        return $html;
    }

    public static function select($label, $id, $value, $options, $inputAttrs = [], $wrapperAttrs = [], $errors = [])
    {
        $wrapperString = self::processAttributes($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttributes($inputAttrs);
        $errorMessage = array_key_exists($id, $errors) ? $errors[$id] : '';

        $html = "<div {$wrapperString}>";
        $html .= "<label for='{$id}'>{$label}</label>";
        $html .= "<select id='{$id}' name='{$id}' {$inputAttrs}>";

        foreach($options as $optionValue => $display) {
            $selected = $optionValue == $value ? ' selected' : '';
            $html .= "<option value='{$optionValue}'{$selected}>{$display}</option>";
        }

        $html .= "</select>";
        $html .= "<div class='invalid-feedback'>{$errorMessage}</div>";
        $html .= "</div>";

        return $html;
    }

    public static function checkbox($label, $id, $checked = '', $inputAttrs = [], $wrapperAttrs = [], $errors = [])
    {
        $wrapperString = self::processAttributes($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputString = self::processAttributes($inputAttrs);
        $checkedString = $checked == 'on' ? 'checked' : '';

        $html = "<div {$wrapperString}>";
        $html .= "<input type='checkbox' id='{$id}' name='{$id}' {$inputString} {$checkedString}>";
        $html .= "<label class='form-check-label' for='{$id}'>{$label}</label>";
        $html .= "</div>";

        return $html;
    }

    public static function appendErrors($key, $inputAttrs, $errors)
    {
        if(array_key_exists($key, $errors)) {
            if(array_key_exists('class', $inputAttrs)) {
                $inputAttrs['class'] .= ' is-invalid';
            } else {
                $inputAttrs['class'] = 'is-invalid';
            }
        }

        return $inputAttrs;
    }

    public static function processAttributes($attributes)
    {
        $html = '';
        foreach($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        return $html;
    }

    public static function csrfField()
    {
        $token = Session::createCsrfToken();
        $html = "<input type='hidden' value='{$token}' name='csrf_token'>";

        return $html;
    }
}