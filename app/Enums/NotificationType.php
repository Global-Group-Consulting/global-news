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
  
  // main app notifications
  const MESSAGE_CHAT = "messageChat";
  const MESSAGE_REPORT = "messageReport";
  const MESSAGE_COMMUNICATION = "messageCommunication";
  
  const REQUEST_DEPOSIT = "requestDeposit";
  const REQUEST_DEPOSIT_COLLECT = "requestDepositCollect";
  const REQUEST_GOLD = "requestGold";
  const REQUEST_APPROVED = "requestApproved";
  const REQUEST_REJECTED = "requestRejected";
  const REQUEST_CANCELLED = "requestCancelled";
  
  const PASSWORD_RECOVER = "passwordRecover";
  const PASSWORD_FORGOT = "passwordForgot";
  
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
    
    // main app notifications
    
    // Messages
    self::MESSAGE_CHAT,
    self::MESSAGE_REPORT,
    self::MESSAGE_COMMUNICATION,
    
    // Requests
    self::REQUEST_DEPOSIT,
    self::REQUEST_DEPOSIT_COLLECT,
    self::REQUEST_GOLD,
    self::REQUEST_APPROVED,
    self::REQUEST_REJECTED,
    self::REQUEST_CANCELLED,
    
    // Password
    self::PASSWORD_RECOVER,
    self::PASSWORD_FORGOT,
  ];
  
}
