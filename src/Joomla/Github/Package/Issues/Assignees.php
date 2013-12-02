<?php
/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Issues;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Assignees class for the Joomla Platform.
 *
 * @documentation http://developer.github.com/v3/issues/assignees/
 *
 * @since  1.0
 */
class Assignees extends AbstractPackage
{
	/**
	 * List assignees.
	 *
	 * This call lists all the available assignees (owner + collaborators) to which issues may be assigned.
	 *
	 * @param   string  $owner  The name of the owner of the GitHub repository.
	 * @param   string  $repo   The name of the GitHub repository.
	 *
	 * @return object
	 */
	public function getList($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/assignees';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Check assignee.
	 *
	 * You may check to see if a particular user is an assignee for a repository.
	 * If the given assignee login belongs to an assignee for the repository, a 204 header
	 * with no content is returned.
	 * Otherwise a 404 status code is returned.
	 *
	 * @param   string  $owner     The name of the owner of the GitHub repository.
	 * @param   string  $repo      The name of the GitHub repository.
	 * @param   string  $assignee  The assignees login name.
	 *
	 * @throws \DomainException|\Exception
	 * @return boolean
	 */
	public function check($owner, $repo, $assignee)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/assignees/' . $assignee;

		try
		{
			$response = $this->client->get($this->fetchUrl($path));

			if (204 == $response->code)
			{
				return true;
			}

			throw new \DomainException('Invalid response: ' . $response->code);
		}
		catch (\DomainException $e)
		{
			if (isset($response->code) && 404 == $response->code)
			{
				return false;
			}

			throw $e;
		}
	}
}
