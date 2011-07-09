<?php
# Version 1.0	  
/**
	$sql = new sql(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
	$sql->go($sql_query)	# Execute query
	$sql->fetchArray()		# Get one result back OR loop through the function using while($var = $sql->fetchArray()) to get all results
	$sql->fetchAll() 		# Get all results in an array $var[#][table_column]
	$sql->numRows() 		# Number of results from the query
	$sql->effected_rows()	# Number of effected rows from the query
	$sql->lastId() 			# last insert id
	$sql->clearResult() 	# clear result in class
	$sql->close() 			# Close db connection
**/

preg_match('/sql.php/',$_SERVER['PHP_SELF']) ? die('Unable To Access File') : false;
//References: You can save query results by giving them a 
//reference number and calling back with the reference number
class sql
{
	var $db_link;
	var $dbname;
	var $result;
	var $mysql_flag = MYSQL_BOTH; // MYSQL_BOTH or MYSQL_ASSOC or MYSQL_NUM
	var $use_log = '';
	//Sets up database link using variables from a config file
	function sql( $dbhost = '',$dbname = '',$dbuser = '',$dbpassword = '' )
	{
		$this->use_log .= 'sql:';
		sql::editLog("Connecting to: [$dbname] Host: [$dbhost]  User: [$dbuser]");
		// If no values sent use the config default connection values
		$dbhost = empty( $dbhost ) ? DB_HOST : $dbhost;
		$dbname = empty( $dbname ) ? DB_NAME : $dbname;
		$dbuser = empty( $dbuser ) ? DB_USER : $dbuser;
		$dbpassword = empty( $dbpassword ) ? DB_PASSWORD : $dbpassword;
		
		// Set the classes database name
		$this->dbname = $dbname;
		$this->db_link = @mysql_connect( $dbhost, $dbuser, $dbpassword, true ) or die( 'Error: Could Not Connect To Database'.mysql_error() );
		@mysql_select_db( $this->dbname, $this->db_link ) or die( 'Error: Could Not Select Database'.mysql_error() );

	}
	
	##-----------------------------------------------------------------------------##
	##                 				 Show Use Log			       			       ##
	##-----------------------------------------------------------------------------##
	
	function showLog()
	{
		$this->use_log .= "showLog()"."<br />\n";
		return $this->use_log;
	}
	
	##-----------------------------------------------------------------------------##
	##                 				 Add Log Entry				   			       ##
	##-----------------------------------------------------------------------------##

	function editLog( $content = NULL )
	{
		$this->use_log .= ' ' . $content . "<br />\n";
	}
	
	// Preform any sql query
	function go( $query = NULL, $ref = 0 )
	{
		$this->use_log .= 'go:';
		if( $query != NULL )
		{
			$this->result[$ref] = @mysql_query( $query, $this->db_link ) or die('Error: Database Query Error<br><br>'.mysql_error());
			sql::editLog("q: [$query] ref: [$ref]");
			return $this->result[$ref];
		} else
		{
			sql::editLog("q: [$query] ref: [$ref] -> EMPTY QUERY");
			return false;
		}
	}
        //devuelve valores en formato de objeto
        function fetchAssoc( $ref = 0 )
	{
		$this->use_log .= 'fetchAssoc:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			sql::editLog("ref: [$ref]");
			return @mysql_fetch_assoc( $this->result[$ref], $this->mysql_flag );
		}
		else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Return array with one result
	function fetchArray( $ref = 0 )
	{
		$this->use_log .= 'fetchArray:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			sql::editLog("ref: [$ref]");
			return @mysql_fetch_array( $this->result[$ref], $this->mysql_flag );
		}
		else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Return an array with all the results
	function fetchAll( $ref = 0 )
	{
		$this->use_log .= 'fetchAll:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			$x = 0;
			while( $a = @mysql_fetch_array( $this->result[$ref], $this->mysql_flag ) )
			{
				$result[$x] = $a;
				$x++;
			}
			sql::editLog("ref: [$ref]");
			return $result;
		} else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Number of rows returned from last called query
	function numRows( $ref = 0 )
	{
		$this->use_log .= 'numRows:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			sql::editLog("ref: [$ref]");
			return @mysql_num_rows( $this->result[$ref] );
		} else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Number of affectedrows returned from last called query
	function affectedRows( $ref = 0 )
	{
		$this->use_log .= 'affectedRows:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			sql::editLog("ref: [$ref]");
			return @mysql_affected_rows( $this->result[$ref] );
		} else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Return the last queries insert id
	function lastId()
	{
		return @mysql_insert_id();
	}
	
	function escape($ref)
	{
		return mysql_real_escape_string($ref);
	}
	
	// Clear a query result from the class
	function clearResult( $ref = 0 )
	{
		$this->use_log .= 'clearResult:';
		if( isset( $this->result[$ref] ) && !( empty( $this->result[$ref] ) ) )
		{
			if( @mysql_free_result( $this->result[$ref] ) ) 
				$clear = true;
			unset( $this->result[$ref] );
			if( isset( $clear ) )
			{
				sql::editLog("ref: [$ref]");
				return true;
			} else
			{
				sql::editLog("ref: [$ref] -> ERROR: Unable to free result");
				return false;
			}
		} else
		{
			sql::editLog("ref: [$ref] -> ERROR: Reference Not Found");
			return false;
		}
	}
	// Closes database connection
	function close()
	{
		$this->use_log .= 'close:';
		if( isset( $this->db_link ) && !( empty( $this->db_link ) ) )
			if( @mysql_close( $this->db_link ) )
			{
				sql::editLog("Connection closed");
				return true;
			}else
			{
				sql::editLog("ERROR: Unable to close connection");
				return false;
			}
		else
		{
			sql::editLog("ERROR: Connection not found");
			return false;
		}
	}
}


?>