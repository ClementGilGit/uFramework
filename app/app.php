<?php

require __DIR__ . '/../vendor/autoload.php';

use Exception\HttpException;
use Http\Request;

// Config
$debug = true;
$database = "uframework";
$login = "uframework";
$password = "p4ssword";
$host = "127.0.0.1";
$port= "32768";// A changer en fonction du port indiqué avec la commande docker ps
$dsn = "mysql:host=".$host.";port=".$port.";dbname=".$database."";
$connection = null;

try {
    $connection = new \Persistance\Connection($dsn, $login, $password);
} catch (PDOException $e) {
    echo "Connection Failed";
}


$statusFinder = new \Persistance\StatusesFinder($connection);
$statusMapper = new \Persistance\StatusesMapper($connection);
$userFinder = new \Persistance\UserFinder($connection);
$userMapper = new \Persistance\UserMapper($connection);

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 */
$app->get('/', function (Http\Request $request) use ($app) {

    if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] != false) {
        return $app->redirect('/statuses ');
    } else {
        return $app->redirect('/login');
    }
});

$app->get('/statuses/(\d+)', function (Http\Request $request, $tweetId) use ($app, $statusFinder) {
    if (!is_int($tweetId)) {
        //$statusesFinder = new Model\JsonFinder();
        //$status = $statusesFinder->findOneById($tweetId);
        $status = $statusFinder->findOneById($tweetId);
        if ($status == null) {
            throw new HttpException(404, 'StatusDB not found');
        } else {
            $data['status'] = $status;
            if ($request->guessBestFormat() === 'application/json') {
                $encode = $status->jsonSerialize();
                return new \Http\SerializedJsonResponse($encode, 200);
            }
        }
    }
    if (isset($_SESSION['user'])) {
        $data['user'] = $_SESSION['user'];
    } else {
        $data['user'] = 'Unknown user';
    }
    return $app->render('status.php', $data);
});

$app->get('/statusesOld', function () use ($app) {
    $statusesFinder = new Model\InMemoryFinder();
    $status = $statusesFinder->findAll();
    $data['status'] = $status;
    return $app->render('statuses.php', $data);
});

$app->post('/statuses', function (Http\Request $request) use ($app, $statusFinder, $statusMapper, $userFinder) {
    //$jsonFinder = new Model\JsonFinder();
    //$jsonFinder->add($request->getParameter("username"),$request->getParameter("message"));

    if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] != false) {
        $status = new \Model\Business\Status(
            0,
            $_SESSION['user'],
            $request->getParameter("content"),
            date("Y/m/d H:i:s")
        );
    } elseif (!empty($userFinder->findOneByLogin($request->getParameter("username")))) {
        $data['error'] = "This username cannot be used";
        $criterion = array();
        $data['status'] = $statusFinder->findAll($criterion);
        return $app->render('statuses.php',$data);
    } else {
        $status = new \Model\Business\Status(
            0,
            $request->getParameter("username"),
            $request->getParameter("content"),
            date("Y/m/d H:i:s")
        );
    }
    $criterion['orderBy'] = "";
    $criterion['limit'] = "";
    $statusMapper->persist($status);

    if ($request->guessBestFormat() === 'application/json') {
        $encode = $status->jsonSerialize();
        return new \Http\SerializedJsonResponse($encode, 201);
    }
    $app->redirect('/statuses');
});

$app->get('/statuses', function (Http\Request $request) use ($app, $statusFinder) {
    //$jsonFinder = new Model\JsonFinder();
    //$statusesJson = $jsonFinder->findAll();
    $criterion['orderBy'] = $request->getParameter("orderBy") ? htmlspecialchars($request->getParameter("orderBy")) : "";
    $criterion['limit'] = $request->getParameter("limit") ? htmlspecialchars($request->getParameter("limit")) : "";
    $statuses = $statusFinder->findAll($criterion);
    if ($statuses === null) {
        $data['status'] = "";
    } else {
        $data['status'] = $statuses;
    }

    if ($request->guessBestFormat() === 'application/json') {
        $encode = array();
        foreach ($statuses as $status) {
               array_push($encode, $status->jsonSerialize());
        }
        return new \Http\SerializedJsonResponse($encode, 200);
    }
    if (isset($_SESSION['user'])) {
        $data['user'] = $_SESSION['user'];
    } else {
        $data['user'] = 'Unknown user';
    }
    return $app->render('statuses.php', $data);
});

$app->delete('/statuses/(\d+)', function (Http\Request $request, $tweetId) use ($app, $statusFinder, $statusMapper) {

    if (!is_int($tweetId)) {
        //$statusesFinder = new Model\JsonFinder();
        //$status = $statusesFinder->findOneById($tweetId);
        $status = $statusFinder->findOneById($tweetId);
        if ($status == null) {
            throw new HttpException(404, 'StatusDB not found');
        } else {
            //$statusesFinder->delete($tweetId);
            $statusMapper->remove($status);
            $statuses = $statusFinder->findAll();
            $data['status'] = $statuses;
            $app->redirect('/statuses');
        }
    }
});

$app->get('/login', function() use ($app) {
    return $app->render('login.php');
});

$app->post('/login', function (Request $request) use ($app, $userFinder) {

    $data['login'] = $request->getParameter('login');
    $data['password'] = $request->getParameter('password');
    if (empty($data['login']) || empty($data['password'])) {
        $data['error'] = "Empty field";
        return $app->render('login.php', $data);
    }

    $user = $userFinder->findOneByLogin($data['login']);

    if (($user === null) || !password_verify($data['password'], $user->getPassword())) {
        $data['error'] = "Unknown user or wrong password";
        return $app->render('login.php', $data);
    }

    $_SESSION['is_authenticated'] = true;
    $_SESSION['user'] = $data['login'];
    $app->redirect('/statuses', $data);

});

$app->get('/logout', function() use ($app) {
    session_destroy();
    $app->redirect('/login');
});

$app->get('/register', function() use ($app) {
    return $app->render('register.php');
});

$app->post('/register', function (Request $request) use ($app, $userMapper) {
    $data['login'] = $request->getParameter('login');
    $data['password'] = $request->getParameter('password');
    $data['passwordCheck'] = $request->getParameter('passwordCheck');

    $dataError = \Validation\FormValidation::validationForm($data['login'], $data['password'], $data['passwordCheck']);

    if(!empty($dataError)){
        return $app->render('register.php',$dataError);
    }

    if ($data['password'] === $data['passwordCheck']) {
        $_SESSION['is_authenticated'] = true;
        $user = new \Model\Business\User(0, $data['login'], password_hash($data['password'], PASSWORD_DEFAULT));
        $userMapper->persist($user);
    }

    return $app->render('login.php');
});


$app->addListener('process.before', function (Request $req) use ($app) {

    if ($req->guessBestFormat() === 'application/json') {
        return;
    }
    session_start();
    $allowed = [
        '/login' => [Request::GET, Request::POST],
        '/statuses' => [Request::GET, Request::POST],
        '/statuses/(\d+)' => [Request::GET, Request::POST],
        '/register' => [Request::GET, Request::POST],
        '/' => [Request::GET],
    ];
    if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true) {
        return;
    }
    foreach ($allowed as $pattern => $methods) {
        if (preg_match(sprintf('#^%s$#', $pattern), $req->getUri()) && in_array($req->getMethod(), $methods)) {
            return;
        }
    }
    $app->redirect('/login');
});


return $app;
