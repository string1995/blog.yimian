<?php

/**
 * Html Helper
 *
 * @author Charles <charlestang@foxmail.com>
 */
class WHtml {

    public static $charset = 'UTF-8';

    /**
     * Encodes special characters into HTML entities.
     * @param string $str
     * @return string 
     */
    public static function encode($str) {
        return htmlspecialchars($str, ENT_QUOTES, self::$charset);
    }

    /**
     * Decodes special HTML entities back to the corresponding characters.
     * @param string $str
     * @return string 
     */
    public static function decode($str) {
        return htmlspecialchars_decode($str, ENT_QUOTES);
    }

    /**
     * Generates an HTML element.
     * @param string $tag the tag name
     * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
     * Since version 1.0.5, if an 'encode' attribute is given and its value is false,
     * the rest of the attribute values will NOT be HTML-encoded.
     * Since version 1.1.5, attributes whose value is null will not be rendered.
     * @param mixed $content the content to be enclosed between open and close element tags. It will not be HTML-encoded.
     * If false, it means there is no body content.
     * @param boolean $closeTag whether to generate the close tag.
     * @return string the generated HTML element tag
     */
    public static function tag($tag, $htmlOptions=array(), $content=false, $closeTag=true) {
        $html = '<' . $tag . self::renderAttributes($htmlOptions);
        if ($content === false) {
            return $closeTag ? $html . ' />' : $html . '>';
        } else {
            return $closeTag ? $html . '>' . $content . '</' . $tag . '>' : $html . '>' . $content;
        }
    }

    /**
     * Renders the HTML tag attributes.
     * Since version 1.1.5, attributes whose value is null will not be rendered.
     * Special attributes, such as 'checked', 'disabled', 'readonly', will be rendered
     * properly based on their corresponding boolean value.
     * @param array $htmlOptions attributes to be rendered
     * @return string the rendering result
     */
    public static function renderAttributes($htmlOptions) {
        $specialAttributes = array(
            'checked' => 1,
            'declare' => 1,
            'defer' => 1,
            'disabled' => 1,
            'ismap' => 1,
            'multiple' => 1,
            'nohref' => 1,
            'noresize' => 1,
            'readonly' => 1,
            'selected' => 1,
        );

        if ($htmlOptions === array()) {
            return '';
        }

        $html = '';
        if (isset($htmlOptions['encode'])) {
            $raw = !$htmlOptions['encode'];
            unset($htmlOptions['encode']);
        } else {
            $raw = false;
        }

        if ($raw) {
            foreach ($htmlOptions as $name => $value) {
                if (isset($specialAttributes[$name])) {
                    if ($value) {
                        $html .= ' ' . $name . '="' . $name . '"';
                    }
                } else if ($value !== null) {
                    $html .= ' ' . $name . '="' . $value . '"';
                }
            }
        } else {
            foreach ($htmlOptions as $name => $value) {
                if (isset($specialAttributes[$name])) {
                    if ($value) {
                        $html .= ' ' . $name . '="' . $name . '"';
                    }
                } else if ($value !== null) {
                    $html .= ' ' . $name . '="' . self::encode($value) . '"';
                }
            }
        }
        return $html;
    }

    /**
     * Generates an input HTML tag.
     * This method generates an input HTML tag based on the given input name and value.
     * @param string $type the input type (e.g. 'text', 'radio')
     * @param string $name the input name
     * @param string $value the input value
     * @param array $htmlOptions additional HTML attributes for the HTML tag (see {@link tag}).
     * @return string the generated input tag
     */
    protected static function inputField($type, $name, $value, $htmlOptions) {
        $htmlOptions['type'] = $type;
        $htmlOptions['value'] = $value;
        $htmlOptions['name'] = $name;
        if (!isset($htmlOptions['id']))
            $htmlOptions['id'] = self::getIdByName($name);
        else if ($htmlOptions['id'] === false)
            unset($htmlOptions['id']);
        return self::tag('input', $htmlOptions);
    }

    /**
     * Generates a valid HTML ID based on name.
     * @param string $name name from which to generate HTML ID
     * @return string the ID generated based on name.
     */
    public static function getIdByName($name) {
        return str_replace(array('[]', '][', '[', ']'), array('', '_', '_', ''), $name);
    }

    protected static function widgetInputField($widget, $type, $name, $value, $htmlOptions) {
        if (!isset($htmlOptions['id'])) {
            $htmlOptions['id'] = $widget->get_field_id($name);
        }
        return self::inputField($type, $widget->get_field_name($name), $value, $htmlOptions);
    }

    public static function widgetTextField($widget, $attribute, $options, $htmlOptions=array(), $label=false) {
        if (isset($htmlOptions['class'])) {
            $htmlOptions .= ' widefat';
        } else {
            $htmlOptions['class'] = 'widefat';
        }
        $html = '';
        
        if (false !== $label) {
            $html .= self::tag('label', array('for' => $widget->get_field_id($attribute)), $label);
        }
        return $html . self::widgetInputField($widget, 'text', $attribute, $options[$attribute], $htmlOptions);
    }

    public static function widgetCheckBox($widget, $attribute, $options, $htmlOptions=array(), $label=false) {
        if (true == $options[$attribute] || 1 == $options[$attribute]) {
            $htmlOptions['checked'] = 1;
        } else {
            $htmlOptions['checked'] = 0;
        }

        $html = '';
        if (false !== $label) {
            $html .= self::tag('label', array('for' => $widget->get_field_id($attribute)), $label);
        }
        return self::widgetInputField($widget, 'checkbox', $attribute, $options[$attribute], $htmlOptions) . $html;
    }
    
    public static function widgetTextArea($widget, $attribute, $options, $htmlOptions=array(), $label=false) {
        $htmlOptions['name'] = $widget->get_field_name($attribute);
        $htmlOptions['id'] = $widget->get_field_id($attribute);
        if (isset($htmlOptions['class'])) {
            $htmlOptions .= ' widefat';
        } else {
            $htmlOptions['class'] = 'widefat';
        }
        
        $html = '';
        if (false !== $label) {
            $html .= self::tag('label', array('for' => $widget->get_field_id($attribute)), $label);
        }
        return $html . self::tag('textarea', $htmlOptions, self::encode($options[$attribute]));
    }

}
