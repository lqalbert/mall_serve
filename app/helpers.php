<?php


if (!function_exists('user_str_getcsv')) {
    function user_str_getcsv($str, $delimiter=',', $enclosure='"', $escape='\\') {
        $return = [];
        $fields = 0;
        $inside = false;
        $quoted = false;
        $char = '';
        
        //Let's go through the string
        for ($i=0; $i<mb_strlen($str); $i++) {
            $char = mb_substr($str, $i, 1, 'UTF-8');
            
            if (!$inside) { //Check if we are not inside a field
                if ($char == $delimiter) { //Check if the current char is the delimiter
                    //Tells the function that we are not inside a field anymore
                    $inside = false;
                    $quoted = false;
                    
                    //Jumps to the next field
                    $fields++;
                    
                } elseif($char == $escape) { //Check if the current char is the escape
                    //Error, because it isn't inside a field and there is a escape here
                    return false;
                    
                } elseif($char != ' ') { //Check if the current char isn't a blank space
                    //Tells the function that a field starts
                    $inside = true;
                    
                    //Check if the current char is the enclosure, indicating that this field is quoted
                    if ($char == $enclosure) {
                        $quoted= true;
                    } else {
//                         $return[$fields] = $return[$fields] . $char;
                        setreturn($return, $fields, $char);
                    }
                }
            } else { //Here we are inside a field
                //Check if the current char is the escape
                if ($char == $escape) {
                    //Check if the string has one more char beyond the current one
                    if (mb_strlen($str)>$i+1) {
                        //Tells the function we will treat the next char
                        $i++;
                        $char = mb_substr($str, $i, 1, 'UTF-8');
                        
                        //Check if our new char is the enclosure
                        if ($char == $enclosure) {
                            //Check if the field is a quoted one
                            if ($quoted) {
                                $return[$fields] .= $enclosure;
                            } else {
                                //Error, because we have an escape and then we have an enclosure and we are not inside a quoted field
                                return false;
                            }
                        } elseif ($char == $escape) {
                            $return[$fields] = $return[$fields]. $char;
                        } else {
                            eval("\$return[\$fields] .= \"\\".$char."\";");
                        }
                        
                    } else {
                        //Error, because there is an escape and nothing more then
                        return false;
                    }
                } elseif ($char == $enclosure) { //Check if the current char is the enclosure
                    //Check if we are in a quoted field
                    if ($quoted) {
                        //Tells the function that we are not inside a field anymore
                        $inside = false;
                        $quoted = false;
                    } else {
                        //Error, because there is an enclosure inside a non quoted field
                        return false;
                    }
                } elseif ($char == $delimiter) { //Check if it is the delimiter
                    //Check if we are inside a quoted field
                    if ($quoted) {
                        $return[$fields] = $return[$fields] . $char;
                    } else {
                        //Tells the function that we are not inside a field anymore
                        $inside = false;
                        $quoted = false;
                        
                        //Jumps to the next field
                        $fields++;
                    }
                } else {
//                     $return[$fields] = $return[$fields] . $char;
                    setreturn($return, $fields, $char);
                }
            }
        }
        return $return;
    }
}

if (!function_exists('setreturn')) {
    function setreturn(&$return, $field, $value) {
        if (isset($return[$field])) {
            $return[$field] .= $value;
        } else {
            $return[$field] = "";
            $return[$field] .= $value;
        }
    }
}

