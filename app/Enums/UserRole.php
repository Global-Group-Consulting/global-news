<?php

namespace App\Enums;

abstract class UserRole {
  const ADMIN = 1;
  const ADMIN_LABEL = "Admin";
  
  const SERV_CLIENTI = 2;
  const SERV_CLIENTI_LABEL = "Servizio Clienti";
  
  const AGENT = 3;
  const AGENT_LABEL = "Agente";
  
  const CLIENT = 4;
  const CLIENT_LABEL = "Cliente";
  
  
  const LABELS = [
    self::ADMIN        => self::ADMIN_LABEL,
    self::SERV_CLIENTI => self::SERV_CLIENTI_LABEL,
    self::AGENT        => self::AGENT_LABEL,
    self::CLIENT       => self::CLIENT_LABEL,
  ];
}
