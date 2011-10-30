<?php

// enkelt oppsett for database
// for Blindern Studenterhjem


if (strpos(__FILE__, ":\\") !== false || substr($_SERVER['DOCUMENT_ROOT'], 0, 8) != "/var/www") // testserver/utvikling
{
	$db_settings = array(
		"host" => "127.0.0.1",
		"user" => "blindern",
		"pass" => "dugnaden",
		"db" => "blindern"
	);
}

else
{
	require "/etc/mysqlserver.php";
	$db_settings = array(
		"host" => $mysqlserver,
		"user" => "blindern_dugnad",
		"pass" => "7YbByOAe",
		"db" => "blindern_dugnad"
	);
}

// koble til database
$db_conn = mysql_connect($db_settings['host'], $db_settings['user'], $db_settings['pass']);
if (!$db_conn) throw new SQLConnectException(mysql_error(), mysql_errno());

// velg riktig database
if (!@mysql_select_db($db_settings['db']))
{
	throw new SQLSelectDatabaseException(mysql_error(), mysql_errno());
}

mysql_set_charset("utf8", $db_conn);


// for å kjøre spørringer
function db_query($query)
{
	$result = mysql_query($query);
	
	// feilet?
	if (!$result)
	{
		$err = mysql_error();
		$errnum = mysql_errno();
		throw new SQLQueryException($err, $errnum);
	}
	
	return $result;
}

function db_quote($text, $null = true)
{
	if (empty($text) && $null) return 'NULL';
	return "'".mysql_real_escape_string($text)."'";
}



/** Exception type for database */
class SQLException extends Exception
{
	protected $sql_err;
	protected $sql_errnum;
	public function __construct($err, $errnum)
	{
		parent::__construct($err, $errnum);
		$this->sql_err = $err;
		$this->sql_errnum = $errnum;
	}
	public function getSQLError() { return $this->sql_err; }
	public function getSQLErrorNum() { return $this->sql_errnum; }
}

/** Exception: Databasetilkobling */
abstract class SQLConnectionException extends SQLException {}

/** Exception: Ingen databasetilkobling */
class SQLNoConnectionException extends SQLConnectionException {
	public function __construct()
	{
		parent::__construct("", 0);
		$this->message = "Det finnes ingen tilkobling til databasen.";
	}
}

/** Exception: Databasetilkobling: Selve tilkoblingen */
class SQLConnectException extends SQLConnectionException
{
	public function __construct($err, $errnum)
	{
		parent::__construct($err, $errnum);
		$this->message = "Kunne ikke opprette kobling med databasen: ($errnum) $err";
	}
}

/** Exception: Databasetilkobling: Velge database */
class SQLSelectDatabaseException extends SQLConnectionException
{
	public function __construct($err, $errnum)
	{
		parent::__construct($err, $errnum);
		$this->message = "Kunne ikke velge riktig database: ($errnum) $err";
	}
}

/** Exception: Databasespørring */
class SQLQueryException extends SQLException {
	public function __construct($err, $errnum)
	{
		parent::__construct($err, $errnum);
		$this->message = "Kunne ikke utføre spørring: ($errnum) $err";
	}
}
