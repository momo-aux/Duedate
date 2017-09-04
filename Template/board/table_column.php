<!-- column titles -->

<?= $this->hook->render('template:board:table:column:before-header-row', array('swimlane' => $swimlane)) ?>

<tr class="board-swimlane-columns-<?= $swimlane['id'] ?>">
    <?php foreach ($swimlane['columns'] as $column): ?>
    <th class="board-column-header board-column-header-<?= $column['id'] ?>" data-column-id="<?= $column['id'] ?>">

        <!-- column in collapsed mode -->
        <div class="board-column-collapsed">
            <small class="board-column-header-task-count" title="<?= t('Show this column') ?>">
            </small>
        </div>

        <!-- column in expanded mode -->
        <div class="board-column-expanded">

            <span class="board-column-title">
                    <?= $this->text->e($column['title']) ?>
			</span>
			<?php if (! $not_editable && $this->projectRole->canCreateTaskInColumn($column['project_id'], $column['id'])): ?>
                <div class="board-add-icon">
                    <?= $this->modal->largeIcon('plus', t('Add a new task'), 'TaskCreationController', 'show', array('project_id' => $column['project_id'], 'column_id' => $column['id'], 'swimlane_id' => $swimlane['id'])) ?>
                </div>
            <?php endif ?>
            <span class="pull-right">
                <?php if ($swimlane['nb_swimlanes'] > 1 && ! empty($column['column_score'])): ?>
                    <span title="<?= t('Total score in this column across all swimlanes') ?>">
                        (<span><?= $column['column_score'] ?></span>)
                    </span>
                <?php endif ?>

                <?php if (! empty($column['score'])): ?>
                    <span title="<?= t('Score') ?>">
                        <?= $column['score'] ?>
                    </span>
                <?php endif ?>

                <?php if (! $not_editable && ! empty($column['description'])): ?>
                    <span class="tooltip" title="<?= $this->text->markdownAttribute($column['description']) ?>">
                        &nbsp;<i class="fa fa-info-circle"></i>
                    </span>
                <?php endif ?>

            </span>

	    <?= $this->hook->render('template:board:column:header', array('swimlane' => $swimlane, 'column' => $column)) ?> 
        </div>

    </th>
    <?php endforeach ?>
</tr>

<?= $this->hook->render('template:board:table:column:after-header-row', array('swimlane' => $swimlane)) ?>
