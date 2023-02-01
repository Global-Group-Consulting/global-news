<?php

namespace App\Enums;

abstract class NewsletterStatus {
  const DRAFT = "draft";
  const SCHEDULED = "scheduled";
  const SENT = "sent";
  const FAILED = "failed";
  
}
