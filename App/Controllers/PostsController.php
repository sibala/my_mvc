<?php

namespace App\Controllers;

use App\Models\Post;
use Core\View;
use Core\Controller;

class PostsController extends Controller
{
	/**
	 * Object of post
	 * @var object
	 */
	private $posts;


	/**
	 * Constructor retrieving route params and creating post object
	 * 
	 * @param array $route_params
	 */
	public function __construct($route_params)
	{
		parent::__construct($route_params);
		$this->posts = new Post;
	}


	/**
	 * Lists all posts
	 * 
	 * @return void
	 */
	public function index()
	{
		$posts = $this->posts->findAll();
		// dd($posts);

		View::render('posts/index.php', compact('posts'));
	}


	/**
	 * Show add new post-page
	 *
	 * @return  void
	 */
	public function addNew()
	{
		View::render('posts/add.php');
	}


	/**
	 * Show edit post-page
	 *
	 * @return  void
	 */
	public function edit()
	{
		$post = $this->posts->find($this->route_params['id']);

		View::render('posts/edit.php', compact('post'));
	}


	/**
	 * Create new post
	 * 
	 * @return void
	 */
	public function create()
	{
		$this->posts->save([
			'title' => $this->route_params['title'],
			'content' => $this->route_params['content']
		]);

		return true;
	}


	/**
	 * Update post
	 * 
	 * @return void
	 */
	public function update()
	{	
		$this->posts->save([
			'id' => $this->route_params['id'],
			'title' => $this->route_params['title'],
			'content' => $this->route_params['content']
		]);

		return true;
	}
}