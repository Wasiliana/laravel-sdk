<?php

namespace Wasiliana\LaravelSdk\Traits;

trait ConversationId
{
    public function uniqueId($prefix = 'conversation_id')
    {
        return sprintf('%s_%d', $prefix, date('YmdHis'));
    }
}
