<?php
namespace Yandex\Metrica\Management;

/**
 * Class GoalsClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  13.02.14 17:39
 */
class GoalsClient extends ManagementClient
{

    /**
     * Get counter goals
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/goals/goals.xml
     *
     * @param int $counterId
     * @return Models\Goals
     */
    public function getGoals($counterId)
    {
        $resource = 'counter/' . $counterId . '/goals';
        $response = $this->sendGetRequest($resource);
        $goalResponse = new Models\GetGoalsResponse($response);
        return $goalResponse->getGoals();
    }


    /**
     * Add goal to counter
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/goals/addgoal.xml
     *
     * @param int $counterId
     * @param Models\Goal $goal
     * @return Models\Goal
     */
    public function addGoal($counterId, Models\Goal $goal)
    {
        $resource = 'counter/' . $counterId . '/goals';
        $response = $this->sendPostRequest($resource, ["goal" => $goal->toArray()]);
        $goalResponse = new Models\AddGoalResponse($response);
        return $goalResponse->getGoal();
    }


    /**
     * Get counter goal
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/goals/goal.xml
     *
     * @param int $id
     * @param int $counterId
     * @return Models\Goal
     */
    public function getGoal($id, $counterId)
    {
        $resource = 'counter/' . $counterId . '/goal/' . $id;
        $response = $this->sendGetRequest($resource);
        $goalResponse = new Models\GetGoalResponse($response);
        return $goalResponse->getGoal();
    }


    /**
     * Update counter goal
     *
     * @see http://api.yandex.ru/metrika/doc/beta/management/goals/editgoal.xml
     *
     * @param int $id
     * @param int $counterId
     * @param Models\Goal $goal
     * @return Models\Goal
     */
    public function updateGoal($id, $counterId, Models\Goal $goal)
    {
        $resource = 'counter/' . $counterId . '/goal/' . $id;
        $response = $this->sendPutRequest($resource, ["goal" => $goal->toArray()]);
        $goalResponse = new Models\UpdateGoalResponse($response);
        return $goalResponse->getGoal();
    }


    /**
     * Delete counter goal
     *
     * @see http://api.yandex.ru/metrika/doc/ref/reference/del-counter-goal.xml
     *
     * @param int $id
     * @param int $counterId
     * @return array
     */
    public function deleteGoal($id, $counterId)
    {
        $resource = 'counter/' . $counterId . '/goal/' . $id;
        $response = $this->sendDeleteRequest($resource);
        return $response;
    }
}
