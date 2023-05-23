<?php
#
#**********************************************************************
#  Component: database.php
#
#  Copyright (c) Cyprotex 2007

#--------------------------------------------
#  Modification History
#
# --------------------------------------------
#  Description: Various database functions sed by other Cloe Screen PHP pages
#
#
#**********************************************************************
# Edit History
#
# MDG 24-Mar-2007 CR3159 : Added maintenance box.
#                          Also added getLastDatabaseErrorMessage function
#
#**********************************************************************
# $Id: database.php,v 1.9 2007/03/26 15:31:48 mdegaris Exp $
#**********************************************************************


$dbConnected = false;



function dbConnect(&$db_credentials = null) {
	global $db_user, $db_pass, $db_instance, $dbHandle, $dbConnected;

	if ($db_credentials) {
		$db_user = $db_credentials["db_user"];
		$db_pass = $db_credentials["db_pass"];
		$db_instance = $db_credentials["db_instance"];
	}

	if (!$dbHandle = oci_connect($db_user, $db_pass, $db_instance)) {
		echo "<b style=\"color:red;\">Error: Unable to connect to database</b>";
		exit;
	}

	$dbConnected = true;
}

function &dbQuery($query, $bind_vars = null, $db_credentials = null) {
	global $dbHandle, $dbConnected;

	  // If not connected then use default connection
	  if (!$dbConnected) {
		dbConnect($db_credentials);
	  }

	$result = array();

	$statement = oci_parse($dbHandle, $query);
	if ($bind_vars != null) {
		foreach ($bind_vars as $name => $value) {
			oci_bind_by_name($statement, ":$name", $bind_vars[$name], -1);
		}
	}

	oci_execute($statement, OCI_DEFAULT); // OCI_DEFAULT stops auto commit
	$error = oci_error($statement);
	if ($error) {
		echo "<b>Error with query</b>: $query<br />";
	} else {
		oci_fetch_all($statement, $result, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
	}

	oci_free_statement($statement);
	return $result;
}



function dbUpdate($query, $bind_vars = null) {
	global $dbHandle, $dbConnected;

	// If not connected then use default connection
	if (!$dbConnected) {
	dbConnect();
	}

	$result = array();

	$statement = oci_parse($dbHandle, $query);
	if ($bind_vars != null) {
		foreach ($bind_vars as $name => $value) {
			oci_bind_by_name($statement, ":$name", $bind_vars[$name], -1);
		}
	}
	oci_execute($statement, OCI_DEFAULT); // OCI_DEFAULT stops auto commit
	$error = oci_error($statement);

	if ($error) {
		echo "<b>Error with query</b>: $query<br />";
	}

	oci_free_statement($statement);
	return $result;
}

// MDG 11-Jan-2007 : Added possible bind variables parameter
function dbExecute($query, &$bind_vars = null) {
	global $dbHandle, $dbConnected;

	if (!$dbConnected) {
		dbConnect();
	}

	$statement = oci_parse($dbHandle, $query);
	if ($bind_vars != null) {
		foreach ($bind_vars as $name => $value) {
			oci_bind_by_name($statement, ":$name", $bind_vars[$name]);
		}
	}

	oci_execute($statement, OCI_DEFAULT); // OCI_DEFAULT stops auto commit

	$error = oci_error($statement);
	oci_free_statement($statement);

	return $error;
}

// MDG 24-Mar-2007 CR3159 : New function for retrieving the error message
//                          of the last database error that occurred.
function getLastDatabaseErrorMessage()
{
  global $dbHandle, $dbConnected;

  if ($dbConnected) {
    $error = oci_error($dbHandle);
    if ($error) {
      return $error['message'];
    }
  }
}


function dbRollback() {
	global $dbHandle, $dbConnected;
	if ($dbConnected) {
		oci_rollback($dbHandle);
	}
}

function dbCommit() {
  global $dbHandle, $dbConnected;
  if ($dbConnected) {
    oci_commit($dbHandle);
  }
}

?>