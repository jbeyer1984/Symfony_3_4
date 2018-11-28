<?php


namespace AppBundle\BlogUser;


class UserMessageHelperFactory
{
    public function createUserMessageHelper()
    {
        return new UserMessagesHelper();
    }
}