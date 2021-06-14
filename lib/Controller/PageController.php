<?php
namespace OCA\Workspace\Controller;

use OCA\Workspace\AppInfo\Application;
use OCA\Workspace\Constants;
use OCA\Workspace\Service\UserService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IUserManager;
use OCP\Util;

class PageController extends Controller {
	/** @var string */
	private $userId;

	/** @var IUserManager */
	private $usersManager;

	/** @var UserService */
	private $userService;

	public function __construct(
		IUserManager $usersManager,
		UserService $userService) {

		$this->userManager = $usersManager;
		$this->userService = $userService;
	}

	/**
	 * Application's main page
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		Util::addScript(Application::APP_ID, 'workspace-main');		// js/workspace-main.js
		Util::addStyle(Application::APP_ID, 'workspace-style');		// css/workspace-style.css
	
		return new TemplateResponse('workspace', 'index', ['isUserGeneralAdmin' => $this->userService->isUserGeneralAdmin()]); 	// templates/index.php
	}

	/**
	 * Returns a list of users whose name matches $term
	 *
	 * @NoAdminRequired
	 *
	 * @param string $term
	 * @param string $spaceId
	 *
	 * @return JSONResponse
	 */
	public function autoComplete(string $term, string $spaceId) {
		// lookup users
		$users = $this->userManager->searchDisplayName($term);

		// transform in a format suitable for the app
		$data = [];
		foreach($users as $user) {
			$data[] = $this->userService->formatUser($user, $spaceId, 'user');
		}

		// return info
		return new JSONResponse($data);
	}

}
