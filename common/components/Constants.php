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
    public const USER_STATUS_DELETED = 0;
    public const USER_STATUS_ACTIVE = 10;

    public const ORGANIZATION_STATE_PAID = 1;
    public const ORGANIZATION_STATE_FREE = 0;

    public const PROPOSAL_STATUS_CREATED = 1;
    public const PROPOSAL_STATUS_CLOSED = 2;
    public const PROPOSAL_STATUS_REJECT = 3;

    public const ORGANIZATION_PROPOSAL_STATUS_APPROVE = 1;
    public const ORGANIZATION_PROPOSAL_STATUS_REJECT = 2;

    public const ADMIN_ORGANIZATION_ID = 1;
}