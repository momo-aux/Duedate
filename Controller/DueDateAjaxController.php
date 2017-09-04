<?php

namespace Kanboard\Plugin\Duedate\Controller;

use Kanboard\Core\Controller\AccessForbiddenException;
use Kanboard\Model\UserMetadataModel;
use Kanboard\Controller\BaseController;

/**
 * Class BoardAjaxController
 *
 * @package Kanboard\Controller
 * @author  Martin Schlierf
 */
class DueDateAjaxController extends BaseController
{
    /**
     * Save new task positions (Ajax request made by the drag and drop)
     *
     * @access public
     */
    public function save()
    {
        $project_id = $this->request->getIntegerParam('project_id');

        if (! $project_id || ! $this->request->isAjax()) {
            throw new AccessForbiddenException();
        }

        $values = $this->request->getJson();

        if (! $this->helper->projectRole->canMoveTask($project_id, $values['src_column_id'], $values['dst_column_id'])) {
            throw new AccessForbiddenException(e("You don't have the permission to move this task"));
        }

        $result =$this->taskPositionModel->movePosition(
            $project_id,
            $values['task_id'],
            $values['dst_column_id'],
            $values['position'],
            $values['swimlane_id']
        );

        if (! $result) {
            $this->response->status(400);
        } else {
            $this->response->html($this->renderBoard($project_id), 201);
        }
    }

    /**
     * Check if the board have been changed
     *
     * @access public
     */
    public function check()
    {
        $project_id = $this->request->getIntegerParam('project_id');
        $timestamp = $this->request->getIntegerParam('timestamp');

        if (! $project_id || ! $this->request->isAjax()) {
            throw new AccessForbiddenException();
        } elseif (! $this->projectModel->isModifiedSince($project_id, $timestamp)) {
            $this->response->status(304);
        } else {
            $this->response->html($this->renderBoard($project_id));
        }
    }

    /**
     * Reload the board with new filters
     *
     * @access public
     */
    public function reload()
    {
        $project_id = $this->request->getIntegerParam('project_id');

        if (! $project_id || ! $this->request->isAjax()) {
            throw new AccessForbiddenException();
        }

        $values = $this->request->getJson();
        $this->userSession->setFilters($project_id, empty($values['search']) ? '' : $values['search']);

        $this->response->html($this->renderBoard($project_id));
    }

    /**
     * Enable collapsed mode
     *
     * @access public
     */
    public function collapse()
    {
        $this->changeDisplayMode(1);
    }

    /**
     * Enable expanded mode
     *
     * @access public
     */
    public function expand()
    {
        $this->changeDisplayMode(0);
    }

    /**
     * Change display mode
     *
     * @access private
     * @param  int $mode
     */
    private function changeDisplayMode($mode)
    {
        $project_id = $this->request->getIntegerParam('project_id');
        $this->userMetadataCacheDecorator->set(UserMetadataModel::KEY_BOARD_COLLAPSED.$project_id, $mode);

        if ($this->request->isAjax()) {
            $this->response->html($this->renderBoard($project_id));
        } else {
            $this->response->redirect($this->helper->url->to('DueDateController', 'show', array('project_id' => $project_id,'plugin' => 'Sitlind')));
        }
    }

    /**
     * Render board
     *
     * @access protected
     * @param  integer $project_id
     * @return string
     */
    protected function renderBoard($project_id)
    {
		error_log("RENDER: $project_id");
        return $this->template->render('Sitlind:board/table_container', array(
            'project' => $this->projectModel->getById($project_id),
            'board_private_refresh_interval' => $this->configModel->get('board_private_refresh_interval'),
            'board_highlight_period' => $this->configModel->get('board_highlight_period'),
            'swimlanes' => $this->taskLexer
                ->build($this->userSession->getFilters($project_id))
                ->format($this->dueDateFormatter->withProjectId($project_id))
        ));
    }
}
