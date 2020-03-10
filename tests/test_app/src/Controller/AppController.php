<?php

namespace App\Controller;

use Shim\Controller\Controller;

class AppController extends Controller {

	/**
	 * @var array
	 */
	public $components = ['Flash', 'RequestHandler'];

	/**
	 * @var array
	 */
	public $helpers = ['Tools.Format'];

}
