<?php if (! empty($task['tags'])): ?>
    <div class="task-tags">
        <ul>
        <?php foreach ($task['tags'] as $tag): ?>
            <li><?= $this->text->e($tag['name']) ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="task-board-icons">
    <div class="task-board-date">
        <?php if (! empty($task['date_due'])): ?>
            <span class="task-date
                <?php if (date('Y-m-d') == date('Y-m-d', $task['date_due'])): ?>
                     task-date-today
                <?php elseif (time() > $task['date_due']): ?>
                     task-date-overdue
                <?php endif ?>
                ">
                <i class="fa fa-calendar"></i>
                <?= $this->dt->date($task['date_due']) ?>
            </span>
        <?php endif ?>
    </div>
    <div class="task-board-icons-row">
        <?php if (! empty($task['nb_links'])): ?>
            <span title="<?= t('Links') ?>" class="tooltip" data-href="<?= $this->url->href('BoardTooltipController', 'tasklinks', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>"><i class="fa fa-code-fork fa-fw"></i><?= $task['nb_links'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['nb_external_links'])): ?>
            <span title="<?= t('External links') ?>" class="tooltip" data-href="<?= $this->url->href('BoardTooltipController', 'externallinks', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>"><i class="fa fa-external-link fa-fw"></i><?= $task['nb_external_links'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['nb_subtasks'])): ?>
            <span title="<?= t('Sub-Tasks') ?>" class="tooltip" data-href="<?= $this->url->href('BoardTooltipController', 'subtasks', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>"><i class="fa fa-bars"></i>&nbsp;<?= round($task['nb_completed_subtasks']/$task['nb_subtasks']*100, 0).'%' ?></span>
        <?php endif ?>

        <?php if (! empty($task['nb_files'])): ?>
            <span title="<?= t('Attachments') ?>" class="tooltip" data-href="<?= $this->url->href('BoardTooltipController', 'attachments', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>"><i class="fa fa-paperclip"></i></span>
        <?php endif ?>

        <?php if (! empty($task['description'])): ?>
            <span title="<?= t('Description') ?>" class="tooltip" data-href="<?= $this->url->href('BoardTooltipController', 'description', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>">
                <i class="fa fa-file-text-o"></i>
            </span>
        <?php endif ?>
        <?php if ($task['nb_comments'] > 0): ?>
            <?php if ($not_editable): ?>
                <span title="<?= $task['nb_comments'] == 1 ? t('%d comment', $task['nb_comments']) : t('%d comments', $task['nb_comments']) ?>"><i class="fa fa-comments-o"></i></span>
            <?php else: ?>
                <?= $this->modal->medium(
                    'comments-o',
                    '',
                    'CommentListController',
                    'show',
                    array('task_id' => $task['id'], 'project_id' => $task['project_id']),
                    $task['nb_comments'] == 1 ? t('%d comment', $task['nb_comments']) : t('%d comments', $task['nb_comments'])
                ) ?>
            <?php endif ?>
        <?php endif ?>		
    </div>
</div>

<?= $this->hook->render('template:board:task:footer', array('task' => $task)) ?>
