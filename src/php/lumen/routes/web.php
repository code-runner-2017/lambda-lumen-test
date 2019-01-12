<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;


$router->get('/hello', function () use ($router) {
    return 'hello world!';
});

$router->get('/test', function (Request $request) use ($router) {
	$obj = new \stdClass();
	$obj->title = 'Blade Runner';
	$obj->director = 'Riddley Scott';
	$obj->uri = $request->path();
	$obj->name = $request->input('name');
	    
	return response()->json($obj);
});

/**
 * Example: Querying an RDS database (postgresql) using plain PDO.
 */
$router->get('/testdb', function (Request $request) use ($router) {
	$host = env('DB_HOST');
	$dbname = env('DB_DATABASE');
	$username = env('DB_USERNAME');
	$password = env('DB_PASSWORD');
	
	// change this if you want to use MySQL
	$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password";
 
	try {
		$pdo = new \PDO($dsn);
	
		$sql = "SELECT user_id, login_name, email FROM users";
		$result = $pdo->query($sql);
				
        $users = [];
		
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
		
		return response()->json($users);
	
	}catch (PDOException $e){
		// report error message
		return $e->getMessage();
	}

});
