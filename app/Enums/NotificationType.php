<?php

namespace App\Enums;

abstract class NotificationType {
  const ORDER_UPDATE = "orderUpdate";
  const NEW_MESSAGE = "newMessage";
  const NEW_NEWS = "newNews";
  const WP_NEW_SEMESTER = "wpNewSemester";
  const WP_BRITES_TO_UNLOCK = "wpBritesToUnlock";
  const CLUB_PACK_DOWNGRADE = "clubPackDowngrade";
  const CLUB_PACK_EXPIRING = "clubPackExpiring";
  const CALENDAR_UPDATE = "calendarUpdate";
  const ACCOUNT_APPROVED = "accountApproved";
  
  const ALL = [
    self::ORDER_UPDATE,
    self::NEW_MESSAGE,
    self::NEW_NEWS,
    self::WP_NEW_SEMESTER,
    self::WP_BRITES_TO_UNLOCK,
    self::CLUB_PACK_DOWNGRADE,
    self::CLUB_PACK_EXPIRING,
    self::CALENDAR_UPDATE,
    self::ACCOUNT_APPROVED,
  ];
  
}
