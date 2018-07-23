<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 9:57
 */

namespace app\common\components;


class Constants
{
    const USER_STATUS_DELETED = 0;
    const USER_STATUS_ACTIVE = 10;

    const ORGANIZATION_STATE_PAID = 1;
    const ORGANIZATION_STATE_FREE = 2;

    const PROPOSAL_STATUS_CREATED = 1;
    const PROPOSAL_STATUS_CLOSED = 2;
    const PROPOSAL_STATUS_REJECT = 3;

    const ORGANIZATION_PROPOSAL_STATUS_APPROVE = 1;
    const ORGANIZATION_PROPOSAL_STATUS_REJECT = 2;
}