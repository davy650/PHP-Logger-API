<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  require_once(DIR.'/vendor/autoload.php');
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  use MonologLogger;
  use MonologHandlerStreamHandler;

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->title = $data->title;
  $post->body = $data->body;
  $post->author = $data->author;
  $post->category_id = $data->category_id;

  // Create post
try
{
  $posts_arr = array();
  $post_item = array(

    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id
  );
  array_push($posts_arr, $post_item);
  echo json_encode($posts_arr);
} catch (PDOException $ex)
{
    array('message' => 'No Posts Found');
}
