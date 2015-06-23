<?php 

// This file contains the database access information. 
// This file also establishes a connection to, and selects, the database.

DEFINE ('DB_TYPE', 'postgres');
DEFINE ('DB_USER', 'trillium_gtfs_web_read');
DEFINE ('DB_PASSWORD', 'g2y-PYu-EoT-hQK');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'trillium_gtfs');

if (DB_TYPE == 'mysql') {
	if ($dbc = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD)) { // Make the connnection.
		if (!mysql_select_db (DB_NAME)) { // If it can't select the database.
			// Handle the error.
			trigger_error("Could not select the database!\n<br />MySQL Error: " . mysql_error());
			echo "Could not select the database!\n<br />MySQL Error: " . mysql_error();
			
			// Print a message to the user, include the footer, and kill the script.
			exit();
			
		} // End of mysql_select_db IF.
	} else { // If it couldn't connect to MySQL.
		// Print a message to the user, include the footer, and kill the script.
		trigger_error("Could not connect to MySQL!\n<br />MySQL Error: " . mysql_error());
		exit();
	} // End of $dbc IF.
} elseif (DB_TYPE == 'postgres') {
	if ($dbc = pg_connect ("host=" . DB_HOST . " user=" . DB_USER . " password=" . DB_PASSWORD . " dbname=" . DB_NAME)) { // Make the connnection.
		//echo "<p>dbc: $dbc";
		//echo "<p> 1+1: " . pg_fetch_result(pg_query("select 1+1;"), 0,0);
	} else { // If it couldn't connect to PostgreSQL.

		// Print a message to the user, include the footer, and kill the script.
		trigger_error("Could not connect to PostgreSQL!\n<br />PostgreSQL Error: " . mysql_error());
		exit();
	}
} else {
	trigger_error("Don't know which database to connect to, since DB_TYPE was not either mysql or postgres!\n");
	exit();
}


function db_query($query) {
  if (DB_TYPE == 'mysql') {
    return mysql_query($query);
  } elseif (DB_TYPE == 'postgres') {
    return pg_query($query);
  }
}

function db_error() {
  if (DB_TYPE == 'mysql') {
    return mysql_error();
  } elseif (DB_TYPE == 'postgres') {
    return pg_last_error();
  }
}

function db_num_rows($result) {
  if (DB_TYPE == 'mysql') {
    return mysql_num_rows($result);
  } elseif (DB_TYPE == 'postgres') {
    return pg_num_rows($result);
  }
}


## this function ALWAYS acts like you've used PG_BOTH or MYSQL_BOTH.
function db_fetch_array() {
  if (DB_TYPE == 'mysql') {
    $fn = 'mysql_fetch_array';
  } elseif (DB_TYPE == 'postgres') {
    $fn = 'pg_fetch_array';
  }
  // ignore the second argument.
  return call_user_func_array ($fn, array( func_get_arg(0) ));
}

// HACK HACK. We return results indexed by both integer and symbolic keys.
function db_fetch_assoc() {
  if (DB_TYPE == 'mysql') {
    $fn = 'mysql_fetch_array';
  } elseif (DB_TYPE == 'postgres') {
    $fn = 'pg_fetch_array';
  }
  // ignore the second argument.
  return call_user_func_array ($fn, array( func_get_arg(0) ));
}


# function db_fetch_array($result, $type) {
#   if (DB_TYPE == 'mysql') {
#     return mysql_fetch_array($result, $type);
#   } elseif (DB_TYPE == 'postgres') {
#     //$pg_type_map = array(MYSQL_NUM => PG_NUM, MYSQL_ASSOC => PG_ASSOC, MYSQL_BOTH => PG_BOTH);
#     //echo "pg_type_map: $pg_type_map <br>";
#     // return pg_fetch_array($result, $pg_type_map[$type]);
#     return pg_fetch_array($result);
#   }
# }

#function db_fetch_assoc() {
#  if (DB_TYPE == 'mysql') {
#    $fn = mysql_fetch_assoc;
#  } elseif (DB_TYPE == 'postgres') {
#    $fn = pg_fetch_assoc;
#  }
#  return call_user_func_array ($fn, func_get_args());
#}

// insert into a table with an auto_increment (or SERIAL) id column, and return
// the id of the inserted row.
function db_insert_returning_id($insert_query, $id_column_name) {
  if (DB_TYPE == 'postgres' ) {
     $insert_query .= " returning " . "$id_column_name";
  }
  echo "<p>insert_query: ".$insert_query."<p>";

  $insert_result = db_query($insert_query);

  if (DB_TYPE == 'mysql') {
    $insert_id = mysql_insert_id();
  } else {
    $insert_id = db_result($insert_result, 0, $id_column_name);
  }
  echo "<p>insert_id: ".$insert_id."<p>";
  return $insert_id;
}

function db_set_application_name($name) {
  if (DB_TYPE == 'mysql') {
    # not implemented
    return 0;
  } elseif (DB_TYPE == 'postgres') {
    # pg_query_params doesn't work with SET it appears.
    return pg_query ("SET application_name = " .  pg_escape_literal($name));
  }
}



function db_affected_rows() {
  if (DB_TYPE == 'mysql') {
    $fn = mysql_affected_rows;
  } elseif (DB_TYPE == 'postgres') {
    $fn = pg_affected_rows;
  }
  return call_user_func_array ($fn, func_get_args());
}

function db_select_db() {
  if (DB_TYPE == 'mysql') {
    $fn = mysql_select_db;
  } elseif (DB_TYPE == 'postgres') {
    echo '<br>ERROR: db_select_db() not supported for postgres!!!';
    //$fn = pg_select_db;
  }
  return call_user_func_array ($fn, func_get_args());
}


function db_result($result, $row, $field) {
  if (DB_TYPE == 'mysql') {
    return mysql_result($result, $row, $field);
  } elseif (DB_TYPE == 'postgres') {
    return pg_fetch_result($result, $row, $field);
  }
}

function db_fetch_result($result) {
  if (DB_TYPE == 'mysql') {
    return mysql_fetch_result($result);
  } elseif (DB_TYPE == 'postgres') {
    return pg_fetch_result($result);
  }
}


function db_free_result($result) {
  if (DB_TYPE == 'mysql') {
    return mysql_free_result($result);
  } elseif (DB_TYPE == 'postgres') {
    return pg_free_result($result);
  }
}

function db_close() {
  if (DB_TYPE == 'mysql') {
    return mysql_close();
  } elseif (DB_TYPE == 'postgres') {
    return pg_close();
  }
}

function db_real_escape_string($string) {
  if (DB_TYPE == 'mysql') {
    return mysql_real_escape_string($string);
  } elseif (DB_TYPE == 'postgres') {
    return pg_escape_string($string);
  }
}

function db_data_seek($result, $offset) {
  if (DB_TYPE == 'mysql') {
    return mysql_data_seek($result, $offset);
  } elseif (DB_TYPE == 'postgres') {
    return pg_result_seek($result, $offset);
  }
}

// Create a function for escaping the data.
function escape_data ($data) {

  // Address Magic Quotes.
  if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
  }
	

  if (DB_TYPE == 'mysql') {

	// Check for mysql_real_escape_string() support.
	if (function_exists('mysql_real_escape_string')) {
		global $dbc; // Need the connection.
		$data = mysql_real_escape_string (trim($data), $dbc);
	} else {
		$data = mysql_escape_string (trim($data));
	}
  } elseif (DB_TYPE == 'postgres') {
     $data = pg_escape_string(trim($data));
  }

  // Return the escaped value.	
  return $data;
} 


?>


