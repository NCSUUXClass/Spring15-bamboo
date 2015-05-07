<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(array('debug'=>true));
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/raw_event/:id', function ($uuid) use ($app) {
  //Show raw event identified by $uuid
  require_once("db_connect.php");
  $stmt = $db->prepare("(select device,project,time,code from events_raw where uuid=?) ".
      "union (select device,project,time,code from archived_events where uuid=?)")
      or die($db->error);

  $stmt->bind_param("ss", $uuid, $uuid) or die($stmt->error);
  $stmt->execute() or die($stmt->error);
  $res = $stmt->get_result() or die("Unable to read from db");
  $row = $res->fetch_assoc() or die("No events with that id");

  $app->response->write(json_encode(array(
      'uuid' => $uuid,
      'device' => $row['device'],
      'project' => $row['project'],
      'time' => $row['time'],
      'code' => $row['code']
  )));
});

$app->post('/raw_event/:id', function($id) use ($app) {
  file_put_contents("test.log", "message received=", FILE_APPEND);
  $message = print_r( $app->request()->params(), TRUE);
  file_put_contents("test.log", $message, FILE_APPEND);

  // Insert or update an event with $id
  $device = $app->request->put('device');
  $project = $app->request->put('project');
  $time = $app->request->put('time');
  $code = $app->request->put('code');
  $uuid = $id;

  require_once("db_connect.php");
  $stmt = $db->prepare("replace into events_raw (device,project,time,code,uuid) value ".
      "(?,?,?,?,?)") or die(__LINE__.": ".$db->error);

  $stmt->bind_param("sssss", $device, $project, $time, $code, $uuid)
      or die(__LINE__.": ".$stmt->error);

  $stmt->execute() or die(__LINE__.": ".$stmt->error);

  $app->response->write(json_encode(array(
      'uuid' => $uuid
  )));
});

$app->error(function($ex) use ($app) {
  die("Exception ".$ex->getLine().": ".$ex->getMessage());
});

$app->run();
