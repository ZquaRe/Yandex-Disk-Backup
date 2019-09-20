<?php
/**
 * User: naxel
 * Date: 14.02.14 15:15
 */

use Yandex\Metrica\Management\ManagementClient;
use Yandex\Metrica\Analytics\AnalyticsClient;

$errorMessage = null;
$status = 'ok';
$result = null;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../settings.php';

    try {

        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['method'])) {

            switch ($_GET['method']) {

                case 'getCounter':
                    if (isset($_GET['counterId']) && $_GET['counterId']) {
                        //GET /management/v1/counter/{counterId}
                        $paramsObj = new \Yandex\Metrica\Management\Models\CounterParams();
                        $paramsObj->setField('goals,mirrors,grants,filters,operations');
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/counters/counter.xml
                         */
                        $result = $managementClient
                            ->counters()
                            ->getCounter($_GET['counterId'], $paramsObj)
                            ->toArray();
                    }
                    break;

                case 'getFilter':
                    if (isset($_GET['counterId'], $_GET['filterId']) && $_GET['counterId'] && $_GET['filterId']) {
                        //GET /management/v1/counter/{counterId}/filter/{filterId}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/filters/filter.xml
                         */
                        $result = $managementClient
                            ->filters()
                            ->getFilter($_GET['filterId'], $_GET['counterId'])
                            ->toArray();
                    }
                    break;

                case 'getGrant':
                    if (isset($_GET['userLogin'], $_GET['counterId']) && $_GET['userLogin'] && $_GET['counterId']) {
                        //GET /management/v1/counter/{counterId}/grant/{userLogin}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/grants/grantold.xml
                         */
                        $result = $managementClient
                            ->grants()
                            ->getGrant($_GET['counterId'], $_GET['userLogin'])
                            ->toArray();
                    }
                    break;

                case 'getOperation':
                    //GET /management/v1/counter/{counterId}/operation/{operationId}
                    /**
                     * @see http://api.yandex.ru/metrika/doc/beta/management/operations/operation.xml
                     */
                    if (isset($_GET['operationId'], $_GET['counterId'])
                        && $_GET['operationId']
                        && $_GET['counterId']
                    ) {
                        $result = $managementClient
                            ->operations()
                            ->getOperation($_GET['operationId'], $_GET['counterId'])
                            ->toArray();
                    }
                    break;

                case 'getPageViewsCount':
                    if (isset($_GET['counterId']) && $_GET['counterId']) {
                        $paramsObj = new \Yandex\Metrica\Analytics\Models\Params();
                        $paramsObj
                            ->setMetrics('ga:pageviews')
                            ->setStartDate('6daysAgo')
                            ->setEndDate('today')
                            ->setIds('ga:' . $_GET['counterId']);

                        $analyticsClient = new AnalyticsClient($_COOKIE['yaAccessToken']);
                        $response = $analyticsClient
                            ->ga()
                            ->getGaData($paramsObj);
                        $result = $response->getRows();
                        if (empty($result)) {
                            $result = 0;
                        } else {
                            $result = current(current($result));
                        }
                    }

                    break;
            }
        }

        if (isset($_POST['method'])) {

            switch ($_POST['method']) {
                case 'addCounter':
                    if (isset($_POST['counterSite']) && isset($_POST['counterName'])) {
                        //POST /counters
                        /**
                         * @see http://api.yandex.ru/metrika/doc/ref/reference/add-counter.xml
                         */
                        $counterPostRequest = new Yandex\Metrica\Management\Models\Counter();
                        $counterPostRequest
                            ->setName($_POST['counterName'])
                            ->setSite($_POST['counterSite']);

                        $codeOptions = new \Yandex\Metrica\Management\Models\CodeOptions();
                        $codeOptions
                            ->setAsync(1)
                            ->setTrackHash(1)
                            ->setVisor(1)
                            ->setUt(1)
                            ->setXmlSite(1)
                            ->setInOneLine(1);

                        $counterPostRequest->setCodeOptions($codeOptions);

                        $result = $managementClient
                            ->counters()
                            ->addCounter($counterPostRequest)
                            ->toArray();
                    }
                    break;

                case 'updateCounter':
                    if (isset($_POST['counterSite']) && isset($_POST['counterName'])
                        && isset($_POST['counterId']) && $_POST['counterId']
                    ) {
                        //PUT /counter/{id}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/ref/reference/edit-counter.xml
                         */
                        $params = new Yandex\Metrica\Management\Models\ExtendCounter();

                        $codeOptions = new \Yandex\Metrica\Management\Models\CodeOptions();
                        $codeOptions
                            ->setAsync(1)
                            ->setTrackHash(0)
                            ->setVisor(0)
                            ->setUt(0)
                            ->setXmlSite(0)
                            ->setInOneLine(0);

                        $params->setCodeOptions($codeOptions);

                        $webvisor = new \Yandex\Metrica\Management\Models\Webvisor();
                        $webvisor
                            ->setArchEnabled(1)
                            ->setUrls('regexp:.*')
                            ->setArchType('load')
                            ->setLoadPlayerType('on_your_behalf');

                        $params->setWebvisor($webvisor);

                        if ($_POST['counterName']) {
                            $params->setName($_POST['counterName']);
                        }
                        if ($_POST['counterSite']) {
                            $params->setSite($_POST['counterSite']);
                        }

                        $result = $managementClient
                            ->counters()
                            ->updateCounter($_POST['counterId'], $params)
                            ->toArray();
                    }
                    break;

                case 'deleteCounter':
                    if (isset($_POST['counterId']) && $_POST['counterId']) {
                        //DELETE /counter/{id}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/ref/reference/delete-counter.xml
                         */
                        $response = $managementClient
                            ->counters()
                            ->deleteCounter($_POST['counterId']);


                        if (isset($response['errors']) && $response['errors']) {
                            $status = 'error';
                            $errorMessage = $response['errors'][0]['text'];

                        } else {
                            $result = array(
                                'id' => $_POST['counterId']
                            );
                        }
                    }
                    break;

                case 'addDelegate':
                    if (isset($_POST['userLogin'], $_POST['createAt'], $_POST['comment']) && $_POST['userLogin']) {
                        //POST /management/v1/delegates
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/adddelegate.xml
                         */
                        $delegateModel = new Yandex\Metrica\Management\Models\Delegate();
                        $delegateModel
                            ->setUserLogin($_POST['userLogin'])
                            ->setCreatedAt($_POST['createAt'])
                            ->setComment($_POST['comment']);
                        $result = $managementClient
                            ->delegates()
                            ->addDelegates($delegateModel)
                            ->toArray();
                    }
                    break;

                case 'updateDelegate':
                    if (isset($_POST['userLogin'], $_POST['createAt'], $_POST['comment']) && $_POST['userLogin']) {
                        //PUT /management/v1/delegates
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/updatedelegates.xml
                         */
                        $delegateModel = new Yandex\Metrica\Management\Models\Delegate();
                        $delegateModel
                            ->setUserLogin($_POST['userLogin'])
                            ->setCreatedAt($_POST['createAt'])
                            ->setComment($_POST['comment']);
                        $result = $managementClient
                            ->delegates()
                            ->updateDelegates($delegateModel)
                            ->toArray();
                    }
                    break;

                case 'deleteDelegate':
                    if (isset($_POST['userLogin']) && $_POST['userLogin']) {
                        //DELETE /management/v1/delegate/{userLogin}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/deletedelegateold.xml
                         */
                        $response = $managementClient
                            ->delegates()
                            ->deleteDelegate($_POST['userLogin']);

                        if (isset($response['errors']) && $response['errors']) {
                            $status = 'error';
                            $errorMessage = $response['errors'][0]['text'];

                        } else {
                            $result = array(
                                'id' => $_POST['userLogin']
                            );
                        }
                    }
                    break;

                case 'deleteAccount':
                    if (isset($_POST['userLogin']) && $_POST['userLogin']) {
                        //DELETE /management/v1/account/{userLogin}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/accounts/deleteaccountold.xml
                         */
                        $response = $managementClient
                            ->accounts()
                            ->deleteAccount($_POST['userLogin']);

                        if (isset($response['errors']) && $response['errors']) {
                            $status = 'error';
                            $errorMessage = $response['errors'][0]['text'];

                        } else {
                            $result = array(
                                'id' => $_POST['userLogin']
                            );
                        }
                    }
                    break;

                case 'addFilter':
                    if (isset($_POST['params'], $_POST['counterId']) && $_POST['params'] && $_POST['counterId']) {
                        parse_str($_POST['params'], $params);
                        $filterModel = new Yandex\Metrica\Management\Models\Filter((array)$params);

                        //POST /management/v1/counter/{counterId}/filters
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/filters/addfilter.xml
                         */
                        $result = $managementClient
                            ->filters()
                            ->addFilter($_POST['counterId'], $filterModel)
                            ->toArray();
                    }
                    break;

                case 'updateFilter':
                    if (isset($_POST['params'], $_POST['counterId'], $_POST['filterId'])
                        && $_POST['params']
                        && $_POST['counterId']
                        && $_POST['filterId']
                    ) {
                        parse_str($_POST['params'], $params);
                        $filterModel = new Yandex\Metrica\Management\Models\Filter((array)$params);

                        //PUT /management/v1/counter/{counterId}/filter/{filterId}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/filters/editfilter.xml
                         */
                        $result = $managementClient
                            ->filters()
                            ->updateFilter($_POST['filterId'],$_POST['counterId'], $filterModel)
                            ->toArray();
                    }
                    break;

                case 'deleteFilter':
                    if (isset($_POST['counterId'], $_POST['filterId']) && $_POST['counterId'] && $_POST['filterId']) {

                        //DELETE /management/v1/counter/{counterId}/filter/{filterId}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/filters/deletefilter.xml
                         */
                        $response = $managementClient
                            ->filters()
                            ->deleteFilter($_POST['filterId'], $_POST['counterId']);

                        if (isset($response['errors']) && $response['errors']) {
                            $status = 'error';
                            $errorMessage = $response['errors'][0]['text'];

                        } else {
                            $result = array(
                                'id' => $_POST['filterId']
                            );
                        }
                    }
                    break;

                case 'addGrant':
                    if (isset($_POST['counterId'], $_POST['userLogin'], $_POST['perm'], $_POST['comment']
                        , $_POST['createdAt'])
                        && $_POST['counterId']
                        && $_POST['userLogin']
                        && $_POST['perm']
                    ) {

                        $grantModel = new Yandex\Metrica\Management\Models\Grant();
                        $grantModel
                            ->setUserLogin($_POST['userLogin'])
                            ->setPerm($_POST['perm'])
                            ->setComment($_POST['comment'])
                            ->setCreatedAt($_POST['createdAt']);

                        //POST /management/v1/counter/{counterId}/grants
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/grants/addgrant.xml
                         */
                        $result = $managementClient
                            ->grants()
                            ->addGrant($_POST['counterId'], $grantModel)
                            ->toArray();
                    }
                    break;

                case 'updateGrant':
                    if (isset($_POST['counterId'], $_POST['userLogin'], $_POST['perm'], $_POST['comment']
                        , $_POST['createdAt'])
                        && $_POST['counterId']
                        && $_POST['userLogin']
                        && $_POST['perm']
                    ) {

                        $grantModel = new Yandex\Metrica\Management\Models\Grant();
                        $grantModel
                            ->setUserLogin($_POST['userLogin'])
                            ->setPerm($_POST['perm'])
                            ->setComment($_POST['comment'])
                            ->setCreatedAt($_POST['createdAt']);

                        //PUT /management/v1/counter/{counterId}/grant/{userLogin}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/grants/editgrantold.xml
                         */
                        $result = $managementClient
                            ->grants()
                            ->updateGrant($_POST['counterId'], $_POST['userLogin'], $grantModel)
                            ->toArray();
                    }
                    break;

                case 'deleteGrant':
                    if (isset($_POST['counterId'], $_POST['userLogin'])
                        && $_POST['counterId']
                        && $_POST['userLogin']
                    ) {
                        //DELETE /management/v1/counter/{counterId}/grant/{userLogin}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/grants/deletegrantold.xml
                         */
                        $response = $managementClient
                            ->grants()
                            ->deleteGrant( $_POST['counterId'], $_POST['userLogin']);

                        if (isset($response['errors']) && $response['errors']) {
                            $status = 'error';
                            $errorMessage = $response['errors'][0]['text'];

                        } else {
                            $result = array(
                                'id' => $_POST['userLogin']
                            );
                        }
                    }
                    break;

                case 'addOperation':
                    if (isset($_POST['counterId'], $_POST['action'], $_POST['attr'], $_POST['value'], $_POST['status'])
                        && $_POST['counterId']
                    ) {

                        $operationModel = new Yandex\Metrica\Management\Models\Operation();
                        $operationModel->setAction($_POST['action'])
                            ->setAttr($_POST['attr'])
                            ->setValue($_POST['value'])
                            ->setStatus($_POST['status']);

                        //POST /management/v1/counter/{counterId}/operations
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/operations/addoperation.xml
                         */
                        $result = $managementClient
                            ->operations()
                            ->addOperation($_POST['counterId'], $operationModel)
                            ->toArray();
                    }
                    break;

                case 'updateOperation':
                    if (isset($_POST['counterId'], $_POST['operationId'], $_POST['action'], $_POST['attr']
                        , $_POST['value'], $_POST['status'])
                        && $_POST['counterId']
                        && $_POST['operationId']
                    ) {

                        $operationModel = new Yandex\Metrica\Management\Models\Operation();
                        $operationModel
                            ->setAction($_POST['action'])
                            ->setAttr($_POST['attr'])
                            ->setValue($_POST['value'])
                            ->setStatus($_POST['status'])
                            ->setId($_POST['operationId']);

                        //PUT /management/v1/counter/{counterId}/operation/{operationId}
                        /**
                         * @see http://api.yandex.ru/metrika/doc/beta/management/operations/editoperation.xml
                         */
                        $result = $managementClient
                            ->operations()
                            ->updateOperation($_POST['operationId'], $_POST['counterId'], $operationModel)
                            ->toArray();
                    }
                    break;
            }
        }

    } catch (\Exception $ex) {
        $errorMessage = $ex->getMessage();
        if ($errorMessage === 'PlatformNotAllowed') {
            $errorMessage .= '<p>Возможно, у приложения нет прав на доступ к ресурсу. Попробуйте '
                . '<a href="' . rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/' . '">авторизироваться</a> и повторить.</p>';
        }
    }
}


echo json_encode(
    array(
        'status' => $status,
        'message' => $errorMessage,
        'result' => $result,
    )
);
