<?php

defined('ACCESS_SYSTEM') or die;

class Route
{
	public  $post = array();
	public  $get = array();
	private $security = array();

	public function security($array, $security) 
	{
		$arrTemp = array();
		foreach ($array as $item) {
			$arrTemp[$item] = $security;
		}
		$this->security = array_merge($this->security, $arrTemp);
	}

	public function getObject($routes, $controllers, $alias) 
	{
		$arrRoute = array();
		$arrController = array();
		$request = array();

		// Route
		$arrRoute = explode('/', $routes);
		$count = count($arrRoute);

		// Controller
		$arrController = explode('@', $controllers);

		for ($i = 0; $i < $count; $i++) { 
			if ($arrRoute[$i]{0} != '{') {
				$request[] = array($arrRoute[$i], 'false');
			} else {
				$tmp = str_replace('{', '', $arrRoute[$i]);
				$tmp = str_replace('}', '', $tmp);
				$request[] = array($tmp, 'true');
			}
		}

		$controller = $arrController[0];
		$action = $arrController[1];

		return compact('request', 'controller', 'action', 'alias');
	}

	public function get($routes, $controllers, $alias = '') 
	{
		$this->get[] = $this->getObject($routes, $controllers, $alias);
	}

	public function post($routes, $controllers, $alias = '') 
	{
		$this->post[] = $this->getObject($routes, $controllers, $alias);
	}

	public function end() 
	{
		$this->getController();
	}

	public function getController() 
	{
		// Stage 1: Get route
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$object = $this->post;
		} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$object = $this->get;
		}

		// Get request
		$request = $_GET['request'];
		$arrRequest = explode('/', $request);
		$count = count($arrRequest);
		$flag = true;
		$route = array();
		$params = array();

		foreach ($object as $item) {
			$flag = true;

			if (count($item['request']) >= $count) {
				for ($i = 0; $i < $count; $i++) {
					if ($item['request'][$i][1] == 'false') {
						if ($item['request'][$i][0] != $arrRequest[$i]) {
							$flag = false;
							break;
						}
					} else {
						$params[$item['request'][$i][0]] = $arrRequest[$i];
					}
				}

				if ($flag) {
					$route = $item;
					break;
				}
			}
		}

		// Stage 2: Check route
		if (!empty($route)) {
			// Stage 3: Security
			if (array_key_exists($route['alias'], $this->security)) {
				$className = $this->security[$route['alias']];

				security($className);

				$secu = new $className();
				if ($secu->check()) {
				}
			} 

			// Stage 4: Add Controller
			controller($route['controller']);
			$con = new $route['controller']();

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$params = $_POST;
				echo $con->$route['action']($params);
			} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
				echo call_user_func_array(array($con, $route['action']), $params);
			}
		} else {
			return redirect('home');
		}
	}
}

?>