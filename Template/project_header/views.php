<ul class="views">
    <li <?= $this->app->checkMenuSelection('ProjectOverviewController') ?>>
        <?= $this->url->icon('eye', '', 'ProjectOverviewController', 'show', array('project_id' => $project['id'], 'search' => $filters['search']), false, 'view-overview menu-icon', t('Keyboard shortcut: "%s"', 'v o')) ?>
    </li>
    <li <?= $this->app->checkMenuSelection('TaskListController') ?>>
        <?= $this->url->icon('list', '', 'TaskListController', 'show', array('project_id' => $project['id'], 'search' => $filters['search']), false, 'view-listing menu-icon', t('Keyboard shortcut: "%s"', 'v l')) ?>
    </li>
    <li <?= $this->app->checkMenuSelection('BoardViewController') ?>>
        <?= $this->url->icon('th', '', 'BoardViewController', 'show', array('project_id' => $project['id'], 'search' => $filters['search']), false, 'view-board menu-icon', t('Keyboard shortcut: "%s"', 'v b')) ?>
    </li>
	<li <?= $this->app->checkMenuSelection('DueDateController') ?>>
		<?= $this->url->icon('calendar-check-o', '', 'DueDateController', 'show', array('project_id' => $project['id'], 'search' => $filters['search'], 'plugin' => 'Duedate'), false, 'view-duedate menu-icon', t('Keyboard shortcut: "%s"', 'v d')) ?>
	</li>
	<?= $this->hook->render('template:project-header:view-switcher', array('project' => $project, 'filters' => $filters)) ?>
</ul>

