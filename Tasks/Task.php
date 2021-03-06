<?php

namespace SumoCoders\Teamleader\Tasks;

use SumoCoders\Teamleader\Teamleader;

class Task
{
    /**
     * @var int
     */
    private $id;

    /**
     * Due date as Unix timestamp(seconds).
     *
     * @var int
     */
    private $due_date;

    /**
     * team_id of the attending user
     *
     * @var int
     */
    private $user_id;

    /**
     * team_id of the attending team
     *
     * @var int
     */
    private $team_id;

    /**
     * Task type id
     *
     * @var int
     */
    private $task_type_id;

    /**
     * @var string|null
     */
    private $description;

    /**
     * Duration in minutes
     *
     * @var int
     */
    private $duration;

    /**
     * Milestone of the corresponding project
     *
     * @var string
     */
    private $priority;

    /**
     * Is it contact,company
     *
     * @var for
     */
    private $for;

    /**
     * Company, contact id who should this task be billed to
     *
     * @var for_id
     */
    private $for_id;

    /**
     * Creator id for the task
     *
     * @var creator_user_id
     */
    private $creator_user_id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param int $due_date
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getTeamId()
    {
        return $this->team_id;
    }

    /**
     * @param int $team_id
     */
    public function setTeamId($team_id)
    {
        $this->team_id = $team_id;
    }

    /**
     * @return int
     */
    public function getTaskTypeId()
    {
        return $this->task_type_id;
    }

    /**
     * @param int $task_type_id
     */
    public function setTaskTypeId($task_type_id)
    {
        $this->task_type_id = $task_type_id;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getFor(){
        return $this->for;
    }

    /**
     * @param string $for
     */
    public function setFor($for){
        $this->for = $for;
    }

    /**
     * @return int
     */
    public function getForId()
    {
        return $this->for_id;
    }

    /**
     * @param int $for_id
     */
    public function setForId($for_id)
    {
        $this->for_id = $for_id;
    }

    /**
     * @return string
     */
    public function getCreatorUserId()
    {
        return $this->creator_user_id;
    }

    /**
     * @param string $creator_user_id
     */
    public function setCreatorUserId($creator_user_id)
    {
        $this->creator_user_id = $creator_user_id;
    }


    /**
     * @param $data
     * @return Task
     */
    public static function initializeWithRawData($data)
    {
        $task = new Task();

        foreach ($data as $key => $value) {
            // Ignore empty values
            if ($value == '') {
                continue;
            }

            $methodName = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (!method_exists(__CLASS__, $methodName)) {
                if (Teamleader::DEBUG) {
                    var_dump($key, $value);
                    throw new Exception('Unknown method (' . $methodName . ')');
                }
            } else {
                call_user_func(array($task, $methodName), $value);
            }
        }

        // These properties don't have the same name in the Teamleader api as when you set them
        $task->setDuration($data['duration_minutes']);

        if (isset($data['attending_internal'][0]['user_id'])) {
            $task->setUserId($data['attending_internal'][0]['user_id']);
        }

        return $task;
    }

    /**
     * This method will convert a credit note to an array that can be used for an
     * API-request
     *
     * @return array
     */
    public function toArrayForApi()
    {
        $return = array();

        if ($this->getDueDate()) {
            $return['due_date'] = $this->getDueDate();
        }
        if ($this->getTeamId()) {
            $return['team_id'] = $this->getTeamId();
        }
        if ($this->getUserId()) {
            $return['user_id'] = $this->getUserId();
        }
        if ($this->getTaskTypeId()) {
            $return['task_type_id'] = $this->getTaskTypeId();
        }
        if ($this->getDescription()) {
            $return['description'] = $this->getDescription();
        }
        if ($this->getDuration()) {
            $return['duration'] = $this->getDuration();
        }else{
            $return['duration'] = 0;
        }
        if ($this->getPriority()) {
            $return['priority'] = $this->getPriority();
        }
        if ($this->getFor()){
            $return['for'] = $this->getFor();
        }
        if ($this->getForId()) {
            $return['for_id'] = $this->getForId();
        }
        if ($this->getCreatorUserId()) {
            $return['creator_user_id'] = $this->getCreatorUserId();
        }

        return $return;
    }
}
