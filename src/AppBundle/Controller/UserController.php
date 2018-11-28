<?php


namespace AppBundle\Controller;


use AppBundle\BlogUser\Controller\UserController\ShowPageFirstTimeAction;
use AppBundle\BlogUser\Controller\UserController\ShowPageNextAction;
use AppBundle\BlogUser\Controller\UserController\ShowPagePrevAction;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\SearchId;
use AppBundle\BlogUser\Paging\Pagination\LastPage;
use AppBundle\BlogUser\UserMessageFactoryContainer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @var UserMessageFactoryContainer
     */
    private $userMessageFactoryContainer;

    /**
     * UserController constructor.
     * @param UserMessageFactoryContainer $userMessageFactory
     */
    public function __construct(UserMessageFactoryContainer $userMessageFactory)
    {
        $this->userMessageFactoryContainer = $userMessageFactory;
    }

    public function showAction()
    {   
        $userMessage = $this->userMessageFactoryContainer->createUserMessage();
        
//        $userMessages = $userMessage->getUserMessages();
        $userMessages = $userMessage->getByPage(0, 3);
        
        
        
        
//        $message = '';
//        foreach ($userMessages as $message) {
//            $message = $message->getMessage();
//        }
//        
//        $dump = print_r(count($userMessages), true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** count($userMessages) ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        
        return $this->render(
            'domain/userblog/user_messages.html.twig',
            ['messages' => $userMessages]
        );
    }

    /**
     * @param $lastPage
     * @param $searchId
     * @param $direction
     * @param $shownItemsCount
     * @return Response
     * @throws \AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetException
     * @throws \AppBundle\BlogUser\Paging\PaginationException
     */
    public function showPageAction($lastPage, $searchId, $direction, $shownItemsCount)
    {
        if (is_numeric($lastPage)) {
            $lastPage = (int) $lastPage;
        }
        if (is_numeric($searchId)) {
            $searchId = (int) $searchId;
        }
        if (is_numeric($direction)) {
            $direction = (int) $direction;
        }
        if (is_numeric($shownItemsCount)) {
            $shownItemsCount = (int) $shownItemsCount;
        }
        $action = null;
        switch ($direction) {
            case 0:
                $action = new ShowPageFirstTimeAction(
                    new LastPage($lastPage), new SearchId($searchId), new ShownItemsCount($shownItemsCount), $this->userMessageFactoryContainer
                );
                break;
            case -1:
                $action = new ShowPagePrevAction(
                    new LastPage($lastPage), new SearchId($searchId), new ShownItemsCount($shownItemsCount), $this->userMessageFactoryContainer
                );
                break;
            case 1:
                $action = new ShowPageNextAction(
                    new LastPage($lastPage), new SearchId($searchId), new ShownItemsCount($shownItemsCount), $this->userMessageFactoryContainer
                ); 
            default:
        }
        
        $action->execute();

        return $this->render(
            'domain/userblog/user_messages.html.twig',
            $action->getVarsToRender()
        );
    }
}