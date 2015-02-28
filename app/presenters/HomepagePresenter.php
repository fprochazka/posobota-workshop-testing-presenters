<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/**
	 * @var \Nette\Database\Context
	 * @inject
	 */
	public $db;


	public function renderDefault()
	{
		$this->template->articles = $this->db->table('articles')->fetchAll();
	}

}
