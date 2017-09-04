<?php

namespace Kanboard\Plugin\Duedate;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;
use Kanboard\Model\TaskModel;
use Kanboard\Plugin\Duedate\Formatter\DueDateFormatter;


class Plugin extends Base
{
    public function initialize()
    {	
		$this->projectAccessMap->add('DueDateController', '*', Role::PROJECT_MANAGER);
		$this->projectAccessMap->add('DueDateAjaxController', '*', Role::PROJECT_MANAGER);
		
		
		$this->route->addRoute('duedate/:project_id', 'DueDateController', 'show', 'plugin');
		$this->route->addRoute('duedate/:project_id/sort/:sorting', 'DueDateController', 'show', 'plugin');
		$this->route->addRoute('duedate/:project_id', 'DueDateAjaxController', 'save', 'plugin');
		$this->route->addRoute('duedate/:project_id', 'DueDateAjaxController', 'reload', 'plugin');
		$this->route->addRoute('duedate/:project_id/timestamp/:timestamp', 'DueDateAjaxController', 'check', 'plugin');
		
		$this->hook->on('template:layout:css', array('template' => 'plugins/Duedate/Assets/css/skin.css'));
		$this->hook->on('template:layout:js', array('template' => 'plugins/Duedate/Assets/js/js.cookie.js'));
		$this->hook->on('template:layout:js', array('template' => 'plugins/Duedate/Assets/js/duedate.js')); 
		
		//$this->template->hook->attach('template:project-header:view-switcher', 'Duedate:project_header/views');
		
        $this->container['dueDateFormatter'] = $this->container->factory(function ($c) {
            return new DueDateFormatter($c);
        });
		
		$this->hook->on('model:color:get-list', function (array &$colors) {
            $colors = array('grey'=>t('Grey'),'blue'=>t('Blue'),'red'=>t('Red'),'green'=>t('Green'));
        });
		
		$this->template->setTemplateOverride('header', 'Duedate:header');
		$this->template->setTemplateOverride('app/filters_helper', 'Duedate:app/filters_helper');
		$this->template->setTemplateOverride('search/activity', 'Duedate:search/activity');
		$this->template->setTemplateOverride('search/index', 'Duedate:search/index');
		$this->template->setTemplateOverride('project_header/views', 'Duedate:project_header/views');
		$this->template->setTemplateOverride('project_header/search', 'Duedate:project_header/search');
		$this->template->setTemplateOverride('task/sidebar', 'Duedate:task/sidebar');
		$this->template->setTemplateOverride('task/details', 'Duedate:task/details');
		$this->template->setTemplateOverride('task_modification/show', 'Duedate:task_modification/show');
		$this->template->setTemplateOverride('task_creation/show', 'Duedate:task_creation/show');
	}
	
	public function getPluginName()
    {
        return 'Duedate';
    }
	
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }	
}