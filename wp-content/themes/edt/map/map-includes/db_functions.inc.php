<?

function query($query) {
    if(!$query) return "";

    $result = mysql_query($query) or die("MySQL Error : " . mysql_error() . "\n&lt;br />In Query &lt;code>$query&lt;/code>");

    if(mysql_num_rows($result) == 1) { //If there is just one result, return it.
        $arr = mysql_fetch_assoc($result);
        if(count($arr) == 1) { //If there is just one result...
            $item = array_values($arr);
            return stripslashes($item[0]); // Creates the effect of 'getOne()'
        } else {
            foreach($arr as $key => $value) $arr[$key] = stripslashes($value);
            return $arr; // Makes the 'query()' effect
        }
        
    } else {
        $arr = array();
        $primary_key = false;

        while ($all = mysql_fetch_row($result)) {
            if(count($all) == 1) array_push($arr,$all[0]);
            elseif(count($all) == 2) {
                if(!$primary_key) { //Happens only one time
                    $meta = mysql_fetch_field($result,0); //If the first element is a primary key, make
                    $primary_key = $meta->primary_key;        // the result an associative array.
                }
                //Make it an Associative Array if there is a primary_key in the given data.
                if($primary_key) $arr[$all[0]] = $all[1];
                else break;
            }
            else break;
        }
        if($arr) {
            //Do a stripslashes() on each element
            foreach($arr as $key => $value) $arr[$key] = stripslashes($value);
            return $arr; // For 'getAll()'

        } else { //If nothing matches...
            mysql_data_seek($result,0); //Reset the Query.
            return $result; // This results in 'getSqlHandle()' effect
        }
    }
} 



   function constructInsert ($table, $fields, $values){

        if(!is_array($fields) || !is_array($values))
            return 'Error - Fields and values must be sent as an array';

        $field_ct  = count($fields);
        $value_ct = count($values);

        if($field_ct != $value_ct)
            return 'Error - Field count and value count do not match.';

        $query = "INSERT INTO `$table` (`";
        $query .= implode('`, `', $fields) . "`) VALUES ('";
        $query .= implode("', '", $values) . "');";

        $query = str_replace("'NOW()'", "NOW()", $query);
        $query = str_replace("'NULL'", "NULL", $query);

        return $query;
    }

?>
