<?php

namespace Core;

class Form
{
    public static function inputBlock($label, $id, $value, $inputAttrs = [], $wrapperAttrs = [], $errors = [])
    {
        $wrapperString = self::processAttributes($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttributes($inputAttrs);
        $errorMessage = array_key_exists($id, $errors) ? $errors[$id] : '';
        
        $html = "<div {$wrapperString}>";
        $html .= "<label for='{$id}'>{$label}</label>";
        $html .= "<input id='{$id}' name='{$id}' value='$value' {$inputAttrs}>";
        $html .= "<div class='invalid-feedback'>{$errorMessage}</div>";
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
}